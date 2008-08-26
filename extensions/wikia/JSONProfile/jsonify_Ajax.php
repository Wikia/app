<?php

function jsonify($the_object) {
	global $IP;
	
	require_once( "$IP/extensions/wikia/JSONProfile/JSON.php" );
	$json = new Services_JSON();
	
	return $json->encode($the_object);
}

function unjsonify($theString){
	global $IP;
	
	require_once( "$IP/extensions/wikia/JSONProfile/JSON.php" );
	$json = new Services_JSON();
	
	return $json->decode($theString);
}

?>
