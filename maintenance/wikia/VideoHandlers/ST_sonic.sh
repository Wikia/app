#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f B -f sonic
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i sonic.sql.gz
rm sonic.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=663 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_sonic.log || exit
echo ""
sudo -u www-data SERVER_ID=663 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_sonic.log || exit
echo ""
