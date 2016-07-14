<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Daniel Grunwell (Grunny)
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

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit( 1 ) ;
}

define('MSG_TEXT_DB', 'messages_text');
if (!defined('MSG_STATUS_DB')) {	//prevent notices - these two const can be defined before in SQMSendToGroupTask
	define('MSG_STATUS_DB', 'messages_status');
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
define('MSG_LANG_ALL', 'all');
define('MSG_LANG_OTHER', 'other');
define('MSG_RECIPIENT_ANON', 'Anonymous users');
define('MSG_WIKI_CREATION_DATE', 'CREATION DATE'); // Hack until we add a column to store extra parameters

class SiteWideMessages extends SpecialPage {

	static $hasMessages = false;

	function  __construct() {
		parent::__construct('SiteWideMessages' /*class*/, 'messagetool' /*restriction*/);
	}

	function execute($subpage) {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgParser;

		//add CSS (from static file)
		global $wgExtensionsPath, $wgExternalSharedDB, $wgDWStatsDB;
		$wgOut->addScript("\n\t<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgExtensionsPath/wikia/SiteWideMessages/SpecialSiteWideMessages.css\" />");

		$template = 'editor';	//default template
		$editMsgId = 0;			//edit message mode

		$formData['sendModeWikis'] = $wgRequest->getVal('mSendModeWikis', 'ALL');
		$formData['sendModeUsers'] = $wgRequest->getVal('mSendModeUsers', 'ALL');
		$formData['hubId'] = intval($wgRequest->getVal('mHubId'));
		$formData['clusterId'] = intval($wgRequest->getVal('mClusterId'));
		$formData['wikiName'] = $wgRequest->getText('mWikiName');
		$formData['listWikiNames'] = $wgRequest->getText( 'mWikiNames' );
		$formData['wikiCreationDateOption'] = $wgRequest->getVal( 'mWikiCreationS' );
		$formData['wikiCreationDateOne'] = $wgRequest->getVal( 'mWikiCreationDateOne' );
		$formData['wikiCreationDateTwo'] = $wgRequest->getVal( 'mWikiCreationDateTwo' );
		$formData['groupName'] = $wgRequest->getText('mGroupName');
		$formData['groupNameS'] = $wgRequest->getText('mGroupNameS');
		$formData[ 'powerUserType' ] = $wgRequest->getArray( 'mPowerUserType' );
		$formData['userName'] = $wgRequest->getText('mUserName');
		$formData['listUserNames'] = $wgRequest->getText( 'mUserNames' );
		$formData['expireTime'] = $wgRequest->getVal('mExpireTime');
		$formData['expireTimeS'] = $wgRequest->getVal('mExpireTimeS');
		$formData['registrationDateOption'] = $wgRequest->getVal( 'mRegistrationS' );
		$formData['registrationDateOne'] = $wgRequest->getVal( 'mRegistrationDateOne' );
		$formData['registrationDateTwo'] = $wgRequest->getVal( 'mRegistrationDateTwo' );
		$formData['editCountOption'] = $wgRequest->getVal( 'mEditCountS' );
		$formData['editCountOne'] = $wgRequest->getVal( 'mEditCountOne' );
		$formData['editCountTwo'] = $wgRequest->getVal( 'mEditCountTwo' );
		$formData['mLang'] = $wgRequest->getArray('mLang');

		//fetching hub list
		$DB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$dbResult = $DB->select(
			[ 'city_verticals' ],
			[ 'vertical_id, vertical_name' ],
			null,
			__METHOD__,
			[ 'ORDER BY' => 'vertical_id' ]
		);

		$hubList = [];
		while ($row = $DB->FetchObject($dbResult)) {
			$hubList[$row->vertical_id] = $row->vertical_name;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		$formData['hubNames'] = $hubList;

		//fetching cluster list
		$DB = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$dbResult = $DB->select(
			array( 'city_list' ),
			array( 'city_cluster' ),
			null,
			__METHOD__,
			array( 'GROUP BY' => 'city_cluster', 'ORDER BY' => 'city_cluster', 'DISTINCT' )
		);

		$clusterList = array();
		while ($row = $DB->FetchObject($dbResult)) {
			$clusterId = empty($row->city_cluster) ? 1 : intval(substr($row->city_cluster,1));
			$clusterName = empty($row->city_cluster) ? 'c1' : $row->city_cluster;
			$clusterList[$clusterId] = $clusterName;
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		$formData['clusterNames'] = $clusterList;

		//fetching group list
		global $wgGroupPermissions;
		$groupList = $wgGroupPermissions;
		unset($groupList['*']);
		$formData['groupNames'] = array_keys($groupList);

		/**
		 * Fetch types of power users to generate checkboxes
		 */
		$formData[ 'powerUserTypes' ] = \Wikia\PowerUser\PowerUser::$aPowerUserProperties;

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

		if($action != 'dismiss' && $action != 'cleanDB' && !$wgUser->isAllowed('messagetool')) {
			throw new PermissionsError('messagetool');
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
				if (wfReadOnly()) {
					$wgOut->SetPageTitle(wfMsg('readonly'));
					$reason = wfReadOnlyReason();
					$formData['messageContent'] = $wgRequest->getText('mContent');
					$formData['errMsg'] = wfMsg('readonlytext', $reason);
				} else {
					$mText = $wgRequest->getText('mContent');
					$editMsgId = isset($_POST['editMsgId']) ? $_POST['editMsgId'] : 0;
					$mExpiry = $wgRequest->getText( 'mExpireTimeS' );
					if ($editMsgId) {	//editing?
						$result = $this->saveMessage( $editMsgId, $mText, $mExpiry );
					}
					$redirect = $wgTitle->getLocalUrl('action=list');
					$wgOut->redirect($redirect, 200);
					return;
				}
				break;

			case 'send':
				$mText = $wgRequest->getText('mContent');
				$result = $this->sendMessage( $wgUser, $mText, $formData );

				if (is_null($result['msgId'])) {	//we have an error
					$formData['messageContent'] = $wgRequest->getText('mContent');
					$formData['errMsg'] = $result['errMsg'];
					$wgOut->SetPageTitle(wfMsg('swm-page-title-editor'));
				} else {
					$queryStr = "action=sent&id={$result['msgId']}" . ( !is_null( $result['taskId'] ) ? "&taskid={$result['taskId']}" : '' );
					$redirect = $wgTitle->getLocalUrl( $queryStr );
					$wgOut->redirect($redirect, 200);
					return;
				}
				break;

			case 'sent':
				$mId = $wgRequest->getText('id');
				$mText = $mId ? $this->getMessageText($mId, true) : null;
				$mTaskId = $wgRequest->getText( 'taskid' );

				if ($mId && !is_null($mText)) {
					$formData['messageContent'] = $wgOut->parse($mText);
					$formData['sendResult'] = wfMsg('swm-msg-sent-ok');
					if ( !empty( $mTaskId ) ) {
						$mTaskId = $mTaskId;
						$taskLink = Linker::linkKnown(
							GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, 177 ),
							"#{$mTaskId}",
							[
								'target' => '_blank'
							],
							array(
								'id' => $mTaskId,
							)
						);
						$formData['sendResult'] .= wfMsg( 'swm-msg-sent-task', $taskLink );
					}
				} else {
					$formData['messageContent'] = '';
					$formData['sendResult'] = wfMsg('swm-msg-sent-err');
				}

				$template = 'sent';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-sent'));
				break;

			case 'remove':
				if (wfReadOnly()) {
					$wgOut->SetPageTitle(wfMsg('readonly'));
					$reason = wfReadOnlyReason();
					$formData['messageContent'] = $wgRequest->getText('mContent');
					$formData['errMsg'] = wfMsg('readonlytext', $reason);
				} else {
					$mId = $wgRequest->getText('id');
					if ($mId) {
						$this->removeMessage($mId);
					}
				}
				//no break - go to 'list'

			case 'list':
				$formData['messages'] = $this->getAllMessagesInfo();

				$template = 'list';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-list'));

				//init pager
				$oPager = new SiteWideMessagesPager( $formData );
				$formData['body']  = $oPager->getBody();
				$formData['nav']   = $oPager->getNavigationBar();
				break;

			case 'edit':
				$mId = $wgRequest->getText('id');
				$formData['messageContent'] = $mId ? $this->getMessageText($mId) : null;
				$formData['expireTimeS'] = $mId ? $this->getMessageExpiry( $mId ) : null;
				$editMsgId = $mId;
				//no break - go to 'default' => editor

			default:	//editor
				$formData['expireTime'] = '';
				$wgOut->SetPageTitle(wfMsg('swm-page-title-editor'));
		}

		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		global $wgSWMSupportedLanguages;
		$oTmpl->set_vars( array(
				'title' => $wgTitle,
				'formData' => $formData,
				'editMsgId' => $editMsgId,
				'supportedLanguages' => $wgSWMSupportedLanguages
			));
		$wgOut->addHTML($oTmpl->render($template));
	}

	//DB functions
	private function sendMessage( $mSender, $mText, $formData ) {
		global $wgExternalSharedDB, $wgSpecialsDB, $wgUser;
		$result = array('msgId' => null, 'errMsg' => null);
		$dbInsertResult = false;
		$mWikiId = null;
		$mLang = $formData['mLang'];
		if ( is_array( $mLang ) ) {
			$mLang = implode( ',', $mLang );
		}
		$mRecipientId = $formData['sendModeUsers'] != 'USER' ? null : $wgUser->idFromName( $formData['userName'] );
		$mWikiName = $formData['wikiName'];
		$mRecipientName = $formData['userName'];
		$mGroupName = $formData['groupName'] == '' ? $formData['groupNameS'] : $formData['groupName'];
		$mPowerUserType = $formData['powerUserType'];
		if ( is_array( $mPowerUserType ) ) {
			$mPowerUserType = implode( ',', $mPowerUserType );
		}
		$mSendModeWikis = $formData['sendModeWikis'];
		$mSendModeUsers = $formData['sendModeUsers'];
		$mHubId = $formData['hubId'];
		$mClusterId = $formData['clusterId'];
		$mUserNamesArr = array_unique( explode( "\n", $formData['listUserNames'] ) );
		$mWikiNamesArr = array_unique( explode( "\n", $formData['listWikiNames'] ) );

		//remove unnecessary data
		switch ( $mSendModeWikis ) {
			case 'ALL':
				$mWikiName = '';
				$mHubId = null;
				$mClusterId = null;
				break;
			case 'HUB':
				$mWikiName = '';
				$mClusterId = null;
				break;
			case 'CLUSTER':
				$mWikiName = '';
				$mHubId = null;
				break;
			case 'WIKI':
				$mHubId = null;
				$mClusterId = null;
				break;
			case 'WIKIS':
				$mWikiName = count( $mWikiNamesArr ) . ' wikis';
				$mHubId = null;
				$mClusterId = null;
				break;
			case 'CREATED':
				$mWikiName = MSG_WIKI_CREATION_DATE;
				$mHubId = null;
				$mClusterId = null;
				break;
		}

		switch ( $mSendModeUsers ) {
			case 'ALL':
			case 'ACTIVE':
				$mRecipientName = '';
				$mGroupName = '';
				$mPowerUserType = '';
				break;
			case 'GROUP':
				$mRecipientName = '';
				$mPowerUserType = '';
				break;
			case 'POWERUSER':
				$mRecipientName = '';
				$mGroupName = '';
				break;
			case 'USER':
				$mGroupName = '';
				$mPowerUserType = '';
				$mLang = MSG_LANG_ALL;
				break;
			case 'USERS':
				$mRecipientName = count( $mUserNamesArr ) . ' users';
				$mGroupName = '';
				$mPowerUserType = '';
				$mLang = MSG_LANG_ALL;
				break;
			case 'ANONS':
				$mRecipientName = MSG_RECIPIENT_ANON;
				$mGroupName = '';
				$mPowerUserType = '';
				break;
			case 'REGISTRATION':
				$mRecipientName = '';
				$mGroupName = '';
				$mPowerUserType = '';
				break;
			case 'EDITCOUNT':
				$mRecipientName = '';
				$mGroupName = '';
				$mPowerUserType = '';
				break;
		}

		$sendToAll = $mSendModeWikis == 'ALL' && $mSendModeUsers == 'ALL';

		$tmpWikiName = false;
		if ($mSendModeWikis == 'WIKI' && $mWikiName != '') {
			$tmpWikiName = $mWikiName;
		}
		if ($tmpWikiName) {
			$wikiDomains = array('', '.wikia.com');
			foreach($wikiDomains as $wikiDomain) {
				if(!is_null($mWikiId = WikiFactory::DomainToID($tmpWikiName . $wikiDomain))) {
					break;
				}
			}
		}

		$validDateTime = true;
		if ( $formData['expireTimeS'] !== '' ) {
			$timestamp = wfTimestamp( TS_UNIX, $formData['expireTimeS'] );
			if ( !$timestamp ) {
				$validDateTime = false;
			}
			$mExpire = wfTimestamp( TS_DB, $timestamp );
		} else {
			//null => expire never
			$mExpire = $formData['expireTime'] != '0' ? date('Y-m-d H:i:s', strtotime(ctype_digit($formData['expireTime']) ? " +{$formData['expireTime']} day" : ' +' . substr($formData['expireTime'], 0, -1) . ' hour')) : null;
		}

		if ( $mSendModeWikis === 'CREATED' ) {
			$timestamp = wfTimestamp( TS_UNIX, $formData['wikiCreationDateOne'] );
			if ( !$timestamp ) {
				$validDateTime = false;
			}
			$formData['wikiCreationDateOne'] = wfTimestamp( TS_DB, $timestamp );
			if ( $formData['wikiCreationDateOption'] === 'between' ) {
				if ( $formData['wikiCreationDateTwo'] !== '' ) {
					$timestamp = wfTimestamp( TS_UNIX, $formData['wikiCreationDateTwo'] );
					if ( !$timestamp ) {
						$validDateTime = false;
					}
					$formData['wikiCreationDateTwo'] = wfTimestamp( TS_DB, $timestamp );
				} else {
					$validDateTime = false;
				}
			}
		}

		if ( $mSendModeUsers === 'REGISTRATION' ) {
			$timestamp = wfTimestamp( TS_UNIX, $formData['registrationDateOne'] );
			if ( !$timestamp ) {
				$validDateTime = false;
			}
			$formData['registrationDateOne'] = wfTimestamp( TS_MW, $timestamp );
			if ( $formData['registrationDateOption'] === 'between' ) {
				if ( $formData['registrationDateTwo'] !== '' ) {
					$timestamp = wfTimestamp( TS_UNIX, $formData['registrationDateTwo'] );
					if ( !$timestamp ) {
						$validDateTime = false;
					}
					$formData['registrationDateTwo'] = wfTimestamp( TS_MW, $timestamp );
				} else {
					$validDateTime = false;
				}
			}
		}

		if (wfReadOnly()) {
			$reason = wfReadOnlyReason();
			$result['errMsg'] = wfMsg('readonlytext', $reason);
		} elseif ($mText == '') {
			$result['errMsg'] = wfMsg('swm-error-empty-message');
		} elseif (mb_strlen($mText) > 500) {
			$result['errMsg'] = wfMsg('swm-error-long-message');
		} elseif ($mSendModeWikis == 'WIKI' && is_null($mWikiId)) {
			//this wiki doesn't exist
			$result['errMsg'] = wfMsg('swm-error-no-such-wiki');
		} elseif ( $mSendModeUsers == 'WIKIS' && empty( $formData['listWikiNames'] ) ) {
			$result['errMsg'] = wfMsg( 'swm-error-no-wiki-list' );
		} elseif ($mSendModeUsers == 'USER' && !User::idFromName($mRecipientName)) {
			$result['errMsg'] = wfMsg('swm-error-no-such-user');
		} elseif ( $mSendModeUsers == 'USERS' && empty( $formData['listUserNames'] ) ) {
			$result['errMsg'] = wfMsg( 'swm-error-no-user-list' );
		} elseif ( !$validDateTime ) {
			$result['errMsg'] = wfMsg( 'swm-error-invalid-time' );
		} elseif ( $mSendModeUsers === 'REGISTRATION'
			&& $formData['registrationDateOption'] === 'between'
			&& ( $formData['registrationDateTwo'] <= $formData['registrationDateOne'] )
		) {
			$result['errMsg'] = wfMsg( 'swm-error-registered-tobeforefrom' );
		} elseif ( $mSendModeWikis === 'CREATED'
			&& $formData['wikiCreationDateOption'] === 'between'
			&& ( $formData['wikiCreationDateTwo'] <= $formData['wikiCreationDateOne'] )
		) {
			$result['errMsg'] = wfMsg( 'swm-error-created-tobeforefrom' );
		} elseif ( $mSendModeUsers === 'EDITCOUNT'
			&& ( !is_numeric( $formData['editCountOne'] )
			|| ( $formData['editCountOption'] === 'between'
			&& !is_numeric( $formData['editCountTwo'] ) ) )
		) {
			$result['errMsg'] = wfMsg( 'swm-error-editcount-notnumber' );
		} elseif ( $mSendModeUsers === 'EDITCOUNT'
			&& $formData['editCountOption'] === 'between'
			&& ( $formData['editCountTwo'] <= $formData['editCountOne'] )
		) {
			$result['errMsg'] = wfMsg( 'swm-error-editcount-tolessthanfrom' );
		} else {
			global $wgParser, $wgUser;
			$title = Title::newFromText(uniqid('tmp'));
			$options = ParserOptions::newFromUser($wgUser);

			//Parse some wiki markup [eg. ~~~~]
			$mText = $wgParser->preSaveTransform($mText, $title, $wgUser, $options);

			$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			$dbResult = (boolean)$DB->Query (
				  'INSERT INTO ' . MSG_TEXT_DB
				. ' (msg_sender_id, msg_text, msg_mode, msg_expire, msg_recipient_name, msg_group_name, msg_wiki_name, msg_hub_id, msg_lang, msg_cluster_id)'
				. ' VALUES ('
				. $DB->AddQuotes($mSender->GetID()). ', '
				. $DB->AddQuotes($mText) . ', '
				. ($sendToAll ? MSG_MODE_ALL : MSG_MODE_SELECTED) . ', '
				. $DB->AddQuotes($mExpire) . ', '
				. $DB->AddQuotes($mRecipientName) . ', '
				. $DB->AddQuotes($mGroupName) . ', '
				. $DB->AddQuotes($mWikiName) . ', '
				. $DB->AddQuotes($mHubId) . ' , '
				. $DB->AddQuotes($mLang) . ' , '
				. $DB->AddQuotes($mClusterId)
				. ');'
				, __METHOD__
			);
			if ($dbResult) {
				$dbInsertResult = true;
				$result['msgId'] = $DB->insertId();
				if ( is_null( $mWikiId ) ) {
					$mWikiId = 0;
				}

				if ($mSendModeUsers == 'USER') {
					if (!is_null($mRecipientId) && !is_null($result['msgId'])) {
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
				} elseif ( $mSendModeUsers == 'USERS' ) {
					$result['taskId'] = $this->queueTask([
						'messageId'		=> $result['msgId'],
						'sendModeWikis'	=> $mSendModeWikis,
						'sendModeUsers'	=> $mSendModeUsers,
						'wikiName'		=> $mWikiName,
						'groupName'		=> $mGroupName,
						'powerUserType' => $mPowerUserType,
						'userNames'     => $mUserNamesArr,
						'senderId'		=> $mSender->GetID(),
						'senderName'	=> $mSender->GetName(),
						'hubId'			=> $mHubId,
						'clusterId'     => $mClusterId,
					]);
				} else {
					switch ($mSendModeWikis) {
						case 'ALL':
							switch ($mSendModeUsers) {
								case 'ALL':
									break;

								case 'ANONS':
									if ( !is_null( $result['msgId'] ) ) {
										$dbResult = (boolean)$DB->query(
											'INSERT INTO ' . MSG_STATUS_DB .
											' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)' .
											' VALUES (' .
											$DB->addQuotes( $mWikiId ). ', 0, ' .
											$DB->addQuotes( $result['msgId'] ) . ', ' .
											MSG_STATUS_UNSEEN .
											');'
											, __METHOD__
										);
										$dbInsertResult &= $dbResult;
									}
									break;

								case 'ACTIVE':
								case 'GROUP':
									$result['taskId'] = $this->queueTask([
										'messageId'		=> $result['msgId'],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									]);
									break;

								case 'POWERUSER':
									$result[ 'taskId' ] = $this->queueTask( [
										'messageId'		=> $result[ 'msgId' ],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									] );
									break;

								case 'REGISTRATION':
									$result['taskId'] = $this->queueTask([
										'messageId'		=> $result['msgId'],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'regOption'     => $formData['registrationDateOption'],
										'regStartDate'  => $formData['registrationDateOne'],
										'regEndDate'    => $formData['registrationDateTwo'],
										'senderId'		=> $mSender->getID(),
										'senderName'	=> $mSender->getName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									]);
									break;

								case 'EDITCOUNT':
									$result['taskId'] = $this->queueTask([
										'messageId'			=> $result['msgId'],
										'sendModeWikis'		=> $mSendModeWikis,
										'sendModeUsers'		=> $mSendModeUsers,
										'wikiName'			=> $mWikiName,
										'groupName'			=> $mGroupName,
										'powerUserType' 	=> $mPowerUserType,
										'editCountOption'	=> $formData['editCountOption'],
										'editCountStart'	=> $formData['editCountOne'],
										'editCountEnd'		=> $formData['editCountTwo'],
										'senderId'			=> $mSender->getID(),
										'senderName'		=> $mSender->getName(),
										'hubId'				=> $mHubId,
										'clusterId'     	=> $mClusterId,
									]);
									break;
							}
							break;

						case 'HUB':
							switch ($mSendModeUsers) {
								case 'ALL':
								case 'ACTIVE':
								case 'GROUP':
								case 'ANONS':
									$result['taskId'] = $this->queueTask([
										'messageId'		=> $result['msgId'],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									]);
									break;
							}
							break;

						case 'CLUSTER':
							switch ($mSendModeUsers) {
								case 'ALL':
								case 'ACTIVE':
								case 'GROUP':
									$result['taskId'] = $this->queueTask([
										'messageId'		=> $result['msgId'],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									]);
									break;
							}
							break;

						case 'WIKI':
							switch ($mSendModeUsers) {
								case 'ALL':
								case 'ACTIVE':
									$dbr = wfGetDB(DB_SLAVE, array(), $wgSpecialsDB);

									$dbResult = $dbr->select(
										array('events_local_users'),
										array('user_id'),
										array('wiki_id' => $mWikiId),
										__METHOD__,
										array( 'DISTINCT' )
									);

									$activeUsers = array();
									while ($oMsg = $dbr->FetchObject($dbResult)) {
										$activeUsers[] = $oMsg->user_id;
									}
									if ($dbResult !== false) {
										$dbr->FreeResult($dbResult);
									}

									if (!$DB) {
										$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
									}
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

								case 'ANONS':
									if ( !is_null( $result['msgId'] ) ) {
										$dbResult = (boolean)$DB->query(
											'INSERT INTO ' . MSG_STATUS_DB .
											' (msg_wiki_id, msg_recipient_id, msg_id, msg_status)' .
											' VALUES (' .
											$DB->addQuotes( $mWikiId ). ', 0, ' .
											$DB->addQuotes( $result['msgId'] ) . ', ' .
											MSG_STATUS_UNSEEN .
											');'
											, __METHOD__
										);
										$dbInsertResult &= $dbResult;
									}
									break;

								case 'GROUP':
									$result['taskId'] = $this->queueTask([
										'messageId'		=> $result['msgId'],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									]);
									break;

								case 'POWERUSER':
									$result[ 'taskId' ] = $this->queueTask( [
										'messageId'		=> $result[ 'msgId' ],
										'sendModeWikis'	=> $mSendModeWikis,
										'sendModeUsers'	=> $mSendModeUsers,
										'wikiName'		=> $mWikiName,
										'groupName'		=> $mGroupName,
										'powerUserType' => $mPowerUserType,
										'senderId'		=> $mSender->GetID(),
										'senderName'	=> $mSender->GetName(),
										'hubId'			=> $mHubId,
										'clusterId'     => $mClusterId,
									] );
									break;

								case 'EDITCOUNT':
									$result['taskId'] = $this->queueTask([
										'messageId'			=> $result['msgId'],
										'sendModeWikis'		=> $mSendModeWikis,
										'sendModeUsers'		=> $mSendModeUsers,
										'wikiName'			=> $mWikiName,
										'groupName'			=> $mGroupName,
										'powerUserType' 	=> $mPowerUserType,
										'editCountOption'	=> $formData['editCountOption'],
										'editCountStart'	=> $formData['editCountOne'],
										'editCountEnd'		=> $formData['editCountTwo'],
										'senderId'			=> $mSender->getID(),
										'senderName'		=> $mSender->getName(),
										'hubId'				=> $mHubId,
										'clusterId'     	=> $mClusterId,
									]);
									break;
							}
							break;

						case 'WIKIS':
							switch ($mSendModeUsers) {
								case 'ALL':
								case 'ACTIVE':
								case 'GROUP':
								case 'EDITCOUNT':
								case 'ANONS':
									$result['taskId'] = $this->queueTask([
										'messageId'			=> $result['msgId'],
										'sendModeWikis'		=> $mSendModeWikis,
										'sendModeUsers'		=> $mSendModeUsers,
										'wikiName'			=> $mWikiName,
										'wikiNames'			=> $mWikiNamesArr,
										'groupName'			=> $mGroupName,
										'powerUserType' 	=> $mPowerUserType,
										'editCountOption'	=> $formData['editCountOption'],
										'editCountStart'	=> $formData['editCountOne'],
										'editCountEnd'		=> $formData['editCountTwo'],
										'senderId'			=> $mSender->GetID(),
										'senderName'		=> $mSender->GetName(),
										'hubId'				=> $mHubId,
										'clusterId'     	=> $mClusterId,
									]);
									break;
							}
							break;

						case 'CREATED':
							switch ( $mSendModeUsers ) {
								case 'ALL':
								case 'ACTIVE':
								case 'GROUP':
								case 'EDITCOUNT':
								case 'ANONS':
									$result['taskId'] = $this->queueTask([
										'messageId'			=> $result['msgId'],
										'sendModeWikis'		=> $mSendModeWikis,
										'sendModeUsers'		=> $mSendModeUsers,
										'wikiName'			=> $mWikiName,
										'wikiNames'			=> $mWikiNamesArr,
										'groupName'			=> $mGroupName,
										'powerUserType' 	=> $mPowerUserType,
										'wcOption'			=> $formData['wikiCreationDateOption'],
										'wcStartDate'		=> $formData['wikiCreationDateOne'],
										'wcEndDate'			=> $formData['wikiCreationDateTwo'],
										'editCountOption'	=> $formData['editCountOption'],
										'editCountStart'	=> $formData['editCountOne'],
										'editCountEnd'		=> $formData['editCountTwo'],
										'senderId'			=> $mSender->GetID(),
										'senderName'		=> $mSender->GetName(),
										'hubId'				=> $mHubId,
										'clusterId'     	=> $mClusterId,
									]);
									break;
							}
							break;
					}	//end: switch ($mSendModeWikis)
				}	//end: if ($mSendModeUsers == 'USER')
			}	//end: if ($dbResult) => message sent
		}	//end: else =? no errors

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || SenderId=" . $mSender->GetID() . ", RecipientId=$mRecipientId, Expire=$mExpire, result=" . ($dbInsertResult ? 'true':'false') . "\n");
		return $result;
	}

	private function queueTask($taskArgs) {
		$task = new \Wikia\Tasks\Tasks\SiteWideMessagesTask();
		$task->call('send', $taskArgs);
		$taskId = $task->queue();

		return $taskId;
	}

	private function saveMessage( $editMsgId, $mText, $mExpiry ) {
		global $wgUser, $wgParser, $wgExternalSharedDB;
		$title = Title::newFromText(uniqid('tmp'));
		$options = ParserOptions::newFromUser($wgUser);

		//Parse some wiki markup [eg. ~~~~]
		$mText = $wgParser->preSaveTransform($mText, $title, $wgUser, $options);

		// Validate date and time
		$validDateTime = true;
		if ( $mExpiry !== '' ) {
			$timestamp = wfTimestamp( TS_UNIX, $mExpiry );
			if ( !$timestamp ) {
				$validDateTime = false;
			}
			$mExpire = wfTimestamp( TS_DB, $timestamp );
		}

		$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbResult = (boolean)$DB->Query (
			  'UPDATE ' . MSG_TEXT_DB
			. ' SET msg_text = ' . $DB->AddQuotes($mText)
			. ' , msg_sender_id = ' . $DB->AddQuotes($wgUser->GetID())
			. ( $validDateTime ? ' , msg_expire = ' . $DB->addQuotes( $mExpire ) : '' )
			. ' WHERE msg_id = ' . $DB->AddQuotes($editMsgId)
			. ';'
			, __METHOD__
		);

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || messageID=$editMsgId, result=" . ($dbResult ? 'true':'false') . "\n");
		return $dbResult;
	}

	/**
	 */
	private function getMessageText($mId, $master = false) {
		global $wgExternalSharedDB;
		$DB = wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalSharedDB );

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

	/**
	 * Get message expiry time
	 *
	 * @access private
	 * @author Daniel Grunwell (grunny)
	 * @param $mId int the message ID
	 * @param $master boolean whether to use the master or slave database (default: false)
	 *
	 */
	private function getMessageExpiry( $mId, $master = false ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalSharedDB );

		$dbResult = $dbr->select(
			array( MSG_TEXT_DB ),
			array( 'msg_expire' ),
			array( 'msg_id' => $mId ),
			__METHOD__
		);

		$result = null;

		if ( $oMsg = $dbr->fetchObject( $dbResult ) ) {
			$result = $oMsg->msg_expire;
		}
		if ( $dbResult !== false ) {
			$dbr->freeResult($dbResult);
		}
		return $result;
	}

	private function getAllMessagesInfo() {
		global $wgExternalSharedDB;
		$DB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$dbResult = $DB->Query (
			  'SELECT msg_id, user_name, msg_text, msg_removed, msg_expire, msg_date, msg_recipient_name, msg_group_name, msg_wiki_name'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN user ON msg_sender_id = user_id'
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
		global $wgExternalSharedDB;
		$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

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
	static function getAllUserMessagesId($user, $filter_seen = true) {
		global $wgCityId, $wgLanguageCode;
		global $wgExternalSharedDB ;
		$localCityId = isset($wgCityId) ? $wgCityId : 0;
		$DB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		//step 1 of 3: get all active messages sent to *all*
		$dbResult = $DB->Query (
			  'SELECT msg_id AS id, msg_lang as lang'
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
			if ( self::getLanguageConstraintsForUser( $user, $oMsg->lang ) ) {
				$tmpMsg[$oMsg->id] = array('wiki_id' => null);
			}
		}
		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}

		if (count($tmpMsg)) {
			// Exclude 'seen' messages based on $filter_seen
			$status[] = MSG_STATUS_DISMISSED;
			if ($filter_seen) $status[] = MSG_STATUS_SEEN;

			//step 2 of 3: remove dismissed and seen messages
			$dbResult = $DB->Query (
				  'SELECT msg_id AS id'
				. ' FROM ' . MSG_STATUS_DB
				. ' WHERE msg_id IN (' . implode(',', array_keys($tmpMsg)) . ')'
				. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
				. ' AND msg_status IN (' . join(',', $status) . ')'
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

		unset($status);
		$status[] = MSG_STATUS_UNSEEN;
		if (! $filter_seen) $status[] = MSG_STATUS_SEEN;

		//step 3 of 3: add unseen messages sent to *this* user (on *all* wikis or *this* wiki)
		$dbResult = $DB->Query (
			  'SELECT msg_wiki_id, msg_id AS id, msg_lang as lang'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . MSG_STATUS_DB . ' USING (msg_id)'
			. ' WHERE msg_mode = ' . MSG_MODE_SELECTED
			. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
			. ' AND msg_status IN (' . join(',', $status) . ')'
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. ' AND msg_removed = ' . MSG_REMOVED_NO
			. " AND (msg_wiki_id = 0 OR msg_wiki_id = $localCityId)"
			. ';'
			, __METHOD__
		);

		while ($oMsg = $DB->FetchObject($dbResult)) {
			if ( self::getLanguageConstraintsForUser( $user, $oMsg->lang ) ) {
				$tmpMsg[$oMsg->id] = array('wiki_id' => $oMsg->msg_wiki_id);
			}
		}

		if ($dbResult !== false) {
			$DB->FreeResult($dbResult);
		}
		//sort from newer to older
		krsort($tmpMsg);

		$messages = array();
		$IDs = array();
		foreach ($tmpMsg as $tmpMsgId => $tmpMsgData) {
			$IDs['id'][] = $tmpMsgId;
			$IDs['wiki'][] = $tmpMsgData['wiki_id'];
		}
		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || userID={$user->GetID()}, result=" . ($dbResult ? 'true':'false') . "\n");

		return $IDs;
	}

	// TODO: add cache
	static function getAllUserMessages($user, $dismissLink = true, $formatted = true) {
		global $wgMemc, $wgCityId, $wgLanguageCode;
		global $wgExternalSharedDB;

		if ( !$user->isLoggedIn() ) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$localCityId = isset($wgCityId) ? $wgCityId : 0;

		$DB = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		//step 1 of 3: get all active messages sent to *all*
		//left outer join here now returns rows where recipient_id is null, but skips users which are NOT our guy. :)
		$dbResult = $DB->Query (
			  'SELECT ' . MSG_TEXT_DB . '.msg_id AS id, msg_text AS text, msg_expire AS expire, msg_lang AS lang, msg_recipient_id AS user_id, msg_status AS status'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . MSG_STATUS_DB . ' ON ' . MSG_TEXT_DB . '.msg_id = ' . MSG_STATUS_DB . '.msg_id'
			. ' AND ' . MSG_STATUS_DB . '.msg_recipient_id = '. $DB->AddQuotes($user->GetID())
			. ' WHERE msg_removed = ' . MSG_REMOVED_NO
			. ' AND msg_mode = ' . MSG_MODE_ALL
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. " AND " . MSG_TEXT_DB . ".msg_date > '{$user->mRegistration}'"	//fix for ticket #2624
			. ';'
			, __METHOD__
		);

		$tmpMsg = array();
		$userId = $user->getID();
		while ($oMsg = $DB->FetchObject($dbResult)) {
			if ( self::getLanguageConstraintsForUser( $user, $oMsg->lang ) ) {
				$tmpMsg[$oMsg->id] = array('wiki_id' => null, 'text' => $oMsg->text, 'expire' => $oMsg->expire);
				//fix for RT#48187
				if ($oMsg->user_id == $userId) {
					$tmpMsg[$oMsg->id]['status'] = $oMsg->status;
				}
			}
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
		//step 3 of 3: add undismissed messages sent to *this* user (on *all* wikis or *this* wiki)
		$dbResult = $DB->Query (
			  'SELECT msg_wiki_id, msg_id AS id, msg_text AS text, msg_expire AS expire, msg_lang AS lang, msg_status AS status'
			. ' FROM ' . MSG_TEXT_DB
			. ' LEFT JOIN ' . MSG_STATUS_DB . ' USING (msg_id)'
			. ' WHERE msg_mode = ' . MSG_MODE_SELECTED
			. ' AND msg_recipient_id = ' . $DB->AddQuotes($user->GetID())
			. ' AND msg_status IN (' . MSG_STATUS_UNSEEN . ', ' . MSG_STATUS_SEEN . ')'
			. ' AND (msg_expire IS NULL OR msg_expire > ' . $DB->AddQuotes(date('Y-m-d H:i:s')) . ')'
			. ' AND msg_removed = ' . MSG_REMOVED_NO
			. " AND (msg_wiki_id = 0 OR msg_wiki_id = $localCityId )"
			. ';'
			, __METHOD__
		);

		while ($oMsg = $DB->FetchObject($dbResult)) {
			if ( self::getLanguageConstraintsForUser( $user, $oMsg->lang ) ) {
				$tmpMsg[$oMsg->id] = array('wiki_id' => $oMsg->msg_wiki_id, 'text' => $oMsg->text, 'expire' => $oMsg->expire, 'status' => $oMsg->status);
			}
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

		//prevent double execution of all those queries
		if (count($messages)) {
			self::$hasMessages = true;
		}

		$userID = $user->GetID();
		//once the messages are displayed, they must be marked as "seen" so user will not see "you have new messages" from now on
		$countDisplayed = count($tmpMsg);
		//do update only for not marked before

		// Keep a copy of these around to return if necessary
		$unformatted = $tmpMsg;

		if ($countDisplayed) {
			//purge the cache
			$key = 'wikia:talk_messages:' . $userID . ':' . str_replace(' ', '_', $user->getName());
			$wgMemc->set($key, 'deleted', 100);
		}

		if ($formatted) {
			$result = implode("\n", $messages);
		} else {
			$result = $unformatted;
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	static function getAllAnonMessages( $user ) {
		global $wgCityId, $wgExternalSharedDB, $wgMemc, $wgTitle;

		wfProfileIn( __METHOD__ );

		$localCityId = isset( $wgCityId ) ? $wgCityId : 0;

		$memcKey = "smw:anon:{$localCityId}";

		$result = $wgMemc->get( $memcKey );

		if ( !is_array( $result ) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

			$result = array();

			$dbResult = $dbr->query(
				'SELECT msg_wiki_id, msg_id AS id, msg_text AS text, msg_expire AS expire, msg_lang AS lang, msg_status AS status' .
				' FROM ' . MSG_TEXT_DB .
				' LEFT JOIN ' . MSG_STATUS_DB . ' USING (msg_id)' .
				' WHERE msg_mode = ' . MSG_MODE_SELECTED .
				' AND msg_recipient_id = 0' .
				' AND msg_recipient_name = ' . $dbr->addQuotes( MSG_RECIPIENT_ANON ) .
				' AND msg_status IN (' . MSG_STATUS_UNSEEN . ', ' . MSG_STATUS_SEEN . ')' .
				' AND (msg_expire IS NULL OR msg_expire > ' . $dbr->addQuotes( date( 'Y-m-d H:i:s' ) ) . ')' .
				' AND msg_removed = ' . MSG_REMOVED_NO .
				" AND (msg_wiki_id = 0 OR msg_wiki_id = $localCityId )" .
				';'
				, __METHOD__
			);

			while ( $oMsg = $dbr->fetchObject( $dbResult ) ) {
				if ( self::getLanguageConstraintsForUser( $user, $oMsg->lang ) ) {
					$messageText = ParserPool::parse( $oMsg->text, $wgTitle, new ParserOptions() )->getText();
					$result['msg_' . $oMsg->id] = array( 'msgId' => $oMsg->id, 'wiki_id' => $oMsg->msg_wiki_id, 'text' => $messageText, 'expire' => $oMsg->expire, 'status' => $oMsg->status );
				}
			}
			if ( $dbResult !== false ) {
				$dbr->freeResult( $dbResult );
			}

			//sort from newer to older
			krsort( $result );

			// Cache result for 15 minutes
			$wgMemc->set( $memcKey, $result, 900 /* 15 minutes */ );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/*
	 * @author Lucas Garczewski <tor@wikia-inc.com>
	 *
	 * @param $user current User object
	 * @param $langs string of comma separated lang codes
	 *
	 * @return string for WHERE clause
	 */
	static function getLanguageConstraintsForUser( $user, $langs ) {
		global $wgSWMSupportedLanguages;

		# if no language options were specified, just let it through
		if ( $langs == null ) {
			return true;
		}

		$langs = explode( ',', $langs );
		$userLang = $user->getGlobalPreference( 'language' );

		$ret = ( in_array( MSG_LANG_ALL, $langs ) || in_array( $userLang, $langs ) || ( in_array( MSG_LANG_OTHER, $langs) && !in_array( $userLang, $wgSWMSupportedLanguages ) ) );

		return $ret;
	}

	static function dismissMessage($messageID) {
		global $wgUser, $wgMemc, $wgExternalSharedDB, $wgTitle, $wgRequest;
		wfProfileIn( __METHOD__ );
		$userID = $wgUser->GetID();
		if (wfReadOnly()) {
			wfProfileOut( __METHOD__ );
			return wfMsg('readonly');
		} elseif ( !$wgUser->isLoggedIn() ) {
			$wgRequest->response()->setcookie( 'swm-' . $messageID, 1, time() + 86400 /*24h*/ );
		} elseif ($userID) {
			$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

			$dbResult = $DB->select(
				array( MSG_STATUS_DB ),
				array( 'msg_wiki_id' ),
				array(
					'msg_id' => $messageID,
					'msg_recipient_id' => $userID
				),
				__METHOD__
			);

			$mWikiId = null;

			if ($oMsg = $DB->fetchObject($dbResult)) {
				$mWikiId = $oMsg->msg_wiki_id;
			}
			if ($dbResult !== false) {
				$DB->freeResult($dbResult);
			}

			if ( is_null( $mWikiId ) ) {
				$dbResult = (boolean)$DB->insert(
					MSG_STATUS_DB,
					array(
						'msg_wiki_id' => 0,
						'msg_recipient_id' => $userID,
						'msg_id' => $messageID,
						'msg_status' => MSG_STATUS_DISMISSED
					),
					__METHOD__
				);
			} else {
				$dbResult = (boolean)$DB->update(
					MSG_STATUS_DB,
					array(
						'msg_status' => MSG_STATUS_DISMISSED
					),
					array(
						'msg_recipient_id' => $userID,
						'msg_id' => $messageID
					),
					__METHOD__
				);
			}

			//purge the cache
			$key = 'wikia:talk_messages:' . $userID . ':' . str_replace(' ', '_', $wgUser->getName());
			$wgMemc->set($key, 'deleted', 100);

			//omit browser cache by increasing pageTouch
			if ( is_object( $wgTitle ) ) {
				$wgTitle->invalidateCache();
			}

			$DB->commit();

			wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || WikiId=$mWikiId, messageID=$messageID, result=" . ($dbResult ? 'true':'false') . "\n");
			wfProfileOut( __METHOD__ );
			return (bool)$dbResult;
		}
		wfProfileOut( __METHOD__ );
		return false;
	}

	static function deleteMessagesOnWiki($city_id) {
		global $wgExternalSharedDB;
		$DB = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbResult = (boolean)$DB->Query (
			  'DELETE FROM ' . MSG_STATUS_DB
			. ' WHERE msg_wiki_id = ' . $DB->AddQuotes($city_id)
			. ';'
			, __METHOD__
		);
		return $dbResult;
	}
}

//class for pagination of list of messages
class SiteWideMessagesPager extends TablePager {
	var $mFieldNames = null;
	var $mMessages = array();
	var $mQueryConds = array();
	var $mTitle;
	var $never;
	var $formData;

	#--- constructor
	function __construct( $formData ) {
		global $wgExternalSharedDB;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'SiteWideMessages' );
		$this->mDefaultDirection = true;
		$this->never = explode(',', wfMsg('swm-days'));
		$this->never = $this->never[0];
		$this->formData = $formData;
		parent::__construct();
		$this->mDb = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
	}

	#--- getFieldNames ------------------------------------------------------
	function getFieldNames() {
		if ( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			$this->mFieldNames['msg_id']             = wfMsg('swm-list-table-id');
			$this->mFieldNames['msg_sender']         = wfMsg('swm-list-table-sender');
			$this->mFieldNames['msg_wiki_name']      = wfMsg('swm-list-table-wiki');
			$this->mFieldNames['msg_hub_id']         = wfMsg( 'swm-list-table-hub' );
			$this->mFieldNames['msg_recipient_name'] = wfMsg('swm-list-table-recipient');
			$this->mFieldNames['msg_group_name']     = wfMsg('swm-list-table-group');
			$this->mFieldNames['msg_expire']         = wfMsg('swm-list-table-expire');
			$this->mFieldNames['msg_removed']        = wfMsg('swm-list-table-removed');
			$this->mFieldNames['msg_text']           = wfMsg('swm-list-table-content');
			$this->mFieldNames['msg_date']           = wfMsg('swm-list-table-date');
			$this->mFieldNames['msg_lang']           = wfMsg('swm-list-table-lang');
			$this->mFieldNames['msg_wiki_tools']     = wfMsg('swm-list-table-tools');
		}
		return $this->mFieldNames;
	}

	#--- isFieldSortable-----------------------------------------------------
	function isFieldSortable( $field ) {
		static $sortable = array( 'msg_id', 'msg_sender', 'msg_removed', 'msg_date', 'msg_expire', 'msg_wiki_name', 'msg_group_name', 'msg_recipient_name', 'msg_text', 'msg_lang', 'msg_hub_id' );
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
				$sRetval = $value ?
					( $value === MSG_RECIPIENT_ANON ? ('<i>' . wfMsg( 'swm-label-mode-users-anon' ) . '</i>') : htmlspecialchars( $value ) ) :
					( '<i>' . wfMsg('swm-label-mode-users-all') . '</i>' );
				break;

			case 'msg_wiki_name':
				$sRetval = ( $value === MSG_WIKI_CREATION_DATE ? ('<i>' . wfMsg( 'swm-label-mode-wikis-created' ) . '</i>') : htmlspecialchars( $value ) );
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

			case 'msg_hub_id':
				$sRetval = ( $value && isset( $this->formData['hubNames'][$value] ) ) ? htmlspecialchars( $this->formData['hubNames'][$value] ) : htmlspecialchars( $value );
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
			'tables' => MSG_TEXT_DB . ' LEFT JOIN user ON msg_sender_id = user_id',
			'fields' => array('msg_id', 'user_name AS msg_sender', 'msg_text', 'msg_removed', 'msg_expire', 'msg_date', 'msg_recipient_name', 'msg_group_name', 'msg_wiki_name', 'msg_lang', 'msg_hub_id')
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
