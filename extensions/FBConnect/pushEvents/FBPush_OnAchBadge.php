<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds an article to their watchlist.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnWatchArticle'] = $pushDir . "FBPush_OnAchBadge.i18n.php";

class FBPush_OnAchBadge extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAchBadge'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAchBadge';
	
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);
		$wgHooks['AchievementsBadgesGiven'][] = 'FBPush_OnAchBadge::onAchievementsBadgesGiven';
		
		wfProfileOut(__METHOD__);
	}
	
	public function loadMsg() {
		wfProfileIn(__METHOD__);
				
		wfLoadExtensionMessages('FBPush_OnAchBadge');
		
		wfProfileOut(__METHOD__);
	}
	
	public static function onAchievementsBadgesGiven(&$user, &$badg ){
		global $wgContentNamespaces, $wgSitename;
		wfProfileIn(__METHOD__); 
		$name = $badg->getName();
		$img =  $badg->getPictureUrl();
		$desc =  $badg->getDetails();
		
		$title = Title::makeTitle( NS_USER  , $row->challenge_username1  );
		
		$params = array(
			'$NAME' => $name,
			'$USERPAGE' => "http://no.no"
			'$WIKINAME' => $wgSitename,
			'$IMAGE' => $img,
			'$DESC' => $desc
		);
		
		self::pushEvent(self::$messageName, $params, __CLASS__ );
	
		wfProfileOut(__METHOD__);
		return true;
	}
}
