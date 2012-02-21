#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c B -f muppets
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i muppets.sql.gz
rm muppets.sql.gz

cd $DIR
sh doAll.sh 831 | tee muppets.log.txt