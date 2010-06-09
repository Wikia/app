<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds a video to the site.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnAddVideo'] = $pushDir . "FBPush_OnAddVideo.i18n.php";

class FBPush_OnAddVideo extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddVideo'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAddVideo';
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);

		$wgHooks['ArticleSave'][] = 'FBPush_OnAddVideo::articleCountVideoDiff'; 	
		
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnAddVideo');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function articleCountVideoDiff(&$article,&$user,&$newText){
		global $wgContentNamespaces, $wgSitename;
		wfProfileIn(__METHOD__);
		if( !in_array($article->getTitle()->getNamespace(), $wgContentNamespaces) ) {
			return true;
		}

		$matches = array();
		$expr = "/\[\[\s*(video):.*?\]\]/i";
		$wNewCount = preg_match_all($expr, $newText, $matches);
		$wOldCount = preg_match_all($expr,  $article->getRawText(), $matches);
		
		$countDiff = $wNewCount - $wOldCount; 			
		if ($countDiff > 1) {
			$params = array(
				'$ARTICLENAME' => $article->getTitle()->getText(),
				'$WIKINAME' => $wgSitename,
				'$ARTICLE_URL' => $article->getTitle()->getFullURL(),
			);
			
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}
		wfProfileOut(__METHOD__);
		return true;	
	}
}
