<?php

/**
 * Hook handlers for loading the required scripts and bootstrapping Bucky RUM reporting.
 */
class Bucky {

	const DEFAULT_SAMPLING = 1; // percentage
	const BASE_URL = 'https://speed.nocookie.net/__rum';

	/**
	 * Adds wgWeppyConfig global JS variable
	 *
	 * @param array $vars
	 * @param OutputPage $out
	 * @return bool true - it's a hook
	 */
	static public function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$app = F::app();
		if ( $app->checkSkin( $app->wg->BuckyEnabledSkins ) ) {
			// todo: find better place for it
			$wgBuckySampling = $app->wg->BuckySampling;
			$url = self::BASE_URL; // "/v1/send" is automatically appended
			// Bucky sampling can be set by request param so we want to check if it's in range from 0 to 100
			$sample = ( ( isset( $wgBuckySampling ) && $wgBuckySampling >= 0 && $wgBuckySampling <= 100 )
					? $wgBuckySampling : self::DEFAULT_SAMPLING ) / 100;
			$config = array(
				'host' => $url,
				'sample' => $sample,
				'aggregationInterval' => 1000,
			);

			$vars['wgWeppyConfig'] = $config;
		}

		return true;
	}
}
