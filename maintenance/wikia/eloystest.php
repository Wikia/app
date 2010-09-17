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
	$url = sprintf( "http://lyric.wikia.com/api.php?action=awcreminder&user_id=%d&token=%s",
		51098,
		$wgTheSchwartzSecretToken
	);
	Wikia::log( __METHOD__, "url", $url );
	print_r( Http::post("http://theschwartz/function/TheSchwartz::Worker::URL", 'default', array (
		CURLOPT_POSTFIELDS => array (
			"theschwartz_run_after" => time() + 300,
			"url" => $url
		),
		CURLOPT_PROXY => "127.0.0.1:6081"
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

function testWF() {
	#print( WikiFactory::getVarValueByName( "wgFavicon", 40 ) ) . "\n";
	#print( WikiFactory::getVarValueByName( "wgFavicon", 40 ) ) . "\n";
	#print( WikiFactory::substVariables( '$wgUploadDirectory/$wgUploadPath', 40 ) ) . "\n";
	print( WikiFactory::UrlToId( 'http://muppet.wikia.com/de/' ) ) . "\n";
	print( WikiFactory::UrlToId( 'http://www.wikia.com/en/' ) ) . "\n";
	print( WikiFactory::UrlToId( 'http://memory-alpha.org/en/' ) ) . "\n";
	print( WikiFactory::UrlToId( 'http://memory-alpha.org/de/' ) ) . "\n";
	print( WikiFactory::UrlToId( 'http://memory-alpha.org/it/' ) ) . "\n";
}

function curlSolrUpdate() {
	print Http::post("http://10.6.30.17:8983/solr/update", 'default', array (
		CURLOPT_HTTPHEADER => array ( "Content-Type: text/xml" ),
		CURLOPT_POSTFIELDS => "<delete><query>wid:89714</query></delete>"
	) );
}

function testInterwikiLink() {
	$t = Title::newFromText( "w:c:answers" );
	echo "interwiki: " .$t->getInterwiki() . "\n";
	echo "dbkey: " . $t->getDBkey() . "\n";
	echo "fulltext: " . $t->getFullText() . "\n";
	echo "external: " . (int)$t->isExternal() . "\n";

	$t = Title::newFromText( "wikipedia:Manitoba" );
	echo "interwiki: " .$t->getInterwiki() . "\n";
	echo "dbkey: " . $t->getDBkey() . "\n";
	echo "fulltext: " . $t->getFullText() . "\n";
	echo "external: " . (int)$t->isExternal() . "\n";

}

function testAvatars() {
	$avatar = $avatarUrl = Masthead::newFromUserName( "Eloy.wikia" );
	echo $avatar->getUrl() . "\n";
	echo $avatar->getThumbnail( 50 ) . "\n";

	$avatar = $avatarUrl = Masthead::newFromUserName( "Wikia" );
	echo $avatar->getUrl() . "\n";
	echo $avatar->getThumbnail( 50 ) . "\n";

	$avatar = $avatarUrl = Masthead::newFromUserId( 0 );
	echo $avatar->getUrl() . "\n";
	echo $avatar->getThumbnail( 50 ) . "\n";

}

#
# main
#
#testDelayedEmails();
#testStomp();
#testWF();
#curlSolrUpdate();
#testInterwikiLink();
testAvatars();
