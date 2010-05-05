<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds an Image to the site.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnAddImage'] = $pushDir . "FBPush_OnAddImage.i18n.php";

class FBPush_OnAddImage extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddImage'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnAddImage');
		
		wfProfileOut(__METHOD__);
	}
}
