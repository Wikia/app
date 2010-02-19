<?php 

set_include_path(get_include_path().PATH_SEPARATOR.dirname( __FILE__ ).PATH_SEPARATOR.dirname( __FILE__ )."/Stomp");
require_once "Stomp.php";

$wgStompServer = 'tcp://10.10.10.8:61613'; #61613
#$wgStompServer = 'tcp://10.8.2.221:61613';
$wgStompUser = 'guest';
$wgStompPassword = 'guest';

function testStomp() {
	global $wgStompServer, $wgStompUser, $wgStompPassword, $wgCityId;

	try {
		echo "wgStompServer = ". $wgStompServer ."\n";
		$stomp = new Stomp( $wgStompServer );
		$stomp->connect( $wgStompUser, $wgStompPassword );
		echo "connected \n";
		$q = "wikia.article.edit.177";
		$stomp->sync = false;
		$stomp->send( $q, "test", array(
			'exchange' => 'amq.topic', 
			'bytes_message' => 1, 
			'routing_key' => "wikia.article.#"
		)); 
		echo "sent \n";
		$stomp->disconnect();
	}
	catch( Stomp_Exception $e ) {
		echo __METHOD__ . 'stomp_exception, ' . $e->getMessage() ;
	}
}

testStomp();
