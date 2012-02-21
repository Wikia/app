#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c B -f legonxt
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i legonxt.sql.gz
rm legonxt.sql.gz

cd $DIR
sh doAll.sh 63219 | tee legonxt.log.txt