<?php
class AchUserProfile {

	public static function getHTML() {
		wfProfileIn(__METHOD__);

		global $wgUser, $wgTitle, $wgStylePath, $wgStyleVersion, $wgExtensionsPath;

		$profileViewerUser = $wgUser;
		$profileOwnerUser = User::newFromName($wgTitle->getText());

		if(!$profileOwnerUser || !$profileOwnerUser->isLoggedIn() || get_class($wgUser->getSkin()) != 'SkinMonaco') {
			wfProfileOut(__METHOD__);
			return;
		}

		if($profileViewerUser->isLoggedIn() && $profileViewerUser->getId() != $profileOwnerUser->getId()) {
			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select('achievements_badges', 'badge_type, badge_lap', array('user_id' => $profileViewerUser->getID()), __METHOD__, array('ORDER BY' => 'badge_type, badge_lap'));

			$viewerBadges = array();

			while($row = $dbr->fetchObject($res)) {
				if($row->badge_lap == null) {
					// not in track
					if(!isset($viewerBadges[$row->badge_type])) {
						$viewerBadges[$row->badge_type] = 0;
					}
					$viewerBadges[$row->badge_type]++;
				} else {
					// in track
					if(!isset($viewerBadges[$row->badge_type])) {
						$viewerBadges[$row->badge_type] = array();
					}
					$viewerBadges[$row->badge_type][] = $row->badge_lap;
				}
			}

			$res = $dbr->select('achievements_counters', 'data, score', array('user_id' => $profileViewerUser->getID()), __METHOD__);
			$row = $dbr->fetchObject($res);

			if($row) {
				$viewerCounters = unserialize($row->data);
			} else {
				$viewerCounters = array();
			}
		}

		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select('achievements_counters', 'data, score', array('user_id' => $profileOwnerUser->getID()), __METHOD__);
		$row = $dbr->fetchObject($res);

		if($row) {
			$ownerCounters = unserialize($row->data);
		} else {
			$ownerCounters = array();
		}

		$badges = array();
		$ownerBadges = array();
		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select('achievements_badges', 'badge_type, badge_lap, badge_level', array('user_id' => $profileOwnerUser->getId()), __METHOD__, array('ORDER BY' => 'date DESC, badge_lap DESC'));
		while($row = $dbr->fetchObject($res)) {

			if($row->badge_lap == null) {
				// not in track
				if(!isset($ownerBadges[$row->badge_type])) {
					$ownerBadges[$row->badge_type] = 0;
				}
				$ownerBadges[$row->badge_type]++;
			} else {
				// in track
				if(!isset($ownerBadges[$row->badge_type])) {
					$ownerBadges[$row->badge_type] = array();
				}
				$ownerBadges[$row->badge_type][] = $row->badge_lap;
			}

			$badge = array();
			$badge['badge_name'] = AchHelper::getBadgeName($row->badge_type, $row->badge_lap);
			$badge['earned_by'] = $dbr->selectField('achievements_badges', 'count(distinct(user_id))', array('badge_type' => $row->badge_type, 'badge_lap' => $row->badge_lap), __METHOD__);
			$badge['given_for'] = AchHelper::getGivenFor($row->badge_type, $row->badge_lap, true);
			$badge['badge_url'] = AchHelper::getBadgeUrl($row->badge_type, $row->badge_lap, 90);
			$badge['badge_level'] = $row->badge_level;

			if(isset($viewerCounters)) {
				if($row->badge_lap === null) {
					if(!isset($viewerBadges[$row->badge_type])) {
						$badge['to_get'] = wfMsg('achievements-badge-to-get-'.AchStatic::$mBadgeNames[$row->badge_type]);
					}
				} else {
					if(!isset($viewerBadges[$row->badge_type]) || !in_array($row->badge_lap, $viewerBadges[$row->badge_type])) {

						if(!isset($viewerCounters[$row->badge_type])) {
							$viewerHas = 0;
						} else if($row->badge_type == BADGE_LOVE) {
							$viewerHas = $viewerCounters[$row->badge_type]['counter'];
						} else if($row->badge_type == BADGE_BLOGCOMMENT) {
							$viewerHas = count($viewerCounters[$row->badge_type]);
						} else {
							$viewerHas = $viewerCounters[$row->badge_type];
						}

						$needed = AchHelper::getNeededEventsFor($row->badge_type, $row->badge_lap);
						$badge['to_get'] = wfMsgExt('achievements-badge-to-get-'.AchStatic::$mBadgeNames[$row->badge_type], array('parsemag'), number_format($needed-$viewerHas));
					}
				}
			}

			$badges[] = $badge;
		}

		// challenges
		$challenges = array();
		foreach($ownerBadges as $badge_type => $badge_laps) {
			if($badge_type != BADGE_LOVE) {
				if(isset(AchStatic::$mInTrackConfig[$badge_type])) {
					$challenges[$badge_type] = count($ownerBadges[$badge_type]);
				}
			}
		}

		$challengesOrder = array(BADGE_WELCOME, BADGE_INTRODUCTION, BADGE_EDIT, BADGE_PICTURE, BADGE_SAYHI, BADGE_BLOGCOMMENT, BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_LOVE);
		foreach($challengesOrder as $challenge) {
			if(!isset($challenges[$challenge]) && !isset($ownerBadges[$challenge])) {
				$challenges[$challenge] = isset(AchStatic::$mInTrackConfig[$challenge]) ? 0 : null;
			}
		}

		$challengesInfo = array();

		foreach($challenges as $badge_type => $badge_lap) {
			if($badge_lap === null) {
				$info = wfMsg('achievements-badge-to-get-'.AchStatic::$mBadgeNames[$badge_type]);
			} else {
				if(!isset($ownerCounters[$badge_type])) {
					$has = 0;
				} else if($badge_type == BADGE_LOVE) {
					$has = $ownerCounters[$badge_type]['counter'];
				} else if($badge_type == BADGE_BLOGCOMMENT) {
					$has = count($ownerCounters[$badge_type]);
				} else {
					$has = $ownerCounters[$badge_type];
				}
				$has = number_format($has);
				$needed = number_format(AchHelper::getNeededEventsFor($badge_type, $badge_lap));
				$info = wfMsgExt('achievements-badge-to-get-'.AchStatic::$mBadgeNames[$badge_type], array('parsemag'), $needed) . " ({$has}/{$needed})";
			}

			$challengesInfo[] = array(
				'badge_name' => AchHelper::getBadgeName($badge_type, $badge_lap),
				'badge_url' => AchHelper::getBadgeUrl($badge_type, $badge_lap, 40),
				'info' => $info);
		}

		$template = new EasyTemplate(dirname(__FILE__).'/templates');

		$data = array(
			'js_url' => "{$wgExtensionsPath}/wikia/Achievements/js/Achievements.js?{$wgStyleVersion}",
			'badges' => $badges,
			'title' => wfMsg('achievements-profile-title', $profileOwnerUser->getName(), count($badges)),
			'title_no' => wfMsg('achievements-profile-title-no', $profileOwnerUser->getName()),
			'leaderboard_url' => Skin::makeSpecialUrl("Leaderboard"),
			'title_challenges' => wfMsg('achievements-profile-title-challenges', $profileOwnerUser->getName()),
			'challengesInfo' => $challengesInfo);

		if(count($ownerBadges) > 0) {
			$dbr->query('SET @rownum := 0');
			$res = $dbr->query('SELECT rank, user_id FROM (SELECT @rownum := @rownum + 1 AS rank, user_id, score FROM achievements_counters ORDER BY score DESC) AS c WHERE user_id='.$profileOwnerUser->getID());
			$data['rank'] = $res->fetchObject()->rank;
		}

		if($profileViewerUser->isAllowed('editinterface')) {
			$data['customize_url'] = Skin::makeSpecialUrl("AchievementsCustomize");
		}

		//$data['wiki_logo'] = wfFindFile('Wiki.png')->getThumbnail(90)->toHtml();

		$template->set_vars($data);

		wfProfileOut(__METHOD__);
		return $template->render('ProfileBox');
	}

}
