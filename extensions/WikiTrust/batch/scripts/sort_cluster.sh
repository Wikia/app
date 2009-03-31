#!/bin/bash

WORKING_DIR=$1
OUTPUT_BASE=$2
START=$3
TEMP_DIR=$4

count=0

PROC_LIM=7
OUTPUT="$OUTPUT_BASE$count"
COMMAND_BASE="sort -n -k 2,2 -o $OUTPUT -T $TEMP_DIR -m "
COMMAND=$COMMAND_BASE
NUM_TO_SORT=100

num_added=0
for file in `ls $WORKING_DIR`; do
  if [ "$count" -ge "$START" ]; then
    COMMAND="$COMMAND $WORKING_DIR/$file "
    let num_added=num_added+1
    if [ "$num_added" -gt "$NUM_TO_SORT" ]; then
      $COMMAND &
      OUTPUT="$OUTPUT_BASE$count"
      COMMAND_BASE="sort -n -k 2,2 -o $OUTPUT -T $TEMP_DIR -m "
      COMMAND=$COMMAND_BASE
      let num_added=0
    fi
  fi
  let count=count+1
  current_proc=`ps -A -f | grep sort | wc -l`
  until [ "$current_proc" -le "$PROC_LIM" ]; do
    sleep 1
    let current_proc=`ps -A -f | grep sort | wc -l`
  done
done

$COMMAND &

