#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f video
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i video.sql.gz
rm video.sql.gz

cd $DIR
sh doAll.sh 298117 | tee video.log.txt

