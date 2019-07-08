<?php


namespace Wikia\CircuitBreaker\Storage;


use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Configuration;
use Ackintosh\Ganesha\Storage\AdapterInterface;
use Ackintosh\Ganesha\Storage\Adapter\TumblingTimeWindowInterface;

/**
 * Class APCUAdapter
 * @package Wikia\CircuitBreaker\Storage
 */
class APCUAdapter implements AdapterInterface, TumblingTimeWindowInterface {

	/**
	 * @var Configuration
	 */
	private $configuration;

	/**
	 * @param Configuration $configuration
	 * @return void
	 */
	public function setConfiguration( Configuration $configuration ) {
		$this->configuration = $configuration;
	}

	/**
	 * @param string $service
	 * @return int
	 */
	public function load( $service ) {
		return apcu_fetch( $service );
	}

	/**
	 * @param string $service
	 * @param int $count
	 * @return void
	 */
	public function save( $service, $count ) {
		apcu_store( $service, $count );
	}

	/**
	 * @param string $service
	 * @return void
	 */
	public function increment( $service ) {
		apcu_inc( $service, 1 );
	}

	/**
	 * decrement failure count
	 *
	 * If the operation would decrease the value below 0, the new value must be 0.
	 *
	 * @param string $service
	 * @return void
	 */
	public function decrement( $service ) {
		apcu_dec( $service, 1 );
	}

	/**
	 * sets last failure time
	 *
	 * @param string $service
	 * @param int $lastFailureTime
	 * @return void
	 */
	public function saveLastFailureTime( $service, $lastFailureTime ) {
		//Interestingly, Ganesha seems to be using the same key for everything, or it is $service meaning different
		//things depending on context https://github.com/ackintosh/ganesha/blob/master/src/Ganesha/Storage/Adapter/Memcached.php
		apcu_store( $service, $lastFailureTime );
	}

	/**
	 * returns last failure time
	 *
	 * @return int | null
	 */
	public function loadLastFailureTime( $service ) {
		return apcu_fetch( $service );
	}

	/**
	 * sets status
	 *
	 * @param string $service
	 * @param int $status
	 * @return void
	 */
	public function saveStatus( $service, $status ) {
		apcu_store( $service, $status );
	}

	/**
	 * returns status
	 *
	 * @param string $service
	 * @return int
	 */
	public function loadStatus( $service ) {
		$status = apcu_fetch( $service );
		if ( $status === false && !apcU_exists( $service ) ) {
			$this->saveStatus( $service, Ganesha::STATUS_CALMED_DOWN );

			return Ganesha::STATUS_CALMED_DOWN;
		}

		return $status;
	}

	/**
	 * resets all counts
	 *
	 * @return void
	 */
	public function reset() {
		apcu_clear_cache();
	}
}
