<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user comments on an article.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnArticleComment'] = $pushDir . "FBPush_OnArticleComment.i18n.php";

class FBPush_OnArticleComment extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnArticleComment'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnArticleComment');
		
		wfProfileOut(__METHOD__);
	}
}
