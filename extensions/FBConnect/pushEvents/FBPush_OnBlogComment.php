<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user comments on a blog post.
 */

class FBPush_OnBlogComment extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnBlogComment'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnBlogComment';
	static $eventImage = 'blogpost.png';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);
		
		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnBlogComment::articleEdit';
		
		wfProfileOut(__METHOD__);
	}
	
	
	public static function articleEdit(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){
		global $wgSitename;
		wfProfileIn(__METHOD__);

		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( !defined('NS_BLOG_ARTICLE_TALK') ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( $article->getTitle()->getNamespace() == NS_BLOG_ARTICLE_TALK ) {
			$title_explode = explode("/", $article->getTitle()->getText());
			$title = Title::newFromText($title_explode[0]."/".$title_explode[1], NS_BLOG_ARTICLE);
			$id = $article->getId();
	  
			$params = array(
				'$WIKINAME' => $wgSitename,
				'$BLOG_POST_URL' => $title->getFullURL(),
				'$BLOG_PAGENAME' =>	$title_explode[0]."/".$title_explode[1],
				'$ARTICLE_URL' => $title->getFullURL("ref=fbfeed&fbtype=blogcomment"), //inside use  
				'$EVENTIMG' => self::$eventImage,
				'$TEXT' => self::shortenText(self::parseArticle($article))	
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}
		
		wfProfileOut(__METHOD__);
		return true;
	}
}
