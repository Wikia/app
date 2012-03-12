#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c B -f icarly
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i icarly.sql.gz
rm icarly.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=6342 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_icarly.log || exit
echo ""
sudo -u www-data SERVER_ID=6342 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_icarly.log || exit
echo ""
