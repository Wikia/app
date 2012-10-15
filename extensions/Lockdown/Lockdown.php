<?php

/**
 * Lockdown extension - implements restrictions on individual namespaces and special pages.
 *
 * @file
 * @ingroup Extensions
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
* - transcluding as template. can be avoided using $wgNonincludableNamespaces.
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
	'descriptionmsg' => 'lockdown-desc',
);

$wgExtensionMessagesFiles['Lockdown'] = dirname(__FILE__) . '/Lockdown.i18n.php';
$wgNamespacePermissionLockdown = array();
$wgSpecialPageLockdown = array();
$wgActionLockdown = array();

$wgHooks['getUserPermissionsErrors'][] = 'lockdownUserPermissionsErrors';
$wgHooks['MediaWikiPerformAction'][] = 'lockdownMediawikiPerformAction';
$wgHooks['SearchableNamespaces'][] = 'lockdownSearchableNamespaces';
$wgHooks['SearchGetNearMatchComplete'][] = 'lockdownSearchGetNearMatchComplete';
$wgHooks['SearchEngineReplacePrefixesComplete'][] = 'lockdownSearchEngineReplacePrefixesComplete';

function lockdownUserPermissionsErrors( $title, $user, $action, &$result ) {
	global $wgNamespacePermissionLockdown, $wgSpecialPageLockdown, $wgWhitelistRead, $wgLang;

	$result = null;
	
	// don't impose extra restrictions on UI pages
	if ( $title->isCssJsSubpage() ) {
		return true;
	}

	if ( $action == 'read' && $wgWhitelistRead ) {
		// don't impose read restrictions on whitelisted pages
		if ( in_array( $title->getPrefixedText(), $wgWhitelistRead ) ) {
			return true;
		}
	}

	$groups = null;
	$ns = $title->getNamespace();
	if ( NS_SPECIAL == $ns ) {
		foreach ( $wgSpecialPageLockdown as $page => $g ) {
			if ( !$title->isSpecial( $page ) ) continue;
			$groups = $g;
			break;
		}
	}
	else {
		$groups = @$wgNamespacePermissionLockdown[$ns][$action];
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown['*'][$action];
		}
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown[$ns]['*'];
		}
	}

	if ( $groups === null ) {
		#no restrictions
		return true;
	}
	
	if ( !$groups ) {
		#no groups allowed

		$result = array(
			'badaccess-group0'
		);
		
		return false;
	}

	$ugroups = $user->getEffectiveGroups( true );;

	$match = array_intersect( $ugroups, $groups );

	if ( $match ) {
		# group is allowed - keep processing
		$result = null;
		return true;
	} else {
		# group is denied - abort
		$groupLinks = array_map( array( 'User', 'makeGroupLinkWiki' ), $groups );
		
		$result = array(
			'badaccess-groups',
			$wgLang->commaList( $groupLinks ),
			count( $groups )
		);
				
		return false;
	}
}

function lockdownMediawikiPerformAction ( $output, $article, $title, $user, $request, $wiki ) {
	global $wgActionLockdown, $wgLang;

	$action = $wiki->getAction( $request );

	if ( !isset( $wgActionLockdown[$action] ) ) {
		return true;
	}

	$groups = $wgActionLockdown[$action];
	if ( $groups === null ) {
		return true;
	}
	if ( !$groups ) {
		return false;
	}

	$ugroups = $user->getEffectiveGroups( true );;
	$match = array_intersect( $ugroups, $groups );

	if ( $match ) {
		return true;
	} else {
		$groupLinks = array_map( array( 'User', 'makeGroupLinkWiki' ), $groups );
		
		$err = array( 'badaccess-groups', $wgLang->commaList( $groupLinks ), count( $groups ) );
		throw new PermissionsError( 'delete', array( $err ) );
		
		return false;
	}
}

function lockdownSearchableNamespaces($arr) {
	global $wgUser, $wgNamespacePermissionLockdown;

	//don't continue if $wgUser's name and id are both null (bug 28842)
	if ( $wgUser->getId() === null && $wgUser->getName() === null ) {
		return true;
	}

	$ugroups = $wgUser->getEffectiveGroups( true );;

	foreach ( $arr as $ns => $name ) {
		$groups = @$wgNamespacePermissionLockdown[$ns]['read'];
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown['*']['read'];
		}
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown[$ns]['*'];
		}

		if ( $groups === null ) {
			continue;
		}

		if ( !$groups || !array_intersect( $ugroups, $groups ) ) {
			unset( $arr[$ns] );
		}
	}
	return true;
}

function lockdownTitle(&$title) {
	if ( is_object($title) ) {
		global $wgUser, $wgNamespacePermissionLockdown;
		$ugroups = $wgUser->getEffectiveGroups( true );;

		$groups = @$wgNamespacePermissionLockdown[$title->getNamespace()]['read'];
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown['*']['read'];
		}
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown[$title->getNamespace()]['*'];
		}

		if ( $groups === null ) {
			return false;
		}

		if ( !$groups || !array_intersect($ugroups, $groups) ) {
			$title = null;
			return false;
		}
	}
	return true;
}

#Stop a Go search for a hidden title to send you to the login required page. Will show a no such page message instead.
function lockdownSearchGetNearMatchComplete( $searchterm, $title ) {
	return lockdownTitle( $title );
}

#Protect against namespace prefixes, explicit ones and <searchall> ('all:'-queries).
function lockdownSearchEngineReplacePrefixesComplete( $searchEngine, $query, $parsed ) {
	global $wgUser, $wgNamespacePermissionLockdown;
	if ( $searchEngine->namespaces === null ) { #null means all namespaces.
		$searchEngine->namespaces = array_keys( SearchEngine::searchableNamespaces() ); #Use the namespaces... filtered
		return true;
	}

	$ugroups = $wgUser->getEffectiveGroups( true );;

	foreach ( $searchEngine->namespaces as $key => $ns ) {
		$groups = @$wgNamespacePermissionLockdown[$ns]['read'];
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown['*']['read'];
		}
		if ( $groups === null ) {
			$groups = @$wgNamespacePermissionLockdown[$ns]['*'];
		}

		if ( $groups === null ) {
			continue;
		}

		if ( !$groups || !array_intersect( $ugroups, $groups ) ) {
			unset( $searchEngine->namespaces[$key] );
		}
	}

	if ( count( $searchEngine->namespaces ) == 0 ) {
		$searchEngine->namespaces = array_keys( SearchEngine::searchableNamespaces() );
	}
	return true;
}
