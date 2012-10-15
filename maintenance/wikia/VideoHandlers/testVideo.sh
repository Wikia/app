#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c D -f video151
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i video151.sql.gz
rm video151.sql.gz

cd $DIR
sh doAllVideo.sh 298117 | tee video.log.txt

