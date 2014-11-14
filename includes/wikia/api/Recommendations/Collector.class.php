<?php

namespace Wikia\Api\Recommendations;

class Collector {

	/**
	 * Return data from all data providers
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @return array
	 */
	public function get( $articleId, $limit ) {
		$out = [];
		$dataProviders = $this->getDataProviders();
		$dataProvidersCount = count( $dataProviders );
		foreach ( $dataProviders as $dataProvider ) {
			$currentLimit = ceil( $limit / $dataProvidersCount );
			if ( (end($dataProviders) === $dataProvider) && ($limit - count( $out ) > $currentLimit) ) {
				$currentLimit = $limit - count( $out );
			}

			$out = array_merge( $out, $dataProvider->get($articleId, $currentLimit ) );
		}

		shuffle($out);
		$out = array_slice($out, 0, $limit);
		return $out;
	}

	/**
	 * Get instances of all available data providers
	 *
	 * @return array
	 */
	protected function getDataProviders() {
		return [
			(new DataProviders\Video),
			(new DataProviders\Category),
			(new DataProviders\TopArticles)
		];
	}
}
