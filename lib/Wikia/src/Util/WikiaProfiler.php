<?php
namespace Wikia\Util;

use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Trait WikiaProfiler
 *
 * Allows sending profiler info (elapsed time) to a InfluxDB for further processing
 * and analyzing.
 *
 * Usage:
 *   - call startProfile() and store a timestamp returned by the function
 *   - execute code which needs to be benchmarked
 *   - call endProfile() and pass it a previously stored timestamp
 *
 *  All data will be sent to a InfluxDB using Transactions.
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
     * @param $event - name of a event to profile (see: Transaction)
     * @param $start_time - timestamp returned by startProfile()
     * @param array $options - [opt] additional options send in log
     * @param float $sample_rate - [opt] how many % of profile calls will be send (default: 0.01)
     */
    function endProfile( $event, $start_time, $options=[], $sample_rate=0.01 ) {
        $elapsed = microtime( true ) - $start_time;

        if ( !$this->getProfileSampler( $sample_rate )->shouldSample() ) {
            return;
        }

        $options['elapsed'] = $elapsed;

        \Transaction::addEvent( $event, $options );
    }
}
