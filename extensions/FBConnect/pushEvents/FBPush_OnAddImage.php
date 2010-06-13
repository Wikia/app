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
		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnAddImage::onArticleSaveComplete'; 	
		$wgHooks['UploadComplete'][] = 'FBPush_OnAddImage::onUploadComplet';   
		wfProfileOut(__METHOD__);
	}

	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnAddImage');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){ 
		
		if( $article->getTitle()->getNamespace() != NS_FILE ) {
			return true;
		}
		
		$img = wfFindFile( $article->getTitle() );
	
		if ($img->media_type == 'BITMAP' ) {
			FBPush_OnAddImage::uploadNews($img->title->getText(), $img->title->getFullUrl("?ref=fbfeed")) ;	
		}
		return true;
	}
	
    public static function  onUploadComplet(&$image) {
        global $wgServer, $wgSitename;
       
        if ($image->mLocalFile->media_type == 'BITMAP' ) {
        	FBPush_OnAddImage::uploadNews( $image->mLocalFile->getTitle(), $wgServer.'/'.$image->mLocalFile->getTitle()."?ref=fbfeed" );
        }   
        return true;
    }
    
	
	public static function uploadNews($name, $url) {
		global $wgSitename;
		$params = array(
			'$IMGNAME' => $name,
			'$ARTICLE_URL' =>$url, //inside use  
			'$WIKINAME' => $wgSitename,
			'$IMG_URL' => $url,
			'$EVENTIMG' => self::$eventImage
		);
		
		self::pushEvent(self::$messageName, $params, __CLASS__ );	
	}
	
}
