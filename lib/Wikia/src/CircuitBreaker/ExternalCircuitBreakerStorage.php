<?php

namespace Wikia\CircuitBreaker;

use GuzzleHttp;
use Wikia\Logger\Loggable;
use Wikia\Util\Statistics\BernoulliTrial;

class ExternalCircuitBreakerStorage implements CircuitBreakerStorage {
	use Loggable;

	const CIRCUIT_BREAKER_SERVICE_URL = 'http://localhost:8080';
	/** @var BernoulliTrial */
	private $logSampler;
	/** @var GuzzleHttp\Client */
	private $apiClient;

	/**
	 * ExternalCircuitBreaker constructor.
	 * @param BernoulliTrial $logSampler
	 */
	public function __construct( BernoulliTrial $logSampler ) {
		$this->logSampler = $logSampler;
		if ( key_exists( 'CIRCUIT_BREAKER_SERVICE_URL', $_ENV ) ) {
			$circuitBreakerUrl = $_ENV['CIRCUIT_BREAKER_SERVICE_URL'];
		} else {
			$circuitBreakerUrl = self::CIRCUIT_BREAKER_SERVICE_URL;
		}
		$this->apiClient = new GuzzleHttp\Client( [ 'base_uri' => $circuitBreakerUrl ] );
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function operationAllowed( string $name ) {
		$resp = $this->apiClient->get( '/allowed', [ 'query' => [ 'name' => $name ] ] );
		if ( $resp->getStatusCode() != 200 ) {
			return false;
		}

		$allowed = GuzzleHttp\json_decode( $resp->getBody() );

		if ( !$allowed->allowed && $this->logSampler->shouldSample() ) {
			$this->warning( "[circuit breaker] open", [ 'service_name' => $name, ] );
		}

		return $allowed->allowed;
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function setOperationStatus( string $name, bool $status ) {
		$resp =
			$this->apiClient->post( '/update',
				[ 'query' => [ 'name' => $name, 'success' => $status ] ] );

		return $resp->getStatusCode() == 204;
	}
}
