<?php

namespace Wikia\AbPerformanceTesting;

use \Wikia\Logger\WikiaLogger;

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

		// set a global JS variable with an experiment name
		global $wgHooks;
		$wgHooks['WikiaSkinTopScripts'][] = function( Array &$vars, &$scripts ) use ( $experimentName ) {
			$vars['wgABPerformanceTest'] = $experimentName;
			return true;
		} ;

		/*
		 * Start the session to bypass CDN cache
		 *
		 * We don't want to polute the CDN cache with the A/B performance testing tracking data.
		 * As the test are run for only a small subset of the traffic, start the session for client
		 * that are in the test groups to bypass the CDN cache.
		 */
		if ( session_id() == '' ) {
			wfSetupSession();
			wfDebug( __METHOD__ . " - session started\n" );

			// log started sessions
			global $wgUser;
			WikiaLogger::instance()->info( __METHOD__, [
				'experiment' => $experimentName,
				'session_id' => session_id(),
				'is_anon' => $wgUser->isAnon()
			] );
		}
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
	static function onAfterInitialize( $title, $article, $output, $user, $request, $wiki ) {
		global $wgAbPerformanceTestingExperiments;
		wfDebug( sprintf( "%s - checking experiments (with beacon ID set to '%s')...\n", __METHOD__, wfGetBeaconId() ) );

		// loop through all registered experiments and run those matching criteria
		foreach ( $wgAbPerformanceTestingExperiments as $experimentName => $experimentConfig ) {
			if ( Experiment::isEnabled( $experimentConfig ) ) {
				self::startExperiment( $experimentName, $experimentConfig );

				// leave now, we handle only a single experiment at a time now
				return true;
			}
		}

		return true;
	}
}
