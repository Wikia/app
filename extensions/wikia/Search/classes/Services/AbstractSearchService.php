<?php

namespace Wikia\Search\Services;


abstract class AbstractSearchService {

	public function query( $phrase ) {
		$select = $this->prepareQuery( $phrase );

		$response = $this->select( $select );

		return $this->consumeResponse( $response );
	}

	protected function prepareQuery( $query ) {
		// Subclass implements

		return null;
	}

	protected function select( $select ) {
		// Subclass implements

		return null;
	}

	protected function consumeResponse( $response ) {
		return $response;
	}
}
