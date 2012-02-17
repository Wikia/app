#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f beer
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i beer.sql.gz
rm beer.sql.gz

cd $DIR
sh doAll.sh 442

