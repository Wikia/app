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
		return wfMsgExt(AchConfig::getInstance()->getBadgeDescKey($this->mBadgeTypeId), array('parsemag', 'content'), number_format(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getPersonalGivenFor() {
		return wfMsgExt(AchConfig::getInstance()->getBadgePersonalDescKey($this->mBadgeTypeId), array('parsemag', 'content'), number_format(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getGiveHoverFor() {
		return wfMsgExt(AchConfig::getInstance()->getBadgeDescHoverKey($this->mBadgeTypeId), array('parsemag', 'content'), number_format(AchConfig::getInstance()->getRequiredEvents($this->mBadgeTypeId, $this->mBadgeLap)), $this->getCategory());
	}

	public function getDetails() {
		return wfMsgForContent(AchConfig::getInstance()->getBadgeToGetDetailsKey($this->mBadgeTypeId), array($this->getCategory()));
	}

	public function getToGet($i = null) {
		return wfMsgExt(AchConfig::getInstance()->getBadgeToGetKey($this->mBadgeTypeId), array('parsemag', 'content'), number_format($i), $this->getCategory());
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

		return "{$wgExtensionsPath}/wikia/AchievementsII/images/badges/".AchConfig::getInstance()->getBadgePictureName($badge_type_id, $realLap, "128px");
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
}