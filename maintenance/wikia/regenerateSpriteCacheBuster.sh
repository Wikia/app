#!/bin/bash
cd ../../

CB=`date +%Y%m%d`
echo -e "\nRegenerating sprite.png cache buster values using '$CB' value"

echo -e "\nGenerating list of files including sprite.png...\n"
MATCHES=`grep -r sprite.png ./skins ./extensions/wikia | grep -v .svn | grep skins\/monaco\/images\/sprite.png | awk -F: '{ print $1 }' | uniq`

for f in $MATCHES
do
	echo "  $f"
	sed -i "s/\(skins\/monaco\/images\/sprite.png[?a-zA-Z0-9]*\)\(.*\)/skins\/monaco\/images\/sprite.png?$CB\2/g" $f
done

echo -e "\nDone\n"
