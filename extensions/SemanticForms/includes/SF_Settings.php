<?php
/**
 * Default settings for Semantic Forms.
 * 
 * Note: 
 * Do not use this file as entry point,
 * use SemanticForms.php in this extensions root instead.
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

# ##
# This is the path to your installation of Semantic Forms as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# #
$sfgPartialPath = '/extensions/SemanticForms';
$sfgScriptPath = $wgScriptPath . $sfgPartialPath;
# #

# ##
# This is the path to your installation of Semantic Forms as
# seen on your local filesystem. Used against some PHP file path
# issues.
# #
$sfgIP = dirname( __FILE__ ) . '/..';
# #


// PHP fails to find relative includes at some level of inclusion:
// $pathfix = $IP . $sfgScriptPath;

// load global functions
require_once( 'SF_GlobalFunctions.php' );

sffInitNamespaces();

# ##
# The number of allowed values per autocomplete - too many might
# slow down the database, and Javascript's completion
# ##
$sfgMaxAutocompleteValues = 1000;

# ##
# Whether to autocomplete on all characters in a string, not just the
# beginning of words - this is especially important for Unicode strings,
# since the use of the '\b' regexp character to match on the beginnings
# of words fails for them.
# ##
$sfgAutocompleteOnAllChars = false;

# ##
# Global variables for handling the two edit tabs (for traditional editing
# and for editing with a form):
# $sfgRenameEditTabs renames the edit-with-form tab to just "Edit", and
#   the traditional-editing tab, if it is visible, to "Edit source", in
#   whatever language is being used.
# $sfgRenameMainEditTab renames only the traditional editing tab, to
#   "Edit source".
# The wgGroupPermissions 'viewedittab' setting dictates which types of
# visitors will see the "Edit" tab, for pages that are editable by form -
# by default all will see it.
# ##
$sfgRenameEditTabs = false;
$sfgRenameMainEditTab = false;
$wgGroupPermissions['*']['viewedittab']   = true;
$wgAvailableRights[] = 'viewedittab';

# ##
# Permission to edit form fields defined as 'restricted'
# ##
$wgGroupPermissions['sysop']['editrestrictedfields'] = true;
$wgAvailableRights[] = 'editrestrictedfields';

# ##
# Permission to view, and create pages with, Special:CreateClass
# ##
$wgGroupPermissions['user']['createclass'] = true;
$wgAvailableRights[] = 'createclass';

# ##
# List separator character
# ##
$sfgListSeparator = ",";

# ##
# Extend the edit form from the internal EditPage class rather than using a
# special page and hacking things up.
# 
# @note This is experimental and requires updates to EditPage which I have only
#       added into MediaWiki 1.14a
# ##
$sfgUseFormEditPage = false;// method_exists('EditPage', 'showFooter');

# ##
# Use 24-hour time format in forms, e.g. 15:30 instead of 3:30 PM
# ##
$sfg24HourTime = false;

# ##
# Cache parsed form definitions in the page_props table, to improve loading
# speed
# ##
$sfgCacheFormDefinitions = false;

# ##
# When modifying red links to potentially point to a form to edit that page,
# check only the properties pointing to that missing page from the page the
# user is currently on, instead of from all pages in the wiki.
# ##
$sfgRedLinksCheckOnlyLocalProps = false;

# ##
# Page properties, used for the API
# ##
$wgPageProps['formdefinition'] = 'Definition of the semantic form used on the page';

# ##
# Global variables for Javascript
# ##
$sfgAdderButtons = array();
$sfgShowOnSelect = array();
$sfgAutocompleteValues = array();
