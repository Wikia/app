<?php

namespace Wikia\Util\PerformanceProfilers;


use Wikia\Tracer\WikiaTracer;
use Wikia\Util\WikiaProfiler;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Class UsernameLookupProfiler
 * This is helper class for provide information about how performance will change
 * if we load username from id instead using username from table with denormalized form.
 * See https://wikia-inc.atlassian.net/browse/SUS-953
 * See
 * @package Wikia\Util\PerformanceProfilers
 */
class UsernameLookupProfiler {
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

	const ALWAYS_SEND_EVENT = 1.0;

	const REQUEST_SAMPLING_RATE = 0.01;


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
				static::ALWAYS_SEND_EVENT
			);
		}
	}

	public static function create( $class, $method ) {
		// we want the profiler to send all events for a request,
		// so we're sampling requests instead of the events
		if ( static::$shouldSampleRequest === null ) {
			$sampler = new BernoulliTrial( static::REQUEST_SAMPLING_RATE );
			static::$shouldSampleRequest = $sampler->shouldSample();
		}
		$traceId = WikiaTracer::instance()->getTraceId();
		return new UsernameLookupProfiler( $class, $method, $traceId, static::$shouldSampleRequest );
	}
}
