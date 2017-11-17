<?php

/**
 * A model for the Curated Content controller
 *
 */
class CuratedContentModel {
	/**
	 * the WikiFactory toggle that qualifies a wiki for being listed in the app
	 */
	const WF_WIKI_RECOMMEND_VAR = 'wgWikiaCuratedContentRecommend';
	const MEMCHACHE_KEY_PREFIX = 'CuratedContent';
	const CACHE_DURATION = 86400; // 24h
	const SEARCH_RESULTS_LIMIT = 100;
	const ITEM_RESULTS_LIMIT = 0; // no limits for now

	private $app;

	function __construct() {
		$this->app = F::app();
	}

	/*
	 * @brief Gets a list of recommended wikis through WikiFactory
	 *
	 * @param integer $limit [OPTIONAL] the maximum number of results
	 * @param int $batch [OPTIONAL] the batch of results, used only when $limit is passed in
	 *
	 * @return array a paginated batch (see wfPaginateArray), each item is an hash with the following keys:
	 * * string name wiki's name
	 * * string color wiki's wordmark text color
	 * * string backgroundColor wiki's background color
	 * * string domain wiki's domain
	 * * wordmarkUrl wiki's wordmark image URL
	 *
	 * @see wfPaginateArray
	 */
	public function getWikisList( $limit = null, $batch = 1 ) {
		wfProfileIn( __METHOD__ );

		$cacheKey = $this->generateCacheKey( __METHOD__ );
		$games = $this->loadFromCache( $cacheKey );

		if ( empty( $games ) ) {
			$games = Array();
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_WIKI_RECOMMEND_VAR, null );

			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );

				foreach ( $recommendedIds as $wikiId ) {
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$wikiGames = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
					$wikiDomain = preg_replace( '!^https?://!', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ) );
					$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId );
					$wordmarkUrl = $wikiThemeSettings['wordmark-image-url'];
					$wordmarkType = $wikiThemeSettings['wordmark-type'];
					// $wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );

					$games[] = Array(
						'name' => ( !empty( $wikiThemeSettings['wordmark-text'] ) ) ? $wikiThemeSettings['wordmark-text'] : $wikiName,
						'games' => ( !empty( $wikiGames ) ) ? $wikiGames : '',
						'color' => ( !empty( $wikiThemeSettings['wordmark-color'] ) ) ? $wikiThemeSettings['wordmark-color'] : '#0049C6',
						'backgroundColor' => ( !empty( $wikiThemeSettings['color-page'] ) ) ? $wikiThemeSettings['color-page'] : '#FFFFFF',
						'domain' => $wikiDomain,
						'wordmarkUrl' => ( $wordmarkType == 'graphic' && !empty( $wordmarkUrl ) ) ? $wordmarkUrl : ''
					);
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( 'WikiFactory variable \'' . self::WF_WIKI_RECOMMEND_VAR . '\' not found' );
			}

			$this->storeInCache( $cacheKey, $games );
		}

		$ret = wfPaginateArray( $games, $limit, $batch );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	private function generateCacheKey( $token ) {
		return wfMemcKey( $token, CuratedContentController::API_VERSION . '.' . CuratedContentController::API_REVISION . '.' . CuratedContentController::API_MINOR_REVISION );
	}

	private function loadFromCache( $key ) {
		return $this->app->wg->memc->get( $key );
	}

	private function storeInCache( $key, $value, $duration = self::CACHE_DURATION ) {
		$this->app->wg->memc->set( $key, $value, $duration );
	}
}
