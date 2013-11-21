#!/bin/bash

scriptpath="../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers"
#scriptpath="../../../../../usr/wikia/mac/maintenance/wikia/VideoHandlers"

TMPFILE=`mktemp /tmp/$0.XXXXXX` || exit 1
echo "Getting list of wikis..."
echo "select
wiki_id, wiki_id, wiki_dbname, wiki_name
from video_notmigrated2;" | /usr/wikia/backend/bin/slave dataware > $TMPFILE
cat $TMPFILE
cat $TMPFILE | while read line; do
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
