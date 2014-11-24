<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Class VideosModule
 */
class VideosModule extends WikiaModel {

	const THUMBNAIL_WIDTH = 268;
	const THUMBNAIL_HEIGHT = 150;

	const LIMIT_VIDEOS = 20;
	const LIMIT_CATEGORY_VIDEOS = 40;
	const CACHE_TTL = 43200; // 12 hours
	const NEGATIVE_CACHE_TTL = 300; // 5 minutes
	const CACHE_VERSION = 3;

	const STAFF_PICK_PREFIX = 'Staff_Pick_';
	const STAFF_PICK_GLOBAL_CATEGORY = 'Staff_Pick_Global';
	const MAX_STAFF_PICKS = 5;

	const SOURCE_LOCAL = 'local';
	const SOURCE_ARTICLE = 'article-related';
	const SOURCE_WIKI_TITLE = 'wiki-title';
	const SOURCE_WIKI_TOPICS = 'wiki-topics';
	const SOURCE_WIKI_CATEGORIES = 'wiki-categories';
	const SOURCE_STAFF = 'staff-picks';
	const SOURCE_WIKI_VERTICAL = 'wiki-vertical';

	const DEFAULT_REGION = "US";

	protected $blacklist = [];          // black listed videos we never want to show in videos module
	protected $blacklistCount = null;   // number of blacklist videos
	protected $existingVideos = [];     // list of titles of existing videos (those which have been added already)
	protected $userRegion;

	public function __construct( $userRegion ) {
		// All black listed videos are stored in WikiFactory in the wgVideosModuleBlackList variable
		// on Community wiki.
		$communityBlacklist = WikiFactory::getVarByName( "wgVideosModuleBlackList", WikiFactory::COMMUNITY_CENTRAL );

		// Set the blacklist if there is data for it
		if ( is_object( $communityBlacklist ) && !empty( $communityBlacklist->cv_value ) ) {
			$this->blacklist = unserialize( $communityBlacklist->cv_value );
		}

		$this->userRegion = $userRegion;
		parent::__construct();
	}

	// options for getting video detail
	protected static $videoOptions = [
		'thumbWidth'   => self::THUMBNAIL_WIDTH,
		'thumbHeight'  => self::THUMBNAIL_HEIGHT,
		'getThumbnail' => true,
		'thumbOptions' => [
			'fluid'       => true,
			'forceSize'   => 'small',
		],
	];

	// list of page categories for premium videos [ array( categoryId => name ) ]
	protected static $pageCategories = [
		WikiFactoryHub::CATEGORY_ID_GAMING        => 'Games',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'Entertainment',
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE     => 'Lifestyle',
	];

	// map category id to search vertical
	protected static $searchCategories = [
		WikiFactoryHub::CATEGORY_ID_GAMING        => Wikia\Search\Config::FILTER_CAT_VIDEOGAMES,
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => Wikia\Search\Config::FILTER_CAT_ENTERTAINMENT,
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE     => Wikia\Search\Config::FILTER_CAT_LIFESTYLE,
	];

	/**
	 * Look for 'Staff Picks' on the video wiki.  These are videos that have been added to the
	 * "Staff Pick DBNAME" category (where DBNAME is this wiki's DB NAME) or the "Staff Pick Global"
	 * category.
	 *
	 * @return array
	 */
	public function getStaffPicks() {
		wfProfileIn( __METHOD__ );

		$categories = [ self::STAFF_PICK_PREFIX.$this->wg->DBname, self::STAFF_PICK_GLOBAL_CATEGORY ];
		$limit = self::MAX_STAFF_PICKS;
		$sort = 'recent';
		$videos = $this->getVideoListFromVideoWiki( $categories, $limit, $sort, self::SOURCE_STAFF );

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get videos added to the wiki
	 * @param integer $numRequired - number of videos required
	 * @param string $sort [recent/trend] - how to sort the results
	 * @return array - list of vertical videos (premium videos)
	 */
	public function getLocalVideos( $numRequired, $sort ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		$memcKey = wfMemcKey( 'videomodule', 'local_videos', self::CACHE_VERSION, $sort, $this->userRegion );
		$videos = $this->wg->Memc->get( $memcKey );

		$loggingParams = [ 'method' => __METHOD__, 'num' => $numRequired, 'sort' => $sort ];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			$filter = 'all';
			$paddedLimit = $this->getPaddedVideoLimit( self::LIMIT_VIDEOS );

			$mediaService = new MediaQueryService();
			$videoList = $mediaService->getVideoList( $sort, $filter, $paddedLimit );
			$videosWithDetails = $this->getVideoDetailFromLocalWiki( $videoList );

			$videos = [];
			foreach ( $videosWithDetails as $video ) {
				if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
					break;
				}
				$this->addToList( $videos, $video, self::SOURCE_LOCAL );
			}

			$ttl = self::CACHE_TTL;
			if ( empty( $videos ) ) {
				$ttl = self::NEGATIVE_CACHE_TTL;
				$log->info( __METHOD__ . ' zero videos', $loggingParams );
			}
			$this->wg->Memc->set( $memcKey, $videos, $ttl );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
	 * @param integer $numRequired - number of videos required
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideosTopics( $numRequired ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		$memcKey = wfMemcKey( 'videomodule', 'wiki_related_videos_topics', self::CACHE_VERSION, $this->userRegion );
		$videos = $this->wg->Memc->get( $memcKey );

		$loggingParams = [ 'method' => __METHOD__, 'num' => $numRequired ];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			// Strip Wiki off the end of the wiki name if it exists
			$wikiTitle = preg_replace( '/ Wiki$/', '', $this->wg->Sitename );

			$params = [
				'defaultTopic' => $wikiTitle,
				'limit'        => $this->getPaddedVideoLimit( self::LIMIT_VIDEOS ),
			];

			$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTopics', $params )->getData();
			$videosWithDetails = $this->getVideoDetailFromVideoWiki( $this->getVideoTitles( $videoResults ) );

			$videos = [];
			foreach ( $videosWithDetails as $video ) {
				if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
					break;
				}
				$this->addToList( $videos, $video, self::SOURCE_WIKI_TOPICS );
			}

			$ttl = self::CACHE_TTL;
			if ( empty( $videos ) ) {
				$ttl = self::NEGATIVE_CACHE_TTL;
				$log->info( __METHOD__ . ' zero videos', $loggingParams );
			}
			$this->wg->Memc->set( $memcKey, $videos, $ttl );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get videos from the Video wiki that are in categories listed in wgVideosModuleCategories
	 * @return array
	 */
	public function getVideosByCategory() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->wg->VideosModuleCategories ) ) {
			wfProfileOut( __METHOD__ );
			return [];
		}

		if ( is_array( $this->wg->VideosModuleCategories ) ) {
			$categories = $this->wg->VideosModuleCategories;
		} else {
			$categories = [ $this->wg->VideosModuleCategories ];
		}
		$categories = $this->transformCatNames( $categories );

		$limit = self::LIMIT_CATEGORY_VIDEOS;
		$sort = 'recent';
		$videos = $this->getVideoListFromVideoWiki( $categories, $limit, $sort, self::SOURCE_WIKI_CATEGORIES );

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get video list from Video wiki
	 * @param array|string $category
	 * @param int $limit The number of videos to return
	 * @param string $sort [recent/popular/trend]
	 * @param string $source Set to one of the SOURCE_* constants in this class
	 * @return array
	 */
	public function getVideoListFromVideoWiki( $category, $limit = self::LIMIT_VIDEOS, $sort = 'recent', $source = '' ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		sort( $category );
		$hashCategory = md5( json_encode( $category ) );
		$memcKey = wfSharedMemcKey( 'videomodule', 'videolist', self::CACHE_VERSION, $hashCategory, $sort, $this->userRegion );
		$videos = $this->wg->Memc->get( $memcKey );

		$loggingParams = [
			'method'   => __METHOD__,
			'category' => $category,
			'limit'    => $limit,
			'sort'     => $sort
		];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			$params = [
				'controller' => 'VideoHandler',
				'method'     => 'getVideoList',
				'sort'       => $sort,
				'limit'      => $this->getPaddedVideoLimit( $limit ),
				'category'   => $category,
			];

			$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
			$videosWithDetails = $this->getVideoDetailFromVideoWiki( $this->getVideoTitles( $response['videos'] ) );

			$videos = [];
			foreach ( $videosWithDetails as $video ) {
				if ( count( $videos ) >= $limit ) {
					break;
				}
				$this->addToList( $videos, $video, $source );
			}

			$ttl = self::CACHE_TTL;
			if ( empty( $videos ) ) {
				$ttl = self::NEGATIVE_CACHE_TTL;
				$log->info( __METHOD__ . ' zero videos', $loggingParams );
			}
			$this->wg->Memc->set( $memcKey, $videos, $ttl );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get videos from the Video wiki that are in this wiki's vertical category
	 * @param integer $numRequired - number of videos required
	 * @param string $sort [recent/trend] - how to sort the results
	 * @return array - list of vertical videos (premium videos)
	 */
	public function getVerticalVideos( $numRequired, $sort ) {
		wfProfileIn( __METHOD__ );

		$category = $this->getWikiVertical();
		$videos = $this->getVideoListFromVideoWiki( $category, $numRequired, $sort, self::SOURCE_WIKI_VERTICAL );

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get wiki vertical
	 *
	 * @return string - wiki vertical
	 */
	public function getWikiVertical() {
		wfProfileIn( __METHOD__ );

		$name = '';

		$categoryId = WikiFactoryHub::getInstance()->getCategoryId( $this->wg->CityId );
		if ( !empty( $categoryId ) ) {
			// get vertical id
			$verticalId = HubService::getCanonicalCategoryId( $categoryId );

			if ( array_key_exists( $verticalId, self::$pageCategories ) ) {
				$name = self::$pageCategories[$verticalId];
			}
		}

		wfProfileOut( __METHOD__ );

		return $name;
	}

	/**
	 * Get vertical name recognized by search from wiki's category ID
	 * @return string - search vertical
	 */
	public function getSearchVertical() {
		wfProfileIn( __METHOD__ );

		$name = '';

		$categoryId = WikiFactoryHub::getInstance()->getCategoryId( $this->wg->CityId );
		if ( !empty( $categoryId ) ) {
			// get vertical id
			$verticalId = HubService::getCanonicalCategoryId( $categoryId );

			if ( array_key_exists( $verticalId, self::$searchCategories ) ) {
				$name = self::$searchCategories[$verticalId];
			}
		}

		wfProfileOut( __METHOD__ );

		return $name;
	}

	/**
	 * Call 'VideoHandlerHelper::getVideoDetail' on the video wiki for each of a list of video titles
	 * @param array $videos A list of video titles
	 * @return array - A list of video details for each title passed
	 */
	public function getVideoDetailFromVideoWiki( $videos ) {
		wfProfileIn( __METHOD__ );

		$videoDetails = [];
		if ( !empty( $videos ) ) {
			$helper = new VideoHandlerHelper();
			$videoDetails = $helper->getVideoDetailFromWiki(
				$this->wg->WikiaVideoRepoDBName,
				$videos,
				self::$videoOptions
			);
		}

		wfProfileOut( __METHOD__ );

		return $videoDetails;
	}

	/**
	 * Get the video details (things like videoId, provider, description, regional restrictions, etc)
	 * for video from the local wiki.
	 * @param $videos
	 * @return array
	 */
	public function getVideoDetailFromLocalWiki( $videos ) {
		$videoDetails = [];
		$helper = new VideoHandlerHelper();
		foreach ( $videos as $video ) {
			$details = $helper->getVideoDetail( $video, self::$videoOptions );
			if ( !empty( $details ) ) {
				$videoDetails[] = $details;
			}
		}
		return $videoDetails;
	}

	/**
	 * Filter video detail
	 * @param array $video
	 * @return array
	 */
	protected function filterVideoDetail( $video ) {
		return [
			'title'     => $video['fileTitle'],
			'url'       => $video['fileUrl'],
			'thumbnail' => $video['thumbnail'],
			'videoKey'  => $video['title'],
			'source'    => $video['source'],
		];
	}

	/**
	 * Get video limit (include the number of blacklisted videos)
	 * @param int $numRequired
	 * @return integer
	 */
	protected function getPaddedVideoLimit( $numRequired ) {
		if ( is_null( $this->blacklistCount ) ) {
			$this->blacklistCount = count( $this->blacklist );
		}

		$limit = $numRequired + $this->blacklistCount;

		return $limit;
	}

	/**
	 * Checks if a video is able to be added to the current list being collected (eg, staffPicks, videosByCategory,
	 * wikiRelated), and adds it to that list. Adding the source of that video to it's detail, as well as appending
	 * it to the list of existingVideos which includes all videos added from all lists. We use this existingVideos
	 * list to filter as we're adding videos to ensure we don't include duplicates.
	 * @param $videos
	 * @param $video
	 * @param $source
	 * @return bool
	 */
	private function addToList( &$videos, $video, $source ) {
		$added = false;
		if ( $this->canAddToList( $video ) ) {
			$video['source'] = $source;
			$this->existingVideos[$video['title']] = true;
			$videos[] = $this->filterVideoDetail( $video );
			$added = true;
		}
		return $added;
	}

	/**
	 * Return whether the video can be added to the current list of videos being
	 * collected (eg, staffPicks, videosByCategory, wikiRelated).
	 * @param $video
	 * @return bool
	 */
	private function canAddToList( $video ) {
		return !( $this->isRegionallyRestricted( $video )
			|| $this->isBlackListed( $video )
			|| $this->isAlreadyAdded( $video ) );
	}

	/**
	 * Return whether the video is regionally restricted in the user's country.
	 * @param LocalFile $video
	 * @return bool
	 */
	public function isRegionallyRestricted( $video ) {
		return !empty( $video['regionalRestrictions'] )
			&& !empty( $this->userRegion )
			&& !preg_match( "/$this->userRegion/", $video['regionalRestrictions'] );
	}

	/**
	 * Return whether the video is blacklisted or not.
	 * @param $video
	 * @return bool
	 */
	public function isBlackListed( $video ) {
		return in_array( $video['title'], $this->blacklist );
	}

	/**
	 * Return whether a video has already been added to a list of videos
	 * to send out to the user (eg, staffPicks, videosByCategory, wikiRelated).
	 * Any video which we're going to send out we add to the existingVideos list.
	 * @param $video
	 * @return bool
	 */
	private function isAlreadyAdded( $video ) {
		return array_key_exists( $video['title'], $this->existingVideos );
	}

	/**
	 * Return a list of just titles given a list of videos.
	 * @param $videos
	 * @return array
	 */
	private function getVideoTitles( $videos ) {
		$videoTitles = [];
		foreach( $videos as $video ) {
			$videoTitles[] = $video['title'];
		}
		return $videoTitles;
	}

	/**
	 * Make sure categories used by videos module are using the database name as
	 * opposed to regular name (ie, use underscores instead of spaces)
	 * @param $categories
	 * @return array
	 */
	private function transformCatNames( array $categories ) {
		$transformedCategories = [];
		foreach ( $categories as $category ) {
			$transformedCategories[] = str_replace( " ", "_", $category );
		}
		return $transformedCategories;
	}
}
