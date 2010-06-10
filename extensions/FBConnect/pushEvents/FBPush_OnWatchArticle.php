<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds an article to their watchlist.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnWatchArticle'] = $pushDir . "FBPush_OnWatchArticle.i18n.php";

class FBPush_OnWatchArticle extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnWatchArticle'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnWatchArticle';
	static $eventImage = 'following.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['WatchArticleComplete'][] = 'FBPush_OnWatchArticle::onWatchArticleComplete';
		
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnWatchArticle');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function onWatchArticleComplete(&$user, &$article ){
		global $wgContentNamespaces, $wgSitename, $wgRequest;
		wfProfileIn(__METHOD__); 

		if ( $wgRequest->getVal('action','') == 'submit' ) {
			return true;
		}
		
		if( $article->getTitle()->getFirstRevision() == null ) {
			return true;
		}
		
		$params = array(
			'$ARTICLENAME' => $article->getTitle()->getText(),
			'$WIKINAME' => $wgSitename,
			'$ARTICLE_URL' => $article->getTitle()->getFullURL("ref=fbfeed"),
			'$EVENTIMG' => self::$eventImage,
			'$TEXT' => self::shortenText(self::parseArticle($article))	
		);
		
		self::pushEvent(self::$messageName, $params, __CLASS__ );
	
		wfProfileOut(__METHOD__);
		return true;
	}
}
