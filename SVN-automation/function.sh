

########################################################################
#
#   compare_file_and_add_different_lines     
#           $src_file 
#           $dst_file 
#           $dst_branch
#
########################################################################

compare_file_and_add_different_lines()
{
    echo "############   compare_file_and_add_different_lines  ############ ";

    local src_file=$1  # source file before get update
    local dst_file=$2
    local dst_branch=$3

    echo "### source file path      : $src_file";
    echo "### destination file path : $dst_file";

    local cur_src=0
    local cur_dst=0
    local file_src_cont
    local file_dst_cont

    while IFS='' read -r line1 || [[ -n "$line1" ]]; do
        file_src_cont[cur_src]=$line1
        let cur_src=$cur_src+1
    done < "$src_file"

   while IFS='' read -r line2 || [[ -n "$line2" ]]; do
        file_dst_cont[cur_dst]=$line2
        let cur_dst=$cur_dst+1
    done < "$dst_file"

    echo "src file lines ; $cur_src";
    echo "dst file lines ; $cur_dst";

    if [ $cur_src -gt $cur_dst ] ;
    then
        min_cur=$cur_dst
        max_cur=$cur_src
    else
        min_cur=$cur_src
        max_cur=$cur_dst
    fi 

    echo "max , min cursor : $max_cur $min_cur"
  
    for((FC=0;FC<max_cur;FC++));
    do 
        if [ "${file_src_cont[FC]}" != "${file_dst_cont[FC]}" ] || [ $FC -ge $min_cur ] ; then
            echo "different lines $FC"; 
            sqlite3 "/home/control/svn.db" "insert into dest_changed_file(dst_branch , path , line) values( '$dst_branch' ,'$dst_file' , '$FC' )"
        fi
    done
}


######################################################################
#
#  merge_file_or_conflict 
#           $src_prev 
#           $src_new 
#           $dst_file
#           $dst_branch
#
#   return 0 : merged
#          1 : conflicted
#
########################################################################


merge_file_or_conflict()
{
    echo "############   merge_file_or_conflict  ############ "
    local src_prev=$1     # new updated changed source file
    local src_new=$2
    local dst_file=$3
    local dst_branch=$4
 
    local dst_backup_file="/home/control/tmp/$(uuidgen)"
    \cp "$dst_file" "$dst_backup_file"
     
    local cur_src_prev=0
    local cur_src_new=0
    local file_src_prev
    local file_src_new

    while IFS='' read -r line1 || [[ -n "$line1" ]]; do
        file_src_prev[cur_src_prev]=$line1
        let cur_src_prev=$cur_src_prev+1
    done < "$src_prev"

    while IFS='' read -r line2 || [[ -n "$line2" ]]; do
        file_src_new[cur_src_new]=$line2
        let cur_src_new=$cur_src_new+1
    done < "$src_new"

    if [ $cur_src_prev -gt $cur_src_new ] ;
    then
        min_cur=$cur_src_new
        max_cur=$cur_src_prev
    else
        min_cur=$cur_src_prev
        max_cur=$cur_src_new
    fi

    echo "min_cur $min_cur"
    echo "max_cur $max_cur"
    echo "---- detect ----"

    #first check the confliction 
    for((FC=0;FC<max_cur;FC++));
    do 
        if [ "${file_src_prev[FC]}" != "${file_src_new[FC]}" ] || [ $FC -ge $min_cur ] ; then
            #line FC is changed,  check if it is changed also in dest file
            echo "select count(*) as num from dest_changed_file where path='$dst_file' and line='$FC'";
            sqlite3 "/home/control/svn.db" "select count(*) as num from dest_changed_file where path='$dst_file' and line='$FC'"
            LIST=`sqlite3 "/home/control/svn.db" "select count(*) as num from dest_changed_file where path='$dst_file' and line='$FC'"`
            for ROW in $LIST; do
                echo "record count for (line $FC) $ROW"
                if [ $ROW -gt 0 ] ; then
                    \rm $dst_backup_file
                    echo "file conflicted"
                    return 1
                fi
            done
        fi
    done

    echo "---- end of detect ---- "
 
    # no conflict , generate merge file
    # reset file
    # merge operation
    > $dst_file

    for((FC=0;FC<cur_src_new;FC++));
    do
        if [ "${file_src_prev[FC]}" != "${file_src_new[FC]}" ]  ; then
            #changed from source code
            echo "${file_src_new[FC]}" >> $dst_file
        else
            #fetch nth line and put on it
            let line_num=$FC+1
            sed "${line_num}q;d" $dst_backup_file >> $dst_file
        fi
    done

    dst_file_lines=$(wc -l < "$dst_backup_file")  
    for((FC=cur_src_new;FC<dst_file_lines;FC++));
    do
        let line_num=$FC+1
        sed "${line_num}q;d" $dst_backup_file >> $dst_file
    done

    \rm $dst_backup_file
    return 0
}

# sqlite3 svn.db "delete from dest_changed_file"
# compare_file_and_add_different_lines "/home/control/test/prev_src.data" "/home/control/test/dst.data" "test_branch"
# merge_file_or_conflict               "/home/control/test/prev_src.data" "/home/control/test/new_src.data" "/home/control/test/dst.data" "test_branch"
# echo "$?";