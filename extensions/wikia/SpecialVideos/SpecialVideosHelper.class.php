<?php

/**
 * SpecialVideos Helper
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosHelper extends WikiaModel {

	const THUMBNAIL_WIDTH = 330;
	const THUMBNAIL_HEIGHT = 211;
	const POSTED_IN_ARTICLES = 5;

	public static $verticalCategoryFilters = [ "Games", "Lifestyle", "Entertainment" ];

	/**
	 * Get meta description tag
	 * @return string $description
	 */
	public function getMetaTagDescription() {
		$catInfo = HubService::getComscoreCategory( $this->wg->CityId );

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
	 * get list of sorting options
	 * @return array $options
	 */
	public function getSortOptions() {
		$options = $this->getSortOptionsMobile();
		$options['popular'] = wfMessage( 'specialvideos-sort-most-popular' )->plain();

		return $options;
	}

	/**
	 * get list of sorting options for mobile
	 * @return array $options
	 */
	public function getSortOptionsMobile() {
		$options = array(
			'trend'   => wfMessage( 'specialvideos-sort-trending' )->plain(),
			'recent'  => wfMessage( 'specialvideos-sort-latest' )->plain(),
		);

		return $options;
	}

	/**
	 * get list of filter options
	 * @return array $options
	 */
	public function getFilterOptions() {
		$options = array();

		$premiumVideos = $this->premiumVideosExist();
		if ( !empty( $premiumVideos ) ) {
			$options['premium'] = wfMessage( 'specialvideos-sort-featured' )->text();
		}

		if ( $this->wg->UseVideoVerticalFilters ) {
			$options['trend:Games'] = wfMessage( 'specialvideos-filter-games' )->text();
			$options['trend:Lifestyle'] = wfMessage( 'specialvideos-filter-lifestyle' )->text();
			$options['trend:Entertainment'] = wfMessage( 'specialvideos-filter-entertainment' )->text();
		}

		return $options;
	}

	/**
	 * get list of videos
	 * @param string $sort [recent/popular/trend]
	 * @param integer $limit
	 * @param integer $page
	 * @param array $providers
	 * @param string $category
	 * @return array $videos
	 */
	public function getVideos( $sort, $limit, $page, $providers = array(), $category = '' ) {
		wfProfileIn( __METHOD__ );

		if ( $sort == 'premium' ) {
			$sort = 'recent';
			$filter = 'premium';
		} else {
			$filter = 'all';
		}

		$mediaService = new MediaQueryService();
		$videoList = $mediaService->getVideoList( $sort, $filter, $limit, $page, $providers, $category );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$thumbOptions = [
				'useTemplate' => true,
				'fluid'       => true,
				'forceSize'   => 'small',
			];
		} else {
			$thumbOptions = [
				'showViews'   => true,
				'fixedHeight' => self::THUMBNAIL_HEIGHT,
			];
		}

		$thumbParams = [
			'width'        => self::THUMBNAIL_WIDTH,
			'height'       => self::THUMBNAIL_HEIGHT,
			'thumbOptions' => $thumbOptions,
			'getThumb'     => true,
		];

		$videos = [];
		$helper = new VideoHandlerHelper();
		foreach ( $videoList as $videoInfo ) {
			$videoDetail = $helper->getVideoDetail( $videoInfo, $thumbParams, self::POSTED_IN_ARTICLES );
			if ( !empty( $videoDetail ) ) {
				$byUserMsg = $this->getByUserMsg( $videoDetail['userName'], $videoDetail['userUrl'] );
				$postedInMsg = $this->getPostedInMsg( $videoDetail['truncatedList'], $videoDetail['isTruncated'] );
				$viewTotal = wfMessage( 'videohandler-video-views', $this->wg->Lang->formatNum( $videoDetail['viewsTotal'] ) )->text();

				$videos[] = [
					'title' => $videoDetail['fileTitle'],
					'fileKey' => $videoDetail['title'],
					'fileUrl' => $videoDetail['fileUrl'],
					'thumbnail' => $videoDetail['thumbnail'],
					'timestamp' => wfTimeFormatAgo( $videoDetail['timestamp'] ),
					'viewTotal' => $viewTotal,
					'byUserMsg' => $byUserMsg,
					'postedInMsg' => $postedInMsg,
				];
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * get message for by user section
	 * @param string $userName
	 * @param string $userUrl
	 * @return string $byUserMsg
	 */
	public function getByUserMsg( $userName, $userUrl ) {
		$byUserMsg = '';
		if ( !empty( $userName ) ) {
			$attribs = array(
				'href' => $userUrl,
				'class' => 'wikia-gallery-item-user',
			);

			$userLink = Xml::element( 'a', $attribs, $userName, false );
			$byUserMsg = wfMessage( 'specialvideos-uploadby', $userLink )->text();
		}

		return $byUserMsg;
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

}
