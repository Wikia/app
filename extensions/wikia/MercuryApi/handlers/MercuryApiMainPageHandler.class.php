<?php

use Wikia\Logger\WikiaLogger;

class MercuryApiMainPageHandler {

	public static function getMainPageData( MercuryApi $mercuryApiModel ) {
		$mainPageData = [ ];
		$curatedContent = self::getCuratedContentData( $mercuryApiModel );
		$trendingArticles = self::getTrendingArticlesData( $mercuryApiModel );
		$trendingVideos = self::getTrendingVideosData( $mercuryApiModel );
		$wikiaStats = self::getWikiaStatsData();

		if ( !empty( $curatedContent[ 'items' ] ) ) {
			$mainPageData[ 'curatedContent' ] = $curatedContent[ 'items' ];
		}

		if ( !empty( $curatedContent[ 'featured' ] ) ) {
			$mainPageData[ 'featuredContent' ] = $curatedContent[ 'featured' ];
		}

		if ( !empty( $trendingArticles ) ) {
			$mainPageData[ 'trendingArticles' ] = $trendingArticles;
		}

		if ( !empty( $trendingVideos ) ) {
			$mainPageData[ 'trendingVideos' ] = $trendingVideos;
		}

		if ( !empty( $wikiaStats ) ) {
			$mainPageData[ 'wikiaStats' ] = $wikiaStats;
		}

		return $mainPageData;
	}

	public static function getCuratedContentData( MercuryApi $mercuryApiModel, $section = null ) {
		$data = [ ];

		try {
			$data = WikiaDataAccess::cache(
				self::curatedContentDataMemcKey( $section ),
				WikiaResponse::CACHE_STANDARD,
				function () use ( $mercuryApiModel, $section ) {
					$rawData = F::app()->sendRequest(
						'CuratedContent',
						'getList',
						empty( $section ) ? [ ] : [ 'section' => $section ]
					)->getData();

					return $mercuryApiModel->processCuratedContent( $rawData );
				}
			);
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Curated content and categories are empty' );
		}

		return $data;
	}

	private static function getTrendingArticlesData( MercuryApi $mercuryApiModel ) {
		global $wgContentNamespaces;

		$params = [
			'abstract' => false,
			'expand' => true,
			'limit' => 10,
			'namespaces' => implode( ',', $wgContentNamespaces )
		];
		$data = [ ];

		try {
			$rawData = F::app()->sendRequest( 'ArticlesApi', 'getTop', $params )->getData();
			$data = $mercuryApiModel->processTrendingArticlesData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending articles data is empty' );
		}

		return $data;
	}

	private static function getTrendingVideosData( MercuryApi $mercuryApiModel ) {
		$params = [
			'sort' => 'trend',
			'getThumbnail' => false,
			'format' => 'json',
		];
		$data = [ ];

		try {
			$rawData = F::app()->sendRequest( 'SpecialVideosSpecial', 'getVideos', $params )->getData();
			$data = $mercuryApiModel->processTrendingVideoData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending videos data is empty' );
		}

		return $data;
	}

	private static function getWikiaStatsData() {
		global $wgCityId;

		$service = new WikiDetailsService();
		$wikiDetails = $service->getWikiDetails( $wgCityId );

		return $wikiDetails[ 'stats' ];
	}

	public static function curatedContentDataMemcKey( $section = null ) {
		return wfMemcKey( 'curated-content-section-data', $section );
	}

	public static function shouldGetMainPageData( $isMainPage ) {
		global $wgEnableMainPageDataMercuryApi, $wgCityId;

		return $isMainPage &&
		!empty( $wgEnableMainPageDataMercuryApi ) &&
		( new CommunityDataService( $wgCityId ) )->hasData();
	}

	/**
	 * @TODO XW-1174 - rethink this
	 * We need to define which details we should send and from where we should fetch it when article doesn't exist
	 *
	 * @param Title $title
	 * @return array
	 */
	public static function getMainPageMockedDetails( Title $title ) {
		return [
			'ns' => 0,
			'title' => $title->getText(),
			'revision' => []
		];
	}
}
