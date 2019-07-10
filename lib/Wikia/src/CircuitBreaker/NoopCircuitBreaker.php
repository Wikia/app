<?php

namespace Wikia\CircuitBreaker;

class NoopCircuitBreaker implements CircuitBreaker {

	/**
	 * @param string $name
	 * @return bool
	 */
	public function OperationAllowed( string $name ) {
		return true;
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function SetOperationStatus( string $name, bool $status ) {
		return true;
	}
}
