<?php

/**
 * Extension that adds a new toggle in user preferences to show if the user is
 * aviabled or not. See http://mediawiki.org/wiki/Extension:OnlineStatus for
 * more informations.
 * Require MediaWiki 1.17 r77011 or higher to work.
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 of greater
 */

// Add credit :)
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'OnlineStatus',
	'author'         => 'Alexandre Emsenhuber',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:OnlineStatus',
	'version'        => '2009-08-22',
	'descriptionmsg' => 'onlinestatus-desc',
);

// Configuration

/**
 * Allow the {{#anyuseronlinestatus:}} parser function ?
 */
$wgAllowAnyUserOnlineStatusFunction = true;

/**
 * New preferences for this extension
 */
$wgDefaultUserOptions['online'] = 'online';
$wgDefaultUserOptions['showonline'] = 0;
$wgDefaultUserOptions['onlineonlogin'] = 1;
$wgDefaultUserOptions['offlineonlogout'] = 1;

// Classes
$wgAutoloadClasses['OnlineStatus'] = dirname( __FILE__ ) . '/OnlineStatus.body.php';

// Add messages files
$wgExtensionMessagesFiles['OnlineStatus'] = dirname( __FILE__ ) . '/OnlineStatus.i18n.php';
$wgExtensionMessagesFiles['OnlineStatusMagic'] = dirname( __FILE__ ) . '/OnlineStatus.i18n.magic.php';

// Hooks for the Parser
$wgHooks['ParserFirstCallInit'][] = 'OnlineStatus::ParserFirstCallInit';

// Magic words hooks
$wgHooks['MagicWordwgVariableIDs'][] = 'OnlineStatus::MagicWordVariable';
$wgHooks['ParserGetVariableValueSwitch'][] = 'OnlineStatus::ParserGetVariable';

// Hooks for Special:Preferences
$wgHooks['GetPreferences'][] = 'OnlineStatus::GetPreferences';

// User hook
$wgHooks['UserLoginComplete'][] = 'OnlineStatus::UserLoginComplete';
$wgHooks['UserLogoutComplete'][] = 'OnlineStatus::UserLogoutComplete';

// User page
$wgHooks['BeforePageDisplay'][] = 'OnlineStatus::BeforePageDisplay';
$wgHooks['PersonalUrls'][] = 'OnlineStatus::PersonalUrls';

// Ajax stuff
$wgAjaxExportList[] = 'OnlineStatus::Ajax';

$wgResourceModules['ext.onlineStatus'] = array(
	'scripts' => 'extensions/OnlineStatus/OnlineStatus.js',
	'styles' => 'extensions/OnlineStatus/OnlineStatus.css',
	'dependencies' => 'mediawiki.legacy.wikibits',
);
