<?php

class AchAwardingService {

	var $mUser;
	var $mArticle;
	var $mRevision;
	var $mStatus;
	var $mTitle;
	var $mBadges = array();
	var $mNewBadges = array();
	var $mCounters;
	var $mUserCountersService;

	private static $mDone = false;

	public function migration($user_id)  {
		wfProfileIn(__METHOD__);
		$this->mUser = User::newFromId($user_id);
		$this->loadUserBadges();
		$this->calculateAndSaveScore();
		wfProfileOut(__METHOD__);
	}

	public function awardCustomNotInTrackBadge($user, $badge_type_id) {
		wfProfileIn(__METHOD__);

		global $wgWikiaBotLikeUsers, $wgExternalSharedDB, $wgCityId;

		$this->mUser = $user;

		// badges are only for logged in and not bot users
		if($this->mUser->isLoggedIn() && !$this->mUser->isBot() && !in_array($this->mUser->getName(), $wgWikiaBotLikeUsers)) {

			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

			$badge = $dbr->selectField(
				'ach_user_badges',
				'badge_type_id',
				array('badge_type_id' => $badge_type_id, 'user_id' => $this->mUser->getId(), 'wiki_id' => $wgCityId),
				__METHOD__);

			if($badge === false) {

				$this->loadUserBadges();
				$this->awardNotInTrackBadge($badge_type_id);
				$this->saveBadges();
				$this->calculateAndSaveScore();

			}
		}

		wfProfileOut(__METHOD__);
	}

	public function processSaveComplete($article, $user, $revision, $status) {
		wfProfileIn(__METHOD__);

		global $wgWikiaBotLikeUsers;

		$this->mUser = $user;

		// badges are only for logged in and not bot users
		if($this->mUser->isLoggedIn() && !$this->mUser->isBot() && !in_array($this->mUser->getName(), $wgWikiaBotLikeUsers)) {

			$this->mArticle = $article;
			$this->mRevision = $revision;

			if($this->mArticle) {

				// logic should be processed only one time during one request
				if(!self::$mDone) {

					$this->mStatus = $status;
					$this->mTitle = $this->mArticle->getTitle();

					$this->mUserCountersService = new AchUserCountersService($this->mUser->getID());
					$this->mCounters = $this->mUserCountersService->getCounters();

					$this->loadUserBadges();

					$this->processAllNotInTrack();
					$this->processAllInTrack();

					$this->mUserCountersService->setCounters($this->mCounters);
					$this->mUserCountersService->save();

					$this->processCountersForInTrack();

					$this->saveBadges();

					if(count($this->mNewBadges) > 0) {
						$this->calculateAndSaveScore();
					}

					self::$mDone = true;
				}

			}

		}

		wfProfileOut(__METHOD__);
	}

	private function calculateAndSaveScore() {
		wfProfileIn(__METHOD__);

		if(count($this->mBadges) > 0) {

			global $wgCityId;

			$notInTrackStatic = AchConfig::getInstance()->getNotInTrackStatic();
			$inTrackStatic = AchConfig::getInstance()->getInTrackStatic();

			$score = 0;

			// notes for later refactoring
			// what do I need here?
			// - number of points based on level - give level, get points
			foreach($this->mBadges as $badge_type_id => $badge_laps) {

				$badgeType = AchConfig::getInstance()->getBadgeType($badge_type_id);

				if($badgeType == BADGE_TYPE_NOTINTRACKSTATIC) {

					$score += AchConfig::getInstance()->getLevelScore($notInTrackStatic[$badge_type_id]['level']);

				} else if($badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM) {

					$score += AchConfig::getInstance()->getLevelScore(BADGE_LEVEL_PLATINUM);

				} else if($badgeType == BADGE_TYPE_INTRACKSTATIC || $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {

					if($badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {
						$badge_type_id = BADGE_EDIT;
					}

					$maxPoints = AchConfig::getInstance()->getLevelScore($inTrackStatic[$badge_type_id]['laps'][count($inTrackStatic[$badge_type_id]['laps'])-1]['level']);

					foreach($badge_laps as $badge_lap) {

						if(isset($inTrackStatic[$badge_type_id]['laps'][$badge_lap])) {
							$score += AchConfig::getInstance()->getLevelScore($inTrackStatic[$badge_type_id]['laps'][$badge_lap]['level']);
						} else {
							$score += $maxPoints;
						}

					}
				}
			}

			global $wgExternalSharedDB;
			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
			$dbw->replace('ach_user_score', null, array('user_id' => $this->mUser->getId(), 'wiki_id' => $wgCityId, 'score' => $score), __METHOD__);
			$dbw->commit();
		}

		wfProfileOut(__METHOD__);
	}

	private function saveBadges() {
		wfProfileIn(__METHOD__);

		if(count($this->mNewBadges) > 0) {
			global $wgCityId, $wgExternalSharedDB;

			foreach($this->mNewBadges as $key => $val) {
				$this->mNewBadges[$key]['user_id'] = $this->mUser->getId();
				$this->mNewBadges[$key]['wiki_id'] = $wgCityId;
			}

			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
			$dbw->insert('ach_user_badges', $this->mNewBadges, __METHOD__);
			$dbw->commit();
			
			$_SESSION['achievementsNewBadges'] = true;

			//touch user when badges are given
			$this->mUser->invalidateCache();
		}

		wfProfileOut(__METHOD__);
	}

	private function processCountersForInTrack() {
		wfProfileIn(__METHOD__);

		$inTrackStatic = AchConfig::getInstance()->getInTrackStatic();

		foreach($this->mCounters as $badge_type_id => $badge_counter) {

			$badgeType = AchConfig::getInstance()->getBadgeType($badge_type_id);

			if($badgeType == BADGE_TYPE_INTRACKSTATIC || $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY) {

				if($badge_type_id == BADGE_LOVE) {
					$eventsCounter = $badge_counter[COUNTERS_COUNTER];
				} else if($badge_type_id == BADGE_BLOGCOMMENT) {
					$eventsCounter = count($badge_counter);
				} else {
					$eventsCounter = $badge_counter;
				}

				$trackConfig = ($badgeType == BADGE_TYPE_INTRACKSTATIC) ? $inTrackStatic[$badge_type_id] : $inTrackStatic[BADGE_EDIT];

				foreach($trackConfig['laps'] as $lap_index => $lap_config) {
					if($eventsCounter >= $lap_config['events']) {
						$this->awardInTrackBadge($badge_type_id, $lap_index, $lap_config['level']);
					}
				}

				if($trackConfig['infinite']) {
					$numberOfLaps = count($trackConfig['laps']);
					$maxEvents = $trackConfig['laps'][$numberOfLaps-1]['events'];
					$maxLevel = $trackConfig['laps'][$numberOfLaps-1]['level'];
					$fakeLap = floor($eventsCounter/$maxEvents) - 1 + $numberOfLaps;
					for($i = $numberOfLaps; $i < $fakeLap; $i++) {
						$this->awardInTrackBadge($badge_type_id, $i, $maxLevel);
					}
				}

			}

		}

		wfProfileOut(__METHOD__);
	}

	private function processAllInTrack() {
		wfProfileIn(__METHOD__);

		global $wgContLang;

		if($this->mTitle->isContentPage()) {

			// BADGE_EDIT
			if(empty($this->mCounters[BADGE_EDIT])) {
				$this->mCounters[BADGE_EDIT] = 0;
			}
			$this->mCounters[BADGE_EDIT]++;

			// EDIT+CATEGORY

			// get categories article already belongs to
			$articleCategories = array_change_key_case($this->mTitle->getParentCategories(), CASE_LOWER);

			// get categories to which article is added within this edit
			$insertedCategories = array_change_key_case(Wikia::getVar('categoryInserts'), CASE_LOWER);

			// get configuration of edit+categories
			$editPlusCategory = AchConfig::getInstance()->getInTrackEditPlusCategory();

			$cat1 = strtolower($wgContLang->getNSText(NS_CATEGORY));
			foreach($editPlusCategory as $badge_type_id => $badge_config) {
				if($badge_config['enabled']) {
					$cat2 = str_replace(' ', '_', strtolower($badge_config['category']));
					if(isset($insertedCategories[$cat2]) || isset($articleCategories[$cat1.':'.$cat2])) {
						if(empty($this->mCounters[$badge_type_id])) {
							$this->mCounters[$badge_type_id] = 0;
						}
						$this->mCounters[$badge_type_id]++;
					}
				}
			}

			// BADGE_PICTURE
			$insertedImages = Wikia::getVar('imageInserts');
			if(!empty($insertedImages) && is_array($insertedImages)) {
				if(empty($this->mCounters[BADGE_PICTURE])) {
					$this->mCounters[BADGE_PICTURE] = 0;
				}
				foreach($insertedImages as $inserted_image) {
					if($inserted_image['il_to']{0} != ':') {
						$this->mCounters[BADGE_PICTURE]++;
					}
				}
			}

			// BADGE_CATEGORY
			$insertedCategories = Wikia::getVar('categoryInserts');
			if(!empty($insertedCategories) && is_array($insertedCategories)) {
				if(empty($this->mCounters[BADGE_CATEGORY])) {
					$this->mCounters[BADGE_CATEGORY] = 0;
				}
				$this->mCounters[BADGE_CATEGORY] += count($insertedCategories);
			}

		}

		// BADGE_BLOGPOST
		// is defined check if required because blogs are not enabled everywhere
		if(defined('NS_BLOG_ARTICLE') && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE) {
			if($this->mTitle->getBaseText() == $this->mUser->getName()) {
				if($this->mStatus->value['new'] == true) {
					if(empty($this->mCounters[BADGE_BLOGPOST])) {
						$this->mCounters[BADGE_BLOGPOST] = 0;
					}
					$this->mCounters[BADGE_BLOGPOST]++;
				}
			}
		}

		// BADGE_BLOGCOMMENT
		// is defined check if required because blogs are not enabled everywhere
		if(defined('NS_BLOG_ARTICLE_TALK') && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE_TALK) {
			// handle only article/comment creating (not editing)
			if($this->mStatus->value['new'] == true) {
				$blogPostTitle = Title::newFromText($this->mTitle->getBaseText(), NS_BLOG_ARTICLE);
				if($blogPostTitle) {
					$blogPostArticle = new Article($blogPostTitle);
					if(empty($this->mCounters[BADGE_BLOGCOMMENT]) || !in_array($blogPostArticle->getID(), $this->mCounters[BADGE_BLOGCOMMENT])) {
						if(empty($this->mCounters[BADGE_BLOGCOMMENT])) {
							$this->mCounters[BADGE_BLOGCOMMENT] = array();
						}
						$this->mCounters[BADGE_BLOGCOMMENT][] = $blogPostArticle->getID();
					}
				}
			}
		}


		// BADGE_LOVE
		if(empty($this->mCounters[BADGE_LOVE])) {
			$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER] = 1;
		} else {
			if($this->mCounters[BADGE_LOVE][COUNTERS_DATE] == date('Y-m-d')) {
				// ignore
			} else if($this->mCounters[BADGE_LOVE][COUNTERS_DATE] == date('Y-m-d', strtotime('-1 day'))) {
				$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER]++;
			} else {
				$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER] = 1;
			}
		}
		$this->mCounters[BADGE_LOVE][COUNTERS_DATE] = date('Y-m-d');

		wfProfileOut(__METHOD__);
	}

	private function processAllNotInTrack() {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgExternalSharedDB;

		// BADGE_LUCKYEDIT
		if($this->mRevision->getId() % 1000 == 0) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$maxLap = $dbr->selectField(
				'ach_user_badges',
				'max(badge_lap) as cnt',
				array('badge_type_id' => BADGE_LUCKYEDIT, 'wiki_id' => $wgCityId),
				_METHOD__);
			$this->awardNotInTrackBadge(BADGE_LUCKYEDIT, $maxLap + 1);
		}

		// BADGE_WELCOME
		if(!$this->hasBadge(BADGE_WELCOME)) {
			$this->awardNotInTrackBadge(BADGE_WELCOME);
		}

		// BADGE_INTRODUCTION
		if(!$this->hasBadge(BADGE_INTRODUCTION)) {

			if($this->mTitle->getNamespace() == NS_USER && $this->mTitle->getText() == $this->mUser->getName()) {
				$this->awardNotInTrackBadge(BADGE_INTRODUCTION);
			}

		}

		// BADGE_SAYHI
		if(!$this->hasBadge(BADGE_SAYHI)) {

			if($this->mTitle->getNamespace() == NS_USER_TALK && $this->mTitle->getBaseText() != $this->mUser->getName()) {
				$this->awardNotInTrackBadge(BADGE_SAYHI);
			}

		}

		// BADGE_POUNCE
		if(!$this->hasBadge(BADGE_POUNCE)) {
			if($this->mTitle->isContentPage() && $this->mStatus->value['new'] != true) {
				if(empty($this->mCounters[BADGE_POUNCE]) || !in_array($this->mArticle->getID(), $this->mCounters[BADGE_POUNCE])) {
					$firstRevision = $this->mTitle->getFirstRevision();
					if(strtotime(wfTimestampNow()) - strtotime($firstRevision->getTimestamp()) < 60 * 60) {
						if(empty($this->mCounters[BADGE_POUNCE])) {
							$this->mCounters[BADGE_POUNCE] = array();
						}
						$this->mCounters[BADGE_POUNCE][] = $this->mArticle->getID();
						if(count($this->mArticle->getID()) == 20) {
							$this->awardNotInTrackBadge(BADGE_POUNCE);
							unset($this->mCounters[BADGE_POUNCE]);
						}
					}
				}
			}
		}

		// BADGE_CAFFEINATED
		if(!$this->hasBadge(BADGE_CAFFEINATED)) {
			if($this->mTitle->isContentPage()) {
				if(empty($this->mCounters[BADGE_CAFFEINATED])) {
					$this->mCounters[BADGE_CAFFEINATED] = array(COUNTERS_COUNTER => 1);
				} else {
					if($this->mCounters[BADGE_CAFFEINATED][COUNTERS_DATE] == date('Y-m-d')) {
						$this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER]++;
					} else {
						$this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER] = 1;
					}
				}
				$this->mCounters[BADGE_CAFFEINATED][COUNTERS_DATE] = date('Y-m-d');
				if($this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER] == 100) {
					$this->awardNotInTrackBadge(BADGE_CAFFEINATED);
					unset($this->mCounters[BADGE_CAFFEINATED]);
				}
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function awardNotInTrackBadge($badge_type_id, $badge_lap = null) {
		wfProfileIn(__METHOD__);

		// can be platinum or static

		$notInTrackStatic = AchConfig::getInstance()->getNotInTrackStatic();

		if(isset($notInTrackStatic[$badge_type_id])) {
			$badge_level = $notInTrackStatic[$badge_type_id]['level'];
		} else {
			$badge_level = BADGE_LEVEL_PLATINUM;
		}

		$this->mNewBadges[] = array('badge_type_id' => $badge_type_id,
									'badge_lap' => $badge_lap,
									'badge_level' => $badge_level);

		if(!isset($this->mBadges[$badge_type_id])) {
			$this->mBadges[$badge_type_id] = 0;
		}
		$this->mBadges[$badge_type_id]++;

		if($badge_type_id == BADGE_WELCOME) {
			if(!isMsgEmpty('welcome-user-page')) {
				$userPageTitle = $this->mUser->getUserPage();
				if($userPageTitle) {
					$userPageArticle = new Article($userPageTitle, 0);
					if(!$userPageArticle->exists()) {
						$userPageArticle->doEdit(wfMsg("welcome-user-page"), '', $this->mUser->isAllowed('bot') ? EDIT_FORCE_BOT : 0, false, User::newFromName('Wikia'));
					}
				}
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function awardInTrackBadge($badge_type_id, $badge_lap = null, $badge_level = null) {
		wfProfileIn(__METHOD__);

		// award only if not awarded yet

		if(!$this->hasBadge($badge_type_id, $badge_lap)) {

			$this->mNewBadges[] = array('badge_type_id' => $badge_type_id,
										'badge_lap' => $badge_lap,
										'badge_level' => $badge_level);

			if(!isset($this->mBadges[$badge_type_id])) {
				$this->mBadges[$badge_type_id] = array();
			}
			$this->mBadges[$badge_type_id][] = $badge_lap;

		}

		wfProfileOut(__METHOD__);
	}

	private function hasBadge($badge_type_id, $badge_lap = null) {
		if($badge_lap == null) {
			return isset($this->mBadges[$badge_type_id]);
		}
		return isset($this->mBadges[$badge_type_id]) && in_array($badge_lap, $this->mBadges[$badge_type_id]);
	}

	private function loadUserBadges() {
		wfProfileIn(__METHOD__);
		global $wgCityId, $wgExternalSharedDB;

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, badge_lap',
			array('user_id' => $this->mUser->getId(), 'wiki_id' => $wgCityId),
			__METHOD__,
			array('ORDER BY' => 'badge_type_id, badge_lap')
		);

		while($row = $dbr->fetchObject($res)) {

			if(AchConfig::getInstance()->isInTrack($row->badge_type_id)) {

				if(!isset($this->mBadges[$row->badge_type_id])) {
					$this->mBadges[$row->badge_type_id] = array();
				}
				$this->mBadges[$row->badge_type_id][] = $row->badge_lap;

			} else {

				if(!isset($this->mBadges[$row->badge_type_id])) {
					$this->mBadges[$row->badge_type_id] = 0;
				}
				$this->mBadges[$row->badge_type_id]++;

			}

		}

		wfProfileOut(__METHOD__);
	}

}
