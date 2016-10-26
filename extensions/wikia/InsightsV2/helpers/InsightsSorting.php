<?php

class InsightsSorting {
	const INSIGHTS_DEFAULT_SORTING = 'pv7';

	private $insightsCache;
	private $config;

	public static
		$sorting = [
		'pv7' => [
			'sortType' => SORT_NUMERIC,
		],
		'pv28' => [
			'sortType' => SORT_NUMERIC,
		],
		'pvDiff' => [
			'sortType' => SORT_NUMERIC,
			'metadata' => 'pv7',
		],
		'random' => [
			'sortType' =>  null,
			'metadata' => 'pv7'
		]
	];

	public function __construct( InsightsConfig $config ) {
		$this->config = $config;
		$this->insightsCache = new InsightsCache( $this->config );
	}

	public static function getDefaultSorting() {
		return static::INSIGHTS_DEFAULT_SORTING;
	}

	public static function getSortingTypes() {
		return static::$sorting;
	}

	/**
	 * Overrides the default values used for sorting and pagination
	 *
	 * @param array $params An array of URL parameters
	 * @return array
	 */
	public function getSortedData( $articleData, $params ) {
		$sortParam = $params['sort'] ?? '';

		if ( $sortParam || $this->config->showPageViews() ) {
			$sortParam = isset( self::$sorting[ $sortParam ] ) ?
				$sortParam :
				self::INSIGHTS_DEFAULT_SORTING;

			$data = WikiaDataAccess::cache(
				$this->insightsCache->getMemcKey( $sortParam ),
				InsightsCache::INSIGHTS_MEMC_TTL,
				function () use ( $sortParam, $articleData ) {
					uasort( $articleData, function( $a, $b ) use ( $sortParam ) {
						return $b['metadata'][ $sortParam ] - $a['metadata'][ $sortParam ];
					});
					return array_keys( $articleData );
				}
			);
		} else {
			$data = array_keys( $articleData );
		}

		return $data;
	}

	public function createSortingArrays( $sortingData ) {
		foreach ( static::$sorting as $key => $item ) {
			if ( isset( $sortingData[$key] ) ) {
				$this->createSortingArray( $sortingData[ $key ], $key );
			}
		}
	}

	/**
	 * Sorts an array and sets it as a value in memcache. Article IDs are
	 * keys in the array.
	 *
	 * @param array $sortingArray The input array with
	 * @param string $key Memcache key
	 */
	public function createSortingArray( $sortingArray, $key ) {
		if ( isset( static::$sorting[ $key ]['sortFunction'] ) ) {
			usort( $sortingArray, static::$sorting[ $key ]['sortFunction'] );
		} else {
			arsort( $sortingArray, static::$sorting[ $key ]['sortType'] );
		}

		$this->insightsCache->set( $key, array_keys( $sortingArray ) );
	}
}
