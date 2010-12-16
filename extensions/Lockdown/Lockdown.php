<?php

/**
 * Lockdown extension - implements restrictions on individual namespaces and special pages.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

/*
* WARNING: you can use this extension to deny read access to some namespaces. Keep in mind that this 
* may be circumvented in several ways. This extension doesn't try to 
* plug such holes. Also note that pages that are not readable will still be shown in listings,
* such as the search page, categories, etc.
*
* Known ways to access "hidden" pages:
* - transcluding as template (can't really be fixed without disabling inclusion for specific namespaces;
*                            that could be done by adding a hook to Parser::fetchTemplate)
* - Special:export  (easily fixed using $wgSpecialPageLockdown)
* - the search page may find text and show excerpts from hidden pages (should be fixed from MediaWiki 1.16). 
* Some search messages may reveal the page existance by producing links to it (MediaWiki:searchsubtitle, 
* MediaWiki:noexactmatch, MediaWiki:searchmenu-exists, MediaWiki:searchmenu-new...).
* - supplying oldid=<revisionfromhiddenpage> may work in some versions of mediawiki. Same with diff, etc.
*
* NOTE: you cannot GRANT access to things forbidden by $wgGroupPermissions. You can only DENY access
* granted there.
*/
 
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Lockdown', 
	'author' => array( 'Daniel Kinzler', 'Platonides'), 
	'url' => 'http://mediawiki.org/wiki/Extension:Lockdown',
	'description' => 'Per namespace group permissions',
	'descriptionmsg' => 'lockdown-desc',
);

$wgExtensionMessagesFiles['Lockdown'] = dirname(__FILE__) . '/Lockdown.i18n.php';
$wgNamespacePermissionLockdown = array();
$wgSpecialPageLockdown = array();
$wgActionLockdown = array();

$wgHooks['userCan'][] = 'lockdownUserCan';
$wgHooks['MediaWikiPerformAction'][] = 'lockdownMediawikiPerformAction';
$wgHooks['SearchableNamespaces'][] = 'lockdownSearchableNamespaces';
$wgHooks['SearchGetNearMatchComplete'][] = 'lockdownSearchGetNearMatchComplete';
$wgHooks['SearchEngineReplacePrefixesComplete'][] = 'lockdownSearchEngineReplacePrefixesComplete';

function lockdownUserCan( $title, $user, $action, &$result ) {
	global $wgNamespacePermissionLockdown, $wgSpecialPageLockdown, $wgWhitelistRead;
	# print "<br />nsAccessUserCan(".$title->getPrefixedDBkey().", ".$user->getName().", $action)<br />\n";

	$result = null;

	// don't impose extra restrictions on UI pages
	if ( $title->isCssJsSubpage() ) return true;

	if ( $action == 'read' && $wgWhitelistRead ) {
		// don't impose read restrictions on whitelisted pages
		if ( in_array( $title->getPrefixedText(), $wgWhitelistRead ) ) {
			return true;
		}
	}

	$groups = null;
	$ns = $title->getNamespace();
	if ( NS_SPECIAL == $ns ) {
		if ( $action != 'read' ) {
			$result = false;
			return true;
		}
		else {
			foreach ( $wgSpecialPageLockdown as $page => $g ) {
				if ( !$title->isSpecial( $page ) ) continue;
				$groups = $g;
				break;
			}
		}
	}
	else {
		$groups = @$wgNamespacePermissionLockdown[$ns][$action];
		if ( $groups === null ) $groups = @$wgNamespacePermissionLockdown['*'][$action];
		if ( $groups === null ) $groups = @$wgNamespacePermissionLockdown[$ns]['*'];
	}

	if ( $groups === null ) return true;
	if ( count( $groups ) == 0 ) return false;

	# print "<br />nsAccessUserCan(".$title->getPrefixedDBkey().", ".$user->getName().", $action)<br />\n";
	# print_r($groups);

	$ugroups = $user->getEffectiveGroups();
	# print_r($ugroups);

	$match = array_intersect( $ugroups, $groups );
	# print_r($match);

	if ( $match ) {
		# print "<br />PASS<br />\n";
		# group is allowed - keep processing
		$result = null;
		return true;
	}
	else {
		# print "<br />DENY<br />\n";
		# group is denied - abort
		$result = false;
		return false;
	}
}

function lockdownMediawikiPerformAction ( $output, $article, $title, $user, $request, $wiki ) {
	global $wgActionLockdown;

	$action = $wiki->getVal( 'Action' );

	if ( !isset( $wgActionLockdown[$action] ) ) return true;

	$groups = $wgActionLockdown[$action];
	if ( $groups === null ) return true;
	if ( count( $groups ) == 0 ) return false;

	$ugroups = $user->getEffectiveGroups();
	$match = array_intersect( $ugroups, $groups );

	if ( $match ) return true;
	else return false;
}

function lockdownSearchableNamespaces($arr) {
	global $wgUser, $wgNamespacePermissionLockdown;
	$ugroups = $wgUser->getEffectiveGroups();

	foreach ( $arr as $ns => $name ) {
		$groups = @$wgNamespacePermissionLockdown[$ns]['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown['*']['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown[$ns]['*'];
	
		if ( $groups === NULL ) continue;
		
		if ( ( count( $groups ) == 0 ) || !array_intersect($ugroups, $groups) ) {
			unset( $arr[$ns] );
		}
	}
	return true;
}

function lockdownTitle(&$title) {
	if ( is_object($title) ) {
		global $wgUser, $wgNamespacePermissionLockdown;
		$ugroups = $wgUser->getEffectiveGroups();
	
		$groups = @$wgNamespacePermissionLockdown[$title->getNamespace()]['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown['*']['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown[$title->getNamespace()]['*'];
	
		if ( $groups === NULL ) continue;
		
		if ( ( count( $groups ) == 0 ) || !array_intersect($ugroups, $groups) ) {
			$title = null;
			return false;
		}		
	}
	return true;	
}

#Stop a Go search for a hidden title to send you to the login required page. Will show a no such page message instead.
function lockdownSearchGetNearMatchComplete($searchterm, $title) {
	return lockdownTitle( $title );
}

#Protect against namespace prefixes, explicit ones and <searchall> ('all:'-queries).
function lockdownSearchEngineReplacePrefixesComplete($searchEngine, $query, $parsed) {
	global $wgUser, $wgNamespacePermissionLockdown;
	if ( $searchEngine->namespaces === null ) { #null means all namespaces.
		$searchEngine->namespaces = array_keys( SearchEngine::searchableNamespaces() ); #Use the namespaces... filtered
		return true;
	}
			
	$ugroups = $wgUser->getEffectiveGroups();

	foreach ( $searchEngine->namespaces as $key => $ns ) {
		$groups = @$wgNamespacePermissionLockdown[$ns]['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown['*']['read'];
		if ( $groups === NULL ) $groups = @$wgNamespacePermissionLockdown[$ns]['*'];
	
		if ( $groups === NULL ) continue;
		
		if ( ( count( $groups ) == 0 ) || !array_intersect($ugroups, $groups) ) {
			unset( $searchEngine->namespaces[$key] );
		}
	}
	
	if (count($searchEngine->namespaces) == 0) {
		$searchEngine->namespaces = array_keys( SearchEngine::searchableNamespaces() );
	}
	return true;
}
