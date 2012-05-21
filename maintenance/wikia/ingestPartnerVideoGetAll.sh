#!/bin/bash
# Mass ingestion script
# Author: Piotr Bablok <pbablok@wikia-inc.com>

counter=0
user="`whoami`"

echo "+====================================+"
echo "|      Mass ingestion script         |"
echo "+------------------------------------+"
echo "| ingestion of historic data from    |"
echo "| 2001 up to the current date        |"
echo "+------------------------------------+"
echo ""
echo "Running as $user"

if [ $user != "www-data" ]
then
	echo "This script needs to be run as www-data user"
	exit
fi

nowunix=`date '+%s'`

while [ 1 ]
do
	endtime=$(( $counter + 60 * 60 * 24 * 7 - 1 ))

	echo ">>> From: `date -d "2001-01-01 $counter sec"`	To:   `date -d "2001-01-01 $endtime sec"`" | tee -a /tmp/ingestion.log
	sleep 1
	from=`date -d "2001-01-01 $counter sec" '+%s'`
	to=`date -d "2001-01-01 $endtime sec" '+%s'`

	SERVER_ID=298117 php ./ingestPartnerVideoWithData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php -e $to -s $from -d | tee -a /tmp/ingestion.log || exit

	counter=$(( $counter + 60 * 60 * 24 * 7 ))
	from=`date -d "2001-01-01 $counter sec" '+%s'`
	if [ $from -gt $nowunix ]
	then
		echo "Finished ingesting videos"
		exit
	fi
done



