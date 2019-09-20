<?php

namespace Wikia\CircuitBreaker;

use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Builder;
use Wikia\CircuitBreaker\Storage\WikiaMemcachedAdapter;
use Wikia\Logger\Loggable;

class MemcachedCircuitBreakerStorage implements CircuitBreakerStorage {

	use Loggable;

	/** @var Ganesha */
	private $ganesha;

	private function configure() {
		global $wgMemCachedTimeout, $wgMemCachedConnectionTimeout;

		return [
			\Memcached::OPT_SEND_TIMEOUT => $wgMemCachedTimeout,
			\Memcached::OPT_RECV_TIMEOUT => $wgMemCachedTimeout,
			\Memcached::OPT_CONNECT_TIMEOUT => $wgMemCachedConnectionTimeout ?: 1.0
		];
	}

	public function __construct() {
		global $wgMemCachedServers;

		$memCached = new \Memcached( );
		$memCached->setOptions( $this->configure() );

		foreach ( $wgMemCachedServers as $weight => $memCachedServer ) {
			$parts = preg_split( '/:/', $memCachedServer, 2 );
			$memCached->addServer( $parts[0], $parts[1] );
		}

		$this->ganesha = Builder::build( [
			'failureRateThreshold' => 50,
			'adapter' => new WikiaMemcachedAdapter( $memCached ),
			'intervalToHalfOpen' => 5,
			'minimumRequests' => 4,
			'timeWindow' => 30,
		] );

		$this->ganesha->subscribe( function ( $event, $service, $message ) {
			switch ( $event ) {
				case Ganesha::EVENT_TRIPPED:
					$this->error( 'Circuit open! It seems that a failure has occurred', [
						'service' => $service,
						'message' => $message,
					] );
					break;
				case Ganesha::EVENT_CALMED_DOWN:
					$this->info( 'The ganesha failure seems to have calmed down', [
							'service' => $service,
							'message' => $message,
						] );
					break;
				case Ganesha::EVENT_STORAGE_ERROR:
					$this->error( 'Memcached circuit breaker failure', [ 'message' => $message ] );
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
