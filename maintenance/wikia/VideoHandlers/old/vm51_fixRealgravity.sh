#!/bin/bash

#sudo -u www-data SERVER_ID=298117 php videoMigrateData_FixRealgravityOnVideoWikia.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php | tee -a logs/298117.migratedata.log

/usr/wikia/backend/bin/withcity --maintenance-script='../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers/videoMigrateData_FixRealgravityOnVideoWikia.php' --usedb=video151 | tee -a logs/298117.migratedata.log