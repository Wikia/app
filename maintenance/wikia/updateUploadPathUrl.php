<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

$dbw = wfGetDB( DB_MASTER );
$res = $dbw->select(
	wfSharedTable( "city_variables" ),
	array( "*" ),
	array( "cv_variable_id" => 16 ),
	__METHOD__
);

$fix = array();
while( $row = $dbw->fetchObject( $res ) )  {
	$before = unserialize( $row->cv_value );
	$after = rtrim( $before, "/" );
	if( $before !== $after ){
		echo "{$before} -> {$after}\n";
		$fix[ $row->cv_city_id ] =  serialize( $after );
	}
}

foreach( $fix as $city_id => $value ) {
	$dbw->begin();
	$dbw->update(
		wfSharedTable( "city_variables" ),
		array( "cv_value" => $value ),
		array( "cv_city_id" => $city_id, "cv_variable_id" => 16 )
	);
	$dbw->commit();
}
$dbw->close();
