<?php

namespace Wikia\CircuitBreaker;

class ServiceCircuitBreaker {
	/** @var string */
	private $serviceName;

	/** @var CircuitBreakerStorage */
	private $circuitBreaker;

	/**
	 * ServiceCircuitBreaker constructor.
	 * @param $serviceName string name of the service
	 * @param CircuitBreakerStorage $circuitBreaker
	 */
	public function __construct( string $serviceName, CircuitBreakerStorage $circuitBreaker ) {
		$this->serviceName = $serviceName;
		$this->circuitBreaker = $circuitBreaker;
	}

	/**
	 * @param $status bool status of the operation
	 * @return bool
	 */
	public function setOperationStatus( $status ) {
		return $this->circuitBreaker->setOperationStatus( $this->serviceName, $status );
	}

	/**
	 * @throws CircuitBreakerOpen
	 */
	public function assertOperationAllowed() {
		if ( !$this->operationAllowed() ) {
			throw new CircuitBreakerOpen( $this->serviceName );
		}
	}

	/**
	 * @return bool returns true if operation can be performed on a given service
	 */
	public function operationAllowed() {
		return $this->circuitBreaker->operationAllowed( $this->serviceName );
	}
}
