#!/bin/bash
## usage ./cronjob-generator
SCRIPT_FOLDER=$(dirname $(readlink -f $0))
JOB_DESCRIPTIONS=(`ls $SCRIPT_FOLDER | grep -v 'example' | grep -v 'cronjob-template.yaml' | grep '.yaml'`)
TEMPLATE=`cat $SCRIPT_FOLDER/cronjob-template.yaml`

for job_description_file_name in "${JOB_DESCRIPTIONS[@]}"; do
	JOB_JSON=`js-yaml $SCRIPT_FOLDER/$job_description_file_name`
	NAME="mediawiki-`basename "$job_description_file_name" .yaml`"
	SCHEDULE=`echo "$JOB_JSON" | jq .schedule`
	ARGS=`echo "$JOB_JSON" | jq .args | js-yaml | sed -e 's/^/            /g'`
	SERVER_ID=`echo "$JOB_JSON" | jq .server_id`

	if [ "$SERVER_ID" = 'null' ]; then
		SERVER_ID="177"
	fi

	if [ "$SCHEDULE" = 'null' ]; then
		echo "schedule has to be set in $job_description_file_name"
		exit 1;
	fi

	if [ "$ARGS" = 'null' ]; then
		echo "args has to be set in $job_description_file_name"
		exit 1;
	fi

	job_k8s_descriptor="${TEMPLATE/\{name\}/${NAME}}"
	job_k8s_descriptor="${job_k8s_descriptor/\{args\}/${ARGS}}"
	job_k8s_descriptor="${job_k8s_descriptor/\{server_id\}/${SERVER_ID}}"
	job_k8s_descriptor="${job_k8s_descriptor/\{schedule\}/${SCHEDULE}}"
	echo "$job_k8s_descriptor"
done
