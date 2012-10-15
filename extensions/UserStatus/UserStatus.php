<?php
/**
 * UserStatus extension -- allows users to provide social status updates
 * (à la Twitter or Facebook) that will show up on their social profile pages.
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:UserStatus Documentation
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'UserStatus',
	'version' => '2.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Social status updates on user profiles and on network pages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UserStatus'
);

// Set up i18n and the new special pages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['UserStatus'] = $dir . 'UserStatus.i18n.php';
#$wgExtensionMessagesFiles['UserStatusAlias'] = $dir . 'UserStatus.alias.php';
$wgAutoloadClasses['UserStatus'] = $dir . 'UserStatusClass.php';
$wgAutoloadClasses['ViewFanUpdates'] = $dir . 'SpecialFanUpdates.php';
$wgAutoloadClasses['ViewUserStatus'] = $dir . 'SpecialUserStatus.php';
$wgAutoloadClasses['ViewThought'] = $dir . 'SpecialViewThought.php';
$wgSpecialPages['FanUpdates'] = 'ViewFanUpdates';
$wgSpecialPages['UserStatus'] = 'ViewUserStatus';
$wgSpecialPages['ViewThought'] = 'ViewThought';

// AJAX functions
include( 'UserStatus_AjaxFunctions.php' );

// New user right, required to delete other people's status messages
$wgAvailableRights[] = 'delete-status-updates';
$wgGroupPermissions['sysop']['delete-status-updates'] = true;
$wgGroupPermissions['staff']['delete-status-updates'] = true;

// ResourceLoader support for MediaWiki 1.17+
$resourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'UserStatus',
	'position' => 'top' // available since r85616
);

$wgResourceModules['ext.userStatus'] = $resourceTemplate + array(
	'styles' => 'UserStatus.css',
	'scripts' => 'UserStatus.js'
);

$wgResourceModules['ext.userStatus.viewThought'] = $resourceTemplate + array(
	'styles' => 'ViewThought.css'
);