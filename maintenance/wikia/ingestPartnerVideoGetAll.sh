#!/bin/bash
# Mass ingestion script
# Author: Piotr Bablok <pbablok@wikia-inc.com>

counter=0
user="`whoami`"

echo "+====================================+"
echo "|      Mass ingestion script         |"
echo "+------------------------------------+"
echo "| ingestion of historic data from    |"
echo "| selected date up to current        |"
echo "+------------------------------------+"
echo ""
echo "Running as $user"

if [ $user != "release" ]
then
	if [ $user != "www-data" ]
	then
		echo "This script needs to be run as 'www-data' or 'release' user"
		exit
	fi
fi

nowunix=`date '+%s'`
startdate='2007-01-01'
provider='ign'
logfile='/tmp/ingestion.log'

while [ 1 ]
do
	endtime=$(( $counter + 60 * 60 * 24 * 28 - 1 ))

	echo ">>> From: `date -d "$startdate $counter sec"`     To:   `date -d "$startdate $endtime sec"`" | tee -a /tmp/ingestion.log
	sleep 1
	from=`date -d "$startdate $counter sec" '+%s'`
	to=`date -d "$startdate $endtime sec" '+%s'`

	SERVER_ID=298117 php ./ingestPartnerVideoWithData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php -e $to -s $from $provider | tee -a $logfile || exit

	counter=$(( $counter + 60 * 60 * 24 * 28 ))
	from=`date -d "$startdate $counter sec" '+%s'`
	if [ $from -gt $nowunix ]
	then
		echo "Finished ingesting videos"
		exit
	fi
done



