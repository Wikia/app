<?php

require_once( dirname( __FILE__ ) . '/../../commandLine.inc' );

global $wgOptimizelyUrl;

$curlUrl = 'http:' . $wgOptimizelyUrl;
$curlHandle = curl_init( $curlUrl );
$curlOptions = array(
	// don't fetch the response body, just headers
	CURLOPT_HEADER => true,
	CURLOPT_NOBODY => true,
	// don't print the output, assign it to a variable instead
	CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array( $curlHandle, $curlOptions );
$curlHeader = curl_exec( $curlHandle );

if ( $curlHeader !== false ) {
	preg_match( '/ETag: "(.*?)"/i', $curlHeader, $curlMatches );
	$curlEtag = $curlMatches[ 1 ];

	$storage = new MysqlKeyValueModel();
	$storedData = $storage->get( 'optimizelyScript' );

	if ( !$storedData || $storedData[ 'etag' ] !== $curlEtag ) {
		curl_setopt_array( $curlHandle, [ CURLOPT_HEADER => false, CURLOPT_NOBODY => false ] );
		$curlBody = curl_exec( $curlHandle );
		$storage->set( 'optimizelyScript', [ 'etag' => $curlEtag, 'script' => $curlBody ] );
	}
}

curl_close( $curlHandle );
