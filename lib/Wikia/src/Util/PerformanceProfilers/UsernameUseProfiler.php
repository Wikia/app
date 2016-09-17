<?php

namespace Wikia\Util\PerformanceProfilers;


use Wikia\Util\WikiaProfiler;

/**
 * Class UsernameUseProfiler
 * This is helper class for provide information about how performance will change
 * if we load username from id instead using username from table with denormalized form.
 * See https://wikia-inc.atlassian.net/browse/SUS-953
 * See
 * @package Wikia\Util\PerformanceProfilers
 */
class UsernameUseProfiler {
	use WikiaProfiler;

	/**
	 * @var string
	 */
	private $class;
	/**
	 * @var string
	 */
	private $method;

	/**
	 * @var integer
	 */
	private $startTime;

	/**
	 * @var float
	 */
	private $sampling;

	const EVENT_USERNAME_FROM_ID = 'username_from_id';


	/**
	 * UsernameUseProfiler constructor.
	 * @param $class string
	 * @param $method string
	 * @param $sampling float
	 */
	public function __construct( $class, $method, $sampling = 0.01 ) {
		$this->class = $class;
		$this->method = $method;
		$this->sampling = $sampling;
		$this->start();
	}

	public function start() {
		$this->startTime = $this->startProfile();
	}

	public function end( $context = [] ) {
		$context[ 'class' ] = $this->class;
		$context[ 'method' ] = $this->method;

		$this->endProfile(
			static::EVENT_USERNAME_FROM_ID,
			$this->startTime,
			$context,
			$this->sampling
		);
	}
}
