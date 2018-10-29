<?php
namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class ReplicationWaitHelper {

	use Loggable;

	private $maxWaitTimeMillis = 10000;

	/** @var \DatabaseBase $dbr */
	private $dbr;

	/** @var string $caller */
	private $caller;

	/**
	 * @param \DatabaseBase $dbr DB connection to wait on - will be passed to the provided callback
	 */
	public function __construct( \DatabaseBase $dbr ) {
		$this->dbr = $dbr;
	}

	/**
	 * Set the maximum time we can wait
	 * @param int $maxWaitTimeMillis
	 */
	public function setMaxWaitTimeMillis( int $maxWaitTimeMillis ) {
		$this->maxWaitTimeMillis = $maxWaitTimeMillis;
	}

	/**
	 * Set the caller function or method that will be logged by this class
	 * @param string $caller
	 */
	public function setCaller( string $caller ) {
		$this->caller = $caller;
	}

	/**
	 * Wait until the specified condition callback returns true, or the timeout is exceeded
	 *
	 * @param callable $exitConditionCallback condition to evaluate; should return true when done.
	 * Will receive the provided database connection as a parameter.
	 */
	public function waitUntil( callable $exitConditionCallback ) {
		$waitMillisTotal = 0;
		$backOffMillis = $this->maxWaitTimeMillis / 15;

		while ( $waitMillisTotal <= $this->maxWaitTimeMillis && !$exitConditionCallback( $this->dbr ) ) {
			usleep( $backOffMillis * 1000);
			$waitMillisTotal += $backOffMillis;
		}

		if ( $waitMillisTotal > $this->maxWaitTimeMillis ) {
			$this->warning( "{$this->caller} - waiting timed out", [
				'took' => $waitMillisTotal / 1000
			] );
		} else {
			$this->info( "{$this->caller} - done waiting", [
				'took' => $waitMillisTotal / 1000
			] );
		}
	}
}
