<?php

class WikiService extends WikiaModel {
	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;
	const IMAGE_HEIGHT_KEEP_ASPECT_RATIO = -1;
	const TOPUSER_CACHE_VALID = 10800;
	const TOPUSER_LIMIT = 150;

	const CACHE_VERSION = '4';
	const MAX_WIKI_RESULTS = 250;

	const FLAG_NEW = 1;
	const FLAG_HOT = 2;
	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;
	const FLAG_OFFICIAL = 16;

	static $botGroups = array('bot', 'bot-global');
	protected $cityVisualizationObject = null;
	protected $wikisModel;

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
	public function getWikiAdminIds( $wikiId = 0, $useMaster = false, $excludeBots = false, $limit = null ) {
		wfProfileIn( __METHOD__ );

		$userIds = array();
		if ( empty($this->wg->FounderEmailsDebugUserId) ) {
			// get founder
			$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
			$wiki = WikiFactory::getWikiById($wikiId);
			if ( !empty($wiki) && $wiki->city_public == 1 ) {
				$userIds[] = $wiki->city_founding_user;

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
			static::TOPUSER_CACHE_VALID,
			function() use ( $wikiId, $excludeBots ) {
				$topEditors = array();

				$db = wfGetDB( DB_SLAVE, array(), 'specials' );

				$result = $db->select(
					array( 'events_local_users' ),
					array( 'user_id', 'edits', 'all_groups' ),
					array( 'wiki_id' => $wikiId, 'edits != 0' ),
					__METHOD__,
					array( 'ORDER BY' => 'edits desc', 'LIMIT' => static::TOPUSER_LIMIT )
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
		return array_slice( $topEditors, 0, $limit, true );
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
					$admins = $this->getWikiAdminIds($wikiId, false, true, $limit);
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

	/** DEPRACATED will be removed */
	public function getWikiDescription( Array $wikiIds, $imgWidth = 250, $imgHeight = null ) {

		$wikiDetails = $this->getDetails( $wikiIds );

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

	/**
	 * Get the domain of a wiki by its' ID
	 *
	 * @param integer $wikiId The wiki's ID
	 *
	 * @return string The domain name, without protocol
	 */
	private function getDomainByWikiId( $wikiId ){
		//this has its' own cache layer
		$domain = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
		$ret = null;

		if ( !empty( $domain ) ) {
			$ret = str_replace( 'http://', '',  $domain );
		}

		return $ret;
	}

	/**
	 * Get the vertical name for a wiki by its' ID
	 *
	 * @param integer $wikiId The wiki's ID
	 *
	 * @return string The name of the vertical (e.g. Gaming, Entertainment, etc.)
	 */
	private function getVerticalByWikiId( $wikiId ){
		//this has its' own cache layer
		$cat = WikiFactory::getCategory( $wikiId );
		$ret = null;

		if ( !empty( $cat ) ) {
			$ret =  $cat->cat_name;
		}

		return $ret;
	}

	/**
	 * Get the top wikis by weekly pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 *
	 * @return array A collection of results with id, name, hub, language, topic and domain
	 */
	public function getTop( Array $langs = null, $hub = null ) {
		wfProfileIn( __METHOD__ );

		$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, implode( ',', $langs ), $hub );
		$results = $this->wg->Memc->get( $cacheKey );

		if ( !is_array( $results ) ) {
			$results = array();
			$wikis = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_WEEKLY, self::MAX_WIKI_RESULTS, $langs, $hub, 1 /* only pubic */ );

			foreach ( $wikis as $wikiId => $wiki ) {
				//fetching data from WikiFactory
				//the table is indexed and values cached separately
				//so making one query for all of them or a few small
				//separate ones doesn't make any big difference while
				//this respects WF's data abstraction layer
				//also: WF data is heavily cached
				$name = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$hubName = ( !empty( $hub ) ) ? $hub : $this->getVerticalByWikiId( $wikiId );
				$langCode = WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId );
				$topic = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
				$domain = $this->getDomainByWikiId( $wikiId );

				$results[] = array(
					'id' => $wikiId,
					'name' => ( !empty( $name ) ) ? $name : null,
					'hub' => $hubName,
					'language' => ( !empty( $langCode ) ) ? $langCode : null,
					'topic' => ( !empty( $topic ) ) ? $topic : null,
					'domain' => $domain
				);
			}

			$this->wg->Memc->set( $cacheKey, $results, 86400 /* 24h */ );
		}

		wfProfileOut( __METHOD__ );
		return $results;
	}

	/**
	 * Finds wikis which name, domain or topic match a string optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $string search term
	 * @param mixed $hub [OPTIONAL] The name of the vertical as a string(e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) or it's related numeric ID to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @param bool [OPTIONAL] Include the domain name in the search, defaults to false
	 *
	 * @return array A collection of results with id, name, hub, language, topic, domain
	 */
	public function getByString( $string, Array $langs = null, $hub = null, $includeDomain = false ) {
		wfProfileIn( __METHOD__ );

		$wikis = [];

		if ( !empty( $string ) ) {
			$hubId = null;

			if ( !empty( $hub ) ) {
				if ( is_string( $hub ) ) {
					//this has it's own memcache layer (24h)
					$hubData = WikiFactoryHub::getInstance()->getCategoryByName( $hub );

					if ( is_array( $hubData ) ) {
						$hubId = $hubData['id'];
					}
				} elseif ( is_integer( $hub ) ) {
					$hubId = $hub;
				}
			}

			if ( empty( $hub ) || ( !empty( $hub ) && is_integer( $hubId ) ) ) {
				$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION,  md5( strtolower( $string ) ), $hubId, implode( ',', $langs ), ( ( !empty( $includeDomain ) ? 'includeDomain' : null ) ) );
				$wikis = $this->app->wg->Memc->get( $cacheKey );

				if ( !is_array( $wikis ) ) {
					$db = $this->getSharedDB();

					$string = $db->addQuotes( "%{$string}%" );
					$varId = (int) WikiFactory::getVarByName( 'wgWikiTopics', null )->cv_variable_id;
					$tables = array(
						'city_list',
						'city_variables'
					);

					$clause = array( "city_list.city_title LIKE {$string}" );

					if ( !empty( $includeDomain ) ) {
						$clause[] = "city_list.city_url LIKE {$string}";
					}

					$clause[] = "city_variables.cv_value LIKE {$string}";

					$where = array(
						'city_list.city_public' => 1,
						'(' . implode( ' OR ', $clause ) . ')'
					);

					$join = array(
						'city_variables' => array(
							'LEFT JOIN',
							"city_list.city_id = city_variables.cv_city_id AND city_variables.cv_variable_id = {$varId}"
						)
					);

					if ( !empty( $langs ) ) {
						$langs = $db->makeList($langs);
						$where[] = 'city_list.city_lang IN (' . $langs . ')';
					}

					if ( is_integer( $hubId ) ) {
						$tables[] = 'city_cat_mapping';
						$where['city_cat_mapping.cat_id'] = $hubId;
						$join['city_cat_mapping'] = array(
							'LEFT JOIN',
							'city_list.city_id = city_cat_mapping.city_id'
						);
					}

					$rows = $db->select(
						$tables,
						array(
							'city_list.city_id',
							'city_list.city_lang',
							'city_list.city_title',
							'city_variables.cv_value'
						),
						$where,
						__METHOD__,
						array(
							'LIMIT' => self::MAX_WIKI_RESULTS
						),
						$join
					);

					while ( $row = $db->fetchObject( $rows ) ) {
						$wikis[] = array(
							'id' => $row->city_id,
							'name' => $row->city_title,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performance
							'hub' => ( !empty( $hub ) && is_string( $hub ) ) ? $hub : $this->getVerticalByWikiId( $row->city_id ),
							'language' => $row->city_lang,
							//WF stores strings as serialized data
							'topic' => ( !empty( $row->cv_value ) ) ? unserialize( $row->cv_value ) : null,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performances
							'domain' => $this->getDomainByWikiId( $row->city_id )
						);
					}

					$this->wg->Memc->set( $cacheKey, $wikis, 43200 /* 12h */ );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $wikis;
	}

	/**
	 * Get details about one or more wikis
	 *
	 * @param Array $wikiIds An array of one or more wiki ID's
	 *
	 * @return Array A collection of results, the index is the wiki ID and each item has a name,
	 * url, lang, hubId, headline, desc, image and flags index.
	 */
	public function getDetails( Array $wikiIds = null ) {
		wfProfileIn(__METHOD__);

		$results = array();

		if ( !empty( $wikiIds ) ) {
			$notFound = array();

			foreach ( $wikiIds as $index => $val ) {
				$val = (int) $val;

				if ( !empty( $val ) ) {
					$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $val );
					$item = $this->wg->Memc->get( $cacheKey );

					if ( is_array( $item ) ) {
						$results[$val] = $item;
					}else {
						$notFound[] = $val;
					}
				}
			}

			$wikiIds = $notFound;
		}

		if ( !empty( $wikiIds ) ) {
			$db = $this->getSharedDB();

			$rows = $db->select(
				array(
					'city_visualization',
					'city_list'
				),
				array(
					'city_list.city_id',
					'city_list.city_title',
					'city_list.city_url',
					'city_visualization.city_lang_code',
					'city_visualization.city_vertical',
					'city_visualization.city_headline',
					'city_visualization.city_description',
					'city_visualization.city_main_image',
					'city_visualization.city_flags',
				),
				array(
					'city_list.city_public' => 1,
					'city_list.city_id IN (' . implode( ',', $wikiIds ) . ')',
					'((city_visualization.city_flags & ' . self::FLAG_BLOCKED . ') != ' . self::FLAG_BLOCKED . ' OR city_visualization.city_flags IS NULL)'
				),
				__METHOD__,
				array(),
				array(
					'city_visualization' => array(
						'LEFT JOIN',
						'city_list.city_id = city_visualization.city_id'
					)
				)
			);

			while( $row = $db->fetchObject( $rows ) ) {
				$item = array(
					'name' => $row->city_title,
					'url' => $row->city_url,
					'lang' => $row->city_lang_code,
					'hubId' => $row->city_vertical,
					'headline' => $row->city_headline,
					'desc' => $row->city_description,
					//this is stored in a pretty peculiar format,
					//see extensions/wikia/CityVisualization/models/CityVisualization.class.php
					'image' => $row->city_main_image,
					'flags' => array(
						'new' => ( ( $row->city_flags & self::FLAG_NEW ) == self::FLAG_NEW ),
						'hot' => ( ( $row->city_flags & self::FLAG_HOT ) == self::FLAG_HOT ),
						'official' => ( ( $row->city_flags & self::FLAG_OFFICIAL ) == self::FLAG_OFFICIAL ),
						'promoted' => ( ( $row->city_flags & self::FLAG_PROMOTED ) == self::FLAG_PROMOTED )
					)
				);

				$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $row->city_id );
				$this->wg->Memc->set( $cacheKey, $item, 43200 /* 12h */ );
				$results[$row->city_id] = $item;
			}
		}

		wfProfileOut(__METHOD__);
		return $results;
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
