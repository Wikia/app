<?php

namespace Wikia\Search\Services;

abstract class AbstractSearchService {

	public function query( $phrase ) {
		$select = $this->prepareQuery( $phrase );

		$response = $this->select( $select );

		return $this->consumeResponse( $response );
	}

	protected abstract function prepareQuery( string $query );

	protected abstract function select( $select );

	protected function consumeResponse( $response ) {
		return $response;
	}
}
