<?php

/**
 * Class CustomMeasurementsDriver
 * @see CustomMeasurementsNewrelicDriver
 * @see CustomMeasurementsDummyDriver
 */
interface CustomMeasurementsDriver {
	/**
	 * Returns true if driver is usable in given context;
	 * @return bool
	 */
	public function canUse();

	/**
	 * Should call $callable, measure execute time and send it to appropriate engine. Will return the result of $callable.
	 * @param string $measurementCategory
	 * @param string $measurementName
	 * @param callable $callable
	 * @return mixed
	 */
	public function measureTime( $measurementCategory, $measurementName, callable $callable );
}

/**
 * Class CustomMeasurementsNewrelicDriver
 * Use newrelic as custom measurement engine.
 * @see CustomMeasurements
 */
class CustomMeasurementsNewrelicDriver implements CustomMeasurementsDriver {

	/**
	 * @return bool
	 */
	public function canUse() {
		return extension_loaded("newrelic")
			&& function_exists("newrelic_custom_metric");
	}

	/**
	 * @param string $measurementCategory
	 * @param string $measurementName
	 * @param callable $callable
	 * @throws Exception - rethrows all exceptions from $callable
	 * @return mixed
	 */
	public function measureTime( $measurementCategory, $measurementName, callable $callable ) {
		$start = 0;
		$fullMeasurementName = "Custom/{$measurementCategory}/{$measurementName}/[seconds|call]";
		$result = null;
		try {
			$start = microtime(true);
			$result = $callable();
		} catch ( Exception $e ) {
			// TODO: use finally keyword for that in PHP 5.5
			$end = microtime(true);
			newrelic_custom_metric( $fullMeasurementName, $end - $start );
			// rethrow exception. We should use finally for that.
			// Since it's not yet available we'll simply rethrow.
			throw $e;
		}
		$end = microtime(true);
		newrelic_custom_metric( $fullMeasurementName, $end - $start );
		return $result;
	}
}

/**
 * Class CustomMeasurementsDummyDriver
 * Dummy Custom measurement driver. Fallback if no other driver is available.
 * @see CustomMeasurements
 */
class CustomMeasurementsDummyDriver implements CustomMeasurementsDriver {

	/**
	 * @return bool
	 */
	public function canUse() {
		return true;
	}

	/**
	 * @param string $measurementCategory
	 * @param string $measurementName
	 * @param callable $callable
	 * @return mixed
	 */
	public function measureTime( $measurementCategory, $measurementName, callable $callable ) {
		return $callable();
	}
}

/**
 * Class CustomMeasurements
 */
class CustomMeasurements {
	/**
	 * @var string
	 */
	private $category;
	/**
	 * @var CustomMeasurementsDriver
	 * @see CustomMeasurementsNewrelicDriver
	 * @see CustomMeasurementsDummyDriver
	 */
	private $driver;

	/**
	 * @param $category
	 * @return CustomMeasurements
	 */
	public static function create( $category ) {
		$driver = new CustomMeasurementsNewrelicDriver();
		if ( !$driver->canUse() ) {
			$driver = new CustomMeasurementsDummyDriver();
		}
		return new CustomMeasurements( $category, $driver );
	}

	/**
	 * @param $category
	 * @param CustomMeasurementsDriver $driver
	 */
	function __construct( $category, CustomMeasurementsDriver $driver) {
		$this->category = $category;
		$this->driver = $driver;
	}

	/**
	 * @param $measurementName
	 * @param callable $callable
	 * @return mixed
	 */
	public function measureTime( $measurementName, callable $callable ) {
		return $this->driver->measureTime( $this->category, $measurementName, $callable );
	}
}
