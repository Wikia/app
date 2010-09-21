<?php

class AchBadge {

	private $mBadgeTypeId;
	private $mBadgeLap;
	private $mLevel;
	private $mCategory;

	public function __construct($badgeTypeId, $badgeLap = null, $badgeLevel = null, $category = null) {
		$this->mBadgeTypeId = $badgeTypeId;
		$this->mBadgeLap = $badgeLap;
		$this->mLevel = $badgeLevel;
	}

	public function getTypeId() {
		return $this->mBadgeTypeId;
	}

	public function getLap() {
		return $this->mBadgeLap;
	}

	public function getName() {
		wfProfileIn(__METHOD__);

		$lap = $this->mBadgeLap;

		if($lap != null && $this->mBadgeTypeId != BADGE_LUCKYEDIT) {
			$virtualType = $this->mBadgeTypeId;

			if(AchConfig::getInstance()->getBadgeType($virtualType) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
				$virtualType = BADGE_EDIT;
			}

			$inTrackStaticBadges = AchConfig::getInstance()->getInTrackStatic();
			$lapsCount = count($inTrackStaticBadges[$virtualType]['laps']);
			$lap = ($lap >= $lapsCount) ? --$lapsCount : $lap;
		}

		$key = AchConfig::getInstance()->getBadgeNameKey($this->mBadgeTypeId, $lap);
		if(AchConfig::getInstance()->getBadgeType($this->mBadgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY && isMsgEmpty($key)) {
			$key = AchConfig::getInstance()->getBadgeNameKey(BADGE_EDIT, $lap);
		}

		return wfMsgForContent($key);

		wfProfileOut(__METHOD__);
	}

	public function getGiveFor() {
		global $wgLang;
		return wfMsgExt(AchConfig::getInstance()->getBadgeDescKey($this->mBadgeTypeId), array('parsemag', 'content'), $wgLang->formatNum(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getPersonalGivenFor() {
		global $wgLang;
		return wfMsgExt(AchConfig::getInstance()->getBadgePersonalDescKey($this->mBadgeTypeId), array('parsemag', 'content'), $wgLang->formatNum(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getGiveHoverFor() {
		global $wgLang;
		return wfMsgExt(AchConfig::getInstance()->getBadgeDescHoverKey($this->mBadgeTypeId), array('parsemag', 'content'), $wgLang->formatNum(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getDetails() {
		return wfMsgForContent(AchConfig::getInstance()->getBadgeToGetDetailsKey($this->mBadgeTypeId), array($this->getCategory()));
	}

	public function getToGet($i = null) {
		global $wgLang;
		return wfMsgExt(AchConfig::getInstance()->getBadgeToGetKey($this->mBadgeTypeId), array('parsemag', 'content'), $wgLang->formatNum($i), $this->getCategory());
	}

	public function getPictureUrl($width = 128, $forceOriginal = false) {
		wfProfileIn(__METHOD__);

		global $wgExtensionsPath;
		$realLap = $this->mBadgeLap;
		$badge_type_id = $this->mBadgeTypeId;

		//check for infinite laps in tracks
		if($realLap !== null && $this->mBadgeTypeId != BADGE_LUCKYEDIT) {

			if(AchConfig::getInstance()->getBadgeType($this->mBadgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
				$badge_type_id = BADGE_EDIT;

			$inTrackStaticBadges = AchConfig::getInstance()->getInTrackStatic();
			$lapsCount = count($inTrackStaticBadges[$badge_type_id]['laps']);
			$realLap = ($this->mBadgeLap >= $lapsCount) ? --$lapsCount : $this->mBadgeLap;
		}

		if(!$forceOriginal) {
			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($this->mBadgeTypeId, $realLap));

			if($image) {
				$thumb = $image->getThumbnail($width);
				return $thumb->getUrl();
			}
		}

		wfProfileOut(__METHOD__);

		$pictureName = AchConfig::getInstance()->getBadgePictureName($badge_type_id, $realLap, null, false);

		if($width <= 40) {
			$subdir = '40';
		} else if($width <= 56) {
			$subdir = '56';
		} else if($width <= 82) {
			$subdir = '82';
		} else if($width <= 90) {
			$subdir = '90';
		} else {
			$subdir = '128';
		}

		return "{$wgExtensionsPath}/wikia/AchievementsII/images/badges/{$subdir}/{$pictureName}";
	}

	public function getEarnedBy() {
		global $wgCityId, $wgExternalSharedDB;

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		return $dbr->selectField(
			'ach_user_badges',
			'count(distinct(user_id))',
			array('badge_type_id' => $this->mBadgeTypeId, 'badge_lap' => $this->mBadgeLap, 'wiki_id' => $wgCityId), __METHOD__);
	}

	//TODO: works only if level has been passed to constructor, level should be inferred by the number of events for the user for E+C and inTrackStatic, maybe too much processing for this bit of information?
	public function getLevel() {
		return $this->mLevel;
	}

	//TODO: works only if category has been passed to constructor
	public function getCategory() {
		return AchConfig::getInstance()->getBadgeTrackCategory($this->mBadgeTypeId);
	}

	/**
	 * Outputs the HTML for the the badge. If 'compact' is set to true, displays a version with less info
	 * that is used on the ActivityFeed (since the user's name, etc. are already on the associated RecentChange).
	 *
	 * @param badgeWrapper - not an AchBadge, but rather an associative array which contains an AchBadge and some other info.
	 */
	public static function renderForActivityFeed($badgeWrapper, $compact=true){
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages('AchievementsII');

		$badge_name = htmlspecialchars($badgeWrapper['badge']->getName());
		$badge_url = $badgeWrapper['badge']->getPictureUrl(82);
		$badge_url_hover = $badgeWrapper['badge']->getPictureUrl(90);
		$badge_details = $badgeWrapper['badge']->getDetails();
		$linkToLeaderboard = Skin::makeSpecialUrl('Leaderboard');
		if($compact){
			$info = wfMsg('achievements-activityfeed-info',
				$badge_name,
				$badgeWrapper['badge']->getGiveFor(),
				$linkToLeaderboard
			);
		} else {
			// This was for the sidebar on the leaderboard page.  Not sure if it makes sense to keep it in this function as an option.
			$info = wfMsg('achievements-recent-info',
				$badgeWrapper['user']->getUserPage()->getLocalURL(),
				$badgeWrapper['user']->getName(),
				$badge_name,
				$badgeWrapper['badge']->getGiveFor(),
				wfTimeFormatAgo($badgeWrapper['date'])
			);
		}
		
		?>
			<div class='achievement-in-activity-feed'>
				<div class="profile-hover">
					<img src="<?=$badge_url_hover;?>" height="90" width="90" />
					<div class="profile-hover-text">
						<h3><?=$badge_name;?></h3>
						<p><?=$badge_details;?></p>
					</div>
				</div>
				<a href="<?= $linkToLeaderboard; ?>" class='achievement-image-link' onclick="WET.byStr('activityFeed/achievement/icon');">
					<img rel="leaderboard" src="<?= $badge_url ?>" alt="<?=$badge_name;?>" height="82" width="82" />
				</a>
				<div class="badge-text">
					<p><?= $info ?></p>
				</div>
			</div>
			<div class="feed-clear"></div>
		<?php

		wfProfileOut( __METHOD__ );
	}
}
