#!/bin/bash

## usage ./cronjob-generator.sh
## This should generate all cron jobs that can be fed to kubectl
## e.g. ./cronjob-generator.sh | kubectl --context context -n environment apply -f -

SCRIPT_FOLDER=$(dirname $(readlink -f $0))
JOB_DESCRIPTIONS=(`ls $SCRIPT_FOLDER | grep -v 'example' | grep -v 'cronjob-template.yaml' | grep '\.yaml$'`)

for job_description_file_name in "${JOB_DESCRIPTIONS[@]}"; do
	./create-cronjob-yaml.sh $job_description_file_name
done
