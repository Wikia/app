<?php

/**
 * Hook handlers for loading the required scripts and bootstrapping Bucky RUM reporting.
 * Currently works only on Oasis.
 */
class Bucky {

	const DEFAULT_SAMPLING = 1; // percentage
	const BASE_URL = '//speed.wikia.net/__rum';

	static public function onWikiaSkinTopScripts( array &$vars, &$scripts ) {
		$app = F::app();
		if ( $app->checkSkin( 'oasis' ) ) {
			// todo: find better place for it
			$wgBuckySampling = $app->wg->BuckySampling;
			$url = self::BASE_URL; // "/v1/send" is automatically appended
			// Bucky sampling can be set by request param so we want to check if it's in range from 0 to 100
			$sample = ( ( isset( $wgBuckySampling ) && $wgBuckySampling >= 0 && $wgBuckySampling <= 100 )
					? $wgBuckySampling : self::DEFAULT_SAMPLING ) / 100;
			$sample = 1;
			$config = array(
				'host' => $url,
				'sample' => $sample,
				'aggregationInterval' => 1000,
				'protocol' => 2,
			);

			$vars['wgBuckyConfig'] = $config;
		}

		return true;
	}

	static public function onOasisSkinAssetGroups( &$assetGroups ) {
		$assetGroups[] = 'bucky_js';

		return true;
	}

}
