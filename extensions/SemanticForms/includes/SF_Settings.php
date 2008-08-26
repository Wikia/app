<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if (!defined('MEDIAWIKI')) die();

###
# This is the path to your installation of Semantic Forms as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
##
$sfgScriptPath = $wgScriptPath . '/extensions/SemanticForms';
##

###
# This is the path to your installation of Semantic Forms as
# seen on your local filesystem. Used against some PHP file path
# issues.
##
$sfgIP = $IP . '/extensions/SemanticForms';
##


// PHP fails to find relative includes at some level of inclusion:
//$pathfix = $IP . $sfgScriptPath;

// load global functions
require_once('SF_GlobalFunctions.php');

###
# If you already have custom namespaces on your site, insert
# $sfgNamespaceIndex = ???;
# into your LocalSettings.php *before* including this file.
# The number ??? must be the smallest even namespace number
# that is not in use yet. However, it must not be smaller
# than 150.
##
if (!isset($sfgNamespaceIndex)) {
        sffInitNamespaces(150);
} else {
        sffInitNamespaces();
}

###
# The number of allowed values per autocomplete - too many might
# slow down the database, and Javascript's completion
###
$sfgMaxAutocompleteValues = 1000;

###
# Global variables for handling the two edit tabs (for traditional editing
# and for editing with a form):
# $sfgRenameEditTabs renames the edit-with-form tab to just "Edit", and
#   the traditional-editing tab, if it is visible, to "Edit source", in
#   whatever language is being used.
# The wgGroupPermissions 'viewedittab' setting dictates which types of
# visitors will see the "Edit" tab, for pages that are editable by form -
# by default all will see it.
###
$sfgRenameEditTabs = false;
$wgGroupPermissions['*'    ]['viewedittab']   = true;
$wgAvailableRights[] = 'viewedittab';

###
# List separator character
###
$sfgListSeparator = ",";

###
# The base URL for all YUI Javascript files - to store the YUI library
# locally, download it and change this to the URL of the local
# installation's 'build' directory.
###
$sfgYUIBase = "http://yui.yahooapis.com/2.5.1/build/";

?>
