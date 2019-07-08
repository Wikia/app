<?php


namespace Wikia\CircuitBreaker;


use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Builder;
use Wikia\CircuitBreaker\Storage\APCUAdapter;
use Wikia\Logger\WikiaLogger;

class LocalCircuitBreaker implements CircuitBreaker {

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
					WikiaLogger::instance()
						->error( "Circuit open! It seems that a failure has occurred in {$service}. {$message}." );
					break;
				case Ganesha::EVENT_CALMED_DOWN:
					WikiaLogger::instance()
						->info( "The failure in {$service} seems to have calmed down. {$message}." );
					break;
				case Ganesha::EVENT_STORAGE_ERROR:
					WikiaLogger::instance()->error( "APCU failure: {$message}" );
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
	public function OperationAllowed( string $name ) {
		return $this->ganesha->isAvailable( $name );
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function SetOperationStatus( string $name, bool $status ) {
		if ( $status ) {
			$this->ganesha->success( $name );
		} else {
			$this->ganesha->failure( $name );
		}

		return true;
	}
}
