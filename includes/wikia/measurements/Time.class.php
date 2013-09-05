<?php

namespace Wikia\Measurements;


/**
 * Class Time
 * @package Wikia\Measurements
 */
class Time {
	/**
	 * @var Driver
	 */
	private $driver;
	/**
	 * @var string
	 */
	private $measurementName;
	/**
	 * @var float|null if $start time is null then timer is stopped.
	 */
	private $startTime;

	/**
	 * @param string|string[] $measurementName
	 * @return Time
	 */
	public static function start( $measurementName ) {
		if ( is_array( $measurementName ) ) {
			$measurementName = implode( '/', $measurementName );
		}
		return new Time( $measurementName, Drivers::get() );
	}

	/**
	 * @param string $measurementName
	 * @param callable $callable
	 */
	public static function run( $measurementName, $callable ) {
		$measurement = self::start( $measurementName );
		return $callable();
	}

	/**
	 * @param $measurementName
	 * @param Driver $driver
	 */
	public function __construct( $measurementName, Driver $driver ) {
		$this->measurementName = $measurementName;
		$this->driver = $driver;
		$this->startTime = \microtime(true);
	}

	/**
	 * Makes sure timer is stopped and measurement registered. Subsequent call gives no effect.
	 */
	public function stop() {
		if ( $this->startTime !== null ) {
			$time = \microtime(true) - $this->startTime;
			$this->driver->measureTime( $this->measurementName, $time );
			$this->startTime = null;
		}
	}

	/**
	 * Make sure measurement is finalised.
	 */
	function __destruct() {
		$this->stop();
	}
}
