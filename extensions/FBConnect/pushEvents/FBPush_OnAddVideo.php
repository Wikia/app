<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds a video to the site.
 */

class FBPush_OnAddVideo extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddVideo'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAddVideo';
	static $eventImage = 'video.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['ArticleSave'][] = 'FBPush_OnAddVideo::articleCountVideoDiff'; 	
		
		wfProfileOut(__METHOD__);
	}
	
	public static function articleCountVideoDiff(&$article,&$user,&$newText){
		global $wgContentNamespaces, $wgSitename;
		wfProfileIn(__METHOD__);

		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( !in_array($article->getTitle()->getNamespace(), $wgContentNamespaces) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$matches = array();
		$expr = "/\[\[\s*(video):.*?\]\]/i";
		$wNewCount = preg_match_all($expr, $newText, $matches);
		$wOldCount = preg_match_all($expr,  $article->getRawText(), $matches);
		
		$countDiff = $wNewCount - $wOldCount; 			
		if ($countDiff > 0) {
			$params = array(
				'$ARTICLENAME' => $article->getTitle()->getText(),
				'$WIKINAME' => $wgSitename,
				'$ARTICLE_URL' => $article->getTitle()->getFullURL("ref=fbfeed&fbtype=addvideo"),
				'$EVENTIMG' => self::$eventImage
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}
		wfProfileOut(__METHOD__);
		return true;	
	}
}
