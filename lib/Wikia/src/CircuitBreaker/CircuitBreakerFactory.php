<?php

namespace Wikia\CircuitBreaker;

use Wikia\Util\Statistics\BernoulliTrial;

class CircuitBreakerFactory {
	/**
	 * @param BernoulliTrial $logSampler
	 * @return ExternalCircuitBreaker|NoopCircuitBreaker
	 */
	public static function GetCircuitBreaker( BernoulliTrial $logSampler ) {
		global $wgCircuitBreakerType;

		switch ( $wgCircuitBreakerType ) {
			case 'external':
				return new ExternalCircuitBreaker( $logSampler );
			default:
				return new NoopCircuitBreaker();
		}
	}
}
