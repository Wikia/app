<?php

###
# This is the path to your installation of the Data Transfer extension as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
##
$dtgScriptPath = $wgScriptPath . '/extensions/DataTransfer';
##

###
# This is the path to your installation of Data Transfer as
# seen on your local filesystem. Used against some PHP file path
# issues.
##
$dtgIP = $IP . '/extensions/DataTransfer';
##

###
# Permission to import files
###
$wgGroupPermissions['sysop']['datatransferimport'] = true;
$wgAvailableRights[] = 'datatransferimport';

// load global functions
require_once('DT_GlobalFunctions.php');

// initialize content language
global $wgLanguageCode;
dtfInitContentLanguage($wgLanguageCode);
