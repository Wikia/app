#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f potcoplayers
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i potcoplayers.sql.gz
rm potcoplayers.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=95889 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_potoplayers.log || exit
echo ""
sudo -u www-data SERVER_ID=95889 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_potoplayers.log || exit
echo ""
