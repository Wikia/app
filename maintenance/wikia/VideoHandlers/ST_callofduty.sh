#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f Callofduty
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i Callofduty.sql.gz
rm Callofduty.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=3125 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_callofduty.log || exit
echo ""
sudo -u www-data SERVER_ID=3125 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_callofduty.log || exit
echo ""
