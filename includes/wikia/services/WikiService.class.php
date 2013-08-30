<?php

class WikiService extends WikiaModel {
	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;
	const IMAGE_HEIGHT_KEEP_ASPECT_RATIO = -1;

	static $botGroups = array('bot', 'bot-global');
	static $excludedWikiaUsers = array(
		22439, //Wikia
		1458396, //Abuse filter
	);

	protected $cityVisualizationObject = null;

	/**
	 * get list of wiki founder/admin/bureaucrat id
	 * Note: also called from maintenance script.
	 *
	 * @param integer $wikiId
	 * @param bool    $useMaster
	 * @param bool    $excludeBots
	 *
	 * @return array of $userIds
	 */
	public function getWikiAdminIds( $wikiId = 0, $useMaster = false, $excludeBots = false, $limit = null, $includeFounder = true ) {
		wfProfileIn( __METHOD__ );

		$userIds = array();
		if ( empty($this->wg->FounderEmailsDebugUserId) ) {
			// get founder
			$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
			$wiki = WikiFactory::getWikiById($wikiId);
			if ( !empty($wiki) && $wiki->city_public == 1 ) {
				if ($includeFounder) {
					$userIds[] = $wiki->city_founding_user;
				}

				// get admin and bureaucrat
				if ( empty($this->wg->EnableAnswers) ) {
					$memKey = $this->getMemKeyAdminIds( $wikiId, $excludeBots, $limit );

					$adminIds = WikiaDataAccess::cache(
						$memKey,
						60 * 60 * 3,
						function() use ($wiki, $useMaster, $excludeBots, $limit) {
							$dbname = $wiki->city_dbname;
							$dbType = ( $useMaster ) ? DB_MASTER : DB_SLAVE;
							$db = wfGetDB( $dbType, array(), $dbname );

							$conditions = array("ug_group in ('sysop','bureaucrat')");

							if ($excludeBots) {
								$conditions[] = "ug_user not in (select distinct ug_user from user_groups where ug_group in (" .
									$db->makeList(self::$botGroups) .
									"))";
							}

							$result = $db->select(
								'user_groups',
								'distinct ug_user',
								$conditions,
								__METHOD__,
								(!empty($limit))?(array('LIMIT' => $limit)):array()
							);

							$adminIds = array();
							while ( $row = $db->fetchObject($result) ) {
								$adminIds[] = $row->ug_user;
							}
							$db->freeResult( $result );
							return $adminIds;
						}
					);

					$userIds = array_unique( array_merge($userIds, $adminIds) );
				}
			}
		} else {
			$userIds[] = $this->wg->FounderEmailsDebugUserId;
		}

		wfProfileOut( __METHOD__ );
		return $userIds;
	}

	/**
	 * Get memcache key for list of admin_ids
	 *
	 * @param integer $wikiId
	 * @param bool    $excludeBots
	 * @param integer $limit
	 *
	 * @return string memcache key
	 */
	public function getMemKeyAdminIds( $wikiId, $excludeBots = false, $limit = null ) {
		return wfSharedMemcKey( 'wiki_admin_ids', $wikiId, $excludeBots, $limit );
	}

	/**
	 * get number of videos on the wiki
	 * @return integer totalVideos
	 */
	public function getTotalVideos( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = wfSharedMemcKey( 'wiki_total_videos', $wikiId );
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( $totalVideos === false ) {
			$totalVideos = 0;
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = wfGetDB( DB_SLAVE, array(), $dbname );

				$row = $db->selectRow(
					array( 'image' ),
					array( 'count(*) cnt' ),
					array( 'img_media_type' => 'VIDEO' ),
					__METHOD__
				);

				if ( $row ) {
					$totalVideos = intval( $row->cnt );
				}

				$this->wg->Memc->set( $memKey, $totalVideos, 60*60*3 );
			}
		}

		wfProfileOut( __METHOD__ );

		return $totalVideos;
	}

	/**
	 * get site stats
	 * @return array $sitestats
	 */
	public function getSiteStats( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = wfSharedMemcKey( 'wiki_sitestats', $wikiId );
		$sitestats = $this->wg->Memc->get( $memKey );
		if ( !is_array($sitestats) ) {
			$sitestats = array(
				'views' => 0,
				'edits' => 0,
				'articles' => 0,
				'pages' => 0,
				'users' => 0,
				'activeUsers' => 0,
				'images' => 0,
			);

			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = wfGetDB( DB_SLAVE, 'vslow', $dbname );

				$row = $db->selectRow(
					array( 'site_stats' ),
					array( '*' ),
					array(),
					__METHOD__
				);

				if ( $row ) {
					$sitestats = array(
						'views' => $row->ss_total_views,
						'edits' => $row->ss_total_edits,
						'articles' => $row->ss_good_articles,
						'pages' => $row->ss_total_pages,
						'users' => $row->ss_users,
						'activeUsers' => $row->ss_active_users,
						'images' => $row->ss_images,
					);
				}

				$this->wg->Memc->set( $memKey, $sitestats, 60*60*3 );
			}
		}

		wfProfileOut( __METHOD__ );

		return $sitestats;
	}

	/**
	 * get list of top editors
	 *
	 * @param integer $wikiId
	 * @param integer $limit
	 * @param bool    $excludeBots
	 *
	 * @return array topEditors [ array( user_id => edits ) ]
	 */
	public function getTopEditors( $wikiId = 0, $limit = 30, $excludeBots = false ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;

		$topEditors = WikiaDataAccess::cache(
			wfSharedMemcKey( 'wiki_top_editors', $wikiId, $excludeBots ),
			60 * 60 * 3,
			function() use ($wikiId, $limit, $excludeBots) {
				$topEditors = array();

				$db = wfGetDB( DB_SLAVE, array(), 'specials' );

				$result = $db->select(
					array( 'events_local_users' ),
					array( 'user_id', 'edits', 'all_groups' ),
					array( 'wiki_id' => $wikiId, 'edits != 0' ),
					__METHOD__,
					array( 'ORDER BY' => 'edits desc', 'LIMIT' => $limit )
				);

				while( $row = $db->fetchObject($result) ) {
					if (!($excludeBots && $this->isBotGroup($row->all_groups))) {
						$topEditors[$row->user_id] = intval( $row->edits );
					}
				}

				return $topEditors;
			}
		);

		wfProfileOut( __METHOD__ );

		return $topEditors;
	}

	public function isBotGroup($groups) {
		$isBot = false;
		$groups = explode(';', $groups);
		foreach (self::$botGroups as $botGroup) {
			if (in_array($botGroup, $groups)) {
				$isBot = true;
				break;
			}
		}
		return $isBot;
	}

	/**
	 * get number of images on the wiki
	 * @return integer totalImages
	 */
	public function getTotalImages( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyTotalImages( $wikiId );
		$totalImages = $this->wg->Memc->get( $memKey );
		if ( $totalImages === false ) {
			$totalImages = 0;
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty($dbname) ) {
				$db = wfGetDB( DB_SLAVE, array(), $dbname );
			} else {
				$db = wfGetDB( DB_SLAVE );
			}

			$row = $db->selectRow(
				array( 'image' ),
				array( 'count(*) cnt' ),
				array( "img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')" ),
				__METHOD__
			);

			if ( $row ) {
				$totalImages = intval( $row->cnt );
			}

			$this->wg->Memc->set( $memKey, $totalImages, 60*60*3 );
		}

		wfProfileOut( __METHOD__ );

		return $totalImages;
	}

	/**
	 * Get user info ( user name, avatar url, user page url ) on given wiki
	 * if the user has avatar
	 * @param integer $userId
	 * @param integer $wikiId
	 * @param integer $avatarSize
	 * @param callable $checkUserCallback
	 * @return array userInfo
	 *
	 */
	public function getUserInfo($userId, $wikiId, $avatarSize, $checkUserCallback) {
		$userInfo = array();
		$user = User::newFromId($userId);

		if ($user instanceof User && $checkUserCallback($user)) {
			$username = $user->getName();

			$userInfo['avatarUrl'] = AvatarService::getAvatarUrl($user, $avatarSize);
			$userInfo['edits'] = 0;
			$userInfo['name'] = $username;
			/** @var $userProfileTitle GlobalTitle */
			$userProfileTitle = GlobalTitle::newFromTextCached($username, NS_USER, $wikiId);
			$userInfo['userPageUrl'] = ($userProfileTitle instanceof Title) ? $userProfileTitle->getFullURL() : '#';
			$userContributionsTitle = GlobalTitle::newFromTextCached('Contributions/' . $username, NS_SPECIAL, $wikiId);
			$userInfo['userContributionsUrl'] = ($userContributionsTitle instanceof Title) ? $userContributionsTitle->getFullURL() : '#';
			$userInfo['userId'] = $userId;

			$userStatsService = new UserStatsService($userId);
			$stats = $userStatsService->getGlobalStats($wikiId);

			if(!empty($stats['date'])) {
				$date = getdate(strtotime($stats['date']));
			} else {
				$date = getdate(strtotime('2005-06-01'));
			}

			$userInfo['lastRevision'] = $stats['lastRevision'];

			$userInfo['since'] = F::App()->wg->Lang->getMonthAbbreviation($date['mon']) . ' ' . $date['year'];
		}

		return $userInfo;
	}

	/**
	 * @param array $wikiIds
	 * @param int $imageWidth
	 * @param int $imageHeight
	 *
	 * @return mixed|null|string
	 */
	public function getWikiImages($wikiIds, $imageWidth, $imageHeight = self::IMAGE_HEIGHT_KEEP_ASPECT_RATIO) {
		$images = array();
		try {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$tables = array('city_visualization');
			$fields = array('city_id', 'city_main_image');
			$conds = array('city_id' => $wikiIds);
			$results = $db->select($tables, $fields, $conds, __METHOD__, array(), array());

			while($row = $results->fetchObject()) {
				$title = Title::newFromText($row->city_main_image, NS_FILE);
				$file = wffindFile($title);
				
				if ($file instanceof File && $file->exists()) {
					$imageServing = new ImageServing(null, $imageWidth, $imageHeight);
					$images[$row->city_id] = $imageServing->getUrl($row->city_main_image, $file->getWidth(), $file->getHeight());
				}
			}
		} catch(Exception $e) {
			// for devbox machines
		}
		return $images;
	}

	public function getWikiAdmins ($wikiId, $avatarSize, $limit = null) {
		return WikiaDataAccess::cacheWithLock(
			wfsharedMemcKey('get_wiki_admins', $wikiId, $avatarSize, $limit),
			3 * 60 * 60,
			function () use ($wikiId, $avatarSize, $limit) {
				$admins = array();
				try {
					$admins = $this->getWikiAdminIds($wikiId, false, true, $limit, false);
					$checkUserCallback = function ($user) { return true; };
					foreach ($admins as &$admin) {
						$userInfo = $this->getUserInfo($admin, $wikiId, $avatarSize, $checkUserCallback);
						$admin = $userInfo;
					}
				} catch (Exception $e) {
					// for devboxes
				}
				return $admins;
			}
		);
	}

	/**
	 * @param int wiki id
	 * @param int avatar size
	 *
	 * @return array most active admins from last week ordered desc
	 */
	public function getMostActiveAdmins($wikiId, $avatarSize) {
		$edits = $ids = [];
		$admins = $this->getWikiAdmins($wikiId, $avatarSize);
		$ids = array_map(function($item) { return $item['userId']; }, $admins);

		$adminsEdits = DataMartService::getUserEditsByWikiId( $ids, $wikiId);

		foreach($admins as $key => $admin) {
			$userEdits = 0;
			if(empty($admin['userId']) || in_array($admin['userId'], self::$excludedWikiaUsers)) {
				unset($admins[$key]);
				continue;
			}
			if(isset($adminsEdits[$admin['userId']])) {
				$userEdits = $this->countAdminEdits($adminsEdits[$admin['userId']]);
			}
			$edits[$key] = $admins[$key]['edits'] = $userEdits;
			$lastRevision[$key] = $admins[$key]['lastRevision'];
		}

		array_multisort($edits, SORT_DESC, $lastRevision, SORT_DESC,  $admins);
		return $admins;
	}

	private function countAdminEdits($edits) {
		$editsCount = 0;
		$editsCount += (int)$edits['edits'] + (int)$edits['deletes'] + (int)$edits['undeletes'];
		return $editsCount;
	}

	public function getWikiDescription( Array $wikiIds, $imgWidth = 250, $imgHeight = null ) {

		$wikiDetails = $this->getWikiDetails( $wikiIds );

		foreach ( $wikiDetails as $wikiId => $wikiData ) {
			if ( empty( $wikiData['desc']) ) {
				$wikiDetails[ $wikiId ]['desc'] = wfMessage( 'wikiasearch2-crosswiki-description', $wikiData['name'] )->text();
			}
			$wikiDetails[ $wikiId ]['image_wiki_id'] = null;
			if ( !empty( $wikiData['image'] ) ) {
				$wikiDetails[ $wikiId ]['image_wiki_id'] = $this->getCityVisualizationObject()->getTargetWikiId( $wikiData['lang'] );

				$imageUrl = $this->getImageSrcByTitle( $wikiDetails[ $wikiId ]['image_wiki_id'], $wikiData['image'], $imgWidth, $imgHeight);
				$wikiDetails[ $wikiId ]['image_url'] = $imageUrl;
			} else {
				$wikiDetails[ $wikiId ]['image_url'] = '';
			}
		}

		return $wikiDetails;
	}

	public function setCityVisualizationObject( $cityVisualizationObject ) {
		$this->cityVisualizationObject = $cityVisualizationObject;
	}

	public function getCityVisualizationObject() {
		if ( empty( $this->cityVisualizationObject ) ) {
			$this->cityVisualizationObject = new CityVisualization();
		}
		return $this->cityVisualizationObject;
	}

	protected function getWikiDetails( $wikiIds ) {
		return ( new WikisModel )->getDetails( $wikiIds );
	}

	protected function getImageSrcByTitle( $wikiId, $imageTitle, $imgWidth, $imgHeight ) {
		return ImagesService::getImageSrcByTitle( $wikiId, $imageTitle, $imgWidth, $imgHeight );
	}

	protected function getMemcKeyTotalImages( $wikiId ) {
		return wfSharedMemcKey( 'wiki_total_images', $wikiId );
	}

	public function invalidateCacheTotalImages( $wikiId = 0 ) {
		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyTotalImages( $wikiId );
		$this->wg->Memc->delete( $memKey );
	}

}
