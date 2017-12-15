<?php

/**
 * @author Mateusz 'Warkot' Warkocki <mateusz-warkocki(at)wikia-inc.com>
 *
 * This script downloads a copy of Optimizely script and puts it into local CDN.
 * It is stored via MySQLKeyValueModel which uses 'specials' database.
 */

require_once( dirname( __FILE__ ) . '/../../commandLine.inc' );

// to make sure OptimizelyController class is loaded, and not be dependent on `wgEnableOptimizelyExt` variable
require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/Optimizely/OptimizelyController.class.php' );

global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;

$url = $wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl;
$data = trim( ExternalHttp::get( $url ) );

if ( !empty( $data ) ) {
	$storageModel = new MySQLKeyValueModel();
	$storedData = $storageModel->get( OptimizelyController::OPTIMIZELY_SCRIPT_KEY );

	if ( empty( $storedData ) || $storedData !== $data ) {
		$storageModel->set( OptimizelyController::OPTIMIZELY_SCRIPT_KEY, $data );
	}
} else {
     throw new MWException("Http response empty");
}