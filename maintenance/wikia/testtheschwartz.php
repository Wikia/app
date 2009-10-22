<?php

/**
 * tests for theschwartz api
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$from      = "community@wikia-inc.com";
$recipient = "eloy@wikia-inc.com";
$body      = "Test email";
$headers   = array(
	"Subject" => "Test email"
);

/**
 * normal email
 */
$textHeaders = "";
foreach( $headers as $header => $value ) {
	$textHeaders .= "{$header}: $value\n";
}
Http::post("http://theschwartz/theschwartz/inject", 'default', array (
	CURLOPT_POSTFIELDS => array (
		"rcpt" => $recipient,
		"env_from" => $from,
		"msg" => "$textHeaders" . "\n\n" . "$body")));

/**
 * delayed email
 */
