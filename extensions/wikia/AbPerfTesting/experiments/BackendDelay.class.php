<?php

namespace Wikia\AbPerfTesting\Experiments;

use Wikia\AbPerfTesting\Experiment;

/**
 * Adds a sleep on the backend for a given number of miliseconds
 */
class BackendDelay extends Experiment {

	/**
	 * @param int $delay delay in ms
	 */
	function __construct($delay) {
		$this->on('RestInPeace', function() use ($delay) {
			wfDebug( sprintf("%s: sleeping for %d ms\n", __CLASS__, $delay) );

			usleep( $delay * 1000 );
			return true;
		});
	}

}
