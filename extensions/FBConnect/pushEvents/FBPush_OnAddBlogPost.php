<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds a blog post to the site.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnAddBlogPost'] = $pushDir . "FBPush_OnAddBlogPost.i18n.php";

class FBPush_OnAddBlogPost extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddBlogPost'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAddBlogPost';
	
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnAddBlogPost');
		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnAddBlogPost::articleEdit';
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnAddBlogPost');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function articleEdit(&$article, &$user, $text, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){
		global $wgContentNamespaces, $wgSitename;
		wfProfileIn(__METHOD__);
		
		if( $article->getTitle()->getNamespace() == NS_BLOG_ARTICLE ) {
			$params = array(
				'$WIKINAME' => $wgSitename,
				'$BLOG_POST_URL' => $article->getTitle()->getFullURL(),
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}
		
		wfProfileOut(__METHOD__);
		return true;
	}
}