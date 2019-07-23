<?php

namespace Wikia\CircuitBreaker;

class CircuitBreakerFactory {
	private $circuitBreakerInstance;

	/**
	 * @param string $serviceName
	 * @return ServiceCircuitBreaker
	 */
	public function GetCircuitBreaker( string $serviceName ) {
		if ( $this->circuitBreakerInstance === null ) {
			global $wgCircuitBreakerType;

			switch ( $wgCircuitBreakerType ) {
				case 'local':
					$this->circuitBreakerInstance = new LocalCircuitBreakerStorage();
					break;
				default:
					$this->circuitBreakerInstance = new NoopCircuitBreakerStorage();
					break;
			}
		}

		return new ServiceCircuitBreaker( $serviceName, $this->circuitBreakerInstance );
	}
}
