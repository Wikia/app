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
	static $messageName = 'fbconnect-msg-OnRateArticle';
	static $eventImage = 'rating.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['ArticleAfterVote'][] = 'FBPush_OnRateArticle::onArticleAfterVote';
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnRateArticle');
		
		wfProfileOut(__METHOD__);
	}
	
	public function onArticleAfterVote($user_id, &$page, $vote) {
		$article = Article::newFromID( $page );
		wfProfileIn(__METHOD__);
		
		$params = array(
			'$ARTICLENAME' => $article->getTitle()->getText(),
			'$WIKINAME' => $wgSitename,
			'$ARTICLE_URL' => $article->getTitle()->getFullURL("ref=fbfeed&fbtype=ratearticle"),
			'$RATING' => $vote,
			'$EVENTIMG' => self::$eventImage,
			'$TEXT' => self::shortenText(self::parseArticle($article))
		);
		
		self::pushEvent(self::$messageName, $params, __CLASS__ );
		
		wfProfileOut(__METHOD__);
		return true;
	}
}
