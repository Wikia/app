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

// PHP fails to find relative includes at some level of inclusion:
//$pathfix = $IP . $dtgScriptPath;

// load global functions
require_once('DT_GlobalFunctions.php');
