#/bin/bash
TMPFILE=`mktemp /tmp/$0.XXXXXX` || exit 1
echo "Getting list of wikis..."
echo "select
c.city_id, count(*), c.city_dbname
from events, wikicities.city_list as c
where c.city_id = wiki_id and page_ns = 400 and event_type = 2
group by wiki_id order by count(*) desc;" | slave stats > $TMPFILE
cat $TMPFILE
cat $TMPFILE | while read line; do
	cityid=`echo "$line" | cut -f 1`
	if [ "$cityid" = "city_id" ];
	then
		continue
	fi
	if [ "$cityid" = "298117" ];
	then
		continue
	fi
	echo "Processing $line"
	sudo -u www-data SERVER_ID=$cityid php videoSanitize.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee -a logs/${cityid}.sanitize.log
	echo "\n\n"
done
rm -f $TMPFILE