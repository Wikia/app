<?php

namespace Wikia\CircuitBreaker;

use ErrorException;
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

class CircuitBreakerOpen extends ErrorException {
	use Loggable;

	/** @var int */
	protected $code;

	/** @var string */
	private $serviceName;

	/**
	 * CircuitBreakerOpen constructor.
	 * @param string $serviceName
	 * @param int $code
	 */
	public function __construct( string $serviceName, int $code = 0 ) {
		$this->serviceName = $serviceName;
		$this->code = $code;

		parent::__construct( "circuit breaker open for service $serviceName", $code );
	}

	protected function logMe() {
		$this->warning( 'circuit breaker open',
			[ 'service' => $this->serviceName, 'code' => $this->code ] );
	}
}
