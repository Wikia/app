<?php

namespace Wikia\ExactTarget;

abstract class BaseAdapter {

	public function __construct( $result ) {
		if ( $result->Properties instanceof \stdClass ) {
			$this->extractSingle( $result->Properties->Property );
		}
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	protected function extractMultiple( array $properties ) {
		foreach ( $properties as $property ) {
			$this->extractSingle( $property->Properties->Property );
		}
	}

	abstract protected function extractSingle( $property );
}
