<?php

/**
 * Lockdown extension - implements restrictions on individual namespaces and special pages.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
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
* - the search page may show excerpts from hidden pages.
* - supplying oldid=<revisionfromhiddenpage> may work in somve versions of mediawiki. Same with diff, etc.
*
* NOTE: you cannot GRANT access to things forbidden by $wgGroupPermissions. You can only DENY access
* granted there.
*/
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array( 
	'name' => 'Lockdown', 
	'author' => 'Daniel Kinzler', 
	'url' => 'http://mediawiki.org/wiki/Extension:Lockdown',
	'description' => 'per-namespace group permissions',
);

$wgNamespacePermissionLockdown = array();
$wgSpecialPageLockdown = array();

$wgHooks['userCan'][] = 'lockdownUserCan';

function lockdownUserCan($title, $user, $action, &$result) {
	global $wgNamespacePermissionLockdown, $wgSpecialPageLockdown, $wgWhitelistRead;
	#print "<br />nsAccessUserCan(".$title->getPrefixedDBkey().", ".$user->getName().", $action)<br />\n";

	$result = NULL;

	//don't impose extra restrictions on UI pages
	if ($title->isCssJsSubpage()) return true;

	if ($action == 'read' && $wgWhitelistRead) {
		//don't impose read restrictions on whitelisted pages
		if (in_array($title->getPrefixedText(), $wgWhitelistRead)) {
			return true;
		}
	}

	$groups = NULL;
	$ns = $title->getNamespace();
	if( NS_SPECIAL == $ns ) {
		if ($action != 'read') {
			$result = false;
			return true;
		}
		else {
			foreach ($wgSpecialPageLockdown as $page => $g) {
				if (!$title->isSpecial($page)) continue;
				$groups = $g;
				break;
			}
		}
	}
	else {
		$groups = @$wgNamespacePermissionLockdown[$ns][$action];
		if (!$groups) $groups = @$wgNamespacePermissionLockdown['*'][$action];
		if (!$groups) $groups = @$wgNamespacePermissionLockdown[$ns]['*'];
	}

	if (!$groups) return true;

	#print "<br />nsAccessUserCan(".$title->getPrefixedDBkey().", ".$user->getName().", $action)<br />\n";
	#print_r($groups);

	$ugroups = $user->getEffectiveGroups();
	#print_r($ugroups);

	$match = array_intersect($ugroups, $groups);
	#print_r($match);

	if ($match) {
		#print "<br />PASS<br />\n";
		#group is allowed - keep processing
		$result = NULL;
		return true;
	}
	else {
		#print "<br />DENY<br />\n";
		#group is denied - abort
		$result = false;
		return false;
	}
}

