#!/bin/bash

#scriptpath="../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers"
scriptpath="../../../../../usr/wikia/mac/maintenance/wikia/VideoHandlers"

TMPFILE=`mktemp /tmp/$0.XXXXXX` || exit 1
echo "Getting list of wikis..."
echo "select distinct wiki_id, wiki_id, wiki_dbname from video_migration_log where action_name='POSTMIGRATION' and action_status='STOP'" | /usr/wikia/backend/bin/master dataware > $TMPFILE
cat $TMPFILE
cat $TMPFILE | while read line; do
	cityid=`echo "$line" | cut -f 1`
	dbname=`echo "$line" | cut -f 3`
	echo "Processing $line ($cityid, $dbname)"

	/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoCleanup.php" --usedb=$dbname | tee -a logs/${cityid}.cleanup.log || die

	echo "---"
done
