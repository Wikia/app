#!/bin/bash

echo == Dumping page ids
command="php extensions/wikia/Discussions/maintenance/batchdump/dumpForumPageIds.php $@"
echo $command;
eval $command;

pagesNumber = $(eval "wc -l $2")
echo "== Pages ids dumped: $pagesNumber"

for i in $(seq 0 500 pagesNumber);
do
  if [[ $((i + 500)) -gt "$pagesNumber" ]]
  then
    echo "Min: $i max: $((pagesNumber - 1))";
  else
    echo "Min: $i max: $((i + 500 - 1))";
  fi;
done
