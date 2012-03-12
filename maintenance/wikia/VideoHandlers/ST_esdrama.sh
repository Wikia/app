#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd /tmp
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -f esdrama
php /usr/wikia/source/wiki/maintenance/wikia/getDatabase.php -i esdrama.sql.gz
rm esdrama.sql.gz

cd $DIR
sudo -u www-data SERVER_ID=14316 php videoReset.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_esdrama.log || exit
echo ""
sudo -u www-data SERVER_ID=14316 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee ST_esdrama.log || exit
echo ""
