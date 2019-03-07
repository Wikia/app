<?php

$statusCode = 200;
$statusMsg = 'OK';

if ( file_exists( "/usr/wikia/conf/current/host_disabled" ) ||
	 file_exists( "/etc/disabled/apache" ) ) {
	# failure!
	$statusCode = 503;
	$statusMsg  = 'Server status is: NOT OK - Disabled';
}

http_response_code( $statusCode );

header( 'Cache-Control: private, must-revalidate, max-age=0' );
header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
if ( function_exists( 'posix_uname' ) ) {
	$uname = posix_uname();
	header( 'X-Served-By: ' . $uname['nodename'] );
}

echo $statusMsg;
