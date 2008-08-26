<?php
/**
* GroupPermissions Manager extension by Ryan Schmidt
* Allows privelaged users to modify group permissions via a special page
* See http://www.mediawiki.org/wiki/Extension:GroupPermissions_Manager for more info
* Licensed under the GPL.
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'GroupPermissions Manager',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GroupPermissionsManager',
	'version'        => '3.2.2',
	'description'    => 'Manage group permissions via a special page',
	'descriptionmsg' => 'grouppermissions-desc',
);
$wgAutoloadClasses['GroupPermissions'] = dirname(__FILE__) . '/GroupPermissionsManager_body.php';
$wgAutoloadClasses['RemoveUnusedGroups'] = dirname(__FILE__) . '/RemoveUnusedGroups.php';
$wgAutoloadClasses['SortPermissions'] = dirname(__FILE__) . '/SortPermissions.php';
$wgSpecialPages['GroupPermissions'] = 'GroupPermissions';
$wgSpecialPages['RemoveUnusedGroups'] = 'RemoveUnusedGroups';
$wgSpecialPages['SortPermissions'] = 'SortPermissions';
$wgExtensionMessagesFiles['GroupPermissions'] = dirname(__FILE__) . '/GetMessages.php';

$wgLogTypes[] = 'gpmanager';
$wgLogActions['gpmanager/add'] = 'grouppermissions-log-add';
$wgLogActions['gpmanager/change'] = 'grouppermissions-log-change';
$wgLogActions['gpmanager/delete'] = 'grouppermissions-log-delete';
$wgLogActions['gpmanager/gpmanager'] = 'grouppermissions-log-entry';
$wgLogHeaders['gpmanager'] = 'grouppermissions-log-header';
$wgLogNames['gpmanager'] = 'grouppermissions-log-name';
$wgSpecialPageGroups['GroupPermissions'] = 'wiki';
$wgSpecialPageGroups['RemoveUnusedGroups'] = 'users';
$wgSpecialPageGroups['SortPermissions'] = 'wiki';

##Permission required to use the 'GroupPermissions' and 'SortPermissions' special page
##By default all bureaucrats can
$wgGroupPermissions['bureaucrat']['grouppermissions'] = true;
##Uncomment this if you want to make a separate group that can access the page as well
#$wgGroupPermissions['grouppermissions']['grouppermissions'] = true;
##'RemoveUnusedGroups' requires the 'userrights' permission, also given to bureaucrats by default

$wgGPManagerNeverGrant = array();
$wgGPManagerSort = array();
$wgGPManagerSortTypes = array( 'read', 'edit', 'manage', 'admin', 'tech', 'misc' );

##Default permissions for the ones added by Permissions++ extension
###Reading-related permissions
$wgGroupPermissions['*']['viewsource'] = true; //allows viewing of wiki source when one cannot edit the page
$wgGroupPermissions['*']['history'] = true; //allows viewing of page histories
$wgGroupPermissions['*']['raw'] = true; //allows use of action=raw
$wgGroupPermissions['*']['render'] = true; //allows use of action=render
$wgGroupPermissions['*']['info'] = true; //allows use of action=info if the option is enabled
$wgGroupPermissions['*']['credits'] = true; //allows use of action=credits
$wgGroupPermissions['*']['search'] = true; //allows access to Special:Search
$wgGroupPermissions['*']['recentchanges'] = true; //allows access to Special:RecentChanges
$wgGroupPermissions['*']['contributions'] = true; //allows viewing Special:Contributions pages, including own
###Editing-related permissions
###Note that 'edit' is reduced to only allowing editing of non-talk pages now, it is NOT a global toggle anymore
###In addition, 'createpage', and 'createtalk' no longer require the 'edit' right, this can be useful if you want to allow people to make pages, but not edit existing ones
$wgGroupPermissions['*']['edittalk'] = true; //can edit talk pages, including use of section=new

##Grouping of permissions for the GPManager
$wgGPManagerSort['read'] = array( 'read', 'viewsource', 'history', 'raw', 'render', 'info',
'credits', 'search', 'recentchanges', 'contributions' );
$wgGPManagerSort['edit'] = array( 'edit', 'createpage', 'createtalk', 'move', 'move-subpages',
'createaccount', 'upload', 'reupload', 'reupload-shared', 'upload_by_url',
'editprotected', 'edittalk', 'writeapi' );
$wgGPManagerSort['manage'] = array( 'delete', 'bigdelete', 'deletedhistory', 'undelete', 'mergehistory',
'protect', 'block', 'blockemail', 'hideuser', 'userrights', 'userrights-interwiki', 'rollback', 'markbotedits',
'patrol', 'editinterface', 'editusercssjs', 'hiderevision', 'deleterevision', 'browsearchive', 'suppressrevision',
'suppressionlog', 'suppress' );
$wgGPManagerSort['admin'] = array( 'siteadmin', 'import', 'importupload', 'trackback', 'unwatchedpages',
'grouppermissions' );
$wgGPManagerSort['tech'] = array( 'bot', 'purge', 'minoredit', 'nominornewtalk', 'ipblock-exempt',
'proxyunbannable', 'autopatrol', 'apihighlimits', 'suppressredirect', 'autoconfirmed',
'emailconfirmed', 'noratelimit' );
$wgGPManagerSort['misc'] = array(); //all rights added by extensions that don't have a sort clause get put here

//let's get all the plugins and load them.
$plugins = scandir(dirname(__FILE__) . '/plugins');
if($plugins && is_array($plugins)) {
	foreach($plugins as $file) {
		//only get .php or .php5 files (prevents dirs and stuff from being included)
		if(preg_match('/\.php5?$/i', $file)) {
			require_once(dirname(__FILE__) . '/plugins/' . $file);
		}
	}
}

##Load the config files, if they exist. This must be the last thing to run in the startup part
##Sort comes before the normal group defines since sort sets stuff to false simply to declare new permissions
if(file_exists(dirname(__FILE__) . '/config/SortPermissions.php')) {
	require(dirname(__FILE__) . '/config/SortPermissions.php');
}
if(file_exists(dirname(__FILE__) . '/config/GroupPermissions.php') ) {
	require(dirname(__FILE__) . '/config/GroupPermissions.php');
}

//Since the one in Title.php is private...
function getTitleProtection($title) {
	// Can't protect pages in special namespaces
	if ( $title->getNamespace() < 0 ) {
		return false;
	}

	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select( 'protected_titles', '*',
		array ('pt_namespace' => $title->getNamespace(), 'pt_title' => $title->getDBkey()) );

	if ($row = $dbr->fetchRow( $res )) {
		return $row;
	} else {
		return false;
	}
}

//was added in 1.13, so supporting for downwards compatibility with 1.12
if(!function_exists('addScriptFile')) {
	function addScriptFile( $file ) {
		global $wgStylePath, $wgStyleVersion, $wgJsMimeType, $wgOut;
		if( substr( $file, 0, 1 ) == '/' ) {
			$path = $file;
		} else {
			$path =  "{$wgStylePath}/common/{$file}";
		}
		$encPath = htmlspecialchars( $path );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$path?$wgStyleVersion\"></script>\n" );
	}
}