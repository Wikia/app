<?php
/** Extension:NewUserMessage
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license LGPL (http://www.gnu.org/copyleft/lesser.html)
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 */

if (!defined('MEDIAWIKI'))
	die('Not an entry point.');

define('NEWUSERMESSAGE_VERSION','1.2.1, 2008-06-04');

// Specify a template to wrap the new user message within
$wgNewUserMessageTemplate = 'MediaWiki:NewUserMessage';

// Set the username of the user that makes the edit on user talk pages. If
// this user does not exist, the new user will show up as editing user.
$wgNewUserMessageEditor = 'Admin';

// Edit summary for the recent changes entry of a new users message
$wgNewUserEditSummary = "Adding [[$wgNewUserMessageTemplate|welcome message]] to new user's talk page";

// Specify whether or not the new user message creation should show up in recent changes
$wgNewUserSupressRC = false;

// Should the new user message creation be a minor edit?
$wgNewUserMinorEdit = true;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['NewUserMessage'] = $dir . 'NewUserMessage.i18n.php';
$wgAutoloadClasses['NewUserMessage'] = $dir . 'NewUserMessage.class.php';

$wgHooks['AddNewAccount'][] = 'NewUserMessage::createNewUserMessage';

$wgExtensionCredits['other'][] = array(
	'name'           => 'NewUserMessage',
	'version'        => NEWUSERMESSAGE_VERSION,
	'author'         => "[http://www.organicdesign.co.nz/User:Nad Nad]",
	'description'    => "Add a [[MediaWiki:NewUserMessage|message]] to newly created user's talk pages",
	'descriptionmsg' => 'newusermessage-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:NewUserMessage',
);
