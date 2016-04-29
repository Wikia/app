<?php

/**
 * SpecialVideos Helper
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosHelper extends WikiaModel {

	const THUMBNAIL_WIDTH = 330;
	const THUMBNAIL_HEIGHT = 211;
	const POSTED_IN_ARTICLES = 100;

	const VIDEOS_PER_PAGE = 24;
	const VIDEOS_PER_PAGE_MOBILE = 12;

	public static $verticalCategoryFilters = [ "Games", "Lifestyle", "Entertainment" ];

	/**
	 * Get meta description tag
	 * @return string $description
	 */
	public function getMetaTagDescription() {
		$catInfo = HubService::getCategoryInfoForCity( $this->wg->CityId );

		$descriptionKey = 'specialvideos-meta-description';

		switch ( $catInfo->cat_id ) {
			case WikiFactoryHub::CATEGORY_ID_GAMING:
				$descriptionKey .= '-gaming';
				break;
			case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
				$descriptionKey .= '-entertainment';
				break;
			case WikiFactoryHub::CATEGORY_ID_LIFESTYLE:
				$descriptionKey .= '-lifestyle';
				break;
			case WikiFactoryHub::CATEGORY_ID_CORPORATE:
				$descriptionKey .= '-corporate';
				break;
		}

		$description = wfMessage( $descriptionKey, $this->wg->Sitename )->escaped();

		return $description;
	}

	/**
	 * get list of videos
	 * @param integer $page
	 * @param string $filter [all/premium]
	 * @param array $providers
	 * @param string $category
	 * @param array $options
	 * @return array $videos
	 */
	public function getVideos( $page, $filter = 'all', $providers = [], $category = '', $options = [] ) {
		wfProfileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$limit = self::VIDEOS_PER_PAGE_MOBILE;
			$providers = $this->wg->WikiaMobileSupportedVideos;
			$thumbOptions = [
				'useTemplate' => true,
				'fluid'       => true,
				'forceSize'   => 'small',
				'img-class'    => 'media',
				'dataParams'  => true,
			];
		} else {
			$limit = self::VIDEOS_PER_PAGE;
			$providers = empty( $providers ) ? [] : explode( ',', $providers );
			$thumbOptions = [
				'fluid'          => true,
				'showViews'      => true,
				'fixedHeight'    => self::THUMBNAIL_HEIGHT,
				'hidePlayButton' => true,
			];
		}

		// get video list
		$mediaService = new MediaQueryService();
		$videoList = $mediaService->getVideoList( $filter, $limit, $page, $providers, $category );

		$videoOptions = [
			'thumbWidth'       => self::THUMBNAIL_WIDTH,
			'thumbHeight'      => self::THUMBNAIL_HEIGHT,
			'postedInArticles' => self::POSTED_IN_ARTICLES,
			'thumbOptions'     => $thumbOptions,
			'getThumbnail'     => ( array_key_exists( 'getThumbnail', $options) ? $options['getThumbnail'] : true ),
		];

		// get video detail
		$videos = [];
		$helper = new VideoHandlerHelper();
		foreach ( $videoList as $videoInfo ) {
			$videoDetail = $helper->getVideoDetail( $videoInfo, $videoOptions );
			if ( !empty( $videoDetail ) ) {
				$byUserMsg = WikiaFileHelper::getByUserMsg( $videoDetail['userName'], $videoDetail['timestamp'] );

				$videos[] = [
					'title' => $videoDetail['fileTitle'],
					'fileKey' => $videoDetail['title'],
					'fileUrl' => $videoDetail['fileUrl'],
					'thumbnail' => $videoDetail['thumbnail'],
					'timestamp' => wfTimeFormatAgo( $videoDetail['timestamp'], false ),
					'updated' => $videoDetail['timestamp'],
					'byUserMsg' => $byUserMsg,
					'truncatedList' => $videoDetail['truncatedList'],
					'duration' => $videoDetail['duration'],
					'thumbUrl' => $videoDetail['thumbUrl'],
					'embedUrl' => $videoDetail['embedUrl'],
				];
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get a count of videos that would be returned by $videoParams when passed to getVideos()
	 * @param array $videoParams
	 *   [ array( 'sort' => string, 'page' => int, 'category' => string, 'provider' => string ) ]
	 * @return integer $totalVideos
	 */
	protected function getTotalVideos( $videoParams ) {
		wfProfileIn( __METHOD__ );

		$mediaService = new MediaQueryService();
		if ( $videoParams['sort'] == 'premium' ) {
			$totalVideos = $mediaService->getTotalPremiumVideos();
		} else if ( !empty( $videoParams['category'] ) ) {
			$totalVideos = $mediaService->getTotalVideosByCategory( $videoParams['category'] );
		} else {
			$totalVideos = $mediaService->getTotalVideos();
		}
		$totalVideos = $totalVideos + 1; // adding 'add video' placeholder to video array count

		wfProfileOut( __METHOD__ );

		return $totalVideos;
	}

	/**
	 * get html tag for article
	 * @param array $article
	 * @return string $articleLink
	 */
	protected function getArticleLink( $article ) {
		$attribs = array(
			'href' => $article['url'],
		);

		$articleLink = Xml::element( 'a', $attribs, $article['titleText'], false );

		return $articleLink;
	}

	/**
	 * get message for by posted in section
	 * @param array $truncatedList
	 * @param integer $isTruncated [0/1]
	 * @return string $postedInMsg
	 */
	public function getPostedInMsg( $truncatedList, $isTruncated ) {
		$postedInMsg = '';
		$articleLinks = array();
		foreach ( $truncatedList as $article ) {
			$articleLinks[] = $this->getArticleLink( $article );
		}

		if ( !empty( $articleLinks ) ) {
			$postedInMsg = wfMessage( 'specialvideos-posted-in', implode( $articleLinks, ', ' ) )->text();
		}

		return $postedInMsg;
	}

	/**
	 * check if premium video exists
	 * @return integer $videoExist [0/1]
	 */
	public function premiumVideosExist() {
		$mediaService = new MediaQueryService();
		$videoExist = (bool) $mediaService->getTotalPremiumVideos();

		return $videoExist;
	}

	/**
	 * Get pagination (HTML)
	 *
	 * Return pagination bar under "body" key.
	 * Return head item (with <link rel="next/prev">) under "head" key
	 *
	 * @param array $videoParams
	 *   [ array( 'sort' => string, 'page' => int, 'category' => string, 'provider' => string ) ]
	 * @param int $addVideo
	 * @return array $pagination
	 *   [ array( 'body' => string, 'head' => string ) ]
	 */
	public function getPagination( $videoParams, &$addVideo  ) {
		wfProfileIn( __METHOD__ );

		$body = '';
		$head = '';
		$totalVideos = $this->getTotalVideos( $videoParams );

		if ( $totalVideos > self::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromCount( $totalVideos, self::VIDEOS_PER_PAGE );
			$pages->setActivePage( $videoParams['page'] );

			$urlTemplate = SpecialPage::getTitleFor( 'Videos' )->escapeLocalUrl();
			$urlTemplate .= '?page=%s';
			foreach( [ 'sort', 'category', 'provider'] as $key ) {
				if ( !empty( $videoParams[$key] ) ) {
					$urlTemplate .= "&$key=" . urlencode( $videoParams[$key] );
				}
			}

			$body = $pages->getBarHTML( $urlTemplate );
			$head = $pages->getHeadItem( $urlTemplate );

			// check if we're on the last page
			if ( $videoParams['page'] < $pages->getPagesCount() ) {
				// we're not so don't show the add video placeholder
				$addVideo = 0;
			}
		}

		wfProfileOut( __METHOD__ );

		return [
			'body' => $body,
			'head' => $head,
		];
	}

}
