#!/bin/bash

source /home/control/common.sh
 
#ignore when this script commit

echo "check revision: $rev repos: $repos"
output=$(svnlook changed -t "$rev" "$repos")
i=0

while read -r line; do
        IFS='    ' read modechar filepath <<< "$line"
        O[i]="${filepath}"
        i=$((i+1))
done <<< "$output"


NN=$((i))
echo $NN
for((i=0;i<NN;i++))
do
        selPath="/home/control/$reponame/${O[i]}"
        conf_list=$(readlink -f "$selPath.conflicted"* )
        echo $conf_list
        found=0
        while read -r fold; do
            if [[ -f "$fold" ]]; then
                found=1
                echo "found:".$fold
                break
            fi
        done <<< "$conf_list"

        if [ ${found} -eq 1 ]
        then
                #check the existance in submit
                exFlag=0
                for((j=0;j<NN;j++))
                do
                        if echo "${O[j]}" | grep "${O[i]}.conflicted."; then
                                exFlag=1
                                echo "${O[j]} same submit found:"
                                break
                        fi
                done

                if [ ${exFlag} -eq 0 ]
                then
                        echo "${O[i]} is conflicted , please get update and resolve" >&2
                        exit 1
                fi
        fi
done


exit 0
