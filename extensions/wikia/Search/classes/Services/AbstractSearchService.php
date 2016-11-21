<?php

namespace Wikia\Search\Services;


abstract class AbstractSearchService {

	public function query( $phrase ) {
		$select = $this->prepareQuery( $phrase );

		$response = $this->select( $select );
		$result = $this->consumeResponse( $response );

		return $result;
	}

	protected function prepareQuery( $query ) {
		return null;
	}

	protected function select( $select ) {
		return null;
	}

	protected function consumeResponse( $response ) {
		return $response;
	}
}
