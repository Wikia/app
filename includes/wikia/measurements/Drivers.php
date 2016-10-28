<?php

namespace Wikia\Measurements;

/**
 * Interface Driver
 * @see NewrelicDriver
 * @see DummyDriver
 * @see Drivers
 * @package Wikia\Measurements
 */
interface Driver {
	/**
	 * Returns true if driver is usable in given context;
	 * @return bool
	 */
	public function canUse();

	/**
	 * Will send measured time to appropriate engine.
	 * @param string $measurementName
	 * @param float $time time in seconds.
	 */
	public function measureTime( $measurementName, $time );
}

/**
 * Class NewrelicDriver
 * Use newrelic as custom measurement engine.
 * @see CustomMeasurements
 */
class NewrelicDriver implements Driver {
	const MILLISECONDS_IN_SECOND = 1000.0;
	/**
	 * @return bool
	 */
	public function canUse() {
		return extension_loaded("newrelic")
			&& function_exists("newrelic_custom_metric");
	}

	/**
	 * @param string $measurementName
	 * @param float $time - in seconds
	 */
	public function measureTime( $measurementName, $time ) {
		$fullMeasurementName = "Custom/{$measurementName}[seconds|call]";
		/*
		 * We need to multiply time in seconds by 1000.
		 * From newrelic_custom_metric documentation:
		 * Adds a custom metric with the specified name and value, which is of type double. Values saved are assumed to be milliseconds, so "4" will be stored as ".004" in our system.
		 */
		/** @noinspection PhpUndefinedFunctionInspection */
		\newrelic_custom_metric( $fullMeasurementName, $time * self::MILLISECONDS_IN_SECOND );
	}
}

/**
 * Class DummyDriver
 * Dummy Custom measurement driver. Fallback if no other driver is available.
 * @see CustomMeasurements
 */
class DummyDriver implements Driver {

	/**
	 * @return bool
	 */
	public function canUse() {
		return true;
	}

	/**
	 * Will send measured time to appropriate engine.
	 * @param string $measurementName
	 * @param float $time time in seconds.
	 */
	public function measureTime($measurementName, $time) {
		// do nothing
	}
}

/**
 * Class Drivers
 * Helper class for managing Drivers.
 * @package Wikia\Measurements
 */
class Drivers {
	/**
	 * @var Driver
	 */
	static private $currentDriver;

	/**
	 * @param Driver $currentDriver
	 */
	public static function set( Driver $currentDriver ) {
		self::$currentDriver = $currentDriver;
	}

	/**
	 * @return Driver
	 */
	public static function get() {
		return self::$currentDriver;
	}

	/**
	 * Resets default driver to default value.
	 */
	public static function resetDefault() {
		$candidates = [ new NewrelicDriver(), new DummyDriver() ];
		foreach( $candidates as $candidate ) { /** @var Driver $candidate */
			if( $candidate->canUse() ) {
				self::set( $candidate );
				break;
			}
		}
	}
}

// static constructor replacement
Drivers::resetDefault();
