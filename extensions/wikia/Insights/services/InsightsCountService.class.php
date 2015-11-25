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
	public static $excludedFromCount = [
		InsightsFlagsModel::INSIGHT_TYPE,
	];

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
			if ( in_array( $type, self::$excludedFromCount ) ) {
				continue;
			}
			$response[$type] = $this->calculateCount( $type );
		}

		return $response;
	}

	/**
	 * @param string $type A type of an Insights list for which you'd like to calculate a count.
	 * @return int|bool Returns false if a given class does not exist or the count otherwise.
	 */
	private function calculateCount( $type ) {
		$className = InsightsHelper::getInsightsPages()[$type];
		if ( !class_exists( $className ) ) {
			return false;
		}

		/**
		 * Use a regular fetchArticleData method from a given class
		 */
		$subpageModel = new $className;
		$subpageModel->initModel( [] );
		return count( $subpageModel->fetchArticlesData() );
	}
}
