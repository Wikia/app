<?php
/**
 * Class InsightsCountApiController
 * A public API that allows you to retrieve information about number of items on Insights lists.
 */

class InsightsCountApiController extends WikiaApiController {

	/**
	 * @requestParam string type A type of an Insights list
	 * @response int count A number of items on the list
	 */
	public function getCount() {
		$type = $this->request->getVal( 'type' );

		$count = ( new InsightsCountService() )->getCount( $type );

		$this->setVal( 'count', $count );
	}

	/**
	 * @response array An array of counts with types of Insights as keys
	 */
	public function getAllCounts() {
		$counts = ( new InsightsCountService() )->getAllCounts();

		$this->setVal( 'counts', $counts );
	}
}
