<?php

class VideosModule extends WikiaModel {

	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	// We don't care where else this video has been posted, we just want to display it
	const POSTED_IN_ARTICLES = 0;
	const VIDEO_LIMIT = 20;
	const GET_THUMB = true;

	protected $blacklistCount = null;	// number of blacklist videos
	protected $existingVideos = [];		// list of existing vides [ hash => title ]

	/**
	 * Use the VideoEmbedToolSearchService to find premium videos related to the current article.
	 * @param integer $articleId - ID of the article being viewed.
	 * @return array $videos - Premium videos related to article.
	 */
	public function getArticleRelatedVideos( $articleId ) {
		wfProfileIn( __METHOD__ );

		$service = new VideoEmbedToolSearchService();
		$service->setLimit( $this->getVideoLimit() );
		$response = $service->getSuggestedVideosByArticleId( $articleId );

		$videos = [];
		foreach ( $response['items'] as $video ) {
			if ( count( $this->existingVideos ) >= self::VIDEO_LIMIT ) {
				break;
			}

			$title = Title::newFromText( $video['title'], NS_FILE );
			if ( $title instanceof Title && $this->isValidVideo( $title->getDBkey() ) ) {
				$videos[] = $title->getDBkey();
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;

	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki.
	 * @return array $videos - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideos() {
		wfProfileIn( __METHOD__ );

		// Strip Wiki off the end of the wiki name if it exists
		$wikiTitle = preg_replace( '/ Wiki$/', '', $this->wg->Sitename );

		$params = [
			'title' => $wikiTitle,
			'limit' => $this->getVideoLimit(),
		];
		$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )->getData();

		$videos = [];
		foreach ( $videoResults as $video ) {
			if ( count( $this->existingVideos ) >= self::VIDEO_LIMIT ) {
				break;
			}

			$videoTitle = preg_replace( '/.+\/File:/', '', urldecode( $video['url'] ) );
			if ( $this->isValidVideo( $videoTitle ) ) {
				$videos[] = $videoTitle;
			}
		}

		shuffle( $videos );

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get videos by category from the wiki
	 * @return array $videos - list of vertical videos (premium videos)
	 */
	public function getVerticalVideos() {
		wfProfileIn( __METHOD__ );

		$videos = [];

		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'getVideoList',
			'limit'      => $this->getVideoLimit(),
			'category'   => $this->getWikiVertical(),
		];

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( !empty( $response['videos'] ) ) {
			foreach ( $response['videos'] as $video ) {
				if ( count( $this->existingVideos ) >= self::VIDEO_LIMIT ) {
					break;
				}

				if ( $this->isValidVideo( $video['title'] ) ) {
					$videos[] = $video['title'];
				}
			}
		}

		shuffle( $videos );

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get wiki vertical
	 * @return string $name - wiki vertical
	 */
	public function getWikiVertical() {
		wfProfileIn( __METHOD__ );

		$categoryId = WikiFactoryHub::getCategoryId( $this->wg->CityId );
		$verticalId = HubService::getCanonicalCategoryId( $categoryId );

		// get category name
		$category = WikiFactoryHub::getInstance()->getCategory( $verticalId );
		$name = empty( $category['name'] ) ? '' : $category['name'];

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
					'title'     => $video['title'],
					'fileTitle' => $video['fileTitle'],
					'fileUrl'   => $video['fileUrl'],
					'thumbnail' => $video['thumbnail'],
				];
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * Check for valid video
	 * @param string $videoTitle - title of the video (DB key)
	 * @return boolean $isValid
	 */
	public function isValidVideo( $videoTitle ) {
		wfProfileIn( __METHOD__ );

		$isValid = false;
		if ( !empty( $videoTitle ) && !in_array( $videoTitle, $this->wg->VideosModuleBlackList ) ) {
			$hash = md5( $videoTitle );
			if ( !array_key_exists( $hash, $this->existingVideos ) ) {
				$this->existingVideos[$hash] = $videoTitle;
				$isValid = true;
			}
		}

		wfProfileOut( __METHOD__ );

		return $isValid;
	}

	/**
	 * Get video limit
	 * @return integer $limit
	 */
	public function getVideoLimit() {
		if ( is_null( $this->blacklistCount ) ) {
			$this->blacklistCount = count( $this->wg->VideosModuleBlackList );
		}

		$limit = self::VIDEO_LIMIT + $this->blacklistCount;

		return $limit;
	}

}
