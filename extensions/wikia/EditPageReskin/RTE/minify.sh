#!/bin/bash
# This shell script is used to concatenate and minify JS and CSS files (CK core and RTE code)
svn up

if [ -n "$1" ]
then
	SERVER_ID=177 php minify.php $*
else
	SERVER_ID=177 php minify.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
fi
