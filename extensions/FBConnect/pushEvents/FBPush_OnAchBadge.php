<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds an article to their watchlist.
 */


class FBPush_OnAchBadge extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAchBadge'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static $messageName = 'fbconnect-msg-OnAchBadge';
	
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);
		$wgHooks['AchievementsNotification'][] = 'FBPush_OnAchBadge::onAchievementsBadgesGiven';
		
		wfProfileOut(__METHOD__);
	}
		
	public static function onAchievementsBadgesGiven($user, $badg ){
		global $wgSitename, $wgUser;
		wfProfileIn(__METHOD__);

		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if( $badg->getTypeId() == BADGE_WELCOME ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$name = $badg->getName();
		$img =  $badg->getPictureUrl();
		$desc =  $badg->getPersonalGivenFor();
		
		$title = Title::makeTitle( NS_USER  , $wgUser->getName() );
		
		$params = array(
			'$ACHIE_NAME' => $name,
			'$ARTICLE_URL' => $title->getFullUrl("ref=fbfeed&fbtype=achbadge"),
			'$WIKINAME' => $wgSitename,
			'$EVENTIMG' => $img,
			'$DESC' => $desc
		);
		self::pushEvent(self::$messageName, $params, __CLASS__ );
		
		wfProfileOut(__METHOD__);
		return true;
	}
}
