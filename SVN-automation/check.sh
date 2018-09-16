#!/bin/sh
DEBUG_MODE=1

source /home/control/common.sh
source /home/control/function.sh


#filter corresponding branches
sel_from=""
#pre-checking require the update of destination even it is not in src branch list
updated_dst_branch=""

NN=${#A_FROM[*]}
for((i=0;i<NN;i++))
do
        if svnlook changed -r $rev $repos | grep ${A_FROM[i]}; then
                USE[i]=1
                sel_from=${A_FROM[i]}
        else
                USE[i]=0
        fi
        if svnlook changed -r $rev $repos | grep ${A_TO[i]}; then
                updated_dst_branch=${A_TO[i]}
        fi
done


if [ "$sel_from" = "" ]
then
        cd "/home/control/$reponame/$updated_dst_branch"
        svn update --username $comuser --password $compass --no-auth-cache
        echo "cancel as no matching found"
        exit
fi

src_branch="$reponame/$sel_from"
cd /home/control/$src_branch/
  
echo "--------- auto commit started -------------"
 

#previous comparing before get svn update in source branch 
different_cur=0
output=$(svnlook changed -r $rev $repos)
while read -r line; do
    IFS='    ' read modechar filepath <<< "$line"

    posL=${#sel_from}
    let posL=$posL+1
    filepath=${filepath:posL} #remove repo from file path
    objpath="/home/control/$src_branch/$filepath"

    echo "different file check src: $objpath"

    for((SR=0;SR<NN;SR++));
    do
        if [ ${USE[SR]} -eq 0 ]
        then
                continue
        fi
        dst_branch="$reponame/${A_TO[$SR]}"
        tarpath="/home/control/$dst_branch/$filepath"
        svn update "$tarpath"  --username $comuser --password $compass --no-auth-cache
        echo "different file check target: $tarpath"
        diff "$objpath" "$tarpath"
        echo "-------"
        if diff -w -q "$objpath" "$tarpath" | grep "diff" ; then
            different_file_list[different_cur]=$tarpath
            compare_file_and_add_different_lines "$objpath" "$tarpath" "$dst_branch" 
            echo "different found"
            echo ${different_file_list[$different_cur]}
            let different_cur=$different_cur+1
        fi
    done
done <<< "$output"


if [ $DEBUG_MODE -eq 1 ] ; then
    echo "#### SQL file contents for table dest_changed_file ###"
    sqlite3 "/home/control/svn.db" "select * from dest_changed_file"
    echo "#### End of SQL file contents ###"
fi

# main thread

#output=$(svn update --username $comuser --password $compass --no-auth-cache)
echo "svnlook changed -r $rev $repos"
output=$(svnlook changed -r $rev $repos)
dash=$(uuidgen)
while read -r line; do
        IFS='    ' read modechar filepath <<< "$line"

        posL=${#sel_from}
        let posL=$posL+1
        filepath=${filepath:posL} #remove repo from file path 

        if [ -z "$modechar" ]
        then
                continue
        fi

        extension="${filepath##*.}"
        if [ "$extension" = "pub" ] || [ "$extension" = "properties" ]
        then
                continue
        fi

        objpath="/home/control/$src_branch/$filepath"
        conflicted=0

        for((SR=0;SR<NN;SR++));
        do
                if [ ${USE[SR]} -eq 0 ]
                then
                        continue
                fi

                dst_branch="$reponame/${A_TO[$SR]}"
                neighbour=${NEIGH[$SR]}
                tarpath="/home/control/$dst_branch/$filepath"
                messagepath="$dst_branch/$filepath"
                echo "handling: $objpath [$src_branch ==> $dst_branch]"

                if  [ $modechar = "A" ] || [ $modechar = "U" ] || [ $modechar = "C" ]
                then
                        prev_src_file="/home/control/tmp/$(uuidgen)"
                        \cp "$objpath" "$prev_src_file"
                        svn update "$objpath"  --username $comuser --password $compass --no-auth-cache

                        if [[ -f "${objpath}" ]]; then

                                update_from_parent=0

                                for((I=0;I<different_cur;I++));
                                do
                                    if [ ${different_file_list[I]} = $tarpath ]
                                    then
                                        update_from_parent=1
                                        echo "updated from parent already" 
                                    fi 
                                done
                                
                                #conflicted
                                #no necessary for updating of target path , it is already updated
                                

                                if [[ -f "${tarpath}" ]]; then #same file exist on target path

                                        if [ $modechar = "U" ] || [ $modechar = "C" ] ;then
                                            if [ $neighbour -eq 0 ] && [ $conflicted -eq 1 ] ; then
                                                continue;
                                            fi
                                        fi

                                        old_conf=$(readlink -f "$tarpath.conflicted"* )
                                        while read -r fold; do
                                            if [[ -f "$fold" ]]; then
                                                svn delete "$fold" --username $comuser --password $compass --no-auth-cache
                                            fi
                                        done <<< "$old_conf"
                                        sqlite3 "/home/control/svn.db" "delete from conflict where path='$tarpath'"
                                        #line count detect
                                        if [ $update_from_parent -eq 1 ] ; then
                                            if diff -w -q "$objpath" "$tarpath" | grep "diff" ; then #content is different
                                                merge_file_or_conflict "$prev_src_file" "$objpath" "$tarpath" "$dst_branch"
                                                if [ $? -eq 1 ] ; then 
                                                    echo "file conflicted"
                                                    \cp "$objpath" "$tarpath.conflicted.$dash.original.$author"
                                                    svn add "$tarpath.conflicted.$dash.original.$author"
                                                    echo "Commit is success in Branch [$dst_branch]" >&2
                                                    echo "Before proceeding to high branch , Resolve Branch [$dst_branch] first" >&2
                                                    echo "Conflict name is $messagepath.conflicted.$dash.original.$author" >&2
                                                    #echo "created: $tarpath.$dash.conflicted.$author" >&2
                                                    echo " -------------------------------" >&2
                                                    sqlite3 "/home/control/svn.db" "insert into conflict(branch_src , branch_dst , path , rnd_file ) values('$src_branch' , '$dst_branch' , '$tarpath' , '$tarpath.conflicted.$dash.original.$author')"
                                                    return_value=1
                                                    conflicted=1
                                                else
                                                    echo "file merged"
                                                fi
                                            else
                                                \cp "$objpath" "$tarpath"
                                            fi
                                        else
                                            echo "Point A"
                                            \cp "$objpath" "$tarpath"
                                        fi

                                else #no exist case
                                        \cp "$objpath" "$tarpath"
                                        svn add "$tarpath"  --username $comuser --password $compass --no-auth-cache
                                fi
                        else
                            #This is directory , so no need to print
                                echo "Directory created"
                                svn update "$objpath"  --username $comuser --password $compass --no-auth-cache
                                svn update "/home/control/$dst_branch/$filepath"  --username $comuser --password $compass --no-auth-cache --non-interactive --quiet
                                 if [ ! -d "${tarpath}" ]; then
                                    mkdir "$tarpath"
                                    svn add "$tarpath"  --username $comuser --password $compass --no-auth-cache
                                fi
                        fi
                fi

                if  [ $modechar = "D" ]
                then
                        svn update "$objpath"  --username $comuser --password $compass --no-auth-cache
                        svn update "$tarpath"  --username $comuser --password $compass --no-auth-cache --non-interactive --quiet
                        if [ -d "${tarpath}" ] || [ -f "${tarpath}" ]; then
                                svn delete "$tarpath"  --username $comuser --password $compass --no-auth-cache
                        fi
                fi
                #update for other files....
                svn update "/home/control/$dst_branch"  --username $comuser --password $compass --no-auth-cache --non-interactive --quiet
        done
done <<< "$output"

for((SR=0;SR<NN;SR++));
do
        if [ ${USE[SR]} -eq 0 ]
        then
                continue
        fi

        dst_branch="$reponame/${A_TO[$SR]}"
        cd "/home/control/$dst_branch"
        echo "svn commit /home/control/$dst_branch  --username $comuser --password $compass --no-auth-cache -m $message:$author"
        svn commit "/home/control/$dst_branch"  --username $comuser --password $compass --no-auth-cache -m "$message:$author"
done

sqlite3 "/home/control/svn.db" "DELETE FROM dest_changed_file"

exit ${return_value}
