<?php

namespace Wikia\CircuitBreaker;

class ApcuStorage implements DataStorage {
	const PREFIX = 'circuitbreaker::';

	public function __construct() {
		if ( !function_exists( 'apcu_fetch' ) ) {
			throw new \Exception( 'APCU not enabled!' );
		}
	}

	public function fetch( $key ) {
		return apcu_fetch( self::PREFIX . $key );
	}

	public function store($key, $value) {
		$result = apcu_store(self::PREFIX . $key, $value);
		if ( $result === false ) {
			// TODO: LOG THE ERROR!
		}
	}

}
