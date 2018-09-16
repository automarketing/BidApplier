#!/bin/sh 

A_FROM[0]="branchA";      A_TO[0]="branchB";  NEIGH[0]=1;
A_FROM[1]="branchA";      A_TO[1]="branchC";  NEIGH[1]=0;
A_FROM[2]="branchA";      A_TO[2]="branchD";  NEIGH[2]=0;
A_FROM[3]="branchB";      A_TO[3]="branchC";  NEIGH[3]=1;
A_FROM[4]="branchB";      A_TO[4]="branchD";  NEIGH[4]=0;
A_FROM[5]="branchC";      A_TO[5]="branchD";  NEIGH[5]=1;

comuser="developer"
compass="starstars"

author=$1
rev=$2
repos=$3
reponame=$4
message=$5

#ignore when this script commit
if [ "$author" = "$comuser" ]
then
        echo "cancel as comuser:$comuser"
        exit
fi

