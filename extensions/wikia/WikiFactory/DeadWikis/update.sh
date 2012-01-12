#!/bin/bash

SERVER_ID=177 php -d display_startup_errors=1 -d display_errors=1 `dirname $0`/update.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --from $1 --to $2 --debug 

