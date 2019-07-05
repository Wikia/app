<?php


namespace Wikia\CircuitBreaker\Storage;


use Ackintosh\Ganesha\Configuration;
use Ackintosh\Ganesha\Storage\AdapterInterface;

class APCUAdapter implements AdapterInterface
{

	/**
	 * @param Configuration $configuration
	 * @return void
	 */
	public function setConfiguration(Configuration $configuration)
	{
		// TODO: Implement setConfiguration() method.
	}

	/**
	 * @param string $service
	 * @return int
	 */
	public function load($service)
	{
		// TODO: Implement load() method.
	}

	/**
	 * @param string $service
	 * @param int $count
	 * @return void
	 */
	public function save($service, $count)
	{
		// TODO: Implement save() method.
	}

	/**
	 * @param string $service
	 * @return void
	 */
	public function increment($service)
	{
		// TODO: Implement increment() method.
	}

	/**
	 * decrement failure count
	 *
	 * If the operation would decrease the value below 0, the new value must be 0.
	 *
	 * @param string $service
	 * @return void
	 */
	public function decrement($service)
	{
		// TODO: Implement decrement() method.
	}

	/**
	 * sets last failure time
	 *
	 * @param string $service
	 * @param int $lastFailureTime
	 * @return void
	 */
	public function saveLastFailureTime($service, $lastFailureTime)
	{
		// TODO: Implement saveLastFailureTime() method.
	}

	/**
	 * returns last failure time
	 *
	 * @return int | null
	 */
	public function loadLastFailureTime($service)
	{
		// TODO: Implement loadLastFailureTime() method.
	}

	/**
	 * sets status
	 *
	 * @param string $service
	 * @param int $status
	 * @return void
	 */
	public function saveStatus($service, $status)
	{
		// TODO: Implement saveStatus() method.
	}

	/**
	 * returns status
	 *
	 * @param string $service
	 * @return int
	 */
	public function loadStatus($service)
	{
		// TODO: Implement loadStatus() method.
	}

	/**
	 * resets all counts
	 *
	 * @return void
	 */
	public function reset()
	{
		// TODO: Implement reset() method.
	}
}
