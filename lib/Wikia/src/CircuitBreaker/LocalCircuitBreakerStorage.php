<?php

namespace Wikia\CircuitBreaker;

use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Builder;
use Wikia\CircuitBreaker\Storage\APCUAdapter;
use Wikia\Logger\Loggable;

class LocalCircuitBreakerStorage implements CircuitBreakerStorage {

	use Loggable;

	/** @var Ganesha */
	private $ganesha;

	public function __construct() {
		$this->ganesha = Builder::build( [
			'failureRateThreshold' => 50,
			'adapter' => new APCUAdapter(),
			'intervalToHalfOpen' => 5,
			'minimumRequests' => 4,
			'timeWindow' => 30,
		] );

		$this->ganesha->subscribe( function ( $event, $service, $message ) {
			switch ( $event ) {
				case Ganesha::EVENT_TRIPPED:
					$this->error( 'Circuit open! It seems that a failure has occurred in', [
						'service' => $service,
						'message' => $message,
					] );
					break;
				case Ganesha::EVENT_CALMED_DOWN:
					$this->info( 'The ganesha failure seems to have calmed down.' . [
							'service' => $service,
							'message' => $message,
						] );
					break;
				case Ganesha::EVENT_STORAGE_ERROR:
					$this->error( 'APCU failure:', [ 'message' => $message ] );
					break;
				default:
					break;
			}
		} );
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function operationAllowed( string $name ) {
		return $this->ganesha->isAvailable( $name );
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function setOperationStatus( string $name, bool $status ) {
		if ( $status ) {
			$this->ganesha->success( $name );
		} else {
			$this->ganesha->failure( $name );
		}

		return true;
	}
}
