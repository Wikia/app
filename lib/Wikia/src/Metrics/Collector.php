<?php

namespace Wikia\Metrics;

use Prometheus\PushGateway;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Wikia\Logger\WikiaLogger;

/**
 * This class can be used to push metrics to Prometheus via Pushgateway
 *
 * Metrics can be added via addGauge() and addCounter() methods.
 * These are collected and pushed to Pushgateway when push() method is called.
 *
 * @package Wikia\Metrics
 */
class Collector {

	// @see https://prometheus.io/docs/practices/naming/
	const METRICS_NAMESPACE = 'mediawiki';

	private $gateway;
	private $registry;

	static function getInstance() : self {
		global $wgPrometheusPushgatewayHost;
		static $instance = null;

		if ( $instance === null ) {
			$instance = new self( $wgPrometheusPushgatewayHost );
		}

		return $instance;
	}

	/**
	 * Create a new instance of Collector class that will push metrics to
	 * a provided Prometheus Pushgateway
	 *
	 * @param string $host Pushgateway address to push metrics to
	 */
	private function __construct( string $host ) {
		$this->gateway = new PushGateway( $host, 2, 5 );
		$this->registry = new CollectorRegistry( new InMemory() );
	}

	public function addGauge( string $name, float $value, array $labels, string $help ) : self {
		$gauge = $this->registry->getOrRegisterGauge(
			self::METRICS_NAMESPACE, $name, $help, array_keys( $labels ) );
		$gauge->set( $value, array_values( $labels ) );

		return $this;
	}

	public function addCounter( string $name, array $labels, string $help ) : self {
		$counter = $this->registry->getOrRegisterCounter(
			self::METRICS_NAMESPACE, $name, $help, array_keys( $labels ) );
		$counter->inc( array_values( $labels ) );

		return $this;
	}

	public function push( string $job ) {
		try {
			$this->gateway->pushAdd( $this->registry, $job );
		}
		catch ( \RuntimeException $ex ) {
			WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $ex
			] );
		}

		// empty the registry
		$this->registry = new CollectorRegistry( new InMemory() );
	}
}
