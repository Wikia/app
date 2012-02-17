#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f twilightsaga
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i twilightsaga.sql.gz
rm twilightsaga.sql.gz

cd $DIR
sh doAll.sh 5687 | tee twilight.log.txt