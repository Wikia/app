<?php


namespace Wikia\CircuitBreaker;


class LocalCircuitBreaker implements CircuitBreaker
{

	/**
	 * @param string $name
	 * @return bool
	 */
	public function OperationAllowed(string $name)
	{
		// TODO: Implement OperationAllowed() method.
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function SetOperationStatus(string $name, bool $status)
	{
		// TODO: Implement SetOperationStatus() method.
	}
}
