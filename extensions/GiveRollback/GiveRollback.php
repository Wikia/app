<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**
 * Special page to allow local bureaucrats to give rollback permissions to
 * a non-sysop user
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Give Rollback',
	'svn-date' => '$LastChangedDate: 2008-05-31 03:03:00 +0000 (Sat, 31 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 35631 $',
	'author' => 'Rob Church',
	'description' => 'Allows local bureaucrats to give [[Special:Giverollback|rollback permissions]] to a non-sysop user',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Giverollback',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['GiveRollback'] = $dir . 'GiveRollback.i18n.php';
$wgAutoloadClasses['GiveRollback'] = $dir . 'GiveRollback.page.php';
$wgSpecialPages['Giverollback'] = 'GiveRollback';
$wgSpecialPageGroups['Giverollback'] = 'users';
$wgAvailableRights[] = 'giverollback';

$wgExtensionFunctions[] = 'efGiveRollback';

/**
 * Determines who can use the extension; as a default, bureaucrats are permitted
 */
$wgGroupPermissions['bureaucrat']['giverollback'] = true;

/**
 * User group with rollback capabilities
 */
$wgGroupPermissions['rollback']['rollback'] = true;

/**
 * Populate the message cache, set up the auditing and register the special page
 */
function efGiveRollback() {
	global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
	$wgLogTypes[] = 'gvrollback';
	$wgLogNames['gvrollback'] = 'giverollback-logpage';
	$wgLogHeaders['gvrollback'] = 'giverollback-logpagetext';
	$wgLogActions['gvrollback/grant']  = 'giverollback-logentrygrant';
	$wgLogActions['gvrollback/revoke'] = 'giverollback-logentryrevoke';
}
