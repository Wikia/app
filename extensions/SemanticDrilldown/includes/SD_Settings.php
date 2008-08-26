<?php

###
# This is the path to your installation of Semantic Drilldown as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
##
$sdgScriptPath = $wgScriptPath . '/extensions/SemanticDrilldown';
##

###
# This is the path to your installation of Semantic Drilldown as
# seen on your local filesystem. Used against some PHP file path
# issues.
##
$sdgIP = $IP . '/extensions/SemanticDrilldown';
##


// PHP fails to find relative includes at some level of inclusion:
//$pathfix = $IP . $sdgScriptPath;

// load global functions
require_once('SD_GlobalFunctions.php');

###
# If you already have custom namespaces on your site, insert
# $sdgNamespaceIndex = ???;
# into your LocalSettings.php *before* including this file.
# The number ??? must be the smallest even namespace number
# that is not in use yet. However, it should not be smaller
# than 170.
##
if (!isset($sdgNamespaceIndex)) {
        sdfInitNamespaces(170);
} else {
        sdfInitNamespaces();
}

###
## List separator character
###
$sdgListSeparator = ",";

###
## Variables for display
###
$sdgNumResultsColumns = 3;
$sdgNumResultsPerPage = 250;
// set these to a positive value to trigger the "tag cloud" display
$sdgFiltersSmallestFontSize=-1;
$sdgFiltersLargestFontSize=-1;
