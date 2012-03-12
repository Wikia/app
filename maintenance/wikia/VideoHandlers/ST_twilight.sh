#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -c C -f twilightsaga
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i twilightsaga.sql.gz
rm twilightsaga.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=5687 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_twilight.log || exit
echo ""
sudo -u www-data SERVER_ID=5687 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_twilight.log || exit
echo ""
