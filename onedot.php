<?php

set_include_path(get_include_path().PATH_SEPARATOR.dirname( __FILE__ )."/lib".PATH_SEPARATOR.dirname( __FILE__ )."/lib/Stomp".PATH_SEPARATOR.dirname( __FILE__ )."/lib/JSON");
require_once "Stomp.php";

if ( !function_exists('json_encode') ) {
	require_once "JSON.php";

	function json_encode($content) {
		$json = new Services_JSON;
		return $json->encode($content);
	}
}

$key = "wikia.apache.stats.";
$params = $_GET;
if ( empty($_GET['c']) || empty($_GET['x']) ) {
	exit(0);
}
$queue = (empty($_GET['db_test'])) ? $key : "";
$queue .= "www-stats";
try {
	$stomp = new Stomp( (!empty($_GET['db_test'])) ? 'tcp://10.10.10.150:61613' : 'tcp://10.8.2.221:61613' );
	$stomp->connect( 'guest', 'guest' );
	$stomp->sync = false;
	$stomp->send(
		$queue,
		json_encode( $params ),
		array( 'exchange' => 'amq.topic', 'bytes_message' => 1 )
	);
}
catch( StompException $e ) {
	error_log ('stomp_exception: ' . $e->getMessage());
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
