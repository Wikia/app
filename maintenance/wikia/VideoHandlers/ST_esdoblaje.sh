#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c B -f esdoblaje
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i esdoblaje.sql.gz
rm esdoblaje.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=44810 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_esdoblaje.log || exit
echo ""
sudo -u www-data SERVER_ID=44810 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_esdoblaje.log || exit
echo ""
