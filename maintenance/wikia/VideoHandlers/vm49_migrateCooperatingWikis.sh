#/bin/bash
TMPFILE=`mktemp /tmp/$0.XXXXXX` || exit 1
echo "Getting list of wikis..."
echo "select
c.city_id, count(*), c.city_dbname
from events, wikicities.city_list as c
where c.city_id = wiki_id and page_ns = 400 and event_type = 2 and (wiki_id = 3125 OR wiki_id = 7414 OR wiki_id = 95889)
group by wiki_id order by count(*) desc;" | /usr/wikia/backend/bin/slave stats > $TMPFILE
cat $TMPFILE
cat $TMPFILE | while read line; do
	cityid=`echo "$line" | cut -f 1`
	dbname=`echo "$line" | cut -f 3`
	if [ "$cityid" = "city_id" ];
	then
		continue
	fi
	if [ "$cityid" = "298117" ];
	then
		continue
	fi
	if [ "$cityid" = "80433" ];
	then
		continue
	fi
	echo "Processing $line"
	#sudo -u www-data SERVER_ID=$cityid php videoMigrateData.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee -a logs/${cityid}.migratedata.log
	#sudo -u www-data SERVER_ID=$cityid php videoPostmigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee -a logs/${cityid}.postmigrate.log

	/usr/wikia/backend/bin/withcity --maintenance-script='../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers/videoMigrateData.php' --usedb=$dbname | tee -a logs/${cityid}.migratedata.log
	/usr/wikia/backend/bin/withcity --maintenance-script='../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers/videoPostmigrate.php' --usedb=$dbname | tee -a logs/${cityid}.postmigrate.log

	echo "---"
done
rm -f $TMPFILE