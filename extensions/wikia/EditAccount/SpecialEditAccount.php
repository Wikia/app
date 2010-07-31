<?php
/**
 * EditAccount
 *
 * This extension is used by Wikia Staff to manage essential user account information
 * in the case of a lost password and/or invalid e-mail submitted during registration.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-17
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named EditAccount.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'EditAccount',
	'version' => '1.0',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'descriptionmsg' => 'editaccount-desc'
);

// New user right, required to use the extension.
$wgAvailableRights[] = 'editaccount';
$wgGroupPermissions['*']['editaccount'] = false;
$wgGroupPermissions['staff']['editaccount'] = true;

// Log definition
$wgLogTypes[] = 'editaccnt';
$wgLogNames['editaccnt'] = 'editaccount-log';
$wgLogHeaders['editaccnt'] = 'editaccount-log-header';
$wgLogActions['editaccnt/mailchange'] = 'editaccount-log-entry-email';
$wgLogActions['editaccnt/passchange'] = 'editaccount-log-entry-pass';
$wgLogActions['editaccnt/realnamechange'] = 'editaccount-log-entry-realname';
$wgLogActions['editaccnt/closeaccnt'] = 'editaccount-log-entry-close';
$wgLogRestrictions['editaccnt'] = 'staff';

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['EditAccount'] = $dir . 'SpecialEditAccount.i18n.php';
$wgAutoloadClasses['EditAccount'] = $dir . 'SpecialEditAccount_body.php';
$wgSpecialPages['EditAccount'] = 'EditAccount';
// Special page group for MW 1.13+
$wgSpecialPageGroups['EditAccount'] = 'users';
