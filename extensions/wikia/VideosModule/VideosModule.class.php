<?php

class VideosModule extends WikiaModel {

	const THUMBNAIL_WIDTH = 300;
	const THUMBNAIL_HEIGHT = 309;
	// We don't care where else this video has been posted, we just want to display it
	const POSTED_IN_ARTICLES = 0;
	const GET_THUMB = true;

	const LIMIT_TRENDING_VIDEOS = 20;
	const CACHE_TTL = 3600;
	const CACHE_VERSION = 1;

	protected $blacklistCount = null;	// number of blacklist videos
	protected $existingVideos = [];		// list of existing vides [ titleKey => true ]

	// list of page categories [ array( categoryId => name ) ]
	protected static $pageCategories = [
		2 => 'Games',
		3 => 'Entertainment',
		9 => 'Lifestyle',
	];

	/**
	 * Get related videos (article related videos and wiki related videos)
	 * @param integer $articleId
	 * @param integer $numRequired - number of videos required
	 * @return array $videos - list of related videos
	 */
	public function getRelatedVideos( $articleId, $numRequired ) {
		// get article related videos
		$videos = $this->getArticleRelatedVideos( $articleId, $numRequired );

		// Add videos from getWikiRelatedVideos if we didn't hit our video count limit
		$numRequired = $numRequired - count( $videos );
		if ( $numRequired > 0 ) {
			$videos = array_merge( $videos, $this->getWikiRelatedVideos( $numRequired ) );
		}

		return $videos;
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
			$service->setLimit( $this->getVideoLimit( $numRequired ) );
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
				'title' => $wikiTitle,
				'limit' => $this->getVideoLimit( self::LIMIT_TRENDING_VIDEOS ),
			];

			$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )->getData();

			$videos = [];
			foreach ( $videoResults as $video ) {
				if ( count( $videos ) >= self::LIMIT_TRENDING_VIDEOS ) {
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
	 * @return array $videos - list of vertical videos (premium videos)
	 */
	public function getVerticalVideos( $numRequired ) {
		wfProfileIn( __METHOD__ );

		$category = $this->getWikiVertical();
		$memcKey = wfSharedMemcKey( 'videomodule', 'vertical_videos', self::CACHE_VERSION, $category );
		$videos = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $videos ) ) {
			$params = [
				'controller' => 'VideoHandler',
				'method'     => 'getVideoList',
				'sort'       => 'trend',
				'limit'      => $this->getVideoLimit( self::LIMIT_TRENDING_VIDEOS ),
				'category'   => $category,
			];

			$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );

			$videos = [];
			if ( !empty( $response['videos'] ) ) {
				foreach ( $response['videos'] as $video ) {
					if ( count( $videos ) >= self::LIMIT_TRENDING_VIDEOS ) {
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
	 * Get detail of the videos
	 * @param array $videos - list of video title
	 * @return array $videoList
	 */
	public function getVideosDetail( $videos ) {
		wfProfileIn( __METHOD__ );

		$videoList = [];
		if ( !empty( $videos ) ) {
			$helper = new VideoHandlerHelper();
			$videosDetail = $helper->getVideoDetailFromWiki(
				$this->wg->WikiaVideoRepoDBName,
				$videos,
				self::THUMBNAIL_WIDTH,
				self::THUMBNAIL_HEIGHT,
				self::POSTED_IN_ARTICLES,
				self::GET_THUMB
			);

			foreach( $videosDetail as $video ) {
				$videoList[] = [
					'title'     => $video['fileTitle'],
					'url'       => $video['fileUrl'],
					'thumbnail' => $video['thumbnail'],
					'videoKey'  => $video['title'],
				];
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
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
	 * @return integer $limit
	 */
	protected function getVideoLimit( $numRequired ) {
		if ( is_null( $this->blacklistCount ) ) {
			$this->blacklistCount = count( $this->wg->VideosModuleBlackList );
		}

		$limit = $numRequired + $this->blacklistCount;

		return $limit;
	}

	/**
	 * Trim randomized list of videos
	 * @param array $videos
	 * @param integer $numRequired
	 * @return array $videos
	 */
	protected function trimVideoList( $videos, $numRequired ) {
		shuffle( $videos );
		array_splice( $videos, $numRequired );
		foreach ( $videos as $video ) {
			$this->existingVideos[$video['videoKey']] = true;
		}

		return $videos;
	}

}
