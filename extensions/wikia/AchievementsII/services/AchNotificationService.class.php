<?php
class AchNotificationService {

	private static $order = array(BADGE_POUNCE, BADGE_CAFFEINATED, BADGE_LUCKYEDIT ,BADGE_LOVE ,BADGE_EDIT , BADGE_PICTURE ,BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_BLOGCOMMENT);

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
			$aO = array_search($a->getTypeId(), self::$order);
			if($aO === false) {
				$aO = 9;
			}

			$bO = array_search($b->getTypeId(), self::$order);
			if($bO === false) {
				$bO = 9;
			}

			if ($aO == $bO) {
				return 0;
			}
		}

		return ($aO < $bO) ? -1 : 1;
	}

	/**
	 * Gets the badge that the user should be notified of.  If 'markAsNotified' is set to false, then this
	 * badge will be returned, but since it isn't set as being notified, then the badge will still be eligible
	 * to be returned on the next call of this function.
	 */
	public function getBadgeToNotify($userId, $markAsNotified = true) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;

		$badge = null;
		$badges = array();

		$lastSeen = null;
		$lastSeenCurrent = null;
		if(!empty($wgEnableAchievementsStoreLocalData)) {
			$dbw = wfGetDB(DB_MASTER);
			$res = $dbw->select('ach_user_badges_notified', array('lastseen'), array('user_id' => $userId), __METHOD__);
			if( $row = $res->fetchObject($res) ) {
				$lastSeen = $row->lastseen;
			}
		}

		if(!empty($lastSeen)) {
			$where = "`user_id` = $userId and `date` > \"$lastSeen\"";
			$res = $dbw->select('ach_user_badges', array('badge_type_id', 'badge_lap', 'badge_level', 'date'), $where, __METHOD__);
		} else {
			$where = array('user_id' => $userId, 'notified' => 0);
			if(empty($wgEnableAchievementsStoreLocalData)) {
				$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
				$where['wiki_id'] = $wgCityId;
			} else {
				$dbw = wfGetDB(DB_MASTER);
			}
			$res = $dbw->select('ach_user_badges', array('badge_type_id', 'badge_lap', 'badge_level', 'date'), $where, __METHOD__);
		}
		while($row = $dbw->fetchObject($res)) {
			if(!isset($badges[$row->badge_level])) {
				$badges[$row->badge_level] = array();
			}

			$badges[$row->badge_level][] = new AchBadge($row->badge_type_id, $row->badge_lap, $row->badge_level);
			if(empty($lastSeenCurrent) || $row->date > $lastSeenCurrent) {
				$lastSeenCurrent = $row->date;
			}
		}

		if(count($badges) > 0) {
			$maxLevel = max(array_keys($badges));

			if(count($badges[$maxLevel]) > 1) {
				usort($badges[$maxLevel], 'AchNotificationService::cmp');
			}

			$badge = $badges[$maxLevel][0];
			if($markAsNotified && !wfReadOnly() && empty($lastSeen)){
				$dbw->update('ach_user_badges', array('notified' => 1), $where);
			}
		}

		if($markAsNotified && !wfReadOnly() ){
			if($lastSeen && $lastSeen != $lastSeenCurrent) {
				$dbw->update('ach_user_badges_notified', array('lastseen' => $lastSeenCurrent), array('user_id'=>$userId));
			} else if ($lastSeenCurrent) {
				try {
					$dbw->insert('ach_user_badges_notified', array('lastseen' => $lastSeenCurrent, 'user_id'=>$userId));
				} catch(Exception $e) {}
			}
		}


		wfProfileOut(__METHOD__);
		return $badge;
	}

	public function getNotifcationHTML($userObj) {
		wfProfileIn(__METHOD__);

		global $wgOut;

		$badge = $this->getBadgeToNotify($userObj->getId());

		if($badge !== null) {
			$template = new EasyTemplate(dirname(__FILE__).'/../templates');

			$template->set_vars(array(
				'badge' => $badge,
				'user' => $userObj
			));

			$out = $template->render('NotificationBox');

			wfRunHooks('AchievementsNotification', array($userObj, $badge, &$out));

		} else {
			$out = '';
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

}
