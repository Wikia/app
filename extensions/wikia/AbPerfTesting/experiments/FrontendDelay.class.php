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
	 * @param int $delay delay in ms
	 */
	function __construct( $delay ) {
		// add a JS global variable with the defined delay
		$this->on( 'WikiaSkinTopScripts', function( Array &$vars ) use ( $delay ) {
			$vars['wgPerfTestFrontEndDelay'] = intval( $delay );
			return true;
		} );

		$this->on( 'BeforePageDisplay', function( \OutputPage $out, \Skin $skin ) {
			$title = $out->getTitle();

			// TODO: create a new criterium from this check - "OasisLoggedInArticles"
			if ( \F::app()->checkSkin( 'oasis', $skin ) && $title->isContentPage() && $title->exists() ) {
				$out->addScriptFile( \AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/AbPerfTesting/js/FrontendDelay.js' ) );
			}
			return true;
		} );
	}
}
