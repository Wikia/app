#!/bin/bash

ulimit -v 400000

trap 'kill %-; exit' SIGTERM
[ ! -z "$1" ] && {
	echo "starting type-specific job runner: $1"
	type=$1
}

#types="htmlCacheUpdate sendMail enotifNotify uploadFromUrl fixDoubleRedirect renameUser"
types="sendMail enotifNotify uploadFromUrl fixDoubleRedirect MoodBarHTMLMailerJob"

cd `readlink -f /usr/local/apache/common/multiversion`
while [ 1 ];do
	# Do the prioritised types
	moreprio=y
	while [ -n "$moreprio" ] ; do
		moreprio=
		for type in $types; do
			db=`php -n MWScript.php nextJobDB.php --wiki=aawiki --type="$type"`
			if [ -n "$db" ]; then
				echo "$db $type"
				nice -n 20 php MWScript.php runJobs.php --wiki="$db" --procs=5 --type="$type" --maxtime=300 &
				wait
				moreprio=y
			fi
		done
	done

	# Do the remaining types
	db=`php -n MWScript.php nextJobDB.php --wiki=aawiki`

	if [ -z "$db" ];then
		# No jobs to do, wait for a while
		echo "No jobs..."
		sleep 5
	else
		echo "$db"
		nice -n 20 php MWScript.php runJobs.php --wiki="$db" --procs=5 --maxtime=300 &
		wait
	fi
done
