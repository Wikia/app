<?php
class AchNotificationService {

	private static $BADGE_TYPES_ORDER = array(BADGE_POUNCE, BADGE_CAFFEINATED, BADGE_LUCKYEDIT ,BADGE_LOVE ,BADGE_EDIT , BADGE_PICTURE ,BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_BLOGCOMMENT);

	const CACHE_TTL = 86400; // 1 day

	protected $app;
	protected $userObj;
	protected $userId;
	protected static $lastBadge = array();

	public function __construct( $user ) {
		$this->userObj = $user;
		$this->userId = $this->userObj->getId();
		$this->app = F::app();
	}

	protected function getMemcKey() {
		return wfMemcKey('AchNotificationService','user',intval($this->userId));
	}

	protected function getLastBadge() {
		wfProfileIn(__METHOD__);
		if ( empty($this->userId) ) {
			wfProfileOut(__METHOD__);
			return null;
		}
		if ( !array_key_exists($this->userId,self::$lastBadge) ) {
			$key = $this->getMemcKey();
			$lastBadge = $this->app->wg->memc->get($key);
			if ( !empty($lastBadge) ) {
				$lastBadge = AchBadge::newFromData($lastBadge);
			} else {
				$lastBadge = null;
			}
			self::$lastBadge[$this->userId] = $lastBadge;
		}
		wfProfileOut(__METHOD__);
		return self::$lastBadge[$this->userId];
	}

	protected function setLastBadge( $badge ) {
		wfProfileIn(__METHOD__);
		if ( empty($this->userId) ) {
			wfProfileOut(__METHOD__);
			return;
		}
		self::$lastBadge[$this->userId] = $badge;
		$key = $this->getMemcKey();
		if ( $badge instanceof AchBadge ) {
			$this->app->wg->memc->set($key,$badge->getData(),self::CACHE_TTL);
		} else {
			$this->app->wg->memc->delete($key);
		}
		wfProfileOut(__METHOD__);
	}

	public function addBadges( $badges ) {
		wfProfileIn(__METHOD__);
		$lastBadge = $this->getLastBadge();
		$changed = false;
		foreach ($badges as $badge) {
			if ( is_array($badge) ) {
				$badge = new AchBadge($badge['badge_type_id'], $badge['badge_lap'], $badge['badge_level']);
			}
			if ( !($badge instanceof AchBadge) ) {
				continue;
			}
			// if there's no last badge or the current one is more important
			if ( empty($lastBadge) || $this->cmp($lastBadge,$badge) >= 0 ) {
				$lastBadge = $badge;
				$changed = true;
			}
		}
		if ( $changed ) {
			$this->setLastBadge($lastBadge);
		}
		wfProfileOut(__METHOD__);
	}

	public function getBadge( $markAsNotified = true ) {
		wfProfileIn(__METHOD__);
		$badge = $this->getLastBadge();
		if ( $markAsNotified ) {
			$this->setLastBadge(null);
		}
		wfProfileOut(__METHOD__);
		return $badge;
	}

	public function getNotificationHTML() {
		wfProfileIn(__METHOD__);

		$badge = $this->getBadge($this->userId);

		if($badge !== null) {
			$template = new EasyTemplate(dirname(__FILE__).'/../templates');

			$template->set_vars(array(
				'badge' => $badge,
				'user' => $this->userObj
			));

			$out = $template->render('NotificationBox');

			wfRunHooks('AchievementsNotification', array($this->userObj, $badge, &$out));

		} else {
			$out = '';
		}

		wfProfileOut(__METHOD__);
		return $out;
	}


	private static function cmp($a, $b) {
		if(
			($a->getLevel() == BADGE_LEVEL_PLATINUM && $b->getLevel() == BADGE_LEVEL_PLATINUM)
			||
			(AchConfig::getInstance()->getBadgeType($a->getTypeId()) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY && AchConfig::getInstance()->getBadgeType($b->getTypeId()) == BADGE_TYPE_INTRACKEDITPLUSCATEGORY)
		) {
			$aO = $a->getTypeId();
			$bO = $b->getTypeId();
		}
		else {
			$aO = array_search($a->getTypeId(), self::$BADGE_TYPES_ORDER);
			if($aO === false) {
				$aO = 9;
			}

			$bO = array_search($b->getTypeId(), self::$BADGE_TYPES_ORDER);
			if($bO === false) {
				$bO = 9;
			}

			if ($aO == $bO) {
				return 0;
			}
		}

		return ($aO < $bO) ? -1 : 1;
	}

}
