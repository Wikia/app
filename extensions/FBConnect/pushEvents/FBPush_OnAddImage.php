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
	static $messageName = 'fbconnect-msg-OnAddImage';
	static $eventImage = 'image.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnAddImage');
		$wgHooks['UploadComplete'][] = 'FBPush_OnAddImage::onUploadComplet'; 	
		wfProfileOut(__METHOD__);
	}

	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnAddImage');
		
		wfProfileOut(__METHOD__);
	}
	
	public function onUploadComplet(&$image) {
		global $wgServer, $wgSitename;
		
		if ($image->mLocalFile->media_type == 'BITMAP' ) {
			$params = array(
				'$IMGNAME' => $image->mLocalFile->getTitle(),
				'$ARTICLE_URL' => $wgServer.'/'.$image->mLocalFile->getTitle(), //inside use  
				'$WIKINAME' => $wgSitename,
				'$IMG_URL' => $wgServer.'/'.$image->mLocalFile->getTitle()."?ref=fbfeed",
				'$EVENTIMG' => self::$eventImage
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}	
		return true;
	}
}
