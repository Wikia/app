<?php
/**
 * Class InsightsCountService
 * Retrieves information on number of items on Insights lists.
 */

class InsightsCountService extends WikiaService {

	/**
	 * @var array
	 * If you do not want to calculate a count for a set of lists - put them in this array.
	 */
	private static $excludedFromCount = [];

	public function __construct() {
		$this->initExcludedFromCountList();
	}

	/**
	 * Returns a count of items on a given Insights list based on a passed type.
	 * @param string $type
	 * @return int
	 */
	public function getCount( $type ) {
		return $this->calculateCount( $type );
	}

	/**
	 * Returns an array of counts on a all Insights list except for the excluded ones.
	 * @return array An array of counts with types as keys
	 */
	public function getAllCounts() {
		$response = [];
		foreach ( InsightsHelper::getInsightsPages() as $type => $className ) {
			$count = $this->calculateCount( $type );
			if ( $count !== false ) {
				$response[$type] = $this->calculateCount( $type );
			}
		}

		return $response;
	}

	/**
	 * Init list with insights without count
	 */
	private function initExcludedFromCountList() {
		global $wgEnableFlagsExt;

		if ( !empty( $wgEnableFlagsExt ) ) {
			self::$excludedFromCount[] = InsightsFlagsModel::INSIGHT_TYPE;
		}
	}

	/**
	 * @param string $type A type of an Insights list for which you'd like to calculate a count.
	 * @return int|bool Returns false if a given class does not exist or the count otherwise.
	 */
	private function calculateCount( $type ) {
		if ( !$this->shouldCalculateForType( $type ) ) {
			return false;
		}

		$className = InsightsHelper::getInsightsPages()[$type];
		if ( !class_exists( $className ) ) {
			return false;
		}

		/**
		 * Use a regular fetchArticleData method from a given class
		 */
		$subpageModel = new $className;
		return count( ( new InsightsContext( $subpageModel ) )->fetchData() );
	}

	/**
	 * Checks if conditions for calculating a count of items are met for a given type of Insights.
	 * @param $type
	 * @return bool
	 */
	private function shouldCalculateForType( $type ) {
		return !in_array( $type, self::$excludedFromCount )
			&& InsightsHelper::isInsightPage( $type );
	}
}
