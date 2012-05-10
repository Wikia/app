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
$wgGroupPermissions['staff']['chatstaff'] = true;
$wgGroupPermissions['helper']['chatmoderator'] = true;
$wgGroupPermissions['chatmoderator']['chatmoderator'] = true; 

$wgAvailableRights[] = 'chat';
$wgGroupPermissions['*']['chat'] = false;
$wgGroupPermissions['user']['chat'] = true;

// Allow admins to control banning/unbanning and chatmod-status
$wgAddGroups['sysop'][] = 'chatmoderator';
$wgAddGroups['sysop'][] = 'bannedfromchat';
$wgAddGroups['chatmoderator'][] = 'bannedfromchat';
$wgRemoveGroups['sysop'][] = 'chatmoderator';
$wgRemoveGroups['sysop'][] = 'bannedfromchat';
$wgRemoveGroups['chatmoderator'][] = 'bannedfromchat';

// Let staff & helpers change chatmod & banning status.
if( !is_array($wgAddGroups['staff']) ){
	$wgAddGroups['staff'] = array();
}
if( !is_array($wgAddGroups['helper']) ){
	$wgAddGroups['helper'] = array();
}
if( !is_array($wgRemoveGroups['staff']) ){
	$wgRemoveGroups['staff'] = array();
}
if( !is_array($wgRemoveGroups['helper']) ){
	$wgRemoveGroups['helper'] = array();
}
$wgAddGroups['staff'][] = 'bannedfromchat';
$wgAddGroups['staff'][] = 'chatmoderator';
$wgRemoveGroups['staff'][] = 'bannedfromchat';
$wgRemoveGroups['staff'][] = 'chatmoderator';
 
$wgAddGroups['helper'][] = 'bannedfromchat';
$wgAddGroups['helper'][] = 'chatmoderator';
$wgRemoveGroups['helper'][] = 'bannedfromchat';
$wgRemoveGroups['helper'][] = 'chatmoderator';

// Attempt to do the permissions the other way (adding restriction instead of subtracting permission).
// When in 'bannedfromchat' group, the 'chat' permission will be revoked
// See http://www.mediawiki.org/wiki/Manual:$wgRevokePermissions
$wgRevokePermissions['bannedfromchat']['chat'] = true;

// autoloaded classes
$wgAutoloadClasses['Chat'] = "$dir/Chat.class.php";
$wgAutoloadClasses['ChatAjax'] = "$dir/ChatAjax.class.php";
$wgAutoloadClasses['ChatHelper'] = "$dir/ChatHelper.php";
$wgAutoloadClasses['ChatController'] = "$dir/ChatController.class.php";
$wgAutoloadClasses['ChatRailController'] = "$dir/ChatRailController.class.php";
$wgAutoloadClasses['SpecialChat'] = "$dir/SpecialChat.class.php";
$wgAutoloadClasses['NodeApiClient'] = "$dir/NodeApiClient.class.php";

// special pages
$wgSpecialPages['Chat'] = 'SpecialChat';

// i18n
$wgExtensionMessagesFiles['Chat'] = $dir.'/Chat.i18n.php';

// hooks
$wgHooks[ 'GetRailModuleList' ][] = 'ChatHelper::onGetRailModuleList';

// register messages package for JS
F::build('JSMessages')->registerPackage('Chat', array(
	'chat-*'
));

// ajax
$wgAjaxExportList[] = 'ChatAjax';
function ChatAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('ChatAjax', $method)) {
		wfProfileIn(__METHOD__);

		// Don't let Varnish cache this.
		header("X-Pass-Cache-Control: max-age=0");

		wfLoadExtensionMessages('Chat');
		$data = ChatAjax::$method();

		// send array as JSON
		$json = Wikia::json_encode($data);
		$response = new AjaxResponse($json);
		$response->setCacheDuration(0); // don't cache any of these requests
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}
