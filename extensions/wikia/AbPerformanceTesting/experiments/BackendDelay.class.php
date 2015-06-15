<?php

namespace Wikia\AbPerformanceTesting\Experiments;

use Wikia\AbPerformanceTesting\Experiment;

/**
 * Adds a sleep on the backend for a given number of miliseconds
 *
 * Note: is applied to Oasis and content namespaces articles only!
 */
class BackendDelay extends Experiment {

	private $mDelay;

	/**
	 * @param array $params experiment parameters
	 */
	function __construct( Array $params ) {
		$this->mDelay = $params['delay'];

		$this->on( 'BeforePageDisplay', function( \OutputPage $out, \Skin $skin ) {
			$this->sleep();
			return true;
		} );
	}

	private function sleep() {
		wfProfileIn( __METHOD__ );

		wfDebug( sprintf( "%s: sleeping for %d ms\n", __CLASS__, $this->mDelay ) );
		usleep( $this->mDelay * 1000 );

		wfProfileOut( __METHOD__ );
	}
}
