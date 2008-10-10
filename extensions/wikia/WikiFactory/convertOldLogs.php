<?php

/**
 * one-time-script for moving old logs to new one
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_MASTER );

$res = $dbw->select(
	wfSharedTable("city_variables_log"),
	array( "*" ),
	array( 1 => 1 ),
	__METHOD__,
	array( "ORDER BY" => "cv_timestamp" )
);

while( $row = $dbw->fetchObject( $res ) ) {
	/**
	 * convert to mysql timestamp
	 */
	$timestamp = wfTimestamp( TS_DB, $row->cv_timestamp );
	$variable = WikiFactory::getVarById( $row->cv_variable_id, $row->cv_city_id );
	echo $timestamp . " : " . $row->cv_city_id . " : " . $variable->cv_name ."\n";;
	$msg = sprintf("Variable %s set value from %s (imported old log)",	$variable->cv_name, var_export( unserialize( $row->cv_value_old ), true ) );

	$log = array(
		"cl_city_id" => $row->cv_city_id,
		"cl_user_id" => $row->cv_user_id,
		"cl_type" => WikiFactory::LOG_VARIABLE,
		"cl_text" => $msg,
		"cl_timestamp" => $timestamp
	);
	$dbw->insert(
		wfSharedTable( "city_list_log" ),
		$log,
		__METHOD__
	);
}
