<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user rates an article.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnRateArticle'] = $pushDir . "FBPush_OnRateArticle.i18n.php";

class FBPush_OnRateArticle extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnRateArticle'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnRateArticle');
		
		wfProfileOut(__METHOD__);
	}
}
