<?php

namespace Wikia\CircuitBreaker\Storage;

use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Configuration;
use Ackintosh\Ganesha\Storage\AdapterInterface;
use Ackintosh\Ganesha\Storage\Adapter\TumblingTimeWindowInterface;
use Ackintosh\Ganesha\Exception\StorageException;
use APCUIterator;

/**
 * Class APCUAdapter
 * @package Wikia\CircuitBreaker\Storage
 */
class APCUAdapter implements AdapterInterface, TumblingTimeWindowInterface {

	/**
	 * @var Configuration
	 */
	private $configuration;

	private function readFailure( $key ) {
		return "APCu fetch failed for key: {$key}";
	}

	private function storeFailure( $key ) {
		return "APCu failed storing value for key: {$key}";
	}

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
		return (int)apcu_fetch( $service );
	}

	/**
	 * @param string $service
	 * @param int $count
	 * @return void
	 */
	public function save( $service, $count ) {
		if ( apcu_store( $service, $count ) === false ) {
			$this->throwException( $this->storeFailure( $service ) );
		}
	}

	/**
	 * @param string $service
	 * @return void
	 */
	public function increment( $service ) {
		$status = false;
		apcu_inc( $service, 1, $status );
		if ( $status === false ) {
			$this->throwException( $this->storeFailure( $service ) );
		}
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
		$status = false;
		apcu_dec( $service, 1, $status );
		if ( $status === false ) {
			$this->throwException( $this->storeFailure( $service ) );
		}
	}

	/**
	 * sets last failure time
	 *
	 * @param string $service
	 * @param int $lastFailureTime
	 * @return void
	 */
	public function saveLastFailureTime( $service, $lastFailureTime ) {
		if (apcu_store( $service, $lastFailureTime ) === false) {
			$this->throwException( $this->storeFailure( $service ) );
		}
	}

	/**
	 * returns last failure time
	 *
	 * @param $service
	 * @return int | null
	 */
	public function loadLastFailureTime( $service ) {
		$status = false;
		$value = (int)apcu_fetch( $service, $status );
		if ( $status ) {
			return $value;
		}

		$this->throwException( $this->readFailure( $service ) );
	}

	/**
	 * sets status
	 *
	 * @param string $service
	 * @param int $status
	 * @return void
	 */
	public function saveStatus( $service, $status ) {
		if ( apcu_store( $service, $status ) === false ) {
			$this->throwException( $this->storeFailure( $service ) );
		}
	}

	/**
	 * returns status
	 *
	 * @param string $service
	 * @return int
	 */
	public function loadStatus( $service ) {
		$status = apcu_fetch( $service );
		if ( $status === false && !apcu_exists( $service ) ) {
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
		$prefix = Ganesha\Storage::KEY_PREFIX;
		$status = apcu_delete( new APCUIterator( "^{$prefix}" ) );

		if ( !$status ) {
			$this->throwException( "Failed clearing circuit breaker cache" );
		}
	}

	/**
	 * Used for throwing exceptions from APCu
	 *
	 * @throws StorageException
	 * @param $message
	 */
	private function throwException( $message ) {
		throw new StorageException( $message );
	}
}
