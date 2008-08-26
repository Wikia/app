<?php

require_once( 'commandLine.inc' );

$dbw = wfGetDB( DB_MASTER );
$oRes = $dbw->select( 
	array( "city_list" ),
 	array( "*" ),
	null,
	__METHOD__
);

$aCityUrls = array();
while ( $oRow = $dbw->fetchObject( $oRes ) ) {

	#--- get wgServer for that wiki
	$oVariable = $dbw->selectRow(
		array( "city_variables" ),
		array( "*" ),
		array(
			"cv_variable_id = (select cv_id from city_variables_pool where cv_name = 'wgServer')",
			"cv_city_id" => $oRow->city_id
		)
	);

	if ( substr($oRow->city_url, -1) == "/") {
		$oRow->city_url = substr($oRow->city_url, 0, -1);
	}
	$_wgServer = unserialize($oVariable->cv_value);

	#--- skip marvels
	if (strpos($oRow->city_url, "marvel") || strpos( $_wgServer, "marvel" ) ) {
		continue;
	}

	#--- skip memory-alpha
	if (strpos($oRow->city_url, "memory-alpha" ) || strpos( $_wgServer, "memory-alpha" ) ) {
		continue;
	}

	if ( $oRow->city_url !== $_wgServer ) {
		if (strlen($_wgServer) == 0) {
			print "wgServer for {$oRow->city_url} is empty\n";
		}
		else {
			$aCityUrls[$oRow->city_id] = $_wgServer."/";
		}
	}
}

$dbw->freeResult( $oRes );

foreach ( $aCityUrls as $id => $url ) {
	print "{$id} => {$url}\n";
	$dbw->update(
		"city_list",
		array( "city_url" => $url ),
		array( "city_id" => $id ),
		__METHOD__
	);
}
$dbw->close();

?>