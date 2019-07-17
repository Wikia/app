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
	 */
	public function __construct( string $serviceName, CircuitBreakerStorage $circuitBreaker ) {
		$this->serviceName = $serviceName;
		$this->circuitBreaker = $circuitBreaker;
	}

	/**
	 * @return bool returns true if operation can be performed on a given service
	 */
	public function OperationAllowed() {
		return $this->circuitBreaker->OperationAllowed( $this->serviceName );
	}

	/**
	 * @param $status bool status of the operation
	 */
	public function SetOperationStatus( $status ) {
		$this->circuitBreaker->SetOperationStatus( $this->serviceName, $status );
	}

	/**
	 * @throws CircuitBreakerOpen
	 */
	public function AssertOperationAllowed() {
		if ( !$this->OperationAllowed() ) {
			throw new CircuitBreakerOpen( $this->serviceName);
		}
	}
}
