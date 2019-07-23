<?php

namespace Wikia\CircuitBreaker;

use Exception;
use Wikia\Logger\Loggable;

interface CircuitBreakerStorage {
	/**
	 * @param string $name
	 * @return bool
	 */
	public function operationAllowed( string $name );

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function setOperationStatus( string $name, bool $status );
}

class CircuitBreakerOpen extends Exception {
	use Loggable;

	/** @var string */
	private $serviceName;

	/** @var int */
	private $code;

	/**
	 * CircuitBreakerOpen constructor.
	 * @param string $serviceName
	 * @param int $code
	 * @param Exception|null $previous
	 */
	public function __construct( string $serviceName, int $code = 0, Exception $previous = null ) {
		$this->serviceName = $serviceName;
		$this->code = $code;

		parent::__construct( "circuit breaker open for service $serviceName", $code, $previous );
	}

	protected function logMe() {
		$this->warning( 'circuit breaker open',
			[ 'service' => $this->serviceName, 'code' => $this->code ] );
	}
}
