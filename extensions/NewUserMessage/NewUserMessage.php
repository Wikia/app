<?php
/** Extension:NewUserMessage
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 */

if (!defined('MEDIAWIKI'))
	die('Not an entry point.');

define('NEWUSERMESSAGE_VERSION','2.0, 2008-06-04');

$wgNewUserSuppressRC = false;            // Specify whether or not the new user message creation should show up in recent changes
$wgNewUserMinorEdit = true;             // Should the new user message creation be a minor edit?
$wgNewUserMessageOnAutoCreate = false;  // Should auto creation (CentralAuth) trigger a new user message?

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['NewUserMessage'] = $dir . 'NewUserMessage.i18n.php';
$wgAutoloadClasses['NewUserMessage'] = $dir . 'NewUserMessage.class.php';

$wgHooks['AddNewAccount'][] = 'NewUserMessage::createNewUserMessage';
$wgHooks['AuthPluginAutoCreate'][] = 'NewUserMessage::createNewUserMessageAutoCreated';
$wgHooks['UserGetReservedNames'][] = 'NewUserMessage::onUserGetReservedNames';

$wgExtensionCredits['other'][] = array(
	'name'           => 'NewUserMessage',
	'version'        => NEWUSERMESSAGE_VERSION,
	'author'         => array( "[http://www.organicdesign.co.nz/User:Nad Nad]", 'Siebrand Mazeland' ),
	'description'    => "Add a [[MediaWiki:NewUserMessage|message]] to newly created user's talk pages",
	'descriptionmsg' => 'newusermessage-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:NewUserMessage',
);
