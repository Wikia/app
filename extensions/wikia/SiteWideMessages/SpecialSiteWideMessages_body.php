<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
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

global $wgSharedDB;
define('MSG_TEXT_DB', wfSharedTable('messages_text'));
if (!defined('MSG_STATUS_DB')) {	//prevent notices - these two const can be defined before in SQMSendToGroupTask
	define('MSG_STATUS_DB', wfSharedTable('messages_status'));
}
define('MSG_MODE_ALL', '0');
define('MSG_MODE_SELECTED', '1');
if (!defined('MSG_STATUS_UNSEEN')) {
	define('MSG_STATUS_UNSEEN', '0');
}
define('MSG_STATUS_SEEN', '1');
define('MSG_STATUS_DISMISSED', '2');
define('MSG_REMOVED_NO', '0');
define('MSG_REMOVED_YES', '1');

class SiteWideMessages extends SpecialPage {
	/**
	 * contructor
	 */
	function  __construct() {
		parent::__construct('SiteWideMessages' /*class*/, 'MessageTool' /*restriction*/);
	}

	function execute($subpage) {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgParser;
		wfLoadExtensionMessages('SpecialSiteWideMessages');

		//add CSS (from static file)
		global $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addScript("\n\t<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.css?$wgStyleVersion\" />");

		$template = 'editor';	//default template
		$editMsgId = 0;	//edit message mode

		$formData['sendMode'] = $wgRequest->getVal('mSendMode', 'ALL');
		$formData['groupMode'] = $wgRequest->getVal('mGroupMode', 'ALL');
		$formData['userName'] = $wgRequest->getText('mUserName');
		$formData['wikiName'] = $wgRequest->getText('mWikiName');
		$formData['groupName'] = $wgRequest->getText('mGroupName');
		$formData['groupNameS'] = $wgRequest->getText('mGroupNameS');
		$formData['groupWikiName'] = $wgRequest->getText('mGroupWikiName');
		$formData['expireTime'] = $wgRequest->getVal('mExpireTime');
		$formData['hubId'] = intval($wgRequest->getVal('mHubId'));

		//fetching hub list
		$DB = wfGetDB(DB_SLAVE);
		$dbResult = $DB->Query (
			  'SELECT cat_id, cat_name'
			. ' FROM ' . wfSharedTable('city_cats')
			. ' ORDER BY cat_id'
			. ';'
			, __METHOD__
		);

		$hubList = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$hubList[$row->cat_id] = $row->cat_name;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		$formData['hubNames'] = $hubList;

		//fetching group list
		$DB = wfGetDB(DB_SLAVE);
		$dbResult = $DB->Query (
			  'SELECT DISTINCT ug_group'
			. ' FROM ' . wfSharedTable('user_groups')
			. ' ORDER BY ug_group'
			. ';'
			, __METHOD__
		);

		$groupList = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$groupList[] = $row->ug_group;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		$formData['groupNames'] = $groupList;

		//handle different submit buttons in one form
		$button = $wgRequest->getVal('mAction');
		switch ($button) {
			case wfMsg('swm-button-preview'):
				$action = 'preview';
				break;

			case wfMsg('swm-button-send'):
				$action = 'send';
				break;

			case wfMsg('swm-button-save'):
				$action = 'save';
				break;

			default:
				$action = $wgRequest->getVal('action');
		}

		if($action != 'dismiss' && $action != 'cleanDB' && !$wgUser->isAllowed('MessageTool')) {
			$wgOut->permissionRequired('MessageTool');
			return;
		}

		switch ($action) {
			case 'dismiss':
				self::dismissMessage($wgRequest->getVal('mID'));
				$redirect = $wgUser->getTalkPage()->getFullURL('redirect=no');
				$wgOut->redirect($redirect, 200);
				return;
				break;

			case 'preview':
				$formData['messageContent'] = $wgRequest->getText('mContent');
				if ($formData['messageContent'] != '') {
					global $wgUser, $wgParser;
					$title = Title::newFromText(uniqid('tmp'));
					$options = ParserOptions::newFromUser($wgUser);

					//Parse some wiki markup [eg. ~~~~]
					$formData['messageContent'] = $wgParser->preSaveTransform($formData['messageContent'], $title, $wgUser, $options);
				}

				$formData['messagePreview'] = $wgOut->parse($formData['messageContent']);
				$editMsgId = $wgRequest->getVal('editMsgId', 0);
				$wgOut->SetPageTitle(wfMsg('swm-page-title-preview'));
				break;

			case 'save':
				$mText = $wgRequest->getText('mContent');
				$editMsgId = isset($_POST['editMsgId']) ? $_POST['editMsgId'] : 0;
				if ($editMsgId) {	//editing?
					$result = $this->saveMessage($editMsgId, $mText);
				}
				$redirect = $wgTitle->getLocalUrl('action=list');
				$wgOut->redirect($redirect, 200);
				return;
				break;

			case 'send':
				$mRecipientId = $formData['sendMode'] == 'ALL' ? null : $wgUser->idFromName($formData['userName']);
				//TODO: if $mRecipientId == 0 => error - no such user
				$mText = $wgRequest->getText('mContent');
				$groupName = $formData['groupName'] == '' ? $formData['groupNameS'] : $formData['groupName'];
				$result = $this->sendMessage($wgUser, $mRecipientId, $mText, $wgRequest->getVal('mExpireTime'), $formData['wikiName'], $formData['userName'], $groupName, $formData['sendMode'], $formData['groupMode'], $formData['groupWikiName'], $formData['hubId']);

				if (is_null($result['msgId'])) {	//we have an error
					$formData['messageContent'] = $wgRequest->getText('mContent');
					$formData['errMsg'] = $result['errMsg'];
					$wgOut->SetPageTitle(wfMsg('swm-page-title-editor'));
				} else {
					$redirect = $wgTitle->getLocalUrl("action=sent&id={$result['msgId']}");
					$wgOut->redirect($redirect, 200);
					return;
				}
				break;

			case 'sent':
				$mId = $wgRequest->getText('id');
				$mText = $mId ? $this->getMessageText($mId) : null;

				if ($mId && !is_null($mText)) {
					$formData['messageContent'] = $wgOut->parse($mText);
					$formData['sendResult'] = wfMsg('swm-msg-sent-ok');
				} else {
					$formData['messageContent'] = '';
					$formData['sendResult'] = wfMsg('swm-msg-sent-err');
				}

				$template = 'sent';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-sent'));
				break;

			case 'remove':
				$mId = $wgRequest->getText('id');
				if ($mId) {
					$this->removeMessage($mId);
				}
				//no break - go to 'list'

			case 'list':
				$formData['messages'] = $this->getAllMessagesInfo();

				$template = 'list';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-list'));

				//init pager
				$oPager = new SiteWideMessagesPager;
				$formData['body']  = $oPager->getBody();
				$formData['nav']   = $oPager->getNavigationBar();
				break;

			case 'edit':
				$mId = $wgRequest->getText('id');
				$formData['messageContent'] = $mId ? $this->getMessageText($mId) : null;
				$editMsgId = $mId;
				//no break - go to 'default' => editor

			default:	//editor
				$formData['expireTime'] = '';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-editor'));
		}

		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_vars( array(
				'title' => $wgTitle,
				'formData' => $formData,
				'editMsgId' => $editMsgId
			));
		$wgOut->addHTML($oTmpl->execute($template));
	}

	//DB functions
	private function sendMessage($mSender, $mRecipientId, $mText, $mExpire, $mWikiName, $mRecipientName, $mGroupName, $mSendMode, $mGroupMode, $mGroupWikiName, $mHubId) {
		global $wgSharedDB;
		$result = array('msgId' => null, 'errMsg' => null);
		$dbInsertResult = false;
		$mWikiId = null;

		//remove unnecessary data
		switch($mSendMode) {
			case 'ALL':
				$mWikiName = '';
				$mRecipientName = '';
				$mGroupName = '';
				$sendToAll = true;
				$mHubId = null;
				break;
			case 'USER':
				$mWikiName = '';
				$mGroupName = '';
				$sendToAll = false;
				$mHubId = null;
				break;
			case 'WIKI':
				$mRecipientName = '';
				$mGroupName = '';
				$sendToAll = false;
				$mHubId = null;
				break;
			case 'GROUP':
				$mWikiName = '';
				$mRecipientName = '';
				if ($mGroupMode == 'ALL') {
					$mGroupWikiName = '';
				}
				$sendToAll = false;
				$mHubId = null;
				break;
			case 'HUB':
				$mWikiName = '';
				$mRecipientName = '';
				$mGroupName = '';
				$sendToAll = false;
		}

		$tmpWikiName = false;
		if ($mSendMode == 'WIKI' && $mWikiName != '') {
			$tmpWikiName = $mWikiName;
		} elseif ($mSendMode == 'GROUP' && $mGroupMode == 'WIKI' && $mGroupWikiName != '') {
			$tmpWikiName = $mGroupWikiName;
		}
		if ($tmpWikiName) {
			$wikiDomains = array('', '.wikia.com', '.sjc.wikia-inc.com');
			foreach($wikiDomains as $wikiDomain) {
				if(!is_null($mWikiId = WikiFactory::DomainToID($tmpWikiName . $wikiDomain))) {
					break;
				}
			}
		}

		if ($mText == '') {
			$result['errMsg'] = wfMsg('swm-error-empty-message');
		} elseif (($mSendMode == 'WIKI' || ($mSendMode == 'GROUP' && $mGroupMode == 'WIKI')) && is_null($mWikiId)) {
			//this wiki doesn't exist
			$result['errMsg'] = wfMsg('swm-error-no-such-wiki');
		} elseif ($mSendMode == 'USER' && !User::idFromName($mRecipientName)) {
			$result['errMsg'] = wfMsg('swm-error-no-such-user');
//		} elseif ($mSendMode == 'GROUP' && $mGroupName == '') {
//			$result['errMsg'] = wfMsg('swm-error-empty-group');
		} else {
			global $wgParser, $wgUser;
			$title = Title::newFromText(uniqid('tmp'));
			$options = ParserOptions::newFromUser($wgUser);

			//Parse some wiki markup [eg. ~~~~]
			$mText = $wgParser->preSaveTransform($mText, $title, $wgUser, $options);

			//null => expire never
			$mExpire = $mExpire != '0' ? date('Y-m-d H:i:s', strtotime(ctype_digit($mExpire) ? " +$mExpire day" : ' +' . substr($mExpire, 0, -1) . ' hour')) : null;

			$DB = wfGetDB(DB_MASTER);
			$dbResult = (boolean)$DB->Query (
				  'INSERT INTO ' . MSG_TEXT_DB
				. ' (msg_sender_id, msg_text, msg_mode, msg_expire, msg_recipient_name, msg_group_name, msg_wiki_name, msg_hub_id)'
				. ' VALUES ('
				. $DB->AddQuotes($mSender->GetID()). ', '
				. $DB->AddQuotes($mText) . ', '
				. ($sendToAll ? MSG_MODE_ALL : MSG_MODE_SELECTED) . ', '
				. $DB->AddQuotes($mExpire) . ', '
				. $DB->AddQuotes($mRecipientName) . ', '
				. $DB->AddQuotes($mGroupName) . ', '
				. $DB->AddQuotes($mWikiName) . ', '
				. $DB->AddQuotes($mHubId)
				. ');'
				, __METHOD__
			);

			if ($dbResult) {
				$dbInsertResult = true;
				$result['msgId'] = $DB->insertId();

				switch($mSendMode) {
					case 'ALL':
						break;

					case 'USER':
						if (!is_null($mRecipientId) && $dbResult && !is_null($result['msgId'])) {
							$dbResult = (boolean)$DB->Query (
								  'INSERT INTO ' . MSG_STATUS_DB
								. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
								. ' VALUES ('
								. $DB->AddQuotes($mWikiId). ', '
								. $DB->AddQuotes($mRecipientId) . ', '
								. $DB->AddQuotes($result['msgId']) . ', '
								. MSG_STATUS_UNSEEN
								. ');'
								, __METHOD__
							);
							$dbInsertResult &= $dbResult;
						}
						break;

					case 'WIKI':
						$wikiDB = WikiFactory::IDtoDB($mWikiId);

						$DB = wfGetDB(DB_SLAVE);
						$DB->selectDB($wikiDB);
						if (!$DB->tableExists('local_users')) {
							break;
						}
						$dbResult = $DB->Query (
							  'SELECT user_id'
							. ' FROM local_users'
							. ';'
							, __METHOD__
						);

						$activeUsers = array();
						while ($oMsg = $DB->FetchObject($dbResult)) {
							$activeUsers[] = $oMsg->user_id;
						}
						if ($dbResult !== false) {
							$DB->FreeResult($dbResult);
						}

						$DB = wfGetDB(DB_MASTER);
						$sqlValues = array();
						foreach($activeUsers as $activeUser) {
							$sqlValues[] = "($mWikiId, $activeUser, {$result['msgId']}, " . MSG_STATUS_UNSEEN . ')';
						}
						if (count($sqlValues)) {
							$dbResult = (boolean)$DB->Query (
								  'INSERT INTO ' . MSG_STATUS_DB
								. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
								. ' VALUES ' . implode(',', $sqlValues)
								. ';'
								, __METHOD__
							);
							$dbInsertResult &= $dbResult;
						}
						break;

					case 'GROUP':
					case 'HUB':
						#--- add task to TaskManager
						$oTask = new SWMSendToGroupTask();
						$oTask->createTask(
							array(
								'taskType' => $mSendMode,
								'messageId' => $result['msgId'],
								'groupMode' => $mGroupMode,
								'groupName' => $mGroupName,
								'groupWikiName' => $mGroupWikiName,
								'senderId' => $mSender->GetID(),
								'senderName' => $mSender->GetName(),
								'hubId' => $mHubId
							),
							TASK_QUEUED
						);
						break;
				}
			}
		}

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || SenderId=" . $mSender->GetID() . ", RecipientId=$mRecipientId, Expire=$mExpire, result=" . ($dbInsertResult ? 'true':'false') . "\n");
		return $result;
	}

	private function saveMessage($editMsgId, $mText) {
		global $wgUser, $wgParser;
		$title = Title::newFromText(uniqid('tmp'));
		$options = ParserOptions::newFromUser($wgUser);

		//Parse some wiki markup [eg. ~~~~]
		$mText = $wgParser->preSaveTransform($mText, $title, $wgUser, $options);

		$DB = wfGetDB(DB_MASTER);
		$dbResult = (boolean)$DB->Query (
			  'UPDATE ' . MSG_TEXT_DB
			. ' SET msg_text = ' . $DB->AddQuotes($mText)
			. ' , msg_sender_id = ' . $DB->AddQuotes($wgUser->GetID())
			. ' WHERE msg_id = ' . $DB->AddQuotes($editMsgId)
			. ';'
			, __METHOD__
		);

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || messageID=$editMsgId, result=" . ($dbResult ? 'true':'false') . "\n");
		return $dbResult;
	}

	/**
	 */
	private function getMessageText($mId) {
		$DB = wfGetDB(DB_SLAVE);

		$dbResult = $DB->Query (
			  'SELECT msg_text'
			. ' FROM ' . MSG_TEXT_DB
			. ' WHERE msg_id = ' . $DB->AddQuotes($mId)
			. ';'
			, __METHOD__
		);

		$result = null;

		if ($oMsg = $DB->FetchObject($dbResult)) {
			$result = $oMsg->msg_text;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}
		return $result;
	}

	private function getAllMessagesInfo() {
		$DB = wfGetDB (DB_SLAVE);

		$dbResult = $DB->Query (
			  'SELECT msg_id, user_name, msg_text, msg_removed, msg_expire, msg_date, msg_recipient_name, msg_group_name, msg_wiki_name'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . wfSharedTable('user') . ' ON msg_sender_id = user_id'
			. ' ORDER BY msg_id DESC'
			. ';'
			, __METHOD__
		);

		$messages = array();
		$i = 0;
		while ($oMsg = $DB->FetchObject($dbResult)) {
			$messages[$i]['msg_id'] = $oMsg->msg_id;
			$messages[$i]['msg_sender'] = $oMsg->user_name;
			$messages[$i]['msg_text'] = htmlspecialchars($oMsg->msg_text);
			$messages[$i]['msg_removed'] = $oMsg->msg_removed;
			$messages[$i]['msg_expire'] = $oMsg->msg_expire;
			$messages[$i]['msg_date'] = $oMsg->msg_date;
			$messages[$i]['msg_recipient_name'] = $oMsg->msg_recipient_name;
			$messages[$i]['msg_group_name'] = $oMsg->msg_group_name;
			$messages[$i]['msg_wiki_name'] = $oMsg->msg_wiki_name;
			$i++;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}
		return $messages;
	}

	private function removeMessage($mId) {
		$DB = wfGetDB(DB_MASTER);

		$dbResult = (boolean)$DB->Query (
			  'UPDATE ' . MSG_TEXT_DB
			. ' SET msg_removed = 1'
			. ' WHERE msg_id = ' . $DB->AddQuotes($mId)
			. ';'
			, __METHOD__
		);

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || messageID=$mId, result=" . ($dbResult ? 'true':'false') . "\n");
		return $dbResult;
	}

	//Static functions (used in hooks)
	static function getAllUserMessagesId($user) {
		global $wgCityId, $wgLanguageCode;
		$localCityId = isset($wgCityId) ? $wgCityId : 0;
		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get all active messages sent to *all*
		$dbResult = $DB->Query (
			  'SELECT msg_id AS id'
			. ' FROM ' . MSG_TEXT_DB
			. ' WHERE msg_removed = ' . MSG_REMOVED_NO
			. ' AND msg_mode = ' . MSG_MODE_ALL
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. " AND msg_date > '{$user->mRegistration}'"	//fix for ticket #2624
			. ';'
			, __METHOD__
		);

		$tmpMsg = array();
		while ($oMsg = $DB->FetchObject($dbResult)) {
			$tmpMsg[$oMsg->id] = array('wiki_id' => null);
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		if (count($tmpMsg)) {
			//step 2 of 3: remove dismissed and seen messages
			$dbResult = $DB->Query (
				  'SELECT msg_id AS id'
				. ' FROM ' . MSG_STATUS_DB
				. ' WHERE msg_id IN (' . implode(',', array_keys($tmpMsg)) . ')'
				. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
				. ' AND msg_status IN (' . MSG_STATUS_DISMISSED . ', ' . MSG_STATUS_SEEN . ')'
				. ';'
				, __METHOD__
			);

			while ($oMsg = $DB->FetchObject($dbResult)) {
				unset($tmpMsg[$oMsg->id]);
			}
			if ($dbResult !== false) {
				$DB->FreeResult($dbResult);
			}
		}
		//step 3 of 3: add unseen messages sent to *this* user (on *all* wikis or *this* wiki)
		$dbResult = $DB->Query (
			  'SELECT msg_wiki_id, msg_id AS id'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . MSG_STATUS_DB . ' USING (msg_id)'
			. ' WHERE msg_mode = ' . MSG_MODE_SELECTED
			. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
			. ' AND msg_status = ' . MSG_STATUS_UNSEEN
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. ' AND msg_removed = ' . MSG_REMOVED_NO
			. ';'
			, __METHOD__
		);

		while ($oMsg = $DB->FetchObject($dbResult)) {
			$tmpMsg[$oMsg->id] = array('wiki_id' => $oMsg->msg_wiki_id);
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}
		//sort from newer to older
		krsort($tmpMsg);

		$messages = array();
		$language = Language::factory($wgLanguageCode);
		$IDs = array();
		foreach ($tmpMsg as $tmpMsgId => $tmpMsgData) {
			$IDs['id'][] = $tmpMsgId;
			$IDs['wiki'][] = $tmpMsgData['wiki_id'];
		}
		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || userID={$user->GetID()}, result=" . ($dbResult ? 'true':'false') . "\n");

		return $IDs;
	}

	static function getAllUserMessages($user, $dismissLink = true) {
		global $wgMemc, $wgCityId, $wgLanguageCode;
		$localCityId = isset($wgCityId) ? $wgCityId : 0;
		$DB = wfGetDB(DB_SLAVE);

		//step 1 of 3: get all active messages sent to *all*
		$dbResult = $DB->Query (
			  'SELECT msg_id AS id, msg_text AS text, msg_expire AS expire'
			. ' FROM ' . MSG_TEXT_DB
			. ' WHERE msg_removed = ' . MSG_REMOVED_NO
			. ' AND msg_mode = ' . MSG_MODE_ALL
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. " AND msg_date > '{$user->mRegistration}'"	//fix for ticket #2624
			. ';'
			, __METHOD__
		);

		$tmpMsg = array();
		while ($oMsg = $DB->FetchObject($dbResult)) {
			$tmpMsg[$oMsg->id] = array('wiki_id' => null, 'text' => $oMsg->text, 'expire' => $oMsg->expire);
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		if (count($tmpMsg)) {
			//step 2 of 3: remove dismissed messages
			$dbResult = $DB->Query (
				  'SELECT msg_id AS id'
				. ' FROM ' . MSG_STATUS_DB
				. ' WHERE msg_id IN (' . implode(',', array_keys($tmpMsg)) . ')'
				. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
				. ' AND msg_status = ' . MSG_STATUS_DISMISSED
				. ';'
				, __METHOD__
			);

			while ($oMsg = $DB->FetchObject($dbResult)) {
				unset($tmpMsg[$oMsg->id]);
			}
			if ($dbResult !== false) {
				$DB->FreeResult($dbResult);
			}
		}
		//step 3 of 3: add not dismissed messages sent to *this* user (on *all* wikis or *this* wiki)
		$dbResult = $DB->Query (
			  'SELECT msg_wiki_id, msg_id AS id, msg_text AS text, msg_expire AS expire'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . MSG_STATUS_DB . ' USING (msg_id)'
			. ' WHERE msg_mode = ' . MSG_MODE_SELECTED
			. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
			. ' AND msg_status IN (' . MSG_STATUS_UNSEEN . ', ' . MSG_STATUS_SEEN . ')'
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. ' AND msg_removed = ' . MSG_REMOVED_NO
			. " AND (msg_wiki_id IS NULL OR msg_wiki_id = $localCityId)"
			. ';'
			, __METHOD__
		);

		while ($oMsg = $DB->FetchObject($dbResult)) {
			$tmpMsg[$oMsg->id] = array('wiki_id' => $oMsg->msg_wiki_id, 'text' => $oMsg->text, 'expire' => $oMsg->expire);
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}
		//sort from newer to older
		krsort($tmpMsg);

		$messages = array();
		$language = Language::factory($wgLanguageCode);
		foreach ($tmpMsg as $tmpMsgId => $tmpMsgData) {
			$messages[] = $dismissLink ?
				"<div class=\"SWM_message\" id=\"msg_$tmpMsgId\">\n".
				"{$tmpMsgData['text']}\n" .
				"<span class=\"SWM_dismiss\"><nowiki>[</nowiki><span class=\"plainlinks\">[{{fullurl:Special:SiteWideMessages|action=dismiss&mID=$tmpMsgId}} " . wfMsg('swm-link-dismiss') . "]</span><nowiki>]</nowiki></span>" .
				(is_null($tmpMsgData['expire']) ? '' : "<span class=\"SWM_expire\">" . wfMsg('swm-expire-info', array($language->timeanddate(strtotime($tmpMsgData['expire']), true, $user->getDatePreference()))) . "</span>") .
				"<div>&nbsp;</div></div>"
				:
				"<div class=\"SWM_message\">{$tmpMsgData['text']}</div>";
		}

		//once the messages are displayed, they must be marked as "seen" so user will not see "you have new messages" from now on
		if (count($tmpMsg)) {
			$userID = $user->GetID();

			$DB = wfGetDB(DB_MASTER);
			$dbResult = (boolean)$DB->Query (
				  'REPLACE INTO ' . MSG_STATUS_DB
				. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
				. ' SELECT msg_wiki_id, msg_recipient_id, msg_id, ' . MSG_STATUS_SEEN
				. ' FROM ' . MSG_STATUS_DB
				. ' WHERE msg_id IN (' . implode(',', array_keys($tmpMsg)) . ')'
				. ' AND msg_recipient_id = ' . $DB->AddQuotes($userID)
				. ';'
				, __METHOD__
			);

			foreach($tmpMsg as $tmpMsgId => $tmpMsgData) {
				if (!is_null($tmpMsgData['wiki_id'])) {
					continue;	//skip messages with specified wikis - those were updated in the previous query
				}
				$dbResult &= (boolean)$DB->Query (
					  'REPLACE INTO ' . MSG_STATUS_DB
					. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
					. ' VALUES ('
					. 'NULL , '
					. $DB->AddQuotes($userID) . ', '
					. $DB->AddQuotes($tmpMsgId) . ', '
					. MSG_STATUS_SEEN
					. ');'
					, __METHOD__
				);
			}

			//purge the cache
			$key = 'wikia:talk_messages:' . $userID . ':' . str_replace(' ', '_', $user->getName());
			$wgMemc->delete($key);

			wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || userID=$userID, result=" . ($dbResult ? 'true':'false') . "\n");
		}
		return implode("\n", $messages);
	}

	static function dismissMessage($messageID) {
		global $wgUser, $wgMemc;
		$userID = $wgUser->GetID();
		if ($userID) {
			$DB = wfGetDB(DB_MASTER);

			$dbResult = $DB->Query (
				  'SELECT msg_wiki_id'
				. ' FROM ' . MSG_STATUS_DB
				. ' WHERE msg_id = ' . $DB->AddQuotes($messageID)
				. ' AND msg_recipient_id = ' . $DB->AddQuotes($userID)
				. ';'
				, __METHOD__
			);

			$mWikiId = null;

			if ($oMsg = $DB->FetchObject($dbResult)) {
				$mWikiId = $oMsg->msg_wiki_id;
			}
			if ($dbResult !== false) {
				$DB->FreeResult($dbResult);
			}

			$dbResult = (boolean)$DB->Query (
				  'REPLACE INTO ' . MSG_STATUS_DB
				. ' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)'
				. ' VALUES ('
				. $DB->AddQuotes($mWikiId). ', '
				. $DB->AddQuotes($userID) . ', '
				. $DB->AddQuotes($messageID) . ', '
				. MSG_STATUS_DISMISSED
				. ');'
				, __METHOD__
			);

			$DB->close();

			//purge the cache
			$key = 'wikia:talk_messages:' . $userID . ':' . str_replace(' ', '_', $wgUser->getName());
			$wgMemc->delete($key);

			wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || WikiId=$mWikiId, messageID=$messageID, result=" . ($dbResult ? 'true':'false') . "\n");
			return $dbResult;
		}
		return false;
	}
}

//class for pagination of list of messages
class SiteWideMessagesPager extends TablePager {
	var $mFieldNames = null;
	var $mMessages = array();
	var $mQueryConds = array();
	var $mTitle;
	var $never;

	#--- constructor
	function __construct() {
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'SiteWideMessages' );
		$this->mDefaultDirection = true;
		$this->never = explode(',', wfMsg('swm-days'));
		$this->never = $this->never[0];
		parent::__construct();
	}

	#--- getFieldNames ------------------------------------------------------
	function getFieldNames() {
		if ( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			$this->mFieldNames['msg_id']             = wfMsg('swm-list-table-id');
			$this->mFieldNames['msg_sender']         = wfMsg('swm-list-table-sender');
			$this->mFieldNames['msg_wiki_name']      = wfMsg('swm-list-table-wiki');
			$this->mFieldNames['msg_recipient_name'] = wfMsg('swm-list-table-recipient');
			$this->mFieldNames['msg_group_name']     = wfMsg('swm-list-table-group');
			$this->mFieldNames['msg_expire']         = wfMsg('swm-list-table-expire');
			$this->mFieldNames['msg_removed']        = wfMsg('swm-list-table-removed');
			$this->mFieldNames['msg_text']           = wfMsg('swm-list-table-content');
			$this->mFieldNames['msg_date']           = wfMsg('swm-list-table-date');
			$this->mFieldNames['msg_wiki_tools']     = wfMsg('swm-list-table-tools');
		}
		return $this->mFieldNames;
	}

	#--- isFieldSortable-----------------------------------------------------
	function isFieldSortable( $field ) {
		static $sortable = array( 'msg_id', 'msg_sender', 'msg_removed', 'msg_date', 'msg_expire', 'msg_wiki_name', 'msg_group_name', 'msg_recipient_name', 'msg_text' );
		return in_array( $field, $sortable );
	}

	#--- formatValue --------------------------------------------------------
	function formatValue( $field, $value ) {
		global $wgStylePath, $wgTitle;

		switch ($field) {
			case 'msg_expire':
				$sRetval = $value ? $value : "<i>{$this->never}</i>";
				break;

			case 'msg_removed':
				$sRetval = $value ? wfMsg('swm-yes') : wfMsg('swm-no');
				break;

			case 'msg_recipient_name':
				$sRetval = $value ? htmlspecialchars($value) : ('<i>' . wfMsg('swm-label-mode-all') . '</i>');
				break;

			case 'msg_text':
				$sRetval = htmlspecialchars(str_replace(array("\r\n", "\n", "\r"), ' ', substr($value, 0, 40)));
				break;

			case 'msg_wiki_tools':
				$sRetval = '<a href="' . $wgTitle->getLocalUrl("id={$this->mCurrentRow->msg_id}&action=edit") . '">' . wfMsg('swm-label-edit') . '</a>';
				if (!$this->mCurrentRow->msg_removed) {
					$sRetval .= ' | <a href="#" onclick="if(confirm(\'' . addslashes(wfMsg('swm-msg-remove')) . '\')) document.location=\'' . $wgTitle->getLocalUrl("id={$this->mCurrentRow->msg_id}&action=remove") . '\';">' . wfMsg('swm-label-remove') . '</a>';
				}
				break;

			default:
				return htmlspecialchars($value);
		}
		return $sRetval;
	}

	/**
	 * formatRow
	 *
	 * more fancy FormatRow method
	 *
	 * @param object $row: database row class
	 */
	function formatRow( $row ) {
		$s = "<tr>\n";
		$fieldNames = $this->getFieldNames();
		$this->mCurrentRow = $row;  # In case formatValue needs to know
		foreach( $fieldNames as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatValue( $field, $value ) );
			if( $formatted == '' ) {
				$formatted = '&nbsp;';
			}
			$class = '';
			if($value && ($field == 'msg_removed' || ($field == 'msg_expire' && strtotime($value) < time()))) {
				$class = ' class="noactive"';
			}
			$s .= "\t<td$class>$formatted</td>\n";
		}
		$s .= "</tr>\n";
		return $s;
	}

	/**
	 * getDefaultSort
	 *
	 * @access public
	 *
	 * @return string: name of table using in sorting
	 */
	public function getDefaultSort() {
		return 'msg_id';
	}

	#--- getQueryInfo -------------------------------------------------------
	function getQueryInfo() {
		return array(
			'tables' => MSG_TEXT_DB . ' LEFT JOIN ' . wfSharedTable('user') . ' ON msg_sender_id = user_id',
			'fields' => array('msg_id', 'user_name AS msg_sender', 'msg_text', 'msg_removed', 'msg_expire', 'msg_date', 'msg_recipient_name', 'msg_group_name', 'msg_wiki_name')
		);
	}

	/**
	 * Hook into getBody(), for the bit between the start and the
	 * end when there are no rows
	 */
	function getEmptyBody() {
		$colspan = count( $this->getFieldNames() );
		$msgEmpty = wfMsg('swm-list-no-messages');
		return "<tr><td colspan=\"$colspan\">$msgEmpty</td></tr>\n";
	}
}
?>