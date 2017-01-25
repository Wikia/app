<?php

use Wikia\Logger\WikiaLogger;

class MercuryApiMainPageHandler {

	// TODO: remove $newFormat param after release release of XW-2590 (XW-2625)
	public static function getMainPageData( MercuryApi $mercuryApiModel, $newFormat=false ) {
		$mainPageData = [ ];
		$curatedContent = self::getCuratedContentData( $mercuryApiModel, null, $newFormat );
		$trendingArticles = self::getTrendingArticlesData( $mercuryApiModel );
		$trendingVideos = self::getTrendingVideosData( $mercuryApiModel );
		$wikiaStats = self::getWikiaStatsData();
		$wikiDescription = self::getWikiDescription();

		if ( !empty( $curatedContent[ 'items' ] ) ) {
			if ( $newFormat ) {
				$mainPageData[ 'curatedContent' ]['items'] = $curatedContent['items'];
			} else {
				// TODO: remove this else block after release release of XW-2590 (XW-2625)
				$mainPageData[ 'curatedContent' ] = $curatedContent[ 'items' ];
			}
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

		if ( !empty( $wikiDescription ) ) {
			$mainPageData[ 'wikiDescription' ] = $wikiDescription;
		}

		return $mainPageData;
	}

	public static function getCuratedContentData( MercuryApi $mercuryApiModel, $section = null, $newFormat=false ) {
		// TODO: remove $newFormat param after release release of XW-2590 (XW-2625)
		$data = [ ];
		try {
			$data = WikiaDataAccess::cache(
				self::curatedContentDataMemcKey( $section . ( $newFormat ? '_new' : '' ) ),
				WikiaResponse::CACHE_STANDARD,
				function () use ( $mercuryApiModel, $section, $newFormat ) {
					$rawData = F::app()->sendRequest(
						'CuratedContent',
						'getList',
						empty( $section ) ? [ ] : [ 'section' => $section ]
					)->getData();

					return $mercuryApiModel->processCuratedContent( $rawData, $newFormat );
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

	/**
	 * Fetches wiki description (aka "Promote your wiki" description)
	 *
	 * @return string
	 */
	private static function getWikiDescription() {
		return (new CommunityDataService( F::app()->wg->CityId ))->getCommunityDescription();
	}
}
