<?php

class InsightsCountApiController extends WikiaApiController {

	public function getCount() {
		$type = $this->request->getVal( 'type' );

		$count = ( new InsightsCountService() )->getCount( $type );

		$this->setVal( 'count', $count );
	}

	public function getAllCounts() {
		$counts = ( new InsightsCountService() )->getAllCounts();

		$this->setVal( 'counts', $counts );
	}
}
