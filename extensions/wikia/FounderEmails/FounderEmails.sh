#!/bin/bash

cd /usr/wikia/source/wiki/extensions/wikia/FounderEmails/
echo -e "$(date)\n"
ulimit -n 100000
SERVER_ID=177 php maintenance.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --event=daysPassed
SERVER_ID=177 php maintenance.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --event=viewsDigest
SERVER_ID=177 php maintenance.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --event=completeDigest
echo -e "\nDone\n"