<?php
/** \file
* \brief Contains setup code for the User Merge and Delete Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo "User Merge and Delete extension";
        exit(1);
}

$wgExtensionFunctions[] = 'efUserMerge';
$wgExtensionCredits['specialpage'][] = array(
    'name'           => 'User Merge and Delete',
    'url'            => 'http://www.mediawiki.org/wiki/Extension:User_Merge_and_Delete',
    'author'         => 'Tim Laqua',
    'description'    => "Merges references from one user to another user in the Wiki database - will also delete old users following merge.  Requires 'usermerge' privileges.",
    'descriptionmsg' => 'usermerge-desc',
    'version'        => '1.5'
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['UserMerge'] = $dir . 'UserMerge_body.php';

$wgExtensionMessagesFiles['UserMerge'] = $dir . 'UserMerge.i18n.php';
$wgSpecialPages['UserMerge'] = 'UserMerge';
$wgSpecialPageGroups['UserMerge'] = 'users';

$wgUserMergeProtectedGroups = array( "sysop" );

function efUserMerge() {
	# Add a new log type
	global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
	$wgLogTypes[]                 		= 'usermerge';
	$wgLogNames['usermerge']            = 'usermerge-logpage';
	$wgLogHeaders['usermerge']          = 'usermerge-logpagetext';
	$wgLogActions['usermerge/mergeuser'] 	= 'usermerge-success-log';
	$wgLogActions['usermerge/deleteuser']	= 'usermerge-userdeleted-log';
}
