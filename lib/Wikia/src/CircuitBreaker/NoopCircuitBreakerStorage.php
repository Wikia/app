<?php

namespace Wikia\CircuitBreaker;

class NoopCircuitBreakerStorage implements CircuitBreakerStorage {

	/**
	 * @param string $name
	 * @return bool
	 */
	public function operationAllowed( string $name ) {
		return true;
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function setOperationStatus( string $name, bool $status ) {
		return true;
	}
}
