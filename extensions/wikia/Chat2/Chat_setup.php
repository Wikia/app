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

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Chat',
	'author' => [ 'Christian Williams', 'Sean Colombo' ],
	'url' => 'http://community.wikia.com/wiki/Chat',
	'descriptionmsg' => 'chat-desc',
];

$dir = dirname( __FILE__ );

// autoloaded classes
$wgAutoloadClasses['Chat'] = "$dir/Chat.class.php";
$wgAutoloadClasses['ChatAjax'] = "$dir/ChatAjax.class.php";
$wgAutoloadClasses['ChatWidget'] = "$dir/ChatWidget.class.php";
$wgAutoloadClasses['ChatUser'] = "$dir/ChatUser.class.php";
$wgAutoloadClasses['ChatConfig'] = "$dir/ChatConfig.class.php";
$wgAutoloadClasses['ChatHooks'] = "$dir/ChatHooks.class.php";
$wgAutoloadClasses['ChatController'] = "$dir/ChatController.class.php";
$wgAutoloadClasses['ChatRailController'] = "$dir/ChatRailController.class.php";
$wgAutoloadClasses['ChatBanTimeOptions'] = "$dir/ChatBanTimeOptions.class.php";
$wgAutoloadClasses['SpecialChat'] = "$dir/SpecialChat.class.php";
$wgAutoloadClasses['ChatServerApiClient'] = "$dir/ChatServerApiClient.class.php";
$wgAutoloadClasses['ChatBanListSpecialController'] = "$dir/ChatBanListSpecialController.class.php";

// special pages
$wgSpecialPages['Chat'] = 'SpecialChat';
$wgSpecialPages['ChatBanList'] = 'ChatBanListSpecialController';

// i18n
$wgExtensionMessagesFiles['Chat'] = $dir . '/Chat.i18n.php';
$wgExtensionMessagesFiles['ChatAliases'] = $dir . '/Chat.aliases.php';
$wgExtensionMessagesFiles['ChatDefaultEmoticons'] = $dir . '/ChatDefaultEmoticons.i18n.php';

// hooks
$wgHooks['GetRailModuleList'][] = 'ChatHooks::onGetRailModuleList';
$wgHooks['MakeGlobalVariablesScript'][] = 'ChatHooks::onMakeGlobalVariablesScript';
$wgHooks['LinkEnd'][] = 'ChatHooks::onLinkEnd';
$wgHooks['BeforePageDisplay'][] = 'ChatHooks::onBeforePageDisplay';
$wgHooks['ContributionsToolLinks'][] = 'ChatHooks::onContributionsToolLinks';
$wgHooks['LogLine'][] = 'ChatHooks::onLogLine';
$wgHooks['UserGetRights'][] = 'ChatHooks::onUserGetRights';
$wgHooks['ParserFirstCallInit'][] = 'ChatWidget::onParserFirstCallInit';

// logs
$wgLogTypes[] = 'chatban';
$wgLogHeaders['chatban'] = 'chat-chatban-log';
$wgLogNames['chatban'] = 'chat-chatban-log';

$wgLogTypes[] = 'chatconnect';
$wgLogHeaders['chatconnect'] = 'chat-chatconnect-log';
$wgLogNames['chatconnect'] = 'chat-chatconnect-log';
$wgLogActions['chatconnect/chatconnect'] = 'chat-chatconnect-log-entry';
$wgLogRestrictions["chatconnect"] = 'checkuser';

$wgLogActionsHandlers['chatban/chatbanchange'] = "ChatHooks::formatLogEntry";
$wgLogActionsHandlers['chatban/chatbanremove'] = "ChatHooks::formatLogEntry";
$wgLogActionsHandlers['chatban/chatbanadd'] = "ChatHooks::formatLogEntry";

// register messages package for JS
JSMessages::registerPackage( 'Chat', [
	'chat-*',
] );

JSMessages::registerPackage( 'ChatBanModal', [
	'chat-log-reason-banadd',
	'chat-ban-modal-change-ban-heading',
	'chat-ban-modal-button-cancel',
	'chat-ban-modal-button-ok',
	'chat-ban-modal-button-change-ban',
] );

/**
 * ResourceLoader module for Chat Rail module and widget
 */
$wgResourceModules['ext.Chat2.ChatWidget'] = [
	'messages' => [
		'chat-join-the-chat',
		'chat-start-a-chat',
		'chat-user-menu-message-wall',
		'chat-user-menu-talk-page',
		'chat-user-menu-contribs',
		'chat-live2',
		'chat-edit-count',
		'chat-member-since',
	],
];

/**
 * ResourceLoader module
 */
$wgResourceModules['ext.Chat2'] = [
	'messages' => [
		'chat-user-permanently-disconnected',
		'chat-welcome-message',
		'chat-user-joined',
		'chat-ban-undolink',
		'chat-user-was-kicked',
		'chat-you-were-kicked',
		'chat-user-was-banned',
		'chat-you-were-banned',
		'chat-user-was-unbanned',
		'chat-user-parted',
		'chat-log-reason-undo',
		'chat-ban-modal-heading',
		'chat-ban-cannt-undo',
		'chat-browser-is-notsupported',
		'chat-message-was-too-long',
	],
	'position' => 'top'
];


define( 'CHAT_TAG', 'chat' );
define( 'CUC_TYPE_CHAT', 128 );    // for CheckUser operation type

// ajax
$wgAjaxExportList[] = 'ChatAjax';
function ChatAjax() {
	global $wgChatDebugEnabled, $wgRequest, $wgUser, $wgMemc;

	if ( !empty( $wgChatDebugEnabled ) ) {
		Wikia::log( __METHOD__, "", "Chat debug:" . json_encode( $_REQUEST ) );
	}

	$method = $wgRequest->getVal( 'method', false );

	$json = json_encode( [
		'error' => 'Invalid method',
	] );

	if ( method_exists( 'ChatAjax', $method ) ) {
		wfProfileIn( __METHOD__ );

		$key = $wgRequest->getVal( 'key' );

		// macbre: check to protect against BugId:27916
		if ( !is_null( $key ) ) {
			$data = $wgMemc->get( $key );
			if ( !empty( $data ) && !empty( $data['user_id'] ) ) {
				$wgUser = User::newFromId( $data['user_id'] );
			}
		}

		$data = ChatAjax::$method();

		// send array as JSON
		$json = json_encode( $data );
	}
	$response = new AjaxResponse( $json );
	$response->setCacheDuration( 0 ); // don't cache any of these requests
	$response->setContentType( 'application/json; charset=utf-8' );

	wfProfileOut( __METHOD__ );

	return $response;
}
