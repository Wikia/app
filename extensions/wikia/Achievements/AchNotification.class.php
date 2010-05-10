<?php
class AchNotification {

	private static $order = array(BADGE_POUNCE, BADGE_CAFFEINATED, BADGE_LUCKYEDIT ,BADGE_LOVE ,BADGE_EDIT , BADGE_PICTURE ,BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_BLOGCOMMENT);

	private static function cmp($a, $b) {
		$aO = array_search($a['type'], self::$order);
		if($aO === false) {
			$aO = 9;
		}

		$bO = array_search($b['type'], self::$order);
		if($bO === false) {
			$bO = 9;
		}

		if ($aO == $bO) {
			return 0;
		}
		return ($aO < $bO) ? -1 : 1;
	}

	private static function getNotificationBadge($user_id) {
		wfProfileIn(__METHOD__);

		$badge = null;
		$badges = array();

		$dbw = wfGetDB(DB_MASTER);
		$res = $dbw->select('achievements_badges', array('badge_type', 'badge_lap', 'badge_level'), array('user_id' => $user_id, 'notified' => 0), __METHOD__);

		while($row = $dbw->fetchObject($res)) {
			if(!isset($badges[$row->badge_level])) {
				$badges[$row->badge_level] = array();
			}
			$badges[$row->badge_level][] = array('type' => $row->badge_type, 'lap' => $row->badge_lap);
		}

		if(count($badges) > 0) {
			$maxLevel = max(array_keys($badges));
			if(count($badges[$maxLevel]) > 1) {
				usort($badges[$maxLevel], 'AchNotification::cmp');
			}
			$badge = $badges[$maxLevel][0];
			$badge['level'] = $maxLevel;


			$dbw->update('achievements_badges', array('notified' => 1), array('user_id' => $user_id));
		}

		return $badge;
		wfProfileOut(__METHOD__);
	}

	public static function getNotifcationHTML() {
		wfProfileIn(__METHOD__);

		global $wgUser, $wgOut, $wgExtensionsPath, $wgStyleVersion;

		$badge = self::getNotificationBadge($wgUser->getId());

		if($badge) {
			wfLoadExtensionMessages('Achievements');
			$template = new EasyTemplate(dirname(__FILE__).'/templates');

			$data = array();
			$data['css_url'] = "{$wgExtensionsPath}/wikia/Achievements/css/notification.css?{$wgStyleVersion}";
			$data['badge_url'] = AchHelper::getBadgeUrl($badge['type'], $badge['lap'], 90);
			$data['badge_name'] = AchHelper::getBadgeName($badge['type'], $badge['lap']);
			$data['title'] = wfMsg('achievements-notification-title', $wgUser->getName());
			$data['subtitle'] = wfMsg('achievements-notification-subtitle', $data['badge_name'], AchHelper::getYourGivenFor($badge['type'], $badge['lap']));
			$data['link'] = wfMsgExt('achievements-notification-link', array('parse'), $wgUser->getName());
			$data['level'] = AchStatic::$mLevelNames[$badge['level']];
			$data['points_no'] = AchStatic::$mLevelsConfig[$badge['level']];
			$data['points'] = wfMsg('achievements-points');

			$template->set_vars($data);

			$out = $template->render('NotificationBox');

			// this works only for Wikia and only in current varnish configuration
			header('X-Pass-Cache-Control: no-store, private, no-cache, must-revalidate');

		} else {
			$out = '';
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

}
