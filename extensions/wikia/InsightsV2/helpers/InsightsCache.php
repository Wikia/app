<?php

class InsightsCache {
	const
		INSIGHTS_MEMC_PREFIX = 'insights',
		INSIGHTS_MEMC_VERSION = '1.6',
		INSIGHTS_MEMC_TTL = 259200, // Cache for 3 days
		INSIGHTS_MEMC_ARTICLES_KEY = 'articlesData';

	private $memc;
	private $config;

	public function __construct( InsightsConfig $config ) {
		global $wgMemc;
		$this->memc = $wgMemc;
		$this->config = $config;
	}

	public function get( $params ) {
		$data = $this->memc->get( $this->getMemcKey( $params ) );
		return is_array( $data ) ? $data : [];
	}

	public function set( $params, $data, $ttl = self::INSIGHTS_MEMC_TTL ) {
		$this->memc->set( $this->getMemcKey( $params ), $data, $ttl );
	}

	public function delete( $params ) {
		$this->memc->delete( $this->getMemcKey( $params ) );
	}

	public function purgeInsightsCache() {
		$this->delete( self::INSIGHTS_MEMC_ARTICLES_KEY );
	}

	/**
	 * Updates the cached articleData and sorting array
	 *
	 * @param int $articleId
	 */
	public function updateInsightsCache( $articleId ) {
		$this->updateArticleDataCache( $articleId );
		$this->updateSortingCache( $articleId );
	}

	/**
	 * Get memcache key for insights
	 *
	 * @param string $params
	 * @return string
	 */
	public function getMemcKey( $params ) {
		return wfMemcKey(
			self::INSIGHTS_MEMC_PREFIX,
			$this->config->getInsightType(),
			$this->config->getInsightSubType(),
			$params,
			self::INSIGHTS_MEMC_VERSION
		);
	}

	/**
	 * Removes a fixed article from the articleData array
	 *
	 * @param int $articleId
	 */
	private function updateArticleDataCache( $articleId ) {
		$articleData =  $this->get( self::INSIGHTS_MEMC_ARTICLES_KEY );

		if ( isset( $articleData[$articleId] ) ) {
			unset( $articleData[$articleId] );
			$this->set( self::INSIGHTS_MEMC_ARTICLES_KEY, $articleData );
		}
	}

	/**
	 * Removes a fixed article from the sorting arrays
	 *
	 * @param int $articleId
	 */
	private function updateSortingCache( $articleId ) {
		$sorting = InsightsSorting::getSortingTypes();

		foreach ( $sorting as $type => $item ) {
			$sortingArray = $this->get( $type );
			if ( !empty( $sortingArray ) ) {
				$key = array_search( $articleId, $sortingArray );

				if ( $key !== false && $key !== null ) {
					unset( $sortingArray[$key] );
					$this->set( $type, $sortingArray );
				}
			}
		}
	}
}
