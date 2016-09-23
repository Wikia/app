<?php

class InsightsPageViews {

	private $config;

	public function __construct( InsightsConfig $config ) {
		$this->config = $config;
	}

	/**
	 * Calculates desirable results and aggregates them in an array.
	 * Then, it modifies the articles data array and returns it
	 * with the values assigned to the articles.
	 *
	 * For now the values are:
	 * * PVs from the last week
	 * * PVs from the last 4 weeks
	 * * Views growth from a penultimate week
	 *
	 * @param array $articlesData
	 * @return array
	 */
	public function assignPageViewsData( $articlesData ) {
		$sortingData = [];
		$pageViewsData = $this->getPageViewsData( array_keys( $articlesData ) );

		foreach ( $articlesData as $articleId => $data ) {
			$articlePV = [];

			foreach ( $pageViewsData as $dataPoint ) {
				if ( isset( $dataPoint[ $articleId ] ) ) {
					$articlePV[] = intval( $dataPoint[ $articleId ] );
				} else {
					$articlePV[] = 0;
				}
			}

			$pv28 = array_sum( $articlePV );
			if ( $articlePV[1] != 0 ) {
				$pvDiff = ( $articlePV[0] - $articlePV[1] ) / $articlePV[1];
				$pvDiff = round( $pvDiff, 2 ) * 100;
				$pvDiff .= '%';
			} else {
				$pvDiff = 'N/A';
			}

			$sortingData['pv7'][ $articleId ] = $articlePV[0];
			$articlesData[ $articleId ]['metadata']['pv7'] = $articlePV[0];

			$sortingData['pv28'][ $articleId ] = $pv28;
			$articlesData[ $articleId ]['metadata']['pv28'] = $pv28;

			$sortingData['pvDiff'][ $articleId ] = $pvDiff;
			$articlesData[ $articleId ]['metadata']['pvDiff'] = $pvDiff;

		}

		( new InsightsSorting( $this->config ) )->createSortingArrays( $sortingData );

		return $articlesData;
	}

	/**
	 * Fetches page views data for a given set of articles. The data includes
	 * number of views for the last four time ids (data points).
	 *
	 * @param array $articlesIds An array of IDs of articles to fetch views for
	 * @return array An array with views for the last four time ids
	 */
	private function getPageViewsData( array $articlesIds ) {
		global $wgCityId;

		$pvData = [];
		if ( empty( $articlesIds ) ) {
			return $pvData;
		}

		/**
		 * Get pv for the last 4 Sundays
		 */
		$pvTimes = $this->getLastFourTimeIds();

		foreach ( $pvTimes as $timeId ) {
			$pvData[] = DataMartService::getPageViewsForArticles( $articlesIds, $timeId, $wgCityId );
		}

		return $pvData;
	}

	/**
	 * Returns an array of datetime entries for the last four Sundays
	 * (page views data is currently updated on every Sunday)
	 *
	 * @return array An array with dates of the last four Sundays
	 */
	private function getLastFourTimeIds() {
		$lastTimeId = ( new DateTime() )->modify( 'last Sunday' );
		$format = 'Y-m-d H:i:s';
		return [
			$lastTimeId->modify( '-1 week' )->format( $format ),
			$lastTimeId->modify( '-1 week' )->format( $format ),
			$lastTimeId->modify( '-1 week' )->format( $format ),
			$lastTimeId->modify( '-1 week' )->format( $format ),
		];
	}
}
