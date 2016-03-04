<?php

namespace Wikia\ExactTarget;

abstract class BaseAdapter {

	public function __construct( array $results ) {
		foreach ( $results as $result ) {
			if ( $result->Properties instanceof \stdClass ) {
				$this->extractResult( $result->Properties->Property );
			}
		}
	}

	abstract protected function extractResult($property );
}
