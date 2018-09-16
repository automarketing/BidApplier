#!/bin/bash
# usage 
#
# list all conflict
# 	conflict.sh 
#
# list conclict with source_branch
# 	conflict.sh -s "branch"
#
# list conclict with destination branch
# 	conflict.sh -d "branch"
#
# list conclict with source and destination branch
# 	conflict.sh -d "branch"
#
# create command
# 

 

while [[ $# -gt 1 ]]
do
key="$1"


case $key in
    -s|--src)
    src_branch="$2"
    shift # past argument
    ;;
    -d|--dst)
    dst_branch="$2"
    shift # past argument
    ;;
    -c|--create)
    sqlite3 "/home/control/svn.db"  "create table IF NOT EXISTS conflict (id INTEGER PRIMARY KEY,branch_src TEXT,branch_dst TEXT,path TEXT,rnd_file TEXT);"
    sqlite3 "/home/control/svn.db"  "create table IF NOT EXISTS dest_changed_file (id INTEGER PRIMARY KEY, dst_branch TEXT, path TEXT,line INTEGER );"
    echo "table conflict is created"
    echo "table dest_changed_file is created" 
    exit
    ;;
    --default)
    DEFAULT=YES
    ;;
    *)
    ;;
esac
shift # past argument or value
done

echo "B"

#validation action
LIST=`sqlite3 "/home/control/svn.db" "SELECT rnd_file FROM conflict"`;

for ROW in $LIST; do
	if [[ -f "${ROW}" ]]; then
		echo "-- $ROW"
	else
		echo "delete from conflict where rnd_file='$ROW'"
		sqlite3 "/home/control/svn.db" "delete from conflict where rnd_file='$ROW'"
	fi
done
#echo $src_branch
#echo $dst_branch

str1=""
if [ $src_branch ];then
	str1="and branch_src='$src_branch'"
fi 
str2=""
if [ $dst_branch ];then
	str2="and branch_dst='$dst_branch'"
fi

echo "C"

#echo "select path from conflict where 1 $str1 $str2"
sqlite3 "/home/control/svn.db" "select path from conflict where 1 $str1 $str2"





