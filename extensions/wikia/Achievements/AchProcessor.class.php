<?php
/**
 * @author: Inez Korczyński (korczynski@gmail.com)
 */

class AchProcessor {

	var $mArticle;
	var $mUser;
	var $mRevision;
	var $mStatus;
	var $mTitle;
	var $mBadges;
	var $mCounters;
	var $mScore;
	var $mNewBadges = array();

	public function processSaveComplete($article, $user, $revision, $status) {
		wfProfileIn(__METHOD__);

		$this->mUser = $user;

		if(!$this->mUser->isLoggedIn() || $this->mUser->isBot()) {
			return; // badges are only for logged in and not bot users
		}

		$this->mArticle = $article;

		if(!$this->mArticle) {
			return; // article object was not passed to hook handler, it should never happen - consider logging it into log stream
		}

		$this->mRevision = $revision;
		$this->mStatus = $status;
		$this->mTitle = $this->mArticle->getTitle();

		$this->loadAllUserBadges();
		$this->loadUserCounters();

		// BADGE_LUCKYEDIT
		if($revision->getId() % 1000 == 0) {
			$this->giveNotInTrackBadge(BADGE_LUCKYEDIT);
		}

		// BADGE_WELCOME
		if(!isset($this->mBadges[BADGE_WELCOME])) {
			$this->giveNotInTrackBadge(BADGE_WELCOME);
		}

		// BADGE_INTRODUCTION
		if(!isset($this->mBadges[BADGE_INTRODUCTION])) {
			if($this->mTitle->getNamespace() == NS_USER && $this->mTitle->getText() == $this->mUser->getName()) {
				$this->giveNotInTrackBadge(BADGE_INTRODUCTION);
			}
		}

		// BADGE_SAYHI
		if(!isset($this->mBadges[BADGE_SAYHI])) {
			if($this->mTitle->getNamespace() == NS_USER_TALK && $this->mTitle->getBaseText() != $this->mUser->getName()) {
				$this->giveNotInTrackBadge(BADGE_SAYHI);
			}
		}

		// BADGE_POUNCE
		if(!isset($this->mBadges[BADGE_POUNCE])) {
			if($this->mTitle->isContentPage() && $this->mStatus->value['new'] != true) {
				if(empty($this->mCounters[BADGE_POUNCE]) || !in_array($this->mArticle->getID(), $this->mCounters[BADGE_POUNCE])) {
					$firstRevision = $this->mTitle->getFirstRevision();
					if(strtotime(wfTimestampNow()) - strtotime($firstRevision->getTimestamp()) < 60 * 60) {
						if(empty($this->mCounters[BADGE_POUNCE])) {
							$this->mCounters[BADGE_POUNCE] = array();
						}
						$this->mCounters[BADGE_POUNCE][] = $this->mArticle->getID();
						if(count($this->mCounters[BADGE_POUNCE]) == 20) {
							unset($this->mCounters[BADGE_POUNCE]);
							$this->giveNotInTrackBadge(BADGE_POUNCE);
						}
					}
				}
			}
		}

		// BADGE_CAFFEINATED
		if(!isset($this->mBadges[BADGE_CAFFEINATED])) {
			if($this->mTitle->isContentPage()) {
				if(empty($this->mCounters[BADGE_CAFFEINATED])) {
					$this->mCounters[BADGE_CAFFEINATED]['counter'] = 1;
				} else {
					if($this->mCounters[BADGE_CAFFEINATED]['date'] == date('Y-m-d')) {
						$this->mCounters[BADGE_CAFFEINATED]['counter']++;
					} else {
						$this->mCounters[BADGE_CAFFEINATED]['counter'] = 1;
					}
				}
				$this->mCounters[BADGE_CAFFEINATED]['date'] = date('Y-m-d');
				if($this->mCounters[BADGE_CAFFEINATED]['counter'] == 100) {
					unset($this->mCounters[BADGE_CAFFEINATED]);
					$this->giveNotInTrackBadge(BADGE_CAFFEINATED);
				}
			}
		}

		if($this->mTitle->isContentPage()) {

			// BADGE_EDIT
			if(empty($this->mCounters[BADGE_EDIT])) {
				$this->mCounters[BADGE_EDIT] = 0;
			}
			$this->mCounters[BADGE_EDIT]++;

			// BADGE_PICTURE
			$imageInserts = Wikia::getVar('imageInserts');
			if(!empty($imageInserts) && is_array($imageInserts)) {
				if(empty($this->mCounters[BADGE_PICTURE])) {
					$this->mCounters[BADGE_PICTURE] = 0;
				}
				foreach($imageInserts as $insert) {
					if($insert['il_to']{0} != ':') {
						$this->mCounters[BADGE_PICTURE]++;
					}
				}
			}

			// BADGE_CATEGORY
			$categoryInserts = Wikia::getVar('categoryInserts');
			if(!empty($categoryInserts) && is_array($categoryInserts)) {
				if(empty($this->mCounters[BADGE_CATEGORY])) {
					$this->mCounters[BADGE_CATEGORY] = 0;
				}
				$this->mCounters[BADGE_CATEGORY] += count($categoryInserts);
			}

		}

		// BADGE_BLOGPOST
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

		//BADGE_BLOGCOMMENT
		if(defined('NS_BLOG_ARTICLE_TALK') && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE_TALK) {
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

		//BADGE_LOVE
		if(empty($this->mCounters[BADGE_LOVE])) {
			$this->mCounters[BADGE_LOVE]['counter'] = 1;
		} else {
			if($this->mCounters[BADGE_LOVE]['date'] == date('Y-m-d')) {
				// ignore
			} else if($this->mCounters[BADGE_LOVE]['date'] == date('Y-m-d', strtotime('-1 day'))) {
				$this->mCounters[BADGE_LOVE]['counter']++;
			} else {
				$this->mCounters[BADGE_LOVE]['counter'] = 1;
			}
		}
		$this->mCounters[BADGE_LOVE]['date'] = date('Y-m-d');

		$this->processInTrackCounters();
		$this->saveUserBadges();
		$this->calculateUserScore();
		$this->saveUserCounters();

		wfProfileOut(__METHOD__);
	}

	public function giveCustomBadge($user, $badge_type) {
		wfProfileIn(__METHOD__);

		$this->mUser = $user;

		$dbr = wfGetDB(DB_SLAVE);
		$badge = $dbr->selectField('achievements_badges', 'badge_type', array('badge_type' => $badge_type, 'user_id' => $this->mUser->getId()), __METHOD__);

		if ($badge === false) {
			$this->loadAllUserBadges();
			$this->loadUserCounters();

			$this->giveNotInTrackBadge($badge_type);
			$this->saveUserBadges();

			$this->calculateUserScore();
			$this->saveUserCounters();
		}

		wfProfileOut(__METHOD__);
	}

	private function calculateUserScore() {
		wfProfileIn(__METHOD__);

		$this->mScore = 0;

		foreach($this->mBadges as $badge_type => $badge_lap) {
			if(is_array($badge_lap)) {
				$top = AchStatic::$mLevelsConfig[AchStatic::$mInTrackConfig[$badge_type][count(AchStatic::$mInTrackConfig[$badge_type])-1]['level']];
				foreach($badge_lap as $lap) {
					if(isset(AchStatic::$mInTrackConfig[$badge_type][$lap])) {
						$this->mScore += AchStatic::$mLevelsConfig[AchStatic::$mInTrackConfig[$badge_type][$lap]['level']];
					} else {
						$this->mScore += $top;
					}
				}
			} else {
				$this->mScore += $badge_lap * AchStatic::$mLevelsConfig[AchStatic::$mNotInTrackConfig[$badge_type]];
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function processInTrackCounters() {
		wfProfileIn(__METHOD__);

		foreach(AchStatic::$mInTrackConfig as $type => $laps) {
			if(isset($this->mCounters[$type])) {

				if($type == BADGE_LOVE) {
					$eventsCounter = $this->mCounters[$type]['counter'];
				} else if($type == BADGE_BLOGCOMMENT) {
					$eventsCounter = count($this->mCounters[$type]);
				} else {
					$eventsCounter = $this->mCounters[$type];
				}

				foreach($laps as $index => $lap) {
					if($eventsCounter >= $lap['events']) {
						$this->giveInTrackBadge($type, $index, $lap['level']);
					}
				}

				if($type != BADGE_BLOGCOMMENT && $type != BADGE_LOVE) {
					$lapsCounter = count($laps);
					$maxEvents = $laps[$lapsCounter-1]['events'];
					$maxColor = $laps[$lapsCounter-1]['level'];
					$lap = floor($eventsCounter/$maxEvents) - 1 + $lapsCounter;
					for($i = $lapsCounter; $i < $lap; $i++) {
						$this->giveInTrackBadge($type, $i, $maxColor);
					}
				}

			}
		}

		wfProfileOut(__METHOD__);
	}

	private function giveNotInTrackBadge($badge_type) {
		wfProfileIn(__METHOD__);

		$this->mNewBadges[] = array('badge_type' => $badge_type,
									'badge_lap' => null,
									'badge_level' => AchStatic::$mNotInTrackConfig[$badge_type]);

		if(!isset($this->mBadges[$badge_type])) {
			$this->mBadges[$badge_type] = 0;
		}
		$this->mBadges[$badge_type]++;

		wfProfileOut(__METHOD__);
	}

	private function giveInTrackBadge($badge_type, $badge_lap, $badge_level) {
		wfProfileIn(__METHOD__);

		if(!isset($this->mBadges[$badge_type]) || !in_array($badge_lap, $this->mBadges[$badge_type])) {
			$this->mNewBadges[] = array('badge_type' => $badge_type,
										'badge_lap' => $badge_lap,
										'badge_level' => $badge_level);

			if(!isset($this->mBadges[$badge_type])) {
				$this->mBadges[$badge_type] = array();
			}
			$this->mBadges[$badge_type][] = $badge_lap;
		}

		wfProfileOut(__METHOD__);
	}

	private function loadAllUserBadges() {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select('achievements_badges', 'badge_type, badge_lap', array('user_id' => $this->mUser->getId()), __METHOD__, array('ORDER BY' => 'badge_type, badge_lap'));

		while($row = $dbr->fetchObject($res)) {
			if($row->badge_lap == null) {
				// not in track
				if(!isset($this->mBadges[$row->badge_type])) {
					$this->mBadges[$row->badge_type] = 0;
				}
				$this->mBadges[$row->badge_type]++;
			} else {
				// in track
				if(!isset($this->mBadges[$row->badge_type])) {
					$this->mBadges[$row->badge_type] = array();
				}
				$this->mBadges[$row->badge_type][] = $row->badge_lap;
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function loadUserCounters() {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select('achievements_counters', 'data, score', array('user_id' => $this->mUser->getId()), __METHOD__);
		$row = $dbr->fetchObject($res);

		if($row) {
			$this->mCounters = unserialize($row->data);
			$this->mScore = $row->score;
		} else {
			$this->mCounters = array();
			$this->mScore = 0;
		}

		wfProfileOut(__METHOD__);
	}

	private function saveUserCounters() {
		wfProfileIn(__METHOD__);

		if(count($this->mCounters) > 0 || $this->mScore) {
			$dbw = wfGetDB(DB_MASTER);
			$dbw->replace('achievements_counters', null, array('user_id' => $this->mUser->getId(), 'data' => serialize($this->mCounters), 'score' => $this->mScore), __METHOD__);
		}

		wfProfileOut(__METHOD__);
	}

	private function saveUserBadges() {
		wfProfileIn(__METHOD__);

		if(count($this->mNewBadges) > 0) {

			foreach($this->mNewBadges as $key => $val) {
				$this->mNewBadges[$key]['user_id'] = $this->mUser->getId();
			}
			$dbw = wfGetDB(DB_MASTER);
			$dbw->insert('achievements_badges', $this->mNewBadges, __METHOD__);

			$_SESSION['achievementsNewBadges'] = true;

		}

		wfProfileOut(__METHOD__);
	}

}