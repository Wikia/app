<?php 

set_include_path(get_include_path().PATH_SEPARATOR.dirname( __FILE__ ).PATH_SEPARATOR.dirname( __FILE__ )."/Stomp");

require_once "Stomp.php";

$wgStompServer = 'tcp://10.10.10.8:61613'; #61613
$wgStompUser = 'guest';
$wgStompPassword = 'guest';

function receiveStomp() {
	global $wgStompServer, $wgStompUser, $wgStompPassword, $wgCityId;

	$stomp = new Stomp( $wgStompServer );
	$stomp->setReadTimeout(10);
	$q = "wikia.article.#";
	$stomp->connect( $wgStompUser, $wgStompPassword );
	$stomp->subscribe($q, array(
		'exchange' => 'amq.topic', 
		'ack' => 'client',
		'activemq.prefetchSize' => 1, 
		'routing_key' => "wikia.article.#"
	) 
	);
	while(1) {
		try {
			$msg = $stomp->readFrame();
			// do what you want with the message
			if ( $msg != null) {
				echo "Message '$msg->body' received from topic\n";
				#echo print_r($msg, true);
				$stomp->ack($msg);
			} else {
				//echo "Failed to receive a message\n";
			}
		}
		catch( StompException $e ) {
			echo __METHOD__ . 'stomp_exception, ' . $e->getMessage() ;
		}
	}
	
	// disconnect
	$stomp->disconnect();
}

receiveStomp();
