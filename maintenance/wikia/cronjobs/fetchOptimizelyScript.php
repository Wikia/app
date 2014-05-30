<?php

/**
 * @author Mateusz 'Warkot' Warkocki <mateusz-warkocki(at)wikia-inc.com>
 *
 * This script downloads a copy of Optimizely script and puts it into local CDN.
 * It is stored via MySQLKeyValueModel which uses 'specials' database.
 */

require_once( dirname( __FILE__ ) . '/../../commandLine.inc' );

global $wgDevelEnvironment, $wgOptimizelyUrl, $wgOptimizelyDevUrl;

$urlPrefix = 'http:';
$url = $wgDevelEnvironment ? $wgOptimizelyDevUrl : $wgOptimizelyUrl;

if ( stripos( $url, $urlPrefix ) !== 0 ) {
	$url = $urlPrefix . $url;
}

$data = Http::get( $url );

if ( empty( $data ) ) {
	$storageModel = new MySQLKeyValueModel();
	$storedData = $storageModel->get( OptimizelyController::OPTIMIZELY_SCRIPT_KEY );

	if ( empty( $storedData ) || $storedData !== $data ) {
		$storageModel->set( OptimizelyController::OPTIMIZELY_SCRIPT_KEY, $data );
	}
}
