#!/bin/sh
echo "Usage ./$0 WIKI_ID"

SERVER_ID=$1 php videoPremigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
SERVER_ID=$1 php videoMigrateData.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
SERVER_ID=$1 php videoPostmigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
