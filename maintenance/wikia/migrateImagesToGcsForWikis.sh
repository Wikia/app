#!/bin/bash


RUNNER_SCRIPT="runOnCluster.php"
RUNNER_FILE="migrateImagesToGcsForWikis.php"

for cluster in $(seq 1 7); do

	CMD="php -d display_errors=1 $RUNNER_SCRIPT --file $RUNNER_FILE -c $cluster --filter all --no-db-check"
	echo -e "\t$CMD"
	$CMD
done

