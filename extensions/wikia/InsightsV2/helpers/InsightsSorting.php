<?php

class InsightsSorting {
	const INSIGHTS_DEFAULT_SORTING = 'pv7';

	private $insightsCache;
	private $data;

	public
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
		]
	];

	public function __construct() {
		$this->insightsCache = new InsightsCache();
	}

	public function getDefaultSorting() {
		return self::INSIGHTS_DEFAULT_SORTING;
	}

	/**
	 * Overrides the default values used for sorting and pagination
	 *
	 * @param array $params An array of URL parameters
	 * @return array
	 */
	public function getSortedData( $articleData, $params ) {
		if ( isset( $params['sort'] ) && isset( $this->sorting[ $params['sort'] ] ) ) {
			$this->data = $this->insightsCache->get( $params['sort'] );
		} else {
			$this->getData( $articleData );
		}

		return $this->data;
	}

	private function getData( $articlesData ) {
		if ( 0 /*$this->arePageViewsRequired()*/ ) {
			$this->data = $this->insightsCache->get( self::INSIGHTS_DEFAULT_SORTING );
		} else {
			$this->data = array_keys( $articlesData );
		}
	}

	public function createSortingArrays( $sortingData ) {
		foreach ( $this->sorting as $key => $item ) {
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
		if ( isset( $this->sorting[ $key ]['sortFunction'] ) ) {
			usort( $sortingArray, $this->sorting[ $key ]['sortFunction'] );
		} else {
			arsort( $sortingArray, $this->sorting[ $key ]['sortType'] );
		}

		$this->insightsCache->set( $key, array_keys( $sortingArray ) );
	}
}