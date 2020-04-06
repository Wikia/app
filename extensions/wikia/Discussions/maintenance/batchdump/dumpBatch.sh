#!/bin/bash

echo == Dumping page ids
command="php extensions/wikia/Discussions/maintenance/batchdump/dumpForumPageIds.php $@"
echo $command;
eval $command;

eval pagesNumber=\$\("cat $2 | wc -l"\)
echo "== Pages ids dumped: $pagesNumber"

for i in $(seq 0 500 $pagesNumber);
do
  if [[ $((i + 500)) -gt "$pagesNumber" ]]
  then
    echo "Min: $i max: $((pagesNumber - 1)) total: $pagesNumber";
    eval "php extensions/wikia/Discussions/maintenance/batchdump/dumpForumBatch.php $@ --minIndex $1 --maxIndex $((pagesNumber - 1))";
  else
    echo "Min: $i max: $((i + 500 - 1)) total: $pagesNumber";
    eval "php extensions/wikia/Discussions/maintenance/batchdump/dumpForumBatch.php $@ --minIndex $1 --maxIndex $((i + 500 - 1))";
  fi;
done
