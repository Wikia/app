#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f Callofduty
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i Callofduty.sql.gz
rm Callofduty.sql.gz

cd $DIR
sh doAll.sh 3125 | tee Callofduty.log.txt