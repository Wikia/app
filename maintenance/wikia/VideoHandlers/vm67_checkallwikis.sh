#!/bin/bash

scriptpath="../../../../../home/release/video_refactoring/trunk/maintenance/wikia/VideoHandlers"
#scriptpath="../../../../../usr/wikia/mac/maintenance/wikia/VideoHandlers"

/usr/wikia/backend/bin/withcity --maintenance-script="$scriptpath/videoCheckMigrated.php"
