<?php

set_include_path(get_include_path().PATH_SEPARATOR.dirname( __FILE__ )."/lib".PATH_SEPARATOR.dirname( __FILE__ )."/lib/Stomp".PATH_SEPARATOR.dirname( __FILE__ )."/lib/JSON");
require "./includes/api/ApiFormatJson_json.php";

$IP = dirname( __FILE__ );
include_once $IP . "/extensions/wikia/Scribe/ScribeClient.php";

if ( !function_exists('wfProfileIn') ) 			{ function wfProfileIn() 	{ }; }
if ( !function_exists('wfProfileOut') ) 		{ function wfProfileOut() 	{ }; }
if ( !function_exists('wfDebug') ) 				{ function wfDebug() 		{ }; }
if ( empty($_GET['c']) || empty($_GET['x']) ) 	{ exit(0); }

$params = $_GET;
try {
	$wgScribeHost = "";
	if ( $params['test'] == 1 ) {
		$wgScribeHost = "10.10.10.150";
	}
	# referer not used
	$params['r'] = '';
	$params['lv'] = date("Y-m-d H:i:s");
	$json = new Services_JSON;
	$data = $json->encode( $params );
	WScribeClient::singleton( 'log_view' )->send( $data );
}
catch( TException $e ) {
	Wikia::log( __FILE__, 'scribeClient exception', $e->getMessage() );
}

/**
 * set & send header to browser
 */
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: 0");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header('Pragma: cache');
header("Content-Type: image/gif");
printf("%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c", 0x47, 0x49, 0x46, 0x38, 0x39, 0x61, 0x01, 0x00, 0x01, 0x00, 0x80, 0x00, 0x00, 0xFF, 0xFF, 0xFF, 0x00, 0x00, 0x00, 0x21, 0xF9, 0x04, 0x01, 0x00, 0x00, 0x00, 0x00, 0x2C, 0x00, 0x00, 0x00, 0x00, 0x01, 0x00, 0x01, 0x00, 0x00, 0x02, 0x02, 0x44, 0x01, 0x00, 0x3B);
exit;
