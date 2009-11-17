<?php

/**
 * Różne testowe bzdurki wymagające MW
 * Tests for different stuffs which demands MW stack
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

function testDelayedEmails() {
	$from      = "community@wikia-inc.com";
	$recipient = "eloy@wikia-inc.com";
	$body      = "Test email";
	$headers   = array(
		"X-Msg-Category" => "Test"
	);

	/**
	 * normal email
	 */
	$headers[ "Subject" ] = wfQuotedPrintable( "Test email normal: " . wfTimestampNow() );
	$textHeaders = "";
	foreach( $headers as $header => $value ) {
		$textHeaders .= "{$header}: $value\n";
	}
	#Http::post("http://theschwartz/theschwartz/inject", 'default', array (
	#	CURLOPT_POSTFIELDS => array (
	#		"rcpt" => $recipient,
	#		"env_from" => $from,
	#		"msg" => "$textHeaders" . "\n\n" . "$body"
	#	)
	#) );

	/**
	 * delayed email
	 */
	global $wgTheSchwartzSecretToken;
	$url = sprintf( "http://lyric.wikia.com/api.php?action=awcreminder%%26user_id=%d%%26token=%s",
		51098,
		$wgTheSchwartzSecretToken
	);
	Wikia::log( __METHOD__, "url", $url );
	print_r( Http::post("http://theschwartz/function/TheSchwartz::Worker::URL", 'default', array (
		CURLOPT_POSTFIELDS => array (
			"theschwartz_run_after" => time() + 300,
			"url" => $url
		),
		#CURLOPT_PROXY => "127.0.0.1:6081"
		CURLOPT_PROXY => "10.8.2.114:80"
	) ) );
}

function testStomp() {
	global $wgStompServer, $wgStompUser, $wgStompPassword, $wgCityId;

	try {
		$stomp = new Stomp( $wgStompServer );
		$stomp->connect( $wgStompUser, $wgStompPassword );
		$stomp->sync = false;
		$stomp->send(
			"/test/eloy/stomp",
			Wikia::json_encode( array( "value" => "test" ) ),
			array( 'exchange' => 'amq.topic', 'bytes_message' => 1 )
		);
	}
	catch( Stomp_Exception $e ) {
		Wikia::log( __METHOD__, 'stomp_exception', $e->getMessage() );
	}
}

#
# main
#
testDelayedEmails();
#testStomp();
