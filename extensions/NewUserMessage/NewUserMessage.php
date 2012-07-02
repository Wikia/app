<?php
/** Extension:NewUserMessage
 *
 * @file
 * @ingroup Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 */

if ( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

define( 'NEWUSERMESSAGE_VERSION', '3.2, 2011-07-14' );

$wgNewUserSuppressRC = false;           // Specify whether or not the new user message creation should show up in recent changes
$wgNewUserMinorEdit = true;             // Should the new user message creation be a minor edit?
$wgNewUserMessageOnAutoCreate = false;  // Should auto creation (CentralAuth) trigger a new user message?

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['NewUserMessage'] = $dir . 'NewUserMessage.i18n.php';
$wgAutoloadClasses['NewUserMessage'] = $dir . 'NewUserMessage.class.php';

$wgHooks['AddNewAccount'][] = 'NewUserMessage::createNewUserMessage';
$wgHooks['AuthPluginAutoCreate'][] = 'NewUserMessage::createNewUserMessageAutoCreated';
$wgHooks['UserGetReservedNames'][] = 'NewUserMessage::onUserGetReservedNames';

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'NewUserMessage',
	'version'        => NEWUSERMESSAGE_VERSION,
	'author'         => array( "[http://www.organicdesign.co.nz/User:Nad Nad]", 'Siebrand Mazeland' ),
	'descriptionmsg' => 'newusermessage-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:NewUserMessage',
);
