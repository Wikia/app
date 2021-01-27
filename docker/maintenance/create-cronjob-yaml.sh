#!/bin/bash

## This script generates a yaml config for a single job
## usage ./create-cronjob-yaml.sh <file_name>
## e.g. ./create-cronjob-yaml.sh phrase-alerts.yaml
## this can be sent to kubectl apply function
## e.g. ./create-cronjob-yaml.sh phrase-alerts.yaml | | kubectl --context context -n environment apply -f -
## This if a very simple script - if you need something else from it - please extend


# using ruby here as it is already installed on devboxes
function yaml2json() {
	ruby -ryaml -rjson -e 'puts JSON.pretty_generate(YAML.load(ARGF))' $*
}

job_description_file_name=$1
LABEL=$2

SCRIPT_FOLDER=$(dirname $(readlink -f $0))
TEMPLATE=`cat $SCRIPT_FOLDER/cronjob-template.yaml`
JOB_JSON=`yaml2json $job_description_file_name`
NAME=`basename "$job_description_file_name" .yaml`
SCHEDULE=`echo "$JOB_JSON" | jq .schedule`

CONCURRENCY=`echo "$JOB_JSON" | jq .concurrency`
if [ "${CONCURRENCY}" = 'null' ]; then
  CONCURRENCY="Allow"
fi
# we need to add 12 spaces of padding to align yaml in template
ARGS=`echo "$JOB_JSON" | jq .args[] | sed -e 's/^/            - /g'`
SERVER_ID=`echo "$JOB_JSON" | jq .server_id`

if [ "$SERVER_ID" = 'null' ]; then
	SERVER_ID="2393201"
fi

if [ "$SCHEDULE" = 'null' ]; then
	echo "schedule has to be set in $job_description_file_name"
	exit 1;
fi

if [ "$ARGS" = 'null' ]; then
	echo "args has to be set in $job_description_file_name"
	exit 1;
fi

job_k8s_descriptor="${TEMPLATE/\$\{name\}/${NAME}}"
job_k8s_descriptor="${job_k8s_descriptor/\$\{args\}/${ARGS}}"
job_k8s_descriptor="${job_k8s_descriptor/\$\{label\}/${LABEL}}"
job_k8s_descriptor="${job_k8s_descriptor/\$\{server_id\}/${SERVER_ID}}"
job_k8s_descriptor="${job_k8s_descriptor/\$\{schedule\}/${SCHEDULE}}"
job_k8s_descriptor="${job_k8s_descriptor/\$\{concurrency\}/${CONCURRENCY}}"
echo "$job_k8s_descriptor"
