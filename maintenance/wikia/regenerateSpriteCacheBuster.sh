#!/bin/bash
cd ../../

# cache buster value to be used
CB=`date +%Y%m%d`

# add extra string to cache buster if script is run with extra param
if [ "$1" != "" ]; then
	CB=$CB'.'$1
fi

echo -e "\nRegenerating sprite.png cache buster values using '$CB' value"

# list of CSS/JS files to be modified
echo -e "\nGenerating list of files including sprite.png...\n"
MATCHES=`grep -r sprite.png ./skins ./extensions/wikia | grep -v .svn | grep skins\/monaco\/images\/sprite.png | awk -F: '{ print $1 }' | uniq`

for f in $MATCHES
do
	echo "  $f"
	sed -i "s/\(skins\/monaco\/images\/sprite.png[?a-zA-Z0-9.]*\)\(.*\)/skins\/monaco\/images\/sprite.png?$CB\2/g" $f
done

echo -e "\nDone\n"
