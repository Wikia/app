<?php
/**
 * Chat
 *
 * Live chat for MediaWiki
 *
 * @author Christian Williams <christian@wikia-inc.com>, Sean Colombo <sean@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Chat',
	'author' => array( 'Christian Williams', 'Sean Colombo' ),
	'url' => 'http://community.wikia.com/wiki/Chat',
	'descriptionmsg' => 'chat-desc',
);

$dir = dirname(__FILE__);

// rights
$wgAvailableRights[] = 'chatmoderator';
$wgGroupPermissions['*']['chatmoderator'] = false;
$wgGroupPermissions['sysop']['chatmoderator'] = true;
$wgGroupPermissions['staff']['chatmoderator'] = true;
$wgGroupPermissions['helper']['chatmoderator'] = true;
$wgGroupPermissions['chatmoderator']['chatmoderator'] = true;

$wgGroupPermissions['*']['chatstaff'] = false;
$wgGroupPermissions['staff']['chatstaff'] = true;

$wgGroupPermissions['*']['chatadmin'] = false;
$wgGroupPermissions['sysop']['chatadmin'] = true;

$wgAvailableRights[] = 'chat';
$wgGroupPermissions['*']['chat'] = false;
$wgGroupPermissions['staff']['chat'] = true;
$wgGroupPermissions['user']['chat'] = true;
if ( $wgWikiaEnvironment == WIKIA_ENV_PREVIEW || $wgWikiaEnvironment == WIKIA_ENV_VERIFY ) {
	$wgGroupPermissions['user']['chat'] = false;
}

$wgGroupPermissions['util']['chatfailover'] = true;

// Allow admins to control banning/unbanning and chatmod-status


// Let staff & helpers change chatmod & banning status.
if( empty($wgAddGroups['staff'])  || !is_array($wgAddGroups['staff']) ){
	$wgAddGroups['staff'] = array();
}
if( empty($wgAddGroups['helper'])  || !is_array($wgAddGroups['helper']) ){
	$wgAddGroups['helper'] = array();
}
if( empty($wgRemoveGroups['staff']) || !is_array($wgRemoveGroups['staff']) ){
	$wgRemoveGroups['staff'] = array();
}
if( empty($wgRemoveGroups['helper']) || !is_array($wgRemoveGroups['helper']) ){
	$wgRemoveGroups['helper'] = array();
}

/*
$wgRemoveGroups['sysop'][] = 'bannedfromchat';
$wgAddGroups['sysop'][] = 'bannedfromchat';
$wgAddGroups['chatmoderator'][] = 'bannedfromchat';
$wgRemoveGroups['chatmoderator'][] = 'bannedfromchat';
$wgAddGroups['staff'][] = 'bannedfromchat';
$wgRemoveGroups['staff'][] = 'bannedfromchat';
$wgAddGroups['helper'][] = 'bannedfromchat';
$wgRemoveGroups['helper'][] = 'bannedfromchat';

// Attempt to do the permissions the other way (adding restriction instead of subtracting permission).
// When in 'bannedfromchat' group, the 'chat' permission will be revoked
// See http://www.mediawiki.org/wiki/Manual:$wgRevokePermissions
$wgRevokePermissions['bannedfromchat']['chat'] = true;

*/


$wgAddGroups['staff'][] = 'chatmoderator';
$wgRemoveGroups['staff'][] = 'chatmoderator';
$wgAddGroups['helper'][] = 'chatmoderator';
$wgRemoveGroups['helper'][] = 'chatmoderator';
$wgAddGroups['sysop'][] = 'chatmoderator';
$wgRemoveGroups['sysop'][] = 'chatmoderator';


// autoloaded classes
$wgAutoloadClasses['Chat'] = "$dir/Chat.class.php";
$wgAutoloadClasses['ChatAjax'] = "$dir/ChatAjax.class.php";
$wgAutoloadClasses['ChatHelper'] = "$dir/ChatHelper.php";
$wgAutoloadClasses['ChatEntryPoint'] = "$dir/ChatEntryPoint.class.php";
$wgAutoloadClasses['ChatController'] = "$dir/ChatController.class.php";
$wgAutoloadClasses['ChatRailController'] = "$dir/ChatRailController.class.php";
$wgAutoloadClasses['SpecialChat'] = "$dir/SpecialChat.class.php";
$wgAutoloadClasses['NodeApiClient'] = "$dir/NodeApiClient.class.php";
$wgAutoloadClasses['ChatfailoverSpecialController'] = "$dir/ChatfailoverSpecialController.class.php";

$wgSpecialPages[ 'Chatfailover'] = 'ChatfailoverSpecialController';

// special pages
$wgSpecialPages['Chat'] = 'SpecialChat';

// i18n
$wgExtensionMessagesFiles['Chat'] = $dir.'/Chat.i18n.php';
$wgExtensionMessagesFiles['ChatAliases'] = $dir.'/Chat.aliases.php';
$wgExtensionMessagesFiles['Chatfailover'] = $dir.'/Chatfailover.i18n.php';
$wgExtensionMessagesFiles['ChatDefaultEmoticons'] = $dir.'/ChatDefaultEmoticons.i18n.php';

// hooks
$wgHooks[ 'GetRailModuleList' ][] = 'ChatHelper::onGetRailModuleList';
$wgHooks[ 'StaffLog::formatRow' ][] = 'ChatHelper::onStaffLogFormatRow';
$wgHooks[ 'MakeGlobalVariablesScript' ][] = 'ChatHelper::onMakeGlobalVariablesScript';
$wgHooks[ 'ParserFirstCallInit' ][] = 'ChatEntryPoint::onParserFirstCallInit';
$wgHooks[ 'LinkEnd' ][] = 'ChatHelper::onLinkEnd';
$wgHooks[ 'BeforePageDisplay' ][] = 'ChatHelper::onBeforePageDisplay';
$wgHooks[ 'ContributionsToolLinks' ][] = 'ChatHelper::onContributionsToolLinks';
$wgHooks[ 'LogLine' ][] = 'ChatHelper::onLogLine';
$wgHooks[ 'UserGetRights' ][] = 'chatAjaxonUserGetRights';
$wgHooks[ 'GetIP' ][] = 'ChatAjax::onGetIP'; // used for calls from chat nodejs server

// logs
$wgLogTypes[] = 'chatban';
$wgLogHeaders['chatban'] = 'chat-chatban-log';
$wgLogNames['chatban'] = 'chat-chatban-log';

$wgLogTypes[] = 'chatconnect';
$wgLogHeaders['chatconnect'] = 'chat-chatconnect-log';
$wgLogNames['chatconnect'] = 'chat-chatconnect-log';
$wgLogActions['chatconnect/chatconnect'] = 'chat-chatconnect-log-entry';
$wgLogRestrictions["chatconnect"] = 'checkuser';

$wgLogActionsHandlers['chatban/chatbanchange'] = "ChatHelper::formatLogEntry";
$wgLogActionsHandlers['chatban/chatbanremove'] = "ChatHelper::formatLogEntry";
$wgLogActionsHandlers['chatban/chatbanadd'] = "ChatHelper::formatLogEntry";

// register messages package for JS
JSMessages::registerPackage('Chat', array(
	'chat-*',
));

JSMessages::registerPackage('ChatBanModal', array(
	'chat-log-reason-banadd',
	'chat-ban-modal-change-ban-heading',
	'chat-ban-modal-button-cancel',
	'chat-ban-modal-button-ok',
	'chat-ban-modal-button-change-ban',
));

JSMessages::registerPackage('ChatEntryPoint', array(
	'chat-join-the-chat',
	'chat-start-a-chat',
	'chat-user-menu-message-wall',
	'chat-user-menu-talk-page',
	'chat-user-menu-contribs',
	'chat-live2',
	'chat-edit-count',
	'chat-member-since'
));

define( 'CHAT_TAG', 'chat' );
define( 'CUC_TYPE_CHAT', 128);	// for CheckUser operation type

/**
 * Add read right to ChatAjax am reqest.
 * That is solving problems with private wikis and chat (communitycouncil.wikia.com)
 */
function chatAjaxonUserGetRights( $user, &$aRights ) {
	global $wgRequest;
	if ( $wgRequest->getVal('action') === 'ajax' && $wgRequest->getVal('rs') === 'ChatAjax' ) {
		$aRights[] = 'read';
	}
	return true;
}

// ajax
$wgAjaxExportList[] = 'ChatAjax';
function ChatAjax() {
	global $wgChatDebugEnabled;

	if (!empty($wgChatDebugEnabled)) {
		Wikia::log( __METHOD__, "", "Chat debug:" . json_encode($_REQUEST));
	}

	global $wgRequest, $wgUser, $wgMemc;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('ChatAjax', $method)) {
		wfProfileIn(__METHOD__);

		$key = $wgRequest->getVal('key');

		// macbre: check to protect against BugId:27916
		if (!is_null($key)) {
			$data = $wgMemc->get( $key, false );
			if( !empty($data) ) {
				$wgUser = User::newFromId( $data['user_id'] );
			}
		}

		/*
		 ChatAjax requests come from chat nodejs server, and that's not the user ip
		 so if the server passed the correct user ip, we try to make use of it and
		 record it here so $wgRequest->getIP return this address
		 */
		$userIP = $wgRequest->getVal('userIP');
		if ( ( $userIP !== false ) && IP::isIPAddress( $userIP ) ){
			ChatAjax::$chatUserIP = $userIP;

		}

		$data = ChatAjax::$method();

		// send array as JSON
		$json = json_encode($data);
		$response = new AjaxResponse($json);
		$response->setCacheDuration(0); // don't cache any of these requests
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}
