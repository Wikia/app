<?php

namespace Wikia\CircuitBreaker;

use Wikia\Util\Statistics\BernoulliTrial;

class CircuitBreakerFactory {
	/**
	 * @param BernoulliTrial $logSampler
	 * @return ExternalCircuitBreaker|LocalCircuitBreaker|NoopCircuitBreaker
	 */
	public static function GetCircuitBreaker( BernoulliTrial $logSampler ) {
		global $wgCircuitBreakerType;

		switch ( $wgCircuitBreakerType ) {
			case 'external':
				return new ExternalCircuitBreaker( $logSampler );
			case 'local':
				return new LocalCircuitBreaker();
			default:
				return new NoopCircuitBreaker();
		}
	}
}
