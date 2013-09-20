<?php

class AchUserProfileService {

	const BADGES_PER_PAGE = 9;

	protected $visible;
	/** @var AchUser */
	protected $owner;
	/** @var AchUser */
	protected $viewer;
	/** @var User */
	protected $ownerUser;
	/** @var User */
	protected $viewerUser;
	protected $hasPersonalAnnotations;

	public function __construct( $ownerUser = null ) {
		global $wgUser, $wgTitle;
		if ( !isset( $ownerUser ) ) {
			$ownerUser = User::newFromName( UserPagesHeaderController::getUserName( $wgTitle, BodyController::getUserPagesNamespaces() ) );
		}

		$this->ownerUser = $ownerUser;
		$this->viewerUser = $wgUser;

		$this->owner = new AchUser($this->ownerUser);
		$this->viewer = new AchUser($this->viewerUser);
	}

	public function getOwnerUser() {
		return $this->ownerUser;
	}

	public function getViewerUser() {
		return $this->viewerUser;
	}

	/**
	 * This should be part of the controller, not the model
	 */
	public function isVisible() {
		if ( !isset( $this->visible ) ) {
			$this->visible =
				// only on Oasis
				in_array( strtolower( RequestContext::getMain()->getSkin()->getSkinName() ), array( 'oasis' ) )
				// the subject user is a registered user that can earn badges
				&& $this->ownerUser && !$this->ownerUser->isAnon()
				&& AchAwardingService::canEarnBadges( $this->ownerUser )
				// and the subject user didn't hide his achievements
				//     by setting the option 'hidepersonalachievements'
				&& !$this->ownerUser->getOption('hidepersonalachievements');
		}
		return $this->visible;
	}

	public function hasPersonalAnnotations() {
		if ( !isset( $this->hasPersonalAnnotations ) ) {
			$this->hasPersonalAnnotations =
				// viewer users is a registered user
				!$this->viewerUser->isAnon()
				// other than the owner user
				&& $this->viewerUser->getId() == $this->ownerUser->getId()
				// and can earn badges
				&& AchAwardingService::canEarnBadges( $this->viewerUser )
				// and didn't hide his achievements
				&& !$this->viewerUser->getOption('hidepersonalachievements');
		}
		return $this->hasPersonalAnnotations;
	}

    public function getHTML() {
		wfProfileIn(__METHOD__);

		if ( $this->isVisible() ) {
			$ownerName = $this->ownerUser->getName();

			$tmplData = array();
			$tmplData['ownerBadges'] = $this->getBadgesAnnotated();;
			$tmplData['challengesBadges'] = $this->getChallengesAnnotated();
			$tmplData['title_no'] = wfMsg('achievements-profile-title-no', $ownerName);
			$tmplData['title'] = wfMsgExt('achievements-profile-title', array('parsemag'), $ownerName, $this->owner->getBadgesCount());
			$tmplData['title_challenges'] = wfMsg('achievements-profile-title-challenges', $ownerName);
			$tmplData['leaderboard_url'] = Skin::makeSpecialUrl("Leaderboard");

			if($this->owner->getBadgesCount() > 0) {
				$rankingService = new AchRankingService();
				$tmplData['user_rank'] = $rankingService->getUserRankingPosition($this->ownerUser);
			}

			if($this->viewerUser->isAllowed('editinterface')) {
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

	public function getBadgesAnnotated( $page = null ) {
		wfProfileIn(__METHOD__);
		if ( is_null( $page ) ) {
			$badges = $this->owner->getAllBadges();
		} else {
			$badges = $this->owner->getBadges( $page * self::BADGES_PER_PAGE, self::BADGES_PER_PAGE );
		}

		$personalAnnotations = $this->hasPersonalAnnotations();
		$viewerCounters = array();
		if ( $personalAnnotations ) {
			$viewerByType = $this->viewer->getBadgesByType();
			$viewerCounters = $this->viewer->getCounters();
		}
		$list = array();
		/** @var $badge AchBadge */
		foreach ($badges as $badge) {
			$toGet = '';
			if ( $personalAnnotations ) {
				$typeId = $badge->getTypeId();
				$lap = $badge->getLap();
				if ( $badge->isInTrack() ) {
					// in track
					if ( !isset($viewerByType[$typeId]) || $lap < $viewerByType[$typeId]['max_lap'] ) {
						if( !isset($viewerByType[$typeId]) ) {
							$eventsCounter = 0;
						} else if ( $typeId == BADGE_LOVE ) {
							$eventsCounter = $viewerCounters[$typeId][COUNTERS_COUNTER];
						} else if ( $typeId == BADGE_BLOGCOMMENT ) {
							$eventsCounter = count($viewerCounters[$typeId]);
						} else {
							$eventsCounter = $viewerCounters[$typeId];
						}

						$toGet = $badge->getToGet(AchConfig::getInstance()->getRequiredEvents($typeId, $lap) - $eventsCounter);
					}
				} else {
					// not in track
					if ( !isset($viewerByType[$typeId]) ) {
						$toGet = $badge->getToGet();
					}
				}

			}
			$list[] = array(
				'badge' => $badge,
				'to_get' => $toGet,
			);
		}

		wfProfileOut(__METHOD__);
		return $list;
	}

	public function getChallengesAnnotated() {
		wfProfileIn(__METHOD__);

		$achConfig = AchConfig::getInstance();

		$notInTrackCommunityPlatinum = $achConfig->getNotInTrackCommunityPlatinum();
		$inTrackStatic = $achConfig->getInTrackStatic();
		$inTrackEditPlusCategory = $achConfig->getInTrackEditPlusCategory();

		$ownerByType = $this->owner->getBadgesByType();
		$ownerCounters = $this->owner->getCounters();

		$challenges = array();

		// PLATINUM BADGES
		foreach($notInTrackCommunityPlatinum as $badge_type_id => $badge_config) {
			if($badge_config['enabled']) {
				if ( !isset( $ownerByType[$badge_type_id] ) ) {
					$challenges[$badge_type_id] = null;
				}
			}
		}

		// IN TRACK BADGES (only those for which user already has at least lap 0)
		foreach ($ownerByType as $badge_type_id => $typeData) {
			$badgeType = $achConfig->getBadgeType($badge_type_id);

			if ( $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY ) {
				if ( $achConfig->isEnabled( $badge_type_id ) ) {
					$challenges[$badge_type_id] = $typeData['count'];
				}
			} else if ( $badgeType == BADGE_TYPE_INTRACKSTATIC ) {
				if ( $inTrackStatic[$badge_type_id]['infinite'] ) {
					$challenges[$badge_type_id] = $typeData['count'];
				} else {
					if ( $typeData['count'] < count( $inTrackStatic[$badge_type_id]['laps'] ) ) {
						$challenges[$badge_type_id] = $typeData['count'];
					}
				}
			}
		}

		$challengesOrder = array(BADGE_WELCOME, BADGE_INTRODUCTION, BADGE_EDIT, 0, BADGE_PICTURE, BADGE_SAYHI, BADGE_BLOGCOMMENT, BADGE_CATEGORY, BADGE_BLOGPOST, BADGE_LOVE);
		foreach($challengesOrder as $badge_type_id) {
			if ( $badge_type_id == 0 ) {
				foreach ( $inTrackEditPlusCategory as $badge_type_id_2 => $badge_config ) {
					if ( $badge_config['enabled'] ) {
						if ( !isset($ownerByType[$badge_type_id_2]) && !isset( $challenges[$badge_type_id_2] ) ) {
							$challenges[$badge_type_id_2] = 0;
						}
					}
				}
			} else if ( !isset($ownerByType[$badge_type_id]) && !isset( $challenges[$badge_type_id] ) ) {
				$challenges[$badge_type_id] = $achConfig->isInTrack($badge_type_id) ? 0 : null;
			}
		}

		global $wgEnableAchievementsForSharing;

		$challengesAnnotated = array();
		foreach($challenges as $badge_type_id => $badge_lap) {
			$badge = new AchBadge($badge_type_id, $badge_lap);

			if($badge_lap === null) {
				$toGet = $badge->getToGet();
			} else {
				if ( !isset( $ownerCounters[$badge_type_id] ) ) {
					$eventsCounter = 0;
				} else if ( $badge_type_id == BADGE_LOVE ) {
					$eventsCounter = $ownerCounters[$badge_type_id][COUNTERS_COUNTER];
				} else if ( $badge_type_id == BADGE_BLOGCOMMENT ) {
					$eventsCounter = count($ownerCounters[$badge_type_id]);
				} else {
					$eventsCounter = $ownerCounters[$badge_type_id];
				}

				$requiredEvents = $achConfig->getRequiredEvents($badge_type_id, $badge_lap);
				$toGet = $badge->getToGet($requiredEvents);
				if ( $badge_type_id != BADGE_SHARING ) {
					$toGet .= " ({$eventsCounter}/{$requiredEvents})";
				} else if(empty($wgEnableAchievementsForSharing)){
					continue;
				}
			}

			$challengesAnnotated[] = array('badge' => $badge, 'to_get' => $toGet);
		}

		wfProfileOut(__METHOD__);

		return $challengesAnnotated;
	}

	public function getBadgesCount() {
		return $this->owner->getBadgesCount();
	}

	public function getCounters() {
		return $this->owner->getCounters();
	}
}
