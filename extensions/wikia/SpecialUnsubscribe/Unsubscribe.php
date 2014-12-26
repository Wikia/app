<?php
/**
 * Extension to provide single unsubscribe point
 *
 * @file
 * @ingroup Extensions
 * @version 0.1
 * @author C. Uberfuzzy Stafford, Wikia Inc.
 * @author Lucas Garczewski <tor@wikia-inc.com>
 * @copyright © 2010
 * @licence GNU General Public Licence
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Unsubscribe',
	'version' => '0.2',
	'author' => array(
		'C. Uberfuzzy Stafford',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]'
	),
	'description' => 'Single email unbsubscribe point',
	#'url' => '',
	'descriptionmsg' => 'Unsubscribe-desc',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Unsubscribe'] = $dir . 'Unsubscribe.i18n.php';
$wgExtensionMessagesFiles['UnsubscribeAliases'] = $dir . 'Unsubscribe.alias.php';

$wgAutoloadClasses['UnsubscribePage'] = $dir . 'Unsubscribe.body.php';
$wgSpecialPages['Unsubscribe'] = 'UnsubscribePage';

$wgAutoloadClasses['UnsubscribePreferences'] = $dir . 'UnsubscribePreferences.class.php';
$wgHooks['GetPreferences'][] = 'UnsubscribePreferences::onGetPreferences';

// Special page group for MW 1.13+
$wgSpecialPageGroups['Unsubscribe'] = 'users';
