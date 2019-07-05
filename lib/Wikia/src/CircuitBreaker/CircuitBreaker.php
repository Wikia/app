<?php

namespace Wikia\CircuitBreaker;

use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\Exception;

class CircuitBreakerOpen extends ClientException {
	/** @var string */
	private $serviceName;

	/**
	 * CircuitBreakerOpen constructor.
	 * @param string $serviceName
	 * @param int $code
	 * @param Exception|null $previous
	 * @param null $data
	 */
	public function __construct(string $serviceName, int $code = 0, Exception $previous = null, $data = null) {
		$this->serviceName = $serviceName;

		parent::__construct("circuit breaker open for service $serviceName", $code, $previous, $data);
	}

	protected function logMe() {
		$this->error( 'circuit breaker open', ['service' => $this->serviceName ] );
	}
}

interface CircuitBreaker {
	/**
	 * @param string $name
	 * @return bool
	 */
	public function OperationAllowed( string $name );

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function SetOperationStatus( string $name, bool $status );
}
