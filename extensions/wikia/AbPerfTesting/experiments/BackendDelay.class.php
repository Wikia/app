<?php

namespace Wikia\AbPerfTesting\Experiments;

use Wikia\AbPerfTesting\Experiment;

/**
 * Adds a sleep on the backend for a given number of miliseconds
 */
class BackendDelay extends Experiment {

	private $mDelay;

	/**
	 * @param int $delay delay in ms
	 */
	function __construct($delay) {
		$this->mDelay = $delay;

		$this->on('RestInPeace', function() {
			$this->sleep();
			return true;
		});
	}

	private function sleep() {
		wfDebug( sprintf("%s: sleeping for %d ms\n", __CLASS__, $this->mDelay) );
		usleep( $this->mDelay * 1000 );
	}
}
