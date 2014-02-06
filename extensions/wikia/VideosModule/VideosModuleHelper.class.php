<?php

class VideosModuleHelper extends WikiaModel {

	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	// We don't care where else this video has been posted, we just want to display it
	const POSTED_IN_ARTICLES = 0;
	const VIDEO_LIMIT = 20;
	const GET_THUMB = true;

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

		$videos = array();
		foreach ( $response['items'] as $video ) {
			if ( count( $videos ) >= self::VIDEO_LIMIT ) {
				break;
			}

			$title = Title::newFromText( $video['title'], NS_FILE );
			if ( !$title instanceof Title ) {
				continue;
			}

			$this->addToList( $videos, $title->getDBkey() );
		}

		wfProfileOut( __METHOD__ );

		return $videos;

	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki.
	 * @param array $videos - existing videos list
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideos( $videos ) {
		wfProfileIn( __METHOD__ );

		// Strip Wiki off the end of the wiki name if it exists
		$wikiTitle = preg_replace( '/ Wiki$/', '', $this->wg->Sitename );

		$params = [
			'title' => $wikiTitle,
			'limit' => $this->getVideoLimit( $videos )
		];
		$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )->getData();

		shuffle( $videoResults );

		foreach ( $videoResults as $video ) {
			if ( count( $videos ) >= self::VIDEO_LIMIT ) {
				break;
			}

			$videoTitle = preg_replace( '/.+\/File:/', '', urldecode( $video['url'] ) );
			$this->addToList( $videos, $videoTitle );
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get videos by category from the wiki
	 * @param array $videos
	 * @return array $videos
	 */
	public function getVerticalVideos( $videos ) {
		wfProfileIn( __METHOD__ );

		$params = [
			'controller' => 'VideoHandler',
			'method'     => 'getVideoList',
			'limit'      => $this->getVideoLimit( $videos ),
			'category'   => $this->getWikiVertical(),
		];

		$response = ApiService::foreignCall( $this->wg->WikiaVideoRepoDBName, $params, ApiService::WIKIA );
		if ( !empty( $response['videos'] ) ) {
			foreach ( $response['videos'] as $video ) {
				if ( count( $videos ) >= self::VIDEO_LIMIT ) {
					break;
				}

				$this->addToList( $videos, $video['title'] );
			}
		}

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
	 * Add video to the list
	 * @param array $videoList
	 * @param string $videoTitle - title of the video
	 */
	public function addToList( &$videoList, $videoTitle ) {
		if ( !empty( $videoTitle ) && !$this->isBlacklist( $videoTitle ) ) {
			$hash = md5( $videoTitle );
			if ( !array_key_exists( $hash, $videoList ) ) {
				$helper = new VideoHandlerHelper();
				$videoDetail = $helper->getVideoDetailFromWiki(
						$this->wg->WikiaVideoRepoDBName,
						$videoTitle,
						self::THUMBNAIL_WIDTH,
						self::THUMBNAIL_HEIGHT,
						self::POSTED_IN_ARTICLES,
						self::GET_THUMB
				);

				if ( !empty( $videoDetail ) ) {
					$videoList[$hash] = $videoDetail;
				}
			}
		}
	}

	/**
	 * Check if the video is in blacklist
	 * @param string $videoTitle - DB key name
	 * @return boolean $result
	 */
	public function isBlacklist( $videoTitle ) {
		$result = in_array( $videoTitle, $this->wg->VideosModuleBlackList );

		return $result;
	}

	/**
	 * Get video limit
	 * @param array $videos
	 * @return integer $limit
	 */
	public function getVideoLimit( $videos = array() ) {
		$limit = self::VIDEO_LIMIT - count( $videos ) + count( $this->wg->VideosModuleBlackList );
		return $limit;
	}

}
