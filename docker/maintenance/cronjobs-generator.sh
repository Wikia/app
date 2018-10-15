#!/bin/bash

## usage ./cronjobs-generator.sh "<docker PHP image label>"
## This should generate all cron jobs that can be fed to kubectl
## e.g. ./cronjobs-generator.sh 05c4221.5c2dd23 | kubectl --context context -n environment apply -f -

SCRIPT_FOLDER=$(dirname $(readlink -f $0))
JOB_DESCRIPTIONS=(`ls $SCRIPT_FOLDER/*yaml | grep -v 'cronjob-template'`)
LABEL=$1

for job_description_file_name in "${JOB_DESCRIPTIONS[@]}"; do
	bash create-cronjob-yaml.sh $job_description_file_name $LABEL
done
