<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds a video to the site.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnAddVideo'] = $pushDir . "FBPush_OnAddVideo.i18n.php";

class FBPush_OnAddVideo extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddVideo'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnAddVideo');
		
		wfProfileOut(__METHOD__);
	}
}
