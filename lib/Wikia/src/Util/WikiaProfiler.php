<?php
namespace Wikia\Util;

use Wikia\Logger\WikiaLogger;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Trait WikiaProfiler
 *
 * Allows sending profiler info (elapsed time) to a log.
 *
 * Usage:
 *   - call startProfile() and store a timestamp returned by the function
 *   - execute code which needs to be benchmarked
 *   - call endProfile() and pass it a previously stored timestamp
 *
 *  All data will be sent to a log using Wikia\Logger\WikiLogger instance.
 *  A caller function name is added to the data being sent automatically if missing.
 *
 * @package Wikia\Util
 */
trait WikiaProfiler {
    /**
     * @var BernoulliTrial
     */
    private $sampler = null;

    /**
     * @param $sample_rate
     * @return BernoulliTrial
     */
    private function getProfileSampler($sample_rate) {
        if ( !isset( $this->sampler ) || $this->sampler->getProbability() != $sample_rate ) {
            $this->sampler = new BernoulliTrial( $sample_rate );
        }

        return $this->sampler;
    }

    /**
     * @return integer - current timestamp
     */
    function startProfile() {
        return microtime( true );
    }

    /**
     * @param $label - message which will be used in a log
     * @param $start_time - timestamp returned by startProfile()
     * @param array $options - [opt] additional options send in log
     * @param float $sample_rate - [opt] how many % of profile calls will be send (default: 0.01)
     */
    function endProfile( $label, $start_time, $options=[], $sample_rate=0.01 ) {
        $elapsed = microtime( true ) - $start_time;

        if ( !$this->getProfileSampler( $sample_rate )->shouldSample() ) {
            return;
        }

        $options['elapsed'] = $elapsed;

        if ( !array_key_exists('function', $options) ) {
            $callers = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
            $options['function'] = $callers[1]['function'];
        }
        WikiaLogger::instance()->info($label, $options);
    }
}
