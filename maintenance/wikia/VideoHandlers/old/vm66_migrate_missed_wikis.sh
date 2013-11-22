#!/bin/bash

scriptpath="../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers"
#scriptpath="../../../../../usr/wikia/mac/maintenance/wikia/VideoHandlers"

echo "11551	11551	azumanga
22850	22850	casemod
31749	31749	kissxsis
37982	37982	minamike" | while read line; do
	cityid=`echo "$line" | cut -f 1`
	dbname=`echo "$line" | cut -f 3`
	echo "Processing $line ($cityid, $dbname)"

	#/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoReset.php" --usedb=$dbname
	/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoSanitize.php" --usedb=$dbname | tee -a logs/${cityid}.sanitize.log || die
	/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoPremigrate.php" --usedb=$dbname | tee -a logs/${cityid}.premigrate.log || die
	/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoMigrateData.php" --usedb=$dbname | tee -a logs/${cityid}.migratedata.log || die
	/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoPostmigrate.php" --usedb=$dbname | tee -a logs/${cityid}.postmigrate.log || die

	echo "---"
done
