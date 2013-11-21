#!/bin/bash

#sudo -u www-data SERVER_ID=298117 php videoPostmigrate.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee -a logs/298117.postmigrate.log

/usr/wikia/backend/bin/withcity --maintenance-script='../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers/videoPostmigrate.php' --usedb=video151 | tee -a logs/298117.postmigrate.log