<?php

namespace Wikia\CircuitBreaker;

use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Builder;
use Ackintosh\Ganesha\Storage\Adapter\Redis;
use Wikia\CircuitBreaker\Storage\WikiaMemcachedAdapter;
use Wikia\Logger\Loggable;

class RedisCircuitBreakerStorage implements CircuitBreakerStorage {

	use Loggable;
	const DEFAULT_REDIS_PORT = 6379;
	const CONN_TIMEOUT = 1.0;
	const RETRY_INTERVAL = 500;
	const READ_TIMEOUT = 1.0;

	/** @var Ganesha */
	private $ganesha;

	public function __construct() {
		global $wgCircuitBreakerRedisHost, $wgCircuitBreakerRedisDb;

		$redis = new \Redis();
		$redis->connect( $wgCircuitBreakerRedisHost, self::DEFAULT_REDIS_PORT, self::CONN_TIMEOUT, null,
			self::RETRY_INTERVAL, self::READ_TIMEOUT );
		$redis->select( $wgCircuitBreakerRedisDb );

		$this->ganesha = Builder::build( [
			'failureRateThreshold' => 50,
			'adapter' => new Redis( $redis ),
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
					$this->error( 'Redis circuit breaker failure', [ 'message' => $message ] );
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
