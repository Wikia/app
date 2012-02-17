#!/bin/sh
if [ -z "$1" ]
then
	echo "Usage ./$0 WIKI_ID"
fi

SERVER_ID=$1 php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php || exit
echo ""
SERVER_ID=$1 php videoPremigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php || exit
echo ""
SERVER_ID=$1 php videoMigrateData.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php || exit
echo ""
SERVER_ID=$1 php videoPostmigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php || exit
echo ""
