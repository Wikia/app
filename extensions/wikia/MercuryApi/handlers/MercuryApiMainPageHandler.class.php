<?php

use Wikia\Logger\WikiaLogger;

class MercuryApiMainPageHandler {

	/**
	 * @var MercuryApi
	 */
	private $mercuryApiModel = null;

	public function __construct(MercuryApi $mercuryApiModel) {
		$this->mercuryApiModel = $mercuryApiModel;
	}

	public function getMainPageData() {
		$mainPageData = [ ];
		$curatedContent = $this->getCuratedContentData();
		$trendingArticles = $this->getTrendingArticlesData();
		$trendingVideos = $this->getTrendingVideosData();
		$wikiaStats = $this->getWikiaStatsData();

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

	public function getCuratedContentData( $section = null ) {
		$data = [ ];

		try {
			$data = WikiaDataAccess::cache(
				self::curatedContentDataMemcKey( $section ),
				WikiaResponse::CACHE_STANDARD,
				function () use ( $section ) {
					$rawData = F::app()->sendRequest(
						'CuratedContent',
						'getList',
						empty( $section ) ? [ ] : [ 'section' => $section ]
					)->getData();

					return $this->mercuryApiModel->processCuratedContent( $rawData );
				}
			);
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Curated content and categories are empty' );
		}

		return $data;
	}

	private function getTrendingArticlesData() {
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
			$data = $this->mercuryApiModel->processTrendingArticlesData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending articles data is empty' );
		}

		return $data;
	}

	private function getTrendingVideosData() {
		$params = [
			'sort' => 'trend',
			'getThumbnail' => false,
			'format' => 'json',
		];
		$data = [ ];

		try {
			$rawData = F::app()->sendRequest( 'SpecialVideosSpecial', 'getVideos', $params )->getData();
			$data = $this->mercuryApiModel->processTrendingVideoData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending videos data is empty' );
		}

		return $data;
	}

	private function getWikiaStatsData() {
		global $wgCityId;

		$service = new WikiDetailsService();
		$wikiDetails = $service->getWikiDetails( $wgCityId );

		return $wikiDetails[ 'stats' ];
	}

	public static function curatedContentDataMemcKey( $section = null ) {
		return wfMemcKey( 'curated-content-section-data', $section );
	}

	public function shouldGetMainPageData( $isMainPage ) {
	global $wgEnableMainPageDataMercuryApi, $wgCityId;

		return $isMainPage &&
		!empty( $wgEnableMainPageDataMercuryApi ) &&
		( new CommunityDataService( $wgCityId ) )->hasData();
	}

}
