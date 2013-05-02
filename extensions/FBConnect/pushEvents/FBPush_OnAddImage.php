<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds an Image to the site.
 */

class FBPush_OnAddImage extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddImage'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAddImage';
	static $eventImage = 'image.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnAddImage::onArticleSaveComplete';
		$wgHooks['UploadComplete'][] = 'FBPush_OnAddImage::onUploadComplete';
		wfProfileOut(__METHOD__);
	}

	public static function onArticleSaveComplete(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){
		wfProfileIn(__METHOD__);
		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( $article->getTitle()->getNamespace() != NS_FILE ) {
			wfProfileOut(__METHOD__);
			return true;
		}
		$img = wfFindFile( $article->getTitle()->getText() );
		if (!empty($img) && ($img->media_type == 'BITMAP') ) {
			FBPush_OnAddImage::uploadNews( $img, $img->title->getText(), $img->title->getFullUrl("?ref=fbfeed&fbtype=addimage")) ;
		}
		wfProfileOut(__METHOD__);
		return true;
	}

	public static function  onUploadComplete(&$image) {
		wfProfileIn(__METHOD__);
		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		/**
		 * $image->mLocalFile is protected
		 */
		$localFile = $image->getLocalFile();
		if ($localFile->media_type == 'BITMAP' ) {
			FBPush_OnAddImage::uploadNews( $localFile, $localFile->getTitle(), $localFile->getTitle()->getFullUrl( "?ref=fbfeed&fbtype=addimage" ) );
		}
		wfProfileOut(__METHOD__);
		return true;
	}

	public static function uploadNews($image, $name, $url) {
		global $wgSitename;

		$is = new ImageServing(array(), 90);
		$thumb_url = $is->getThumbnails(array($image));
		$thumb_url = array_pop($thumb_url);
		$thumb_url = $thumb_url['url'];

		$params = array(
			'$IMGNAME' => $name,
			'$ARTICLE_URL' =>$url, //inside use
			'$WIKINAME' => $wgSitename,
			'$IMG_URL' => $url,
			'$EVENTIMG' => $thumb_url
		);

		self::pushEvent(self::$messageName, $params, __CLASS__ );
	}

}
