<?php

namespace Wikia\AbPerfTesting\Experiments;

use Wikia\AbPerfTesting\Experiment;

/**
 * Adds a sleep on the frontend onDOMReady event for a given number of miliseconds
 *
 * Note: is applied to Oasis and content namespaces articles only!
 */
class FrontendDelay extends Experiment {

	/**
	 * @param array $params experiment parameters
	 */
	function __construct( Array $params ) {
		// $delay = $params['delay'];

		// add a JS global variable with the defined delay
		// TODO: the bucketing logic is now in the front-end part
		/**
		$this->on( 'WikiaSkinTopScripts', function( Array &$vars ) use ( $delay ) {
			$vars['wgPerfTestFrontEndDelay'] = intval( $delay );
			return true;
		} );
		**/

		$this->on( 'BeforePageDisplay', function( \OutputPage $out, \Skin $skin ) {
			$out->addScript( \Html::linkedScript( \AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/AbPerfTesting/js/FrontendDelay.js' ) ) );
			return true;
		} );
	}
}
