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
# Permission to edit form fields defined as 'restricted'
###
$wgGroupPermissions['sysop']['editrestrictedfields'] = true;

###
# List separator character
###
$sfgListSeparator = ",";

###
# The base URL for all YUI Javascript files - to store the YUI library
# locally, download it (from http://developer.yahoo.com/yui/) and change this
# value to the URL of the local installation's 'build' directory.
###
$sfgYUIBase = "http://yui.yahooapis.com/2.6.0/build/";

###
# Extend the edit form from the internal EditPage class rather than using a
# special page and hacking things up.
# 
# @note This is experimental and requires updates to EditPage which I have only
#       added into MediaWiki 1.14a
###
$sfgUseFormEditPage = false;//version_compare( $wgVersion, '1.14alpha', '>=' );

###
# Use 24-hour time format in forms, e.g. 15:30 instead of 3:30 PM
###
$sfg24HourTime = false;
