<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed in the event of a large edit.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnLargeEdit'] = $pushDir . "FBPush_OnLargeEdit.i18n.php";

class FBPush_OnLargeEdit extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnLargeEdit'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static private $MIN_CHARS_TO_PUSH = 300; // number of chars that need to be changed
	
	static public function getMinCharsToPush(){
		return self::$MIN_CHARS_TO_PUSH;
	}
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnLargeEdit');
		
		wfProfileOut(__METHOD__);
	}
}
