<?php

class WikiService extends WikiaModel {
	const ADMIN_GROUPS = [
		'bureaucrat',
		'sysop'
	];

	const WAM_DEFAULT_ITEM_LIMIT_PER_PAGE = 20;
	const IMAGE_HEIGHT_KEEP_ASPECT_RATIO = -1;
	const TOPUSER_CACHE_VALID = 10800;
	const TOPUSER_LIMIT = 150;

	const CACHE_VERSION = '5';
	const MAX_WIKI_RESULTS = 300;

	const MOST_LINKED_CACHE_TTL = 86400; // 86400 == 24h
	const MOST_LINKED_LIMIT = 50;

	const WIKI_ADMIN_IDS_CACHE_TTL = 10800; // 10800 == 3hrs;

	const WIKIAGLOBAL_CITY_ID = 80433;

	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;
	const FLAG_OFFICIAL = 16;

	static $botGroups = [ 'bot', 'bot-global' ];
	static $excludedWikiaUsers = [
		22439, //Wikia
		/* Abuse filter users start */
		519362,
		3245469,
		5309332,
		4067247,
		4865761,
		4119511,
		1458396,
		15510531,
		24039613
		/* Abuse filter users start */
	];

	protected $cityVisualizationObject = null;
	protected $wikisModel;

	/**
	 * get list of wiki founder/admin/bureaucrat id
	 * Note: also called from maintenance script.
	 *
	 * @param integer $wikiId - wiki Id (default: current wiki Id)
	 * @param bool    $useMaster - flag that describes if we should use masted DB (default: false)
	 * @param bool    $excludeBots - flag that describes if bots should be excluded from admins list (default: false)
	 * @param integer $limit - admins limit
	 * @param bool    $includeFounder - flag that describes if founder user should be added to admins list (default: true)
	 *
	 * @return array of $userIds
	 */
	public function getWikiAdminIds( $wikiId = 0, $useMaster = false, $excludeBots = false, $limit = null, $includeFounder = true ) {
		if ( !empty( $this->wg->FounderEmailsDebugUserId ) ) {
			return [ $this->wg->FounderEmailsDebugUserId ];
		}

		$wikiId = empty( $wikiId ) ? $this->wg->CityId : $wikiId ;
		$wiki = WikiFactory::getWikiById( $wikiId );

		if ( empty( $wiki ) || $wiki->city_public != 1 ) {
			return [];
		}

		// Get founder
		$userIds = [];
		if ( $includeFounder ) {
			$userIds[] = $wiki->city_founding_user;
		}

		if ( !empty( $this->wg->EnableAnswers ) ) {
			return $userIds;
		}

		// Get admins and bureaucrats
		$memKey = $this->getMemKeyAdminIds( $wikiId, $excludeBots, $limit );
		$adminIds = WikiaDataAccess::cache(
			$memKey,
			self::WIKI_ADMIN_IDS_CACHE_TTL,
			function() use ( $wiki, $useMaster, $excludeBots, $limit ) {
				$dbName = $wiki->city_dbname;
				$dbType = $useMaster ? DB_MASTER : DB_SLAVE;
				$db = wfGetDB( $dbType, [], $dbName );

				return self::getAdminIdsFromDB( $db, $excludeBots, $limit );
			}
		);

		$userIds = array_unique( array_merge( $userIds, $adminIds ) );

		return $userIds;
	}

	private static function getAdminIdsFromDB( DatabaseBase $db, $excludeBots = false, $limit = null ) {
		$conditions = [ 'ug_group' => self::ADMIN_GROUPS ];

		if ( $excludeBots ) {
			$groupList = $db->makeList( self::$botGroups );
			$subQuery = "select distinct ug_user from user_groups where ug_group in ($groupList)";

			$conditions[] = "ug_user not in ($subQuery)";
		}

		$result = $db->select(
			'user_groups',
			'distinct ug_user',
			$conditions,
			__METHOD__,
			!empty( $limit ) ? [ 'LIMIT' => $limit ] : []
		);

		$adminIds = [];
		while ( $row = $db->fetchObject( $result ) ) {
			$adminIds[] = $row->ug_user;
		}
		$db->freeResult( $result );

		return $adminIds;
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
		$fname = __METHOD__;

		$topEditors = WikiaDataAccess::cache(
			wfSharedMemcKey( 'wiki_top_editors', $wikiId, $excludeBots ),
			static::TOPUSER_CACHE_VALID,
			function() use ( $wikiId, $excludeBots, $fname ) {
				global $wgSpecialsDB;
				$topEditors = array();

				$db = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );

				$result = $db->select(
					array( 'events_local_users' ),
					array( 'user_id', 'edits', 'all_groups' ),
					array( 'wiki_id' => $wikiId, 'edits != 0' ),
					$fname,
					array(
						'ORDER BY' => 'edits desc',
						'LIMIT' => static::TOPUSER_LIMIT,
						'USE INDEX' => 'PRIMARY', # mysql in Reston wants to use a different key (PLATFORM-1648)
					)
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
	 * @param callable $checkUserCallback (optional)
	 * @return array userInfo
	 *
	 */
	public function getUserInfo($userId, $wikiId, $avatarSize, $checkUserCallback = null) {
		$userInfo = array();
		$user = User::newFromId($userId);

		if ( $user instanceof User && ( !is_callable( $checkUserCallback ) || $checkUserCallback( $user ) ) ) {
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
	public function getWikiImages( $wikiIds, $imageWidth, $imageHeight = self::IMAGE_HEIGHT_KEEP_ASPECT_RATIO ) {
		$images = array();
		try {
			$db = wfGetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );
			$tables = array( 'city_visualization' );
			$fields = array( 'city_id', 'city_lang_code', 'city_main_image' );
			$conds = array( 'city_id' => $wikiIds );
			$results = $db->select( $tables, $fields, $conds, __METHOD__, array(), array() );

			while ( $row = $results->fetchObject() ) {
				$promoImage = PromoImage::fromPathname($row->city_main_image);
				$promoImage->ensureCityIdIsSet($row->city_id);

				$file = $promoImage->corporateFileByLang($row->city_lang_code);

				if ( $file->exists() ) {
					$imageServing = new ImageServing( null, $imageWidth, $imageHeight );
					$images[ $row->city_id ] = ImagesService::overrideThumbnailFormat(
						$imageServing->getUrl( $file, $file->getWidth(), $file->getHeight() ),
						ImagesService::EXT_JPG
					);
				}
			}
		} catch ( Exception $e ) {
			Wikia::log( __METHOD__, false, $e->getMessage() );
		}
		return $images;
	}

	public function getWikiWordmark( $wikiId ) {
		$url = '';
		$history = WikiFactory::getVarByName( 'wgOasisThemeSettingsHistory', $wikiId );
		$settings = unserialize( $history->cv_value );
		if ( $settings !== false ) {
			$currentSettings =  end( $settings );

			if ( isset($currentSettings['settings']['wordmark-type']) && $currentSettings['settings']['wordmark-type'] == 'text' ) {
				return '';
			}

			if ( isset( $currentSettings['settings'] ) && !empty( $currentSettings['settings']['wordmark-image-url'] ) ) {
					$url = wfReplaceImageServer( $currentSettings['settings']['wordmark-image-url'], $currentSettings['timestamp'] );
			}
		}
		return $url;
	}

	public function getWikiAdmins ($wikiId, $avatarSize, $limit = null) {
		return WikiaDataAccess::cacheWithLock(
			wfsharedMemcKey('get_wiki_admins', $wikiId, $avatarSize, $limit),
			3 * 60 * 60,
			function () use ($wikiId, $avatarSize, $limit) {
				$admins = array();
				try {
					$admins = $this->getWikiAdminIds($wikiId, false, true, $limit, false);
					foreach ($admins as &$admin) {
						$userInfo = $this->getUserInfo($admin, $wikiId, $avatarSize);
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
	 * @param int $wikiId
	 * @return array most linked articles
	 */
	public function getMostLinkedPages( $wikiId = 0 ) {
		wfProfileIn( __METHOD__ );

		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyMostLinked( $wikiId );
		$mostLinked = $this->wg->Memc->get( $memKey );

		if ( $mostLinked === false ) {
			$mostLinked = [];
			$dbname = WikiFactory::IDtoDB( $wikiId );
			if ( !empty( $dbname ) ) {
				$db = wfGetDB( DB_SLAVE, array(), $dbname );
			} else {
				$db = false;
			}

			if ( $db !== false ) {
				$res = $db->select(
					array( 'querycache', 'page' ),
					array( 'page_id', 'qc_value', 'page_title' ),
					array(
						'qc_title = page_title',
						'qc_namespace = page_namespace',
						'page_is_redirect = 0',
						'qc_type' => 'Mostlinked',
						'qc_namespace' => '0'
					),
					__METHOD__,
					array( 'ORDER BY' => 'qc_value DESC', 'LIMIT' => self::MOST_LINKED_LIMIT  )
				);

				while ( $row = $db->fetchObject( $res ) ) {
					$mostLinked[ $row->page_id ] = [ 	"page_id" => $row->page_id,
														"page_title" => $row->page_title,
														"backlink_cnt" => $row->qc_value ];
				}
			}
			$this->wg->Memc->set( $memKey, $mostLinked, self::MOST_LINKED_CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $mostLinked;
	}

	/**
	 * @param int wiki id
	 * @param int avatar size
	 *
	 * @return array most active admins from last week ordered desc
	 */
	public function getMostActiveAdmins($wikiId, $avatarSize) {
		$edits = $ids = $lastRevision = [];
		$admins = $this->getWikiAdmins($wikiId, $avatarSize);

		foreach ( $admins as $admin ) {
			if ( isset( $admin['userId'] ) ) {
				$ids[] = $admin['userId'];
			}
		}

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
				if ( !empty( $name ) ) {
					$hubName = ( !empty( $hub ) ) ? $hub : $this->getVerticalByWikiId( $wikiId );
					$langCode = WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId );
					$topic = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
					$domain = $this->getDomainByWikiId( $wikiId );

					$results[ ] = array(
						'id' => $wikiId,
						'name' => $name,
						'hub' => $hubName,
						'language' => ( !empty( $langCode ) ) ? $langCode : null,
						'topic' => ( !empty( $topic ) ) ? $topic : null,
						'domain' => $domain
					);
				}
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
					$wikis = [];
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
					'city_list',
					'city_verticals',
					'city_cat_mapping',
					'city_cats'
				),
				array(
					'city_list.city_id',
					'city_list.city_title',
					'city_list.city_description',
					'city_list.city_url',
					'city_list.city_lang',
					'city_list.city_vertical',
					'city_visualization.city_headline',
					'city_visualization.city_description',
					'city_visualization.city_main_image',
					'city_visualization.city_flags',
					'city_verticals.vertical_name',
					'city_cats.cat_name'
				),
				array(
					'city_list.city_public' => 1,
					'city_list.city_id' => $wikiIds,
					'((city_visualization.city_flags & ' . self::FLAG_BLOCKED . ') != ' . self::FLAG_BLOCKED . ' OR city_visualization.city_flags IS NULL)'
				),
				__METHOD__,
				array(),
				array(
					'city_visualization' => array(
						'LEFT JOIN',
						'city_list.city_id = city_visualization.city_id'
					),
					'city_verticals' => array(
						'LEFT JOIN',
						'city_list.city_vertical = city_verticals.vertical_id'
					),
					'city_cat_mapping' => array (
						'LEFT JOIN',
						'city_list.city_id = city_cat_mapping.city_id',
					),
					'city_cats' => array(
						'LEFT JOIN',
						'city_cat_mapping.cat_id = city_cats.cat_id'
					)
				)
			);

			while( $row = $db->fetchObject( $rows ) ) {
				$item = array(
					'name' => $row->city_title,
					'url' => $row->city_url,
					'domain' => $row->city_url,
					'title' => $row->city_title,
					'topic' => $row->cat_name,
					'lang' => $row->city_lang,
					'hub' => $row->vertical_name,
					'headline' => $row->city_headline,
					'desc' => $row->city_description,
					//this is stored in a pretty peculiar format,
					//see extensions/wikia/CityVisualization/models/CityVisualization.class.php
					'image' => PromoImage::fromPathname($row->city_main_image)->ensureCityIdIsSet($row->city_id)->getPathname(),
					'flags' => array(
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

	protected function getMemcKeyMostLinked( $wikiId ) {
		return wfSharedMemcKey( 'wiki_most_linked', $wikiId );
	}

	public function invalidateCacheTotalImages( $wikiId = 0 ) {
		$wikiId = ( empty($wikiId) ) ? $this->wg->CityId : $wikiId ;
		$memKey = $this->getMemcKeyTotalImages( $wikiId );
		$this->wg->Memc->delete( $memKey );
	}

}
