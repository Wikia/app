<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2008-01-09
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SiteWideMessages',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'This extension provides an interface for sending messages seen on all wikis.'
);
//Allow group STAFF to use this extension.
$wgAvailableRights[] = 'MessageTool';
$wgGroupPermissions['*']['MessageTool'] = false;
$wgGroupPermissions['staff']['MessageTool'] = true;

$wgExtensionFunctions[] = 'SiteWideMessagesInit';
$wgExtensionMessagesFiles['SpecialSiteWideMessages'] = dirname(__FILE__) . '/SpecialSiteWideMessages.i18n.php';
$wgAjaxExportList[] = 'SiteWideMessagesAjaxDismiss';

if ( empty( $wgSWMSupportedLanguages ) ) $wgSWMSupportedLanguages = array( 'en' );

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialSiteWideMessages_body.php', 'SiteWideMessages', 'SiteWideMessages');
$wgSpecialPageGroups['SiteWideMessages'] = 'wikia';

/**
 * Initialize hooks
 *
 */
function SiteWideMessagesInit() {
	global $wgSharedDB, $wgDontWantShared;
	//Include files ONLY when SharedDB is defined and desired.
	if (isset($wgSharedDB) && empty($wgDontWantShared)) {
		global $wgHooks;
		$wgHooks['OutputPageBeforeHTML'][] = 'SiteWideMessagesEmptyTalkPageWithMessages';
		$wgHooks['GetUserMessagesDiffCurrent'][] = 'SiteWideMessagesDiff';
		$wgHooks['UserRetrieveNewTalks'][] = 'SiteWideMessagesUserNewTalks';
		$wgHooks['OutputPageParserOutput'][] = 'SiteWideMessagesGetUserMessages';
		$wgHooks['EditPage::showEditForm:initial'][] = 'SiteWideMessagesArticleEditor';
		$wgHooks['AbortDiffCache'][] = 'SiteWideMessagesAbortDiffCache';
		$wgHooks['WikiFactoryPublicStatusChange'][] = 'SiteWideMessagesPublicStatusChange';
		$wgHooks['SkinNotificationsBeforeExecute'][] = 'SiteWideMessagesUndismissedNotifications';
	}
}

/**
 * Used to cancel caching diff when user has some messages - important security issue
 *
 */
function SiteWideMessagesAbortDiffCache($oDiffEngine) {
	$msgContent = SiteWideMessagesGetUserMessagesContent(false, false, true, false);
	return !(wfIsTalkPageForCurrentUserDisplayed() && $msgContent != '');
}

/**
 * Load JS/CSS for extension
 *
 */
function SiteWideMessagesIncludeJSCSS( $skin, & $bottomScripts) {
	global $wgExtensionsPath, $wgStyleVersion;

	$bottomScripts .= "<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.js?$wgStyleVersion\"></script>";

	return true;
}


/**
 * Return a content of all user's messages and add CSS styles
 *
 */
function SiteWideMessagesGetUserMessagesContent($dismissLink = true, $parse = true, $useForDiff = false, $addJSandCSS = true) {
	global $wgExtensionsPath, $wgStyleVersion, $wgOut, $wgUser, $wgRequest;
	if ($wgRequest->getText('diff') == '' || $useForDiff) {
		wfLoadExtensionMessages('SpecialSiteWideMessages');

		if ($addJSandCSS) {
			global $wgHooks;
			$wgHooks['SkinAfterBottomScripts'][] = 'SiteWideMessagesIncludeJSCSS';
			$wgOut->AddScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.css?$wgStyleVersion\" />");
		}

		$content = SiteWideMessages::getAllUserMessages($wgUser, $dismissLink);
		return $parse ? $wgOut->Parse($content) : $content;
	} else {
		return '';
	}
}

/**
 * Replace standard MW information about empty page when user has some messages
 *
 */
function SiteWideMessagesEmptyTalkPageWithMessages(&$out, &$text) {
	global $wgTitle, $wgOut, $wgUser;
	if (SiteWideMessages::$hasMessages && wfIsTalkPageForCurrentUserDisplayed() && !$wgUser->isAllowed('bot') && !$wgTitle->exists()) {
		//replace message about empty UserTalk only if we have a messages to display
		$text = '';
	}
	return true;
}

/**
 * Adds content of messages to the user talk page
 *
 */
function SiteWideMessagesGetUserMessages(&$out, $parseroutput) {
	global $wgUser;
	//don't add messages when editing, previewing changes etc. AND don't even try for unlogged or bots
	if (wfIsTalkPageForCurrentUserDisplayed() && !$wgUser->isAllowed('bot') && !Wikia::isOasis()) {
		$out->addHTML( SiteWideMessagesGetUserMessagesContent() ); // #2321
	}
	return true;
}

/**
 * Grab information about new messages and if they exist - add notification for specified wikis
 *
 */
function SiteWideMessagesUserNewTalks(&$user, &$talks) {
	global $wgExternalSharedDB, $wgMemc, $wgUser;

	if (Wikia::isOasis() || $user->isAnon() || $wgUser->isAllowed('bot')) {	//don't show information for anons and bots
		return true;
	}

	wfProfileIn( __METHOD__ );
	$key = 'wikia:talk_messages:' . $user->getID() . ':' . str_replace(' ', '_', $user->getName());
	$messages = $wgMemc->get($key);

	if(!is_array($messages) && $messages != 'deleted') {
		$messages = array();
		
		// For Oasis we want to set the filter_seen argument to false since we want the messages
		// to stay visible until they actually dismiss them
		$messagesID = SiteWideMessages::getAllUserMessagesId($user);
		if(!empty($messagesID)) {
			//selected wikis
			$wikis = array_filter($messagesID['wiki']);
			if(count($wikis)) {
				$wikis = implode(',', $wikis);
				$DB = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
				$res = $DB->query("SELECT city_id, city_title, city_url FROM city_list WHERE city_id IN ($wikis)");

				while($row = $DB->fetchObject($res)) {
					$link = $row->city_url . 'index.php?title=User_talk:' . urlencode($user->getTitleKey());
					$wiki = $row->city_title;
					$messages[$row->city_id] = array('wiki' => $wiki, 'link' => $link);
				}
			}

			//all wikis
			$wikis = array_filter($messagesID['wiki'], create_function('$v', 'return empty($v);'));
			if(count($wikis)) {
				global $wgCityId, $wgUser, $wgSitename;
				$utp = $wgUser->getTalkPage();
				$messages[$wgCityId] = array( 'wiki' => $wgSitename, 'link' => $utp->getFullURL() );
			}
			$wgMemc->set($key, $messages, 300);
		}
	}
	if( is_array( $messages ) && count( $messages) > 0 ) {
		$talks += $messages;
	}
	wfProfileOut( __METHOD__ );
	return true;
}

/**
 * Add messages without class, dismiss links etc to the content for diff engine
 *
 */
function SiteWideMessagesDiff($oTitle, $uMessages) {
	global $wgUser, $wgTitle, $wgRequest, $wgOut, $wgExtensionsPath, $wgStyleVersion;
	if ($wgTitle->getNamespace() == NS_USER_TALK &&                      //user talk page?
		$wgUser->getTitleKey() == $wgTitle->getPartialURL() &&           //*my* user talk page?
		!$wgUser->isAllowed('bot') &&                                    //user is not a bot?
		$wgRequest->getVal('diff') != ''                                 //*diff* versions?
	) {                                                                  //if all above == 'yes' - display user's messages
		$swmMessages = SiteWideMessagesGetUserMessagesContent(false, false, true);
		//don't add a new line if there are no messages
		if ($swmMessages != '') {
			$uMessages = $swmMessages . "\n" . $uMessages;
		}
	}
	return true;
}

/**
 * Add messages above the editor on UserTalk page so the user with empty UTP would see their message when clicking on UTP link
 *
 */
function SiteWideMessagesArticleEditor($editPage) {
	global $wgOut, $wgTitle, $wgUser;
	if ($wgTitle->getNamespace() == NS_USER_TALK &&                      //user talk page?
		$wgUser->getName() == $wgTitle->getPartialURL() &&               //*my* user talk page?
		!$wgUser->isAllowed('bot')                                       //user is not a bot?
	) {                                                                  //if all above == 'yes' - display user's messages
		$wgOut->addHTML(SiteWideMessagesGetUserMessagesContent());
	}
	return true;
}

/**
 * Dismiss message via AJAX
 *
 */
function SiteWideMessagesAjaxDismiss($msgId) {
	$result = SiteWideMessages::dismissMessage($msgId);
	return is_bool($result) ? ($result ? '1' : '0') : $result;
}

/**
 * When wiki is disabled or changed into the redirect, remove all messages from that wiki
 * User won't be able to do this by his own
 */
function SiteWideMessagesPublicStatusChange($city_public, $city_id) {
	if ($city_public == 0 || $city_public == 2) {
		SiteWideMessages::deleteMessagesOnWiki($city_id);
	}
	return true;
}

function SiteWideMessagesUndismissedNotifications(&$skin) {
	global $wgUser;

	// Add site wide notifications that haven't been dismissed
	$msg = SiteWideMessages::getAllUserMessages($wgUser, false, false);
	$skin->addSiteWideNotification($msg);
	
	return true;
}

$wgHooks['UserRename::Global'][] = "SiteWideMessagesUserRenameGlobal";

function SiteWideMessagesUserRenameGlobal( $dbw, $uid, $oldusername, $newusername, $process, &$tasks ) {
	$tasks[] = array(
		'table' => 'messages_text',
		'username_column' => 'msg_recipient_name',
	);
	return true;
}
