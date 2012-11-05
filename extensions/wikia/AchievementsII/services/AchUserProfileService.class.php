<?php

class AchUserProfileService {

	const ITEMS_PER_BATCH = 9;

	var $mOwnerBadgesSimple = array();
	var $mOwnerBadgesCount;
	var $mOwnerBadgesExtended = array();
	var $mViewerBadgesExtended = array();
	var $mViewerCounters = null;
	var $mOwnerCounters = array();
	var $mChallengesBadges = array();
	var $mUserOwner;
	var $mUserViewer;


    public function getHTML() {
    	wfProfileIn(__METHOD__);

    	global $wgTitle, $wgUser;

		//fix #10881, get correct username from user namespace subpages
    	$this->mUserOwner = F::build('User', array( UserPagesHeaderController::getUserName( $wgTitle, BodyController::getUserPagesNamespaces() ) ), 'newFromName');

    	if(
		in_array( strtolower( RequestContext::getMain()->getSkin()->getSkinName() ), array( 'oasis' ) ) &&
		$this->mUserOwner &&
		AchAwardingService::canEarnBadges( $this->mUserOwner ) &&
		$this->mUserOwner->isLoggedIn() &&
		!($wgUser->getId() == $this->mUserOwner->getId() && $wgUser->getOption('hidepersonalachievements'))) {

    		$this->mUserViewer = $wgUser;

    		if($this->mUserViewer->isLoggedIn() && $this->mUserViewer->getId() != $this->mUserOwner->getId()) {
				$this->loadViewerBadges();
				$this->loadViewerCounters();
    		}

			$this->loadOwnerBadgesCount();
			$this->loadOwnerBadges();
			$this->loadOwnerCounters();
    		$this->prepareChallenges();

			$tmplData = array();
			$tmplData['ownerBadges'] = $this->mOwnerBadgesSimple;
			$tmplData['challengesBadges'] = $this->mChallengesBadges;
			$tmplData['title_no'] = wfMsg('achievements-profile-title-no', $this->mUserOwner->getName());
			$tmplData['title'] = wfMsgExt('achievements-profile-title', array('parsemag'), $this->mUserOwner->getName(), count($this->mOwnerBadgesSimple));
			$tmplData['title_challenges'] = wfMsg('achievements-profile-title-challenges', $this->mUserOwner->getName());
			$tmplData['leaderboard_url'] = Skin::makeSpecialUrl("Leaderboard");

			if(count($this->mOwnerBadgesExtended) > 0) {
				$rankingService = new AchRankingService();
				$tmplData['user_rank'] = $rankingService->getUserRankingPosition($this->mUserOwner);
			}

			if($this->mUserViewer->isAllowed('editinterface')) {
				$tmplData['customize_url'] = Skin::makeSpecialUrl("AchievementsCustomize");
			}

    		$template = new EasyTemplate(dirname(__FILE__).'/../templates');
    		$template->set_vars($tmplData);
    		$out = $template->render('ProfileBox');
    	} else {
    		$out = '';
    	}

		wfProfileOut(__METHOD__);
    	return $out;
    }

	public function initOwnerBadges($userName = '', $page = 0){
		wfProfileIn(__METHOD__);
		global $wgUser;

		$this->mUserOwner = F::build('User', array( $userName ), 'newFromName');

		if(
			in_array( strtolower( RequestContext::getMain()->getSkin()->getSkinName() ), array( 'oasis' ) ) &&
			$this->mUserOwner &&
			AchAwardingService::canEarnBadges( $this->mUserOwner ) &&
			$this->mUserOwner->isLoggedIn() &&
			!($wgUser->getId() == $this->mUserOwner->getId() && $wgUser->getOption('hidepersonalachievements')) &&
			$page >= 0){

			$this->loadOwnerBadges($page);
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * Service method to get the most recently earned badge for a list of users
	 * This is used in the new Leaderboard special page
	 *
	 * @param array $user_ids
	 * @return array of badge objects key by user_id
	 *
	 * Usage: $profileService->getMostRecentUserBadge(array('1', '2'));
	 * Returns: Array (
	 *			[1] => AchBadge Object
	 *			[2] => AchBadge Object
	 *		)
	 */
	public function getMostRecentUserBadge($user_ids) {
		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;
		wfProfileIn(__METHOD__);

		$badges = array();

		if (is_array($user_ids) && count($user_ids) > 0) {
			if(empty($wgEnableAchievementsStoreLocalData)) {
				$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
				$sql = "SELECT user_id, badge_type_id, badge_lap FROM `ach_user_badges` a1
					WHERE wiki_id='$wgCityId'
					AND user_id IN (" . implode(',', $user_ids) . ")
					AND date = (SELECT max(date) from ach_user_badges a2 where wiki_id = $wgCityId and a1.user_id = a2.user_id) ";
			} else {
				$dbr = wfGetDB(DB_SLAVE);
				$sql = "SELECT user_id, badge_type_id, badge_lap FROM `ach_user_badges` a1
					WHERE user_id IN (" . implode(',', $user_ids) . ")
					AND date = (SELECT max(date) from ach_user_badges a2 where a1.user_id = a2.user_id) ";
			}

			$res = $dbr->query( $sql, __METHOD__ );
			while($row = $dbr->fetchObject($res)) {
				$badges[$row->user_id] = new AchBadge($row->badge_type_id, $row->badge_lap);
			}
		}
		wfProfileOut(__METHOD__);
		return $badges;
	}

    private function prepareChallenges() {
    	wfProfileIn(__METHOD__);

		$notInTrackCommunityPlatinum = AchConfig::getInstance()->getNotInTrackCommunityPlatinum();
		$inTrackStatic = AchConfig::getInstance()->getInTrackStatic();
		$inTrackEditPlusCategory = AchConfig::getInstance()->getInTrackEditPlusCategory();

		$challenges = array();

		// PLATINUM BADGES
		foreach($notInTrackCommunityPlatinum as $badge_type_id => $badge_config) {
			if($badge_config['enabled']) {
				if(!isset($this->mOwnerBadgesExtended[$badge_type_id])) {
					$challenges[$badge_type_id] = null;
				}
			}
		}

		// IN TRACK BADGES (only those for which user already has at least lap 0)
    	foreach($this->mOwnerBadgesExtended as $badge_type_id => $badge_laps) {
    		$badgeType = AchConfig::getInstance()->getBadgeType($badge_type_id);

    		if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
    			if(AchConfig::getInstance()->isEnabled($badge_type_id)) {
    				$challenges[$badge_type_id] = count($this->mOwnerBadgesExtended[$badge_type_id]);
    			}
    		} else if($badgeType == BADGE_TYPE_INTRACKSTATIC) {
    			if($inTrackStatic[$badge_type_id]['infinite']) {
					$challenges[$badge_type_id] = count($this->mOwnerBadgesExtended[$badge_type_id]);
    			} else {
    				if(count($this->mOwnerBadgesExtended[$badge_type_id]) < count($inTrackStatic[$badge_type_id]['laps'])) {
    					$challenges[$badge_type_id] = count($this->mOwnerBadgesExtended[$badge_type_id]);
    				}
    			}
    		}
    	}

    	$challengesOrder = array(BADGE_WELCOME, BADGE_INTRODUCTION, BADGE_EDIT, 0, BADGE_PICTURE, BADGE_SAYHI, BADGE_BLOGCOMMENT, BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_LOVE);

    	foreach($challengesOrder as $badge_type_id) {
    		if($badge_type_id == 0) {
    			foreach($inTrackEditPlusCategory as $badge_type_id_2 => $badge_config) {
    				if($badge_config['enabled']) {
    					if(!isset($this->mOwnerBadgesExtended[$badge_type_id_2]) && !isset($challenges[$badge_type_id_2])) {
							$challenges[$badge_type_id_2] = 0;
    					}
    				}
    			}
    		} else if(!isset($this->mOwnerBadgesExtended[$badge_type_id]) && !isset($challenges[$badge_type_id])) {
				$challenges[$badge_type_id] = AchConfig::getInstance()->isInTrack($badge_type_id) ? 0 : null;
    		}
    	}

    	global $wgEnableAchievementsForSharing;

    	foreach($challenges as $badge_type_id => $badge_lap) {

    		$badge = new AchBadge($badge_type_id, $badge_lap);

    		if($badge_lap === null) {
    			$to_get = $badge->getToGet();
    		} else {
				if(!isset($this->mOwnerCounters[$badge_type_id])) {
					$eventsCounter = 0;
				} else if($badge_type_id == BADGE_LOVE) {
					$eventsCounter = $this->mOwnerCounters[$badge_type_id][COUNTERS_COUNTER];
				} else if($badge_type_id == BADGE_BLOGCOMMENT) {
					$eventsCounter = count($this->mOwnerCounters[$badge_type_id]);
				} else {
					$eventsCounter = $this->mOwnerCounters[$badge_type_id];
				}

				$requiredEvents = AchConfig::getInstance()->getRequiredEvents($badge_type_id, $badge_lap);
				$to_get = $badge->getToGet($requiredEvents);
				if($badge_type_id != BADGE_SHARING) {
					$to_get .= " ({$eventsCounter}/{$requiredEvents})";
				} else if(empty($wgEnableAchievementsForSharing)){
					continue;
				}
    		}

    		$this->mChallengesBadges[] = array('badge' => $badge, 'to_get' => $to_get);
    	}

    	wfProfileOut(__METHOD__);
    }

    private function loadViewerCounters() {
    	wfProfileIn(__METHOD__);

    	$userCountersService = new AchUserCountersService($this->mUserViewer->getID());
		$this->mViewerCounters = $userCountersService->getCounters();

    	wfProfileOut(__METHOD__);
    }

    private function loadOwnerCounters() {
    	wfProfileIn(__METHOD__);

    	$userCountersService = new AchUserCountersService($this->mUserOwner->getID());
		$this->mOwnerCounters = $userCountersService->getCounters();

    	wfProfileOut(__METHOD__);
    }

	private function loadViewerBadges() {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;
		$where = array('user_id' => $this->mUserViewer->getId());
		if(empty($wgEnableAchievementsStoreLocalData)) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$where['wiki_id'] = $wgCityId;
		} else {
			$dbr = wfGetDB(DB_SLAVE);
		}

		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, badge_lap',
			$where,
			__METHOD__,
			array('ORDER BY' => 'date DESC, badge_lap DESC')
		);

		while($row = $dbr->fetchObject($res)) {
			if(AchConfig::getInstance()->isInTrack($row->badge_type_id)) {
				// in track
				if(!isset($this->mViewerBadgesExtended[$row->badge_type_id])) {
					$this->mViewerBadgesExtended[$row->badge_type_id] = array();
				}
				$this->mViewerBadgesExtended[$row->badge_type_id][] = $row->badge_lap;
			} else {
				// not in track
				if(!isset($this->mViewerBadgesExtended[$row->badge_type_id])) {
					$this->mViewerBadgesExtended[$row->badge_type_id] = 0;
				}
				$this->mViewerBadgesExtended[$row->badge_type_id]++;
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function loadOwnerBadgesCount(){
		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;
		wfProfileIn(__METHOD__);

		$where = array('user_id' => $this->mUserOwner->getId());
		if(empty($wgEnableAchievementsStoreLocalData)) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$where['wiki_id'] = $wgCityId;
		} else {
			$dbr = wfGetDB(DB_SLAVE);
		}

		$res = $dbr->selectRow(
			'ach_user_badges',
			array( 'COUNT(*) AS count' ),
			$where,
			__METHOD__
			);

		$this->mOwnerBadgesCount =  isset( $res->count ) ? $res->count : 0 ;
		wfProfileOut(__METHOD__);
	}



	private function loadOwnerBadges($page = 0) {
		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;
		wfProfileIn(__METHOD__);

		$where = array('user_id' => $this->mUserOwner->getId());
		if(empty($wgEnableAchievementsStoreLocalData)) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$where['wiki_id'] = $wgCityId;
		} else {
			$dbr = wfGetDB(DB_SLAVE);
		}

		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, badge_lap',
			$where,
			__METHOD__,
			array('ORDER BY' => 'date DESC, badge_lap DESC', 'OFFSET' => $page*self::ITEMS_PER_BATCH, 'LIMIT' =>  self::ITEMS_PER_BATCH)
		);

		while($row = $dbr->fetchObject($res)) {
			if(AchConfig::getInstance()->isInTrack($row->badge_type_id)) {
				// in track
				if(!isset($this->mOwnerBadgesExtended[$row->badge_type_id])) {
					$this->mOwnerBadgesExtended[$row->badge_type_id] = array();
				}
				$this->mOwnerBadgesExtended[$row->badge_type_id][] = $row->badge_lap;
			} else {
				// not in track
				if(!isset($this->mOwnerBadgesExtended[$row->badge_type_id])) {
					$this->mOwnerBadgesExtended[$row->badge_type_id] = 0;
				}
				$this->mOwnerBadgesExtended[$row->badge_type_id]++;
			}

			$badge = new AchBadge($row->badge_type_id, $row->badge_lap);
			$to_get = '';

			if(is_array($this->mViewerCounters)) {
				if(AchConfig::getInstance()->isInTrack($row->badge_type_id)) {
					// in track
					if(!isset($this->mViewerBadgesExtended[$row->badge_type_id]) || !in_array($row->badge_lap, $this->mViewerBadgesExtended[$row->badge_type_id])) {

						if(!isset($this->mViewerBadgesExtended[$row->badge_type_id])) {
							$eventsCounter = 0;
						} else if($row->badge_type_id == BADGE_LOVE) {
							$eventsCounter = $this->mViewerCounters[$row->badge_type_id][COUNTERS_COUNTER];
						} else if($row->badge_type_id == BADGE_BLOGCOMMENT) {
							$eventsCounter = count($this->mViewerCounters[$row->badge_type_id]);
						} else {
							$eventsCounter = $this->mViewerCounters[$row->badge_type_id];
						}

						$to_get = $badge->getToGet(AchConfig::getInstance()->getRequiredEvents($row->badge_type_id, $row->badge_lap) - $eventsCounter);
					}
				} else {
					// not in track
					if(!isset($this->mViewerBadgesExtended[$row->badge_type_id])) {
						$to_get = $badge->getToGet();
					}
				}
			}

			$this->mOwnerBadgesSimple[] = array('badge' => $badge, 'to_get' => $to_get);

		}
		wfProfileOut(__METHOD__);
	}

}
