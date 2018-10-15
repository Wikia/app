<?php

namespace Wikia\Metrics;

use Prometheus\CollectorRegistry;
use Prometheus\Exception\StorageException;
use Prometheus\Storage\Redis;
use Wikia\Logger\Loggable;

/**
 * This class can be used to push metrics to Prometheus.
 *
 * Metrics can be added via addGauge() and addCounter() methods.
 * These are stored temporarily in Redis and later collected by
 * Prometheus which requests /metrics.php file.
 *
 * @package Wikia\Metrics
 */
class Collector {

	use Loggable;

	// @see https://prometheus.io/docs/practices/naming/
	const METRICS_NAMESPACE = 'mediawiki';

	private $registry;

	static function getInstance() : self {
		global $wgRedisHost;
		static $instance = null;

		if ( $instance === null ) {
			$instance = new self( $wgRedisHost );
		}

		return $instance;
	}

	/**
	 * Create a new instance of Collector class that will push metrics to Redis that will later
	 * be collected by Prometheus
	 *
	 * @param string $redisHost Redis server to store metrics before they will be collected by Prometheus
	 */
	private function __construct( string $redisHost ) {
		$this->registry = new CollectorRegistry( new Redis( [ 'host' => $redisHost ] ) );
	}

	public function addGauge( string $name, float $value, array $labels, string $help ) : self {
		try {
			$gauge = $this->registry->getOrRegisterGauge(
				self::METRICS_NAMESPACE, $name, $help, array_keys( $labels ) );
			$gauge->set( $value, array_values( $labels ) );
		} catch ( StorageException $ex ) {
			$this->error( __METHOD__, [
				'exception' => $ex
			] );
		}

		return $this;
	}

	public function addCounter( string $name, array $labels, string $help ) : self {
		try {
			$counter = $this->registry->getOrRegisterCounter(
				self::METRICS_NAMESPACE, $name, $help, array_keys( $labels ) );
			$counter->inc( array_values( $labels ) );
		} catch ( StorageException $ex ) {
			$this->error( __METHOD__, [
				'exception' => $ex
			] );
		}
		return $this;
	}
}
