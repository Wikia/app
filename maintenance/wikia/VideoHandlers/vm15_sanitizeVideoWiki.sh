#!/bin/bash

/usr/wikia/backend/bin/withcity --maintenance-script='../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers/videoSanitizeVideoWiki.php' --usedb=video151 | tee -a logs/298117.sanitize.log
