<?php

class VideosModule extends WikiaModel {

	const THUMBNAIL_WIDTH = 300;
	const THUMBNAIL_HEIGHT = 309;

	const LIMIT_VIDEOS = 20;
	const CACHE_TTL = 3600;
	const CACHE_VERSION = 2;

	const MAX_STAFF_PICKS = 5;

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

		// Try to get the staff video picks from cache first
		$memcKey = wfMemcKey( 'videomodule', 'staff_videos', self::CACHE_VERSION );
		$videos = $this->wg->Memc->get( $memcKey );

		// If none are there call out to the video wiki to look for some
		if ( !is_array( $videos ) ) {

			// Look for picks specific to this wiki.  Don't get a thumbnail
			// since we'll be generating it below
			$params = [
				'controller'   => 'SpecialVideosSpecialController',
				'method'       => 'getVideos',
				'sort'         => 'recent',
				'getThumbnail' => false,
				'category'     => 'Staff_Pick_'.$this->app->wg->DBname,
			];

			$response = ApiService::foreignCall( 'video151', $params, ApiService::WIKIA );
			$wikiResults = empty( $response['videos'] ) ? [] : $response['videos'];

			// Look for global wikia-wide picks
			$params['category'] = 'Staff_Pick_Global';

			$response = ApiService::foreignCall( 'video151', $params, ApiService::WIKIA );
			$globalResults = empty( $response['videos'] ) ? [] : $response['videos'];

			$combinedVideos = array_merge( $wikiResults, $globalResults );

			// Sort the combined array by the updated field, which is YYYY-MM-DD hh:mm:ss
			usort( $combinedVideos, function ( $a, $b ) {
				return strcmp( $b['updated'], $a['updated'] );
			} );

			// Cap the number of videos we send to the front end at MAX_STAFF_PICKS
			$videos = [];
			foreach ( $combinedVideos as $video ) {

				if ( count($videos) >= self::MAX_STAFF_PICKS ) {
					break;
				}

				if ( $this->addToList( $videos, $video['fileKey'] ) ) {
					// Adding videos to the existingVideos array is normally done using trimVideoList. Since there's
					// nothing to trim, just add it to existingVideos directly.
					$this->existingVideos[$video['fileKey']] = true;
				}
			}

			$videos = $this->getVideosDetail( $videos );

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );
		return $videos;
	}

	/**
	 * Get videos added to the wiki
	 * @param integer $numRequired - number of videos required
	 * @param string $sort [recent/trend] - how to sort the results
	 * @return array $videos - list of vertical videos (premium videos)
	 */
	public function getLocalVideos( $numRequired, $sort ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( 'videomodule', 'local_videos', self::CACHE_VERSION, $sort );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
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
					if ( !empty( $videoDetail ) ) {
						$videos[] = $this->filterVideoDetail( $videoDetail );
					}
				}
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Use the VideoEmbedToolSearchService to find premium videos related to the current article.
	 * @param integer $articleId - ID of the article being viewed.
	 * @param integer $numRequired - number of videos required
	 * @return array $videos - Premium videos related to article.
	 */
	public function getArticleRelatedVideos( $articleId, $numRequired ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( 'videomodule', 'article_related_videos', self::CACHE_VERSION, $articleId );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
			$service = new VideoEmbedToolSearchService();
			$service->setLimit( $this->getPaddedVideoLimit( $numRequired ) );

			$category = $this->getSearchVertical();
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
				$videos = $this->getVideosDetail( $videos );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki.
	 * @param integer $numRequired - number of videos required
	 * @return array $videos - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideos( $numRequired ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( 'videomodule', 'wiki_related_videos', self::CACHE_VERSION );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
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
				$videos = $this->getVideosDetail( $videos );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
	 * @param integer $numRequired - number of videos required
	 * @return array $videos - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideosTopics( $numRequired ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( 'videomodule', 'wiki_related_videos_topics', self::CACHE_VERSION );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
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
				$videos = $this->getVideosDetail( $videos );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Get videos by category from the wiki
	 * @param integer $numRequired - number of videos required
	 * @param string $sort [recent/trend] - how to sort the results
	 * @return array $videos - list of vertical videos (premium videos)
	 */
	public function getVerticalVideos( $numRequired, $sort ) {
		wfProfileIn( __METHOD__ );

		$category = $this->getWikiVertical();
		$memcKey = wfSharedMemcKey( 'videomodule', 'vertical_videos', self::CACHE_VERSION, $category, $sort );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
			$params = [
				'controller' => 'VideoHandler',
				'method'     => 'getVideoList',
				'sort'       => $sort,
				'limit'      => $this->getPaddedVideoLimit( self::LIMIT_VIDEOS ),
				'category'   => $category,
			];

			$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );

			$videos = [];
			if ( !empty( $response['videos'] ) ) {
				foreach ( $response['videos'] as $video ) {
					if ( count( $videos ) >= self::LIMIT_VIDEOS ) {
						break;
					}

					$this->addToList( $videos, $video['title'] );
				}

				// get video detail
				$videos = $this->getVideosDetail( $videos );
			}

			$this->wg->Memc->set( $memcKey, $videos, self::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );

		return $this->trimVideoList( $videos, $numRequired );
	}

	/**
	 * Get wiki vertical
	 * @return string $name - wiki vertical
	 */
	public function getWikiVertical() {
		wfProfileIn( __METHOD__ );

		$name = '';

		$categoryId = WikiFactoryHub::getCategoryId( $this->wg->CityId );
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
	 * @return string $name - search vertical
	 */
	public function getSearchVertical() {
		wfProfileIn( __METHOD__ );

		$name = '';

		$categoryId = WikiFactoryHub::getCategoryId( $this->wg->CityId );
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
	 * @return array A list of video details for each title passed
	 */
	public function getVideosDetail( $videos ) {
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
	 * @return array $videos
	 */
	protected function trimVideoList( $videos, $numRequired ) {
		array_splice( $videos, $numRequired );
		foreach ( $videos as $video ) {
			$this->existingVideos[$video['videoKey']] = true;
		}

		return $videos;
	}
}
