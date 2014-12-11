<?php

namespace Wikia\Api\Recommendations;

/**
 * Recommendations API data collector
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Damian Jozwiak <damian@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 *
 */
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

			wfDebug( sprintf("%s: calling %s to get %d items...\n", __METHOD__, get_class($dataProvider), $currentLimit ) );
			$out = array_merge( $out, $dataProvider->get($articleId, $currentLimit ) );
		}

		shuffle($out);
		$out = array_slice($out, 0, $limit);
		return $out;
	}

	/**
	 * Get instances of all available data providers
	 *
	 * @return \Wikia\Api\Recommendations\DataProviders\IDataProvider[]
	 */
	protected function getDataProviders() {
		global $wgWikiDirectedAtChildrenByStaff, $wgWikiDirectedAtChildrenByFounder;

		$availableDataProviders = [
			(new DataProviders\Video),
			(new DataProviders\Category)
		];

		if ( empty( $wgWikiDirectedAtChildrenByStaff ) && empty( $wgWikiDirectedAtChildrenByFounder ) ) {
			$availableDataProviders[] = (new DataProviders\TopArticles);
		}

		return $availableDataProviders;
	}
}
