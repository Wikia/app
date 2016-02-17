<?php

class MercuryApiCuratedMainPageHander {
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
					$rawData = $this->sendRequest(
						'CuratedContent',
						'getList',
						empty( $section ) ? [ ] : [ 'section' => $section ]
					)->getData();

					return $this->mercuryApi->processCuratedContent( $rawData );
				}
			);
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Curated content and categories are empty' );
		}

		return $data;
	}
}
