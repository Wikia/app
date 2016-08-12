<?php

class AchAwardingService {

	/**
	 * @var User
	 */
	var $mUser;
	var $mArticle;
	var $mRevision;
	var $mStatus;
	var $mTitle;
	var $mBadges = array();
	var $mNewBadges = array();
	var $mCounters;
	var $mUserCountersService;
	private $mCityId;

	private static $mDone = false;

	public function __construct( $city_id = null ) {
		if ( is_null( $city_id ) ) {
			global $wgCityId;
			$this->mCityId = $wgCityId;
		} else {
			$this->mCityId = $city_id;
		}
	}

	public function migration( $user_id )  {
		wfProfileIn( __METHOD__ );
		$this->mUser = User::newFromId( $user_id );
		$this->loadUserBadges();
		$this->calculateAndSaveScore();
		wfProfileOut( __METHOD__ );
	}

	/*
	 * awardCustomNotInTracBadge
	 *
	 * @param User $user
	 * @param Int $badge_type_id
	 */
	public function awardCustomNotInTrackBadge( $user, $badge_type_id ) {
		wfProfileIn( __METHOD__ );

		global $wgExternalSharedDB;

		$achConfig = AchConfig::getInstance();
		if ( !$achConfig->shouldShow( $badge_type_id ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$this->mUser = $user;

		if ( self::canEarnBadges( $this->mUser ) ) {

			$where = array( 'badge_type_id' => $badge_type_id, 'user_id' => $this->mUser->getId() );

			$dbr = wfGetDB( DB_SLAVE );

			$badge = $dbr->selectField(
				'ach_user_badges',
				'badge_type_id',
				$where,
				__METHOD__ );

			if ( $badge === false ) {

				$this->loadUserBadges();
				$this->awardNotInTrackBadge( $badge_type_id );
				$this->saveBadges();
				$this->calculateAndSaveScore();

			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function processSharing( $articleID, $sharerID, $IP ) {
		global $wgEnableAchievementsForSharing, $wgAchievementsEditOnly;

		if ( empty( $wgEnableAchievementsForSharing ) ) {
			return;
		}

		if (!empty( $wgAchievementsEditOnly ) ) {
			return;
		}

		wfProfileIn( __METHOD__ );

		$this->mUser = User::newFromID( $sharerID );

		if ( !$this->mUser->isLoggedIn() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$this->mUserCountersService = new AchUserCountersService( $this->mUser->getID() );
		$this->mCounters = $this->mUserCountersService->getCounters();
		$this->loadUserBadges();

		/*
		 * BADGE_SHARING
		 *
		 * Here is the structure of counter array for sharing badge
		 *
		 * This method is called from two different places:
		 * - from sharing feature
		 * -- creates empty array assigned to article_id which will be used then to store IPs of visitors to specific article
		 * -- add user IP to IPs array
		 *
		 * - from special page to which shared link lead to
		 * -- add user IP to IPs array of specific article_id, if this IP is not there yet and if it's not in IPs array as well
		 *
		 * [
		 * 	ips: [<ip>, <ip>]
		 * 	article_ids: [
		 * 		<article_id> : [<ip>],
		 *		<article_id> : [<ip>, <ip>],
		 *  ]
		 * ]
		 */
		if (empty( $this->mCounters[BADGE_SHARING] ) ) {
			$this->mCounters[BADGE_SHARING] = array( 'ips' => array(), 'article_ids' => array() );
		}

		if ( isset( $this->mCounters[BADGE_SHARING]['article_ids'][$articleID] ) ) {
			// called from special page to which shared link lead to
			if (!in_array( $IP, $this->mCounters[BADGE_SHARING]['ips'] ) ) {
				if ( !in_array( $IP, $this->mCounters[BADGE_SHARING]['article_ids'][$articleID] ) ) {
					$this->mCounters[BADGE_SHARING]['article_ids'][$articleID][] = $IP;
				}
			}
		} else {
			// called from sharing feature
			$this->mCounters[BADGE_SHARING]['article_ids'][$articleID] = array();
			if (!in_array( $IP, $this->mCounters[BADGE_SHARING]['ips'] ) ) {
				$this->mCounters[BADGE_SHARING]['ips'][] = $IP;
			}
		}

		$this->mUserCountersService->setCounters( $this->mCounters );
		$this->mUserCountersService->save();
		$this->processCountersForInTrack();
		$this->saveBadges();

		if ( count( $this->mNewBadges ) > 0 ) {
			$this->calculateAndSaveScore();
		}

		wfProfileOut( __METHOD__ );
	}

	public function processSaveComplete($article, $user, $revision, $status ) {
		wfProfileIn( __METHOD__ );

		$this->mUser = $user;

		if ( self::canEarnBadges( $this->mUser ) ) {

			$this->mArticle = $article;
			$this->mRevision = $revision;

			if ( $this->mArticle ) {

				// logic should be processed only one time during one request
				if ( !self::$mDone ) {

					$this->mStatus = $status;
					$this->mTitle = $this->mArticle->getTitle();

					$this->mUserCountersService = new AchUserCountersService( $this->mUser->getID() );
					$this->mCounters = $this->mUserCountersService->getCounters();

					$this->loadUserBadges();

					$this->processAllNotInTrack();
					$this->processAllInTrack();

					$this->mUserCountersService->setCounters( $this->mCounters );
					$this->mUserCountersService->save();

					$this->processCountersForInTrack();

					$this->saveBadges();

					if ( count( $this->mNewBadges ) > 0 ) {
						$this->calculateAndSaveScore();
					}

					self::$mDone = true;
				}

			}

		}

		wfProfileOut( __METHOD__ );
	}

	private function calculateAndSaveScore() {
		wfProfileIn( __METHOD__ );

		if ( count( $this->mBadges ) > 0 ) {

			$notInTrackStatic = AchConfig::getInstance()->getNotInTrackStatic();
			$inTrackStatic = AchConfig::getInstance()->getInTrackStatic();

			$score = 0;

			// notes for later refactoring
			// what do I need here?
			// - number of points based on level - give level, get points
			foreach ( $this->mBadges as $badge_type_id => $badge_laps ) {

				$badgeType = AchConfig::getInstance()->getBadgeType( $badge_type_id );

				if ( $badgeType == BADGE_TYPE_NOTINTRACKSTATIC ) {

					$score += AchConfig::getInstance()->getLevelScore( $notInTrackStatic[$badge_type_id]['level'] ) * ( ( AchConfig::getInstance()->isInfinite( $badge_type_id ) ) ? $badge_laps : 1 );

				} else if ( $badgeType == BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM ) {

					$score += AchConfig::getInstance()->getLevelScore( BADGE_LEVEL_PLATINUM );

				} else if ( $badgeType == BADGE_TYPE_INTRACKSTATIC || $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY ) {

					if ( $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY ) {
						$badge_type_id = BADGE_EDIT;
					}

					$maxPoints = AchConfig::getInstance()->getLevelScore( $inTrackStatic[$badge_type_id]['laps'][count( $inTrackStatic[$badge_type_id]['laps'] )-1]['level'] );

					foreach ( $badge_laps as $badge_lap ) {

						if ( isset( $inTrackStatic[$badge_type_id]['laps'][$badge_lap] ) ) {
							$score += AchConfig::getInstance()->getLevelScore( $inTrackStatic[$badge_type_id]['laps'][$badge_lap]['level'] );
						} else {
							$score += $maxPoints;
						}

					}
				}
			}

			global $wgExternalSharedDB;
			$where = array( 'user_id' => $this->mUser->getId(), 'score' => $score );
			$dbw = wfGetDB( DB_MASTER );
			$dbw->replace( 'ach_user_score', null, $where, __METHOD__ );
			$dbw->commit();
		}

		wfProfileOut( __METHOD__ );
	}

	private function saveBadges() {
		wfProfileIn( __METHOD__ );

		if ( count( $this->mNewBadges ) > 0 ) {
			$dbw = wfGetDB( DB_MASTER );

			// Doing replace instead of insert prevents dupes in case of slave lag or other errors
			foreach ( $this->mNewBadges as $key => $val ) {
				$this->mNewBadges[$key]['user_id'] = $this->mUser->getId();
				$dbw->replace( 'ach_user_badges', null, $this->mNewBadges[$key], __METHOD__ );
			}

			$dbw->commit();

			//notify the user only if he wants to be notified
			if ( !( $this->mUser->getGlobalPreference( 'hidepersonalachievements' ) ) ) {
				$_SESSION['achievementsNewBadges'] = true;

				$achNotificationService = new AchNotificationService( $this->mUser );
				$achNotificationService->addBadges( $this->mNewBadges );

				// Hook to give backend stuff something to latch onto at award-time rather than notifcation-time.
				// NOTE: This has the limitation that it is only called for a max of one badge per page.
				// If the user earned multiple badges on the same page, the hook will only be run on the badge which getBadgeToNotify() determines is more important.
				global $wgWikiaForceAIAFdebug;
				Wikia::log( __METHOD__, "", "Saving a new badge. About to run hook if badge can be re-loaded.", $wgWikiaForceAIAFdebug );
				$badge = $achNotificationService->getBadge(  /*markAsNotified*/ false );
				if ( $badge !== null ) {
					wfRunHooks( 'AchievementEarned', array( $this->mUser, $badge ) );
				}
			}

			//touch user when badges are given
			$this->mUser->invalidateCache();

			//purge the user page to update counters/ranking/badges/score, FB#2872
			$this->mUser->getUserPage()->purgeSquid();

			//run a hook to let other extensions know when Achievements-related cache should be purged
			wfRunHooks( 'AchievementsInvalidateCache', array(  $this->mUser  ) );

			// SUS-770: Purge Achievements rail module on this user's page
			$userPage = $this->mUser->getUserPage();
			Wikia::purgeSurrogateKey(
				RailController::getSurrogateKeyForTitle( $userPage )
			);

			// SUS-770: Purge Recently Earned Badges rail module on this wiki
			Wikia::purgeSurrogateKey(
				RailController::getSurrogateKeyForModule( 'LatestEarnedBadges', 'Index' )
			);
		}

		wfProfileOut( __METHOD__ );
	}

	private function processCountersForInTrack() {
		wfProfileIn( __METHOD__ );

		$inTrackStatic = AchConfig::getInstance()->getInTrackStatic();

		foreach ( $this->mCounters as $badge_type_id => $badge_counter ) {

			$badgeType = AchConfig::getInstance()->getBadgeType( $badge_type_id );

			if ( $badgeType == BADGE_TYPE_INTRACKSTATIC || $badgeType == BADGE_TYPE_INTRACKEDITPLUSCATEGORY ) {

				if ( $badge_type_id == BADGE_LOVE ) {
					$eventsCounter = $badge_counter[COUNTERS_COUNTER];
				} else if ( $badge_type_id == BADGE_BLOGCOMMENT ) {
					$eventsCounter = count( $badge_counter );
				} else if ( $badge_type_id == BADGE_SHARING ) {
					$eventsCounter = -1;
					if ( isset( $badge_counter['article_ids'] ) ) {
						$eventsCounter = 0;
						foreach ( $badge_counter['article_ids'] as $article_id => $ips ) {
							$eventsCounter += count( $ips );
						}
					}
				} else {
					$eventsCounter = $badge_counter;
				}

				$trackConfig = ( $badgeType == BADGE_TYPE_INTRACKSTATIC ) ? $inTrackStatic[$badge_type_id] : $inTrackStatic[BADGE_EDIT];

				foreach ( $trackConfig['laps'] as $lap_index => $lap_config ) {
					if ( $eventsCounter >= $lap_config['events'] ) {
						$this->awardInTrackBadge( $badge_type_id, $lap_index, $lap_config['level'] );
					}
				}

				if ( $trackConfig['infinite'] ) {
					$numberOfLaps = count( $trackConfig['laps'] );
					$maxEvents = $trackConfig['laps'][$numberOfLaps-1]['events'];
					$maxLevel = $trackConfig['laps'][$numberOfLaps-1]['level'];
					$fakeLap = floor( $eventsCounter/$maxEvents ) - 1 + $numberOfLaps;
					for ( $i = $numberOfLaps; $i < $fakeLap; $i++ ) {
						$this->awardInTrackBadge( $badge_type_id, $i, $maxLevel );
					}
				}

			}

		}

		wfProfileOut( __METHOD__ );
	}

	private function processAllInTrack() {
		wfProfileIn( __METHOD__ );

		global $wgAchievementsEditOnly;

		if ( empty( $wgAchievementsEditOnly ) ) {
			if ( $this->mTitle->isContentPage() ) {
				$this->processInTrackPicture();
				$this->processInTrackCategory();
			}
			$this->processInTrackBlogPost();
			$this->processInTrackBlogComment();
			$this->processInTrackLove();
		}

		if ( $this->mTitle->isContentPage() ) {
			$this->processInTrackEdit();
			$this->processInTrackEditCategory();
		}

		wfProfileOut( __METHOD__ );
	}

	private function processInTrackEdit() {
		// BADGE_EDIT
		$this->incrementCounterBy( BADGE_EDIT, 1 );
	}

	private function processInTrackEditCategory() {
		global $wgContLang;

		// EDIT+CATEGORY
		// get categories article already belongs to
		$articleCategories = array_change_key_case( $this->mTitle->getParentCategories(), CASE_LOWER );

		// get categories to which article is added within this edit
		$insertedCategories = array_change_key_case( Wikia::getVar( 'categoryInserts' ), CASE_LOWER );

		// get configuration of edit+categories
		$editPlusCategory = AchConfig::getInstance()->getInTrackEditPlusCategory();

		$cat1 = strtolower( $wgContLang->getNSText( NS_CATEGORY ) );
		foreach ( $editPlusCategory as $badge_type_id => $badge_config ) {
			if ( $badge_config['enabled'] ) {
				$cat2 = str_replace( ' ', '_', strtolower( $badge_config['category'] ) );
				if ( isset( $insertedCategories[$cat2] ) || isset( $articleCategories[$cat1 . ':' . $cat2] ) ) {
					$this->incrementCounterBy( $badge_type_id, 1 );
				}
			}
		}
	}

	private function processInTrackPicture() {
		// BADGE_PICTURE
		$insertedImages = Wikia::getVar( 'imageInserts' );
		if ( !empty( $insertedImages ) && is_array( $insertedImages ) ) {
			foreach ( $insertedImages as $inserted_image ) {
				if ( $inserted_image['il_to']{0} != ':' ) {
					if ( wfFindFile( $inserted_image['il_to'] ) ) {
						//check if the image has been used less than 10 times
						//( to avoid awarding after template based bulk insertion )
						//calls api.php?action=query&list=imageusage&iulimit=10&iutitle=File:File_mame.ext
						$imageUsageCount = 0;
						$imageUsageLimit = 10;
						$params = array(
							'action' => 'query',
							'list' => 'imageusage',
							'iutitle' => "File:{$inserted_image['il_to']}",
							'iulimit' => $imageUsageLimit,
						 );

						try {
							wfProfileIn( __METHOD__ . '::apiCall' );

							$api = new ApiMain( new FauxRequest( $params ) );
							$api->execute();
							$res = $api->getResultData();

							wfProfileOut( __METHOD__ . '::apiCall' );

							if ( is_array( $res['query']['imageusage'] ) ) {
								$imageUsageCount = count( $res['query']['imageusage'] );
							}
						} catch ( Exception $e ) {
						};

						if ( $imageUsageCount < $imageUsageLimit ) {
							$this->incrementCounterBy( BADGE_PICTURE, 1 );
						}
					}
				}
			}
		}
	}

	private function processInTrackCategory() {
		// BADGE_CATEGORY
		$insertedCategories = Wikia::getVar( 'categoryInserts' );
		if ( !empty( $insertedCategories ) && is_array( $insertedCategories ) ) {
			$this->incrementCounterBy( BADGE_CATEGORY, count( $insertedCategories ) );
		}
	}

	private function processInTrackBlogPost() {
		//BADGE_BLOGPOST
		//is defined check if required because blogs are not enabled everywhere
		if ( defined( 'NS_BLOG_ARTICLE' ) && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE ) {
			if ( $this->mTitle->getBaseText() == $this->mUser->getName() ) {
				if ( $this->mStatus->value['new'] == true ) {
					$this->incrementCounterBy( BADGE_BLOGPOST, 1 );
				}
			}
		}
	}

	private function processInTrackBlogComment() {
		// BADGE_BLOGCOMMENT
		// is defined check if required because blogs are not enabled everywhere
		if ( defined( 'NS_BLOG_ARTICLE_TALK' ) && $this->mTitle->getNamespace() == NS_BLOG_ARTICLE_TALK ) {
			// handle only article/comment creating ( not editing )
			if ( $this->mStatus->value['new'] == true ) {
				$blogPostTitle = Title::newFromText( $this->mTitle->getBaseText(), NS_BLOG_ARTICLE );
				if ( $blogPostTitle ) {
					$blogPostArticle = new Article( $blogPostTitle );
					if ( empty( $this->mCounters[BADGE_BLOGCOMMENT] ) || !in_array( $blogPostArticle->getID(), $this->mCounters[BADGE_BLOGCOMMENT] ) ) {
						if ( empty( $this->mCounters[BADGE_BLOGCOMMENT] ) ) {
							$this->mCounters[BADGE_BLOGCOMMENT] = array();
						}
						$this->mCounters[BADGE_BLOGCOMMENT][] = $blogPostArticle->getID();
					}
				}
			}
		}
	}

	private function processInTrackLove() {
		//BADGE_LOVE
		if ( empty( $this->mCounters[BADGE_LOVE] ) ) {
			$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER] = 1;
		} else {
			if ( $this->mCounters[BADGE_LOVE][COUNTERS_DATE] == date( 'Y-m-d' ) ) {
				// ignore
			} else if ( $this->mCounters[BADGE_LOVE][COUNTERS_DATE] == date( 'Y-m-d', strtotime( '-1 day' ) ) ) {
				$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER]++;
			} else {
				$this->mCounters[BADGE_LOVE][COUNTERS_COUNTER] = 1;
			}
		}
		$this->mCounters[BADGE_LOVE][COUNTERS_DATE] = date( 'Y-m-d' );
	}

	private function incrementCounterBy( $badge_type_id, $value ) {
		if ( !is_array( $this->mCounters ) ) {
			throw new MWException( "Counters have to be initialized as array." );
		}

		if ( !isset( $this->mCounters[$badge_type_id] ) ) {
			$this->mCounters[$badge_type_id] = 0;
		}
		$this->mCounters[$badge_type_id] += $value;
	}

	private function processAllNotInTrack() {
		global $wgAchievementsEditOnly;

		if ( !empty( $wgAchievementsEditOnly ) ) {
			return;
		}

		wfProfileIn( __METHOD__ );

		// BADGE_LUCKYEDIT
		if ( $this->mRevision->getId() % 1000 == 0 ) {
			$where = array( 'badge_type_id' => BADGE_LUCKYEDIT );
			$dbr = wfGetDB( DB_SLAVE );

			$maxLap = $dbr->selectField(
				'ach_user_badges',
				'max( badge_lap ) as cnt',
				$where,
				__METHOD__ );
			$this->awardNotInTrackBadge( BADGE_LUCKYEDIT, $maxLap + 1 );
		}

		// BADGE_WELCOME
		if ( !$this->hasBadge( BADGE_WELCOME ) ) {
			$this->awardNotInTrackBadge( BADGE_WELCOME );
		}

		// BADGE_INTRODUCTION
		if ( !$this->hasBadge( BADGE_INTRODUCTION ) ) {

			if ( $this->mTitle->getNamespace() == NS_USER && $this->mTitle->getText() == $this->mUser->getName() ) {
				$this->awardNotInTrackBadge( BADGE_INTRODUCTION );
			}

		}
		// BADGE_SAYHI
		if ( !$this->hasBadge( BADGE_SAYHI ) ) {
			if ( ( $this->mTitle->getNamespace() == NS_USER_TALK || (  defined( "NS_USER_WALL_MESSAGE" ) && $this->mTitle->getNamespace() == NS_USER_WALL_MESSAGE  ) )&& $this->mTitle->getBaseText() != $this->mUser->getName() ) {
				$this->awardNotInTrackBadge( BADGE_SAYHI );
			}

		}

		// BADGE_POUNCE
		if ( !$this->hasBadge( BADGE_POUNCE ) ) {
			if ( $this->mTitle->isContentPage() && $this->mStatus->value['new'] != true ) {
				if ( empty( $this->mCounters[BADGE_POUNCE] ) || !in_array( $this->mArticle->getID(), $this->mCounters[BADGE_POUNCE] ) ) {
					$firstRevision = $this->mTitle->getFirstRevision();

					if ( $firstRevision instanceof Revision && ( strtotime( wfTimestampNow() ) - strtotime( $firstRevision->getTimestamp() ) < ( 3600 /* 1h */ ) ) ) {
						if ( empty( $this->mCounters[BADGE_POUNCE] ) ) {
							$this->mCounters[BADGE_POUNCE] = array();
						}
						$this->mCounters[BADGE_POUNCE][] = $this->mArticle->getID();
						if ( count( $this->mCounters[BADGE_POUNCE] ) > 99 && !$this->hasBadge( BADGE_POUNCE ) ) {
							// badge is awarded when user makes their 100th edit to a unique article within 1h of it's creation
							// 99 was put here to correct an error in awarding that did not affect counters and award missing badges
							$this->awardNotInTrackBadge( BADGE_POUNCE );
							unset( $this->mCounters[BADGE_POUNCE] );
						}
					}
				}
			}
		}

		// BADGE_CAFFEINATED
		if ( !$this->hasBadge( BADGE_CAFFEINATED ) ) {
			if ( $this->mTitle->isContentPage() ) {
				if ( empty( $this->mCounters[BADGE_CAFFEINATED] ) ) {
					$this->mCounters[BADGE_CAFFEINATED] = array( COUNTERS_COUNTER => 1 );
				} else {
					if ( $this->mCounters[BADGE_CAFFEINATED][COUNTERS_DATE] == date( 'Y-m-d' ) ) {
						$this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER]++;
					} else {
						$this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER] = 1;
					}
				}
				$this->mCounters[BADGE_CAFFEINATED][COUNTERS_DATE] = date( 'Y-m-d' );
				if ( $this->mCounters[BADGE_CAFFEINATED][COUNTERS_COUNTER] == 100 ) {
					$this->awardNotInTrackBadge( BADGE_CAFFEINATED );
					unset( $this->mCounters[BADGE_CAFFEINATED] );
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private function awardNotInTrackBadge( $badge_type_id, $badge_lap = null ) {
		wfProfileIn( __METHOD__ );
		global $wgRequest;

		// can be platinum or static

		$notInTrackStatic = AchConfig::getInstance()->getNotInTrackStatic();

		if ( isset( $notInTrackStatic[$badge_type_id] ) ) {
			$badge_level = $notInTrackStatic[$badge_type_id]['level'];
		} else {
			$badge_level = BADGE_LEVEL_PLATINUM;
		}

		$this->mNewBadges[] = array( 'badge_type_id' => $badge_type_id,
									'badge_lap' => $badge_lap,
									'badge_level' => $badge_level );

		if ( !isset( $this->mBadges[$badge_type_id] ) ) {
			$this->mBadges[$badge_type_id] = 0;
		}
		$this->mBadges[$badge_type_id]++;

		if ( $badge_type_id == BADGE_WELCOME ) {
			if ( !isMsgEmpty( 'welcome-user-page' ) ) {
				$userPageTitle = $this->mUser->getUserPage();
				if ( $userPageTitle ) {
					$userPageArticle = new Article( $userPageTitle, 0 );
					if ( !$userPageArticle->exists() ) {
						$userWikia = User::newFromName( 'Wikia' );

						//#60032: forcing IP for bot since this code is run in a real user session and not from a maintenance script
						$origIP = $wgRequest->getIP();
						$wgRequest->setIP(  '127.0.0.1'  );

						//fixme. following functionality is done by HAWelcome extension...
						$userPageArticle->doEdit(  wfMsgForContentNoTrans( 'welcome-user-page', $userPageTitle->getText()  ), '', $userWikia->isAllowed( 'bot' ) ? EDIT_FORCE_BOT : 0, false, $userWikia  );

						//restore original IP from user session
						$wgRequest->setIP(  $origIP  );
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private function awardInTrackBadge( $badge_type_id, $badge_lap = null, $badge_level = null ) {
		wfProfileIn( __METHOD__ );

		// award only if not awarded yet

		if ( !$this->hasBadge( $badge_type_id, $badge_lap ) ) {

			$this->mNewBadges[] = array( 'badge_type_id' => $badge_type_id,
										'badge_lap' => $badge_lap,
										'badge_level' => $badge_level );

			if ( !isset( $this->mBadges[$badge_type_id] ) ) {
				$this->mBadges[$badge_type_id] = array();
			}
			$this->mBadges[$badge_type_id][] = $badge_lap;

		}

		wfProfileOut( __METHOD__ );
	}

	private function hasBadge( $badge_type_id, $badge_lap = null ) {
		if ( $badge_lap == null ) {
			return isset( $this->mBadges[$badge_type_id] );
		}
		return isset( $this->mBadges[$badge_type_id] ) && in_array( $badge_lap, $this->mBadges[$badge_type_id] );
	}

	private function loadUserBadges() {
		wfProfileIn( __METHOD__ );

		$where = array( 'user_id' => $this->mUser->getId() );
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'ach_user_badges',
			'badge_type_id, badge_lap',
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'badge_type_id, badge_lap' )
		 );

		while ( $row = $dbr->fetchObject( $res ) ) {

			if ( AchConfig::getInstance()->isInTrack( $row->badge_type_id ) ) {

				if ( !isset( $this->mBadges[$row->badge_type_id] ) ) {
					$this->mBadges[$row->badge_type_id] = array();
				}
				$this->mBadges[$row->badge_type_id][] = $row->badge_lap;

			} else {

				if ( !isset( $this->mBadges[$row->badge_type_id] ) ) {
					$this->mBadges[$row->badge_type_id] = 0;
				}
				$this->mBadges[$row->badge_type_id]++;

			}

		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Helper function to check if a user should earn badges at all
	 *
	 * @author tor
	 */
	public static function canEarnBadges( User $user = null ) {
		global $wgWikiaBotLikeUsers, $wgUser, $wgAchievementsExemptUsers;

		if ( empty( $user ) ) {
			$user = $wgUser;
		}

		if (
			$user->isAnon() ||
			$user->isBlocked( true, false ) ||
			( $user->isAllowed( 'bot' ) || in_array( $user->getName(), $wgWikiaBotLikeUsers ) ) ||
			( is_array( $wgAchievementsExemptUsers ) && in_array( $user->getId(), $wgAchievementsExemptUsers ) ) ||
			/*
			 * certain users ( like staff and helpers ) should not earn badges
			 * unless they also belong to a group that explicitly states they should
			 * @see fb#4876
			 */
			( $user->isAllowed( 'achievements-exempt' ) && !$user->isAllowed( 'achievements-explicit' ) )
		 ) {
			return false;
		}

		return true;
	}
}
