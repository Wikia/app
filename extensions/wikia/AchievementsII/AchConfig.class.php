<?php

class AchConfig {
	private static $mLevels = array(
		BADGE_LEVEL_BRONZE => array('name' => 'bronze', 'score' => 10),
		BADGE_LEVEL_SILVER => array('name' => 'silver', 'score' => 50),
		BADGE_LEVEL_GOLD => array('name' => 'gold', 'score' => 100),
		BADGE_LEVEL_PLATINUM => array('name' => 'platinum', 'score' => 250)
	);

	private static $mStaticBadgesNames = array(
		BADGE_WELCOME => 'welcome',
		BADGE_INTRODUCTION => 'introduction',
		BADGE_SAYHI => 'sayhi',
		BADGE_CREATOR => 'creator',
		BADGE_POUNCE => 'pounce',
		BADGE_CAFFEINATED => 'caffeinated',
		BADGE_LUCKYEDIT => 'luckyedit',
		BADGE_EDIT => 'edit',
		BADGE_PICTURE => 'picture',
		BADGE_CATEGORY => 'category',
		BADGE_BLOGPOST => 'blogpost',
		BADGE_BLOGCOMMENT => 'blogcomment',
		BADGE_LOVE => 'love',
		BADGE_SHARING => 'sharing',
	);

	private static $mSpecialBadges = array(
		BADGE_WELCOME,
		BADGE_INTRODUCTION,
		BADGE_SAYHI,
		BADGE_CREATOR
	);

	private static $mSecretBadges = array(
		BADGE_POUNCE,
		BADGE_CAFFEINATED,
		BADGE_LUCKYEDIT
	);

	private static $mEditOnlyBadge = array(
		BADGE_EDIT
	);

	private static $mInstance;
	//private $mLoadedData;
	private $mAllDataFetched;
	private $mInTrackEditPlusCategory;
	private $mNotInTrackCommunityPlatinum;
	private $mInTrackStatic;
	private $mNotInTrackStatic;



	public function __construct() {
		//$this->mLoadedData = array();
		$this->reset();

		$this->mNotInTrackStatic = array(
			BADGE_WELCOME => array('level' => BADGE_LEVEL_BRONZE, 'infinite' => false),
			BADGE_INTRODUCTION => array('level' => BADGE_LEVEL_BRONZE, 'infinite' => false),
			BADGE_SAYHI => array('level' => BADGE_LEVEL_BRONZE, 'infinite' => false),
			BADGE_CREATOR => array('level' => BADGE_LEVEL_GOLD, 'infinite' => false),
			BADGE_POUNCE => array('level' => BADGE_LEVEL_SILVER, 'infinite' => false),
			BADGE_CAFFEINATED => array('level' => BADGE_LEVEL_SILVER, 'infinite' => false),
			BADGE_LUCKYEDIT => array('level' => BADGE_LEVEL_GOLD, 'infinite' => true)
		);

		$this->mInTrackStatic = array(
			BADGE_EDIT => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 250),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 500)
				),
				'infinite' => true
			),
			BADGE_PICTURE => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 250),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 500)
				),
				'infinite' => true
			),
			BADGE_CATEGORY => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 250)
				),
				'infinite' => true
			),
			BADGE_BLOGPOST => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
					//disabling higher levels for the blog track as requested in #56280
					/*array('level' => BADGE_LEVEL_SILVER, 'events' => 5),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 10),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 50)*/
				),
				'infinite' => false
			),
			BADGE_BLOGCOMMENT => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 3),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 10)
				),
				'infinite' => false
			),
			BADGE_LOVE => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_SILVER, 'events' => 5),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 14),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 30),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 60),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 100),
					array('level' => BADGE_LEVEL_GOLD, 'events' => 200),
					array('level' => BADGE_LEVEL_PLATINUM, 'events' => 365)
				),
				'infinite' => false
			),
/*			BADGE_SHARING => array(
				'laps' => array(
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 0),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
					array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 10),
					array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
				),
				'infinite' => true
			) */
		);
	}
	private function reset() {
		$this->mAllDataFetched = false;
		$this->mInTrackEditPlusCategory = array();
		$this->mNotInTrackCommunityPlatinum = array();
	}

	/**
	 * @static
	 * @return AchConfig instance
	 */
	static public function getInstance() {
		if (!isset(self::$mInstance))
			self::$mInstance = new self();

		return self::$mInstance;
	}

	private function fetchAll($useMasterDb = false) {
		wfProfileIn(__METHOD__);

		if(!$this->mAllDataFetched) {
			$dbr = wfGetDB(($useMasterDb) ? DB_MASTER : DB_SLAVE);
			$where = array();
			$res = $dbr->select('ach_custom_badges', 'id, type, enabled, cat, sponsored, badge_tracking_url, hover_tracking_url, click_tracking_url', $where, __METHOD__);

			while($row = $dbr->fetchObject($res)) {
				//WARNING: if DB schema changes array will change too, it's efficient but can turn to being dangerous
				/*
				$store = null;

				if($type == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
					$store = &$this->mInTrackEditPlusCategory;
				elseif($type == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM)
					$store = &$this->mNotInTrackCommunityPlatinum;
				else {
					wfDebug("Unknown badge type for {$badgeTypeId}");
					return false;
				}

				foreach($row as $prop => $value) {
					$store[$row->id][$prop] = $value;
				}
				*/

				if($row->type == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
					$this->mInTrackEditPlusCategory[$row->id] = array('enabled' => $row->enabled, 'category' => $row->cat);
				elseif($row->type == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM) {
					$this->mNotInTrackCommunityPlatinum[$row->id] = array(
						'enabled' => $row->enabled,
						'is_sponsored' => $row->sponsored,
						'badge_tracking_url' => $row->badge_tracking_url,
						'hover_tracking_url' => $row->hover_tracking_url,
						'click_tracking_url' => $row->click_tracking_url
					);
				} else {
					wfDebug("Unknown badge type for {$row->id}");
					wfProfileOut(__METHOD__);
					return false;
				}

				//flagging cache
				//$this->mLoadedData[$row->id] = true;
			}

			$dbr->freeResult($res);
			$this->mAllDataFetched = true;
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	private function fetchOne($badgeTypeId) {
		wfProfileIn(__METHOD__);

		if(!isset($this->mLoadedData[$badgeTypeId])) {
			$dbr = wfGetDB(DB_SLAVE);

			if($row = $dbr->selectRow('ach_custom_badges', 'type, enabled, cat, sponsored, badge_tracking_url, hover_tracking_url, click_tracking_url', array('id' => $badgeTypeId), __METHOD__)) {
				if($row->type == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM) {
					$this->mNotInTrackCommunityPlatinum[$badgeTypeId] = array(
						'enabled' => $row->enabled,
						'is_sponsored' => $row->sponsored,
						'badge_tracking_url' => $row->badge_tracking_url,
						'hover_tracking_url' => $row->hover_tracking_url,
						'click_tracking_url' => $row->click_tracking_url
					);

				}
				elseif($row->type == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
					$this->mInTrackEditPlusCategory[$badgeTypeId] = array('enabled' => $row->enabled, 'category' => $row->cat);
				}
				else {
					wfDebug("Unknown badge type for {$badgeTypeId}");
					wfProfileOut(__METHOD__);
					return false;
				}

				$this->mLoadedData[$badgeTypeId] = true;
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	public function getNotInTrackStatic() {
		return $this->mNotInTrackStatic;
	}

	public function getInTrackStatic() {
		return $this->mInTrackStatic;
	}

	public function getInTrackEditPlusCategory() {
		if($this->fetchAll()) {
			return $this->mInTrackEditPlusCategory;
		}
		else
			return null;
	}

	public function getNotInTrackCommunityPlatinum() {
		if($this->fetchAll()) {
			return $this->mNotInTrackCommunityPlatinum;
		}
		else
			return null;
	}

	public function getBadgeType($badgeTypeId) {
		//check the static data first starting with the smallest array
		if(isset($this->mNotInTrackStatic[$badgeTypeId]))
			return BADGE_TYPE_NOTINTRACKSTATIC;
		elseif(isset($this->mInTrackStatic[$badgeTypeId]))
			return BADGE_TYPE_INTRACKSTATIC;
		else {//check the DB data
			//TODO: when we'll have real data test which method performs better between fetchAll or fetchOne
			//$this->fetchOne($badgeTypeId);
			if($this->fetchAll())
			{
				if(isset($this->mNotInTrackCommunityPlatinum[$badgeTypeId]))
					return BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM;
				elseif(isset($this->mInTrackEditPlusCategory[$badgeTypeId]))
					return BADGE_TYPE_INTRACKEDITPLUSCATEGORY;
				else
					wfDebug("Unknown badge type for {$badgeTypeId}");
			}

			return false;
		}
	}

	public function isEnabled($badgeTypeId) {
		if($badgeTypeId < 0) {
			return true;
		} else {
			$item = null;

			if($this->fetchAll()) {
				if(isset($this->mNotInTrackCommunityPlatinum[$badgeTypeId]))
					$item =  $this->mNotInTrackCommunityPlatinum[$badgeTypeId];
				elseif(isset($this->mInTrackEditPlusCategory[$badgeTypeId]))
					$item =  $this->mInTrackEditPlusCategory[$badgeTypeId];
			}

			return $item['enabled'];
		}
	}

	public function isInfinite($badgeTypeId) {
		wfProfileIn(__METHOD__);

		$badgeType = $this->getBadgeType($badgeTypeId);

		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
			$badgeTypeId = BADGE_EDIT;
			$badgeType = BADGE_TYPE_INTRACKSTATIC;
		}

		$ret = false;

		if ($badgeType == BADGE_TYPE_NOTINTRACKSTATIC) {
			$ret = (!empty($this->mNotInTrackStatic[$badgeTypeId]['infinite']));
		} elseif ($badgeType == BADGE_TYPE_INTRACKSTATIC) {
			$ret = (!empty($this->mInTrackStatic[$badgeTypeId]['infinite']));
		}

		wfProfileOut(__METHOD__);

		return $ret;
	}

	public function isSpecial($badgeTypeId) {
		return in_array($badgeTypeId, self::$mSpecialBadges);
	}

	public function isSecret($badgeTypeId) {
		return in_array($badgeTypeId, self::$mSecretBadges);
	}

	public function shouldShow( $badgeTypeId ) {
		global $wgAchievementsEditOnly;
		if ( empty( $wgAchievementsEditOnly ) || in_array( $badgeTypeId, self::$mEditOnlyBadge ) ) {
			return true;
		}
		return false;
	}

	public function isInTrack($badgeTypeId) {
		wfProfileIn(__METHOD__);

		$badgeType = $this->getBadgeType($badgeTypeId);

		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY || $badgeType == BADGE_TYPE_INTRACKSTATIC) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	public function isSponsored( $badgeTypeId ) {
		$badgeType = $this->getBadgeType($badgeTypeId);

		if ( $badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM ) {
			return $this->mNotInTrackCommunityPlatinum[ $badgeTypeId ][ 'is_sponsored' ];
		}
		return false;
	}

	public function getLevelMsgKeyPart($level) {
		return self::$mLevels[$level]['name'];
	}

	public function getLevelName($level) {
		return wfMsg('achievements-' . $this->getLevelMsgKeyPart($level));
	}

	public function getLevelScore($level) {
		return self::$mLevels[$level]['score'];
	}

	private function getBadgeMsgKeyPart($badgeTypeId) {
		if($badgeTypeId > 0) {
			return $badgeTypeId;
		} else {
			return self::$mStaticBadgesNames[$badgeTypeId];
		}

		/*
		switch($type = $this->getBadgeType($badgeTypeId)) {
			case BADGE_TYPE_NOTINTRACKSTATIC:
			case BADGE_TYPE_INTRACKSTATIC:
				return self::$mStaticBadgesNames[$badgeTypeId];
				break;
			case BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM:
			case BADGE_TYPE_INTRACKEDITPLUSCATEGORY:
				return $badgeTypeId;
				break;
		}
		*/
	}

	public function getBadgeNameKey($badgeTypeId, $badge_lap = null) {
		if($badgeTypeId == BADGE_LUCKYEDIT) {
			$badge_lap = null;
		}
		return 'achievements-badge-name-'.$this->getBadgeMsgKeyPart($badgeTypeId) . (($badge_lap !== null) ? "-{$badge_lap}" : null);
	}

	public function getBadgeDescKey($badgeTypeId) {
		if($this->getBadgeType($badgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
			return 'achievements-badge-desc-edit-plus-category';
		else
			return 'achievements-badge-desc-'.$this->getBadgeMsgKeyPart($badgeTypeId);
	}

	public function getBadgePersonalDescKey($badgeTypeId) {
		$badgeType = $this->getBadgeType($badgeTypeId);
		$msgKeyPart = null;

		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
			$msgKeyPart = 'edit-plus-category';
		elseif($badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM)
			return $this->getBadgeDescKey($badgeTypeId);
		else
			$msgKeyPart = $this->getBadgeMsgKeyPart($badgeTypeId);

		return "achievements-badge-your-desc-{$msgKeyPart}";
	}

	public function getBadgeDescHoverKey($badgeTypeId) {
		$badgeType = $this->getBadgeType($badgeTypeId);
		$msgKeyPart = null;

		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
			$msgKeyPart =  'edit-plus-category';
		else
			$msgKeyPart = $this->getBadgeMsgKeyPart($badgeTypeId);

		if($badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM)
			return "achievements-badge-desc-{$msgKeyPart}";
		else
			return "achievements-badge-hover-desc-{$msgKeyPart}";
	}

	public function getBadgeToGetKey($badgeTypeId) {
		if($this->getBadgeType($badgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
			return 'achievements-badge-to-get-edit-plus-category';
		else
			return 'achievements-badge-to-get-'.$this->getBadgeMsgKeyPart($badgeTypeId);
	}

	public function getBadgeToGetDetailsKey($badgeTypeId) {
		$badgeType = $this->getBadgeType($badgeTypeId);
		$msgKeyPart = null;

		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
			$msgKeyPart =  'edit-plus-category';
		elseif($badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM)
			$msgKeyPart =  'community-platinum';
		else
			$msgKeyPart = $this->getBadgeMsgKeyPart($badgeTypeId);

		return "achievements-badge-to-get-{$msgKeyPart}-details";
	}

	public function getBadgePictureName($badgeTypeId, $badge_lap = null, $postfix = null, $withPrefix = true) {
		if($badgeTypeId == BADGE_LUCKYEDIT) {
			$badge_lap = null;
		}
		return (($withPrefix) ? ACHIEVEMENTS_BADGE_PREFIX : null) . $this->getBadgeMsgKeyPart($badgeTypeId). (($badge_lap !== null) ? "-{$badge_lap}" : null) . (($postfix !== null) ? "-{$postfix}" : null) . '.png';
	}

	public function getHoverPictureName( $badgeTypeId ) {
		return ACHIEVEMENTS_HOVER_PREFIX . $this->getBadgeMsgKeyPart( $badgeTypeId ) . '.png';
	}

	public function getRequiredEvents($badgeTypeId, $badge_lap = null) {
		if($badgeTypeId == BADGE_LUCKYEDIT) {
			$events = 1000 * ( $badge_lap + 1 );
		}
		elseif($badgeTypeId == BADGE_CAFFEINATED) {
			$events = 100;
		}
		elseif($badge_lap !== null) {

			if($this->getBadgeType($badgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
				$badgeTypeId = BADGE_EDIT;
			}

			$badge_lapsCount = count($this->mInTrackStatic[$badgeTypeId]['laps']);

			if($badge_lap >= $badge_lapsCount) {
				$max = $this->mInTrackStatic[$badgeTypeId]['laps'][$badge_lapsCount-1]['events'];
				$events = ($badge_lap - $badge_lapsCount + 2) * $max;
			} else {
				$events = $this->mInTrackStatic[$badgeTypeId]['laps'][$badge_lap]['events'];
			}
		} else
			$events = null;

		return $events;
	}

	public function getTrackNameKey($badgeTypeId) {
		$token = null;

		switch($this->getBadgeType($badgeTypeId)) {
			case BADGE_TYPE_INTRACKSTATIC:
				return "achievements-track-name-" . self::$mStaticBadgesNames[$badgeTypeId];
				break;
			case BADGE_TYPE_INTRACKEDITPLUSCATEGORY:
				return 'achievements-edit-plus-category-track-name';
				break;
			default:
				return null;
		}
	}

	public function getBadgeTrackCategory($badgeTypeId) {
		if($badgeTypeId < 0)
			return null;
		else {
			if($this->getBadgeType($badgeTypeId) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY){
				$inTrackEditPlusCategory = $this->getInTrackEditPlusCategory();
				return $inTrackEditPlusCategory[$badgeTypeId]['category'];
			}
			else
				return null;
		}
	}

	public function trackForCategoryExists($categoryName) {
		foreach($this->getInTrackEditPlusCategory() as $badgeTypeId => $track) {
			if($track['category'] == $categoryName)
				return $badgeTypeId;
		}

		return false;
	}

	public function getBadgeClickCommandUrl( $badgeTypeId ) {
		if ( $this->isSponsored( $badgeTypeId ) ) {
			return $this->mNotInTrackCommunityPlatinum[ $badgeTypeId ][ 'click_tracking_url' ];
		}
		return false;
	}

	public function getBadgeTrackingUrl( $badgeTypeId ) {
		if ( $this->isSponsored( $badgeTypeId ) ) {
			return $this->mNotInTrackCommunityPlatinum[ $badgeTypeId ][ 'badge_tracking_url' ];
		}
		return false;
	}

	public function getBadgeHoverTrackingUrl( $badgeTypeId ) {
		if ( $this->isSponsored( $badgeTypeId ) ) {
			return $this->mNotInTrackCommunityPlatinum[ $badgeTypeId ][ 'hover_tracking_url' ];
		}
		return false;
	}

	public function refreshData($useMasterDb = false) {
		$this->reset();
		return $this->fetchAll($useMasterDb);
	}
}
