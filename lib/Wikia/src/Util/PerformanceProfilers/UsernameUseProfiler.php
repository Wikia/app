<?php

namespace Wikia\Util\PerformanceProfilers;


use Wikia\Tracer\WikiaTracer;
use Wikia\Util\WikiaProfiler;
use Wikia\Util\Statistics\BernoulliTrial;

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

	private static $shouldSampleRequest = null;

	/**
	 * @var string
	 */
	private $class;

	/**
	 * @var string
	 */
	private $method;

	/**
	 * @var string
	 */
	private $traceId;

	/**
	 * @var integer
	 */
	private $startTime;

	/**
	 * @var boolean
	 */
	private $shouldSample;

	const EVENT_USERNAME_FROM_ID = 'username_from_id';


	/**
	 * UsernameUseProfiler constructor.
	 * @param $class string
	 * @param $method string
	 * @param $traceId string
	 * @param $shouldSample boolean
	 */
	private function __construct( $class, $method, $traceId, $shouldSample ) {
		$this->class = $class;
		$this->method = $method;
		$this->traceId = $traceId;
		$this->shouldSample = $shouldSample;
		$this->start();
	}

	private function start() {
		if( $this->shouldSample ) {
			$this->startTime = $this->startProfile();
		}
	}

	public function end( $context = [] ) {
		if( $this->shouldSample ) {
			$context['class'] = $this->class;
			$context['method'] = $this->method;
			$context['trace_id'] = $this->traceId;

			$this->endProfile(
				static::EVENT_USERNAME_FROM_ID,
				$this->startTime,
				$context,
				$this->sampling
			);
		}
	}

	public static function instance( $class, $method ) {
		if ( static::$shouldSampleRequest === null ) {
			static::$shouldSampleRequest = new BernoulliTrial( 0.01 ).shouldSample();
		}
		$traceId = WikiaTracer::instance().getTraceId();
		return new UsernameUseProfiler( $class, $method, $traceId, static::$shouldSampleRequest );
	}
}
