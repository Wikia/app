#!/bin/bash

echo == Dumping page ids
command="php extensions/wikia/Discussions/maintenance/batchdump/dumpForumPageIds.php $@"
echo $command;
eval $command;
echo == Pages ids dumped: $(eval "wc -l $2")