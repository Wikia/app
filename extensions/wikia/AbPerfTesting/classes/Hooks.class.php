<?php

namespace Wikia\AbPerfTesting;

class Hooks {

	/**
	 * Initialize the experiment and set all required tracking things
	 *
	 * @param string $experimentName
	 * @param array $experimentConfig
	 */
	private static function startExperiment( $experimentName, Array $experimentConfig ) {
		wfDebug( sprintf( "%s[%s] using %s class with %s params\n",
			__METHOD__, $experimentName, $experimentConfig['handler'], json_encode( $experimentConfig['params'] ) ) );

		new $experimentConfig['handler']( $experimentConfig['params'] ? : [] );

		// mark a transaction with an experiment name
		\Transaction::getInstance()->set( \Transaction::PARAM_AB_PERFORMANCE_TEST, $experimentName );

		// mark a transaction using UA's custom dimensions
		global $wgHooks;
		$wgHooks['WikiaSkinTopScripts'][] = function( Array &$vars, &$scripts ) use ( $experimentName ) {
			$val = \Xml::encodeJsVar( $experimentName );
			$scripts .= \Html::inlineScript( "_gaq.push(['set', 'dimension20', {$val}]);" );
			return true;
		} ;
	}

	/**
	 * Initialize performance experiments when MediaWiki starts the engine
	 *
	 * @param \Title $title
	 * @param \Article $article
	 * @param \OutputPage $output
	 * @param \User $user
	 * @param \WebRequest $request
	 * @param \MediaWiki $wiki
	 * @return bool it's a hook
	 */
	static function onAfterInitialize( \Title $title, \Article $article, \OutputPage $output, \User $user, \WebRequest $request, \MediaWiki $wiki ) {
		global $wgABPerfTestingExperiments;
		wfDebug( sprintf( "%s - checking experiments (with beacon ID set to '%s')...\n", __METHOD__, wfGetBeaconId() ) );

		// loop through all registered experiments and run those matching criteria
		foreach ( $wgABPerfTestingExperiments as $experimentName => $experimentConfig ) {
			if ( Experiment::isEnabled( $experimentConfig ) ) {
				self::startExperiment( $experimentName, $experimentConfig );

				// leave now, we handle only a single experiment at a time now
				return true;
			}
		}

		return true;
	}
}
