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
		foreach ( $dataProviders as $dataProvider ) {
			// TODO better limit :)
			$out = array_merge( $out, $dataProvider->get($articleId, 3 ) );
		}

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
			(new DataProviders\TopArticles),
			(new DataProviders\Category)
		];
	}
}
