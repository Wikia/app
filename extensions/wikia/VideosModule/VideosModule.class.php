<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Class VideosModule
 */
class VideosModule extends WikiaModel {

	const THUMBNAIL_WIDTH = 300;
	const THUMBNAIL_HEIGHT = 309;

	const LIMIT_VIDEOS = 20;
	const CACHE_TTL = 3600;
	const CACHE_VERSION = 2;

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

	protected $blacklistCount = null;	// number of blacklist videos
	protected $existingVideos = [];		// list of existing videos [ titleKey => true ]

	// options for getting video detail
	protected static $videoOptions = [
		'thumbWidth'   => self::THUMBNAIL_WIDTH,
		'thumbHeight'  => self::THUMBNAIL_HEIGHT,
		'getThumbnail' => true,
		'thumbOptions' => [
			'useTemplate' => true,
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

		$memcKey = wfMemcKey( 'videomodule', 'local_videos', self::CACHE_VERSION, $sort );
		$videos = $this->wg->Memc->get( $memcKey );

		$loggingParams = [ 'method' => __METHOD__, 'num' => $numRequired, 'sort' => $sort ];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			$filter = 'all';
			$paddedLimit = $this->getPaddedVideoLimit( self::LIMIT_VIDEOS );

			$mediaService = new MediaQueryService();
			$videoList = $mediaService->getVideoList( $sort, $filter, $paddedLimit );

			$videos = [];
			$videoTitles = [];
			$helper = new VideoHandlerHelper();
			foreach ( $videoList as $videoInfo ) {
				if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
					break;
				}

				if ( $this->addToList( $videoTitles, $videoInfo['title'] ) ) {
					// get video detail
					$videoDetail = $helper->getVideoDetail( $videoInfo, self::$videoOptions );
					$videoDetail['source'] = self::SOURCE_LOCAL;
					if ( !empty( $videoDetail ) ) {
						$videos[] = $this->filterVideoDetail( $videoDetail );
					}
				}
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Use the VideoEmbedToolSearchService to find premium videos related to the current article.
	 * @param integer $articleId - ID of the article being viewed.
	 * @param integer $numRequired - number of videos required
	 * @return array - Premium videos related to article.
	 */
	public function getArticleRelatedVideos( $articleId, $numRequired ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		$memcKey = wfMemcKey( 'videomodule', 'article_related_videos', self::CACHE_VERSION, $articleId );
		$videos = $this->wg->Memc->get( $memcKey );
		$category = $this->getSearchVertical();

		$loggingParams = [
			'method'    => __METHOD__,
			'articleId' => $articleId,
			'num'       => $numRequired,
			'category'  => $category
		];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			$service = new VideoEmbedToolSearchService();
			$service->setLimit( $this->getPaddedVideoLimit( $numRequired ) );

			if ( !empty( $category ) ) {
				$service->getConfig()->setFilterQueryByCode( $category );
			}

			$response = $service->getSuggestedVideosByArticleId( $articleId );

			$videos = [];
			foreach ( $response['items'] as $video ) {
				if ( count( $videos ) >= $numRequired ) {
					break;
				}

				$title = Title::newFromText( $video['title'], NS_FILE );
				if ( $title instanceof Title && $this->addToList( $videos, $title->getDBkey() ) ) {
					$this->existingVideos[$title->getDBkey()] = true;
				}
			}

			// get video detail
			if ( !empty( $videos ) ) {
				$videos = $this->getVideosDetail( $videos, self::SOURCE_ARTICLE );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki.
	 * @param integer $numRequired - number of videos required
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideos( $numRequired ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		$memcKey = wfMemcKey( 'videomodule', 'wiki_related_videos', self::CACHE_VERSION );
		$videos = $this->wg->Memc->get( $memcKey );

		$loggingParams = [ 'method' => __METHOD__, 'num' => $numRequired ];

		if ( !is_array( $videos ) ) {
			$log->info( __METHOD__.' memc MISS', $loggingParams );

			// Strip Wiki off the end of the wiki name if it exists
			$wikiTitle = preg_replace( '/ Wiki$/', '', $this->wg->Sitename );

			$params = [
				'defaultTopic' => $wikiTitle,
				'limit' => $this->getPaddedVideoLimit( self::LIMIT_VIDEOS ),
			];

			$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByWikiTopic', $params )->getData();

			$videos = [];
			foreach ( $videoResults as $video ) {
				if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
					break;
				}

				$videoTitle = preg_replace( '/.+\/File:/', '', urldecode( $video['url'] ) );
				$this->addToList( $videos, $videoTitle );
			}

			// get video detail
			if ( !empty( $videos ) ) {
				$videos = $this->getVideosDetail( $videos, self::SOURCE_WIKI_TITLE );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
	 * @param integer $numRequired - number of videos required
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideosTopics( $numRequired ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		$memcKey = wfMemcKey( 'videomodule', 'wiki_related_videos_topics', self::CACHE_VERSION );
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

			$videos = [];
			foreach ( $videoResults as $video ) {
				if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
					break;
				}

				$videoTitle = preg_replace( '/.+\/File:/', '', urldecode( $video['url'] ) );
				$this->addToList( $videos, $videoTitle );
			}

			// get video detail
			if ( !empty( $videos ) ) {
				$videos = $this->getVideosDetail( $videos, self::SOURCE_WIKI_TOPICS );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		} else {
			$log->info( __METHOD__.' memc HIT', $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Get videos from the Video wiki that are in categories listed in wgVideosModuleCategories
	 * @param integer $numRequired
	 * @return array
	 */
	public function getVideosByCategory( $numRequired ) {
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

		$limit = self::LIMIT_VIDEOS;
		$sort = 'recent';
		$videos = $this->getVideoListFromVideoWiki( $categories, $limit, $sort, self::SOURCE_WIKI_CATEGORIES );

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
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
		$memcKey = wfSharedMemcKey( 'videomodule', 'videolist', self::CACHE_VERSION, $hashCategory, $sort );
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

			$videos = [];
			if ( !empty( $response['videos'] ) ) {
				foreach ( $response['videos'] as $video ) {
					if ( count( $videos ) >= $limit ) {
						break;
					}

					$this->addToList( $videos, $video['title'] );
				}

				// get video detail
				$videos = $this->getVideosDetail( $videos, $source );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
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
		$limit = self::LIMIT_VIDEOS;
		$videos = $this->getVideoListFromVideoWiki( $category, $limit, $sort, self::SOURCE_WIKI_VERTICAL );

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
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
	 * @param string $source The way these videos were generated/found.  Used for logging/debugging
	 * @return array - A list of video details for each title passed
	 */
	public function getVideosDetail( $videos, $source = '' ) {
		wfProfileIn( __METHOD__ );

		$videoList = [];
		if ( !empty( $videos ) ) {
			$helper = new VideoHandlerHelper();
			$videosDetail = $helper->getVideoDetailFromWiki(
				$this->wg->WikiaVideoRepoDBName,
				$videos,
				self::$videoOptions
			);

			foreach( $videosDetail as $video ) {
				$video['source'] = $source;
				$videoList[] = $this->filterVideoDetail( $video );
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
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
	 * Check for valid video and add the video to list
	 * @param array $videos - list of videos
	 * @param string $videoTitle - title of the video (DB key)
	 * @return boolean
	 */
	public function addToList( &$videos, $videoTitle ) {
		if ( !empty( $videoTitle ) && !in_array( $videoTitle, $this->wg->VideosModuleBlackList ) ) {
			if ( !array_key_exists( $videoTitle, $this->existingVideos ) ) {
				$videos[] = $videoTitle;

				return true;
			}
		}

		return false;
	}

	/**
	 * Get video limit (include the number of blacklisted videos)
	 * @param int $numRequired
	 * @return integer
	 */
	protected function getPaddedVideoLimit( $numRequired ) {
		if ( is_null( $this->blacklistCount ) ) {
			$this->blacklistCount = count( $this->wg->VideosModuleBlackList );
		}

		$limit = $numRequired + $this->blacklistCount;

		return $limit;
	}

	/**
	 * Trim a list of videos down to $numRequired and make a note that we're using it
	 * @param array $videos
	 * @param integer $numRequired
	 * @return array
	 */
	protected function trimVideoList( $videos, $numRequired ) {
		array_splice( $videos, $numRequired );
		foreach ( $videos as $video ) {
			$this->existingVideos[$video['videoKey']] = true;
		}

		return $videos;
	}
}
