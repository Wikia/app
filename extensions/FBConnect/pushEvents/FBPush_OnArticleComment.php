<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user comments on an article.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnArticleComment'] = $pushDir . "FBPush_OnArticleComment.i18n.php";

class FBPush_OnArticleComment extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnArticleComment'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnArticleComment';
	static $eventImage = 'comment.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnArticleComment::articleEdit';
	
		
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnArticleComment');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function articleEdit(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){
		global $wgContentNamespaces, $wgServer, $wgEnableArticleCommentsExt, $wgSitename;
		wfProfileIn(__METHOD__);

		if (empty( $wgEnableArticleCommentsExt) ) {
			return true;
		}

		if( $article->getTitle()->getNamespace() == NS_TALK ) {
			$title = explode("/", $article->getTitle()->getText());
			$title = $title[0];
			$title = Title::newFromText($title);
			$id = $article->getId();
			
			$params = array(
				'$ARTICLENAME' => $title->getText(),
				'$WIKINAME' => $wgSitename,
				'$ARTICLE_URL' => $title->getFullURL("ref=fbfeed&fbtype=articlecomment"),
				'$EVENTIMG' => self::$eventImage,
				'$TEXT' => self::shortenText(self::parseArticle($article))
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
			
		}
		wfProfileOut(__METHOD__);
		return true;
	}
}
