<?php

/**
 * migrate user data from local to shared database
 */


ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

include "fixloggingwowwiki.inc.php";

if( $wgCityId <> 490 ) {
	echo "Not wowwiki site. Exiting...\n";
	exit( 1 );
}
$dbw = wfGetDB( DB_MASTER );
$dbr = wfGetDB( DB_SLAVE );

$res = $dbw->select(
	array( "logging" ),
	array( "*" ),
	array( "log_timestamp < 20080318000001" ),
	__METHOD__,
	array( "order by" => "log_timestamp" )
);

$users = array();
while( $row = $dbw->fetchObject( $res ) ) {
	$log_user = isset($logging[ $row->log_id ] ) ? $logging[ $row->log_id ] : false ;
	if( $log_user ) {
		if( isset( $users[ $log_user ] ) && $users[ $log_user ] ){
			$user_id = $users[ $log_user ];
		}
		else {
			/**
			 * check username in local table
			 */
			$localUser = $dbr->selectRow(
				array( "wowwiki.user" ),
				array( "user_name", "user_id" ),
				array( "User_id" => $log_user ),
				__METHOD__
			);

			if( isset( $localUser->user_name ) ) {
				$sharedUser = $dbr->selectRow(
					array( wfSharedTable ( "user" ) ),
					array( "user_id" ),
					array( "User_name" => $localUser->user_name ),
					__METHOD__
				);
				$users[ $localUser->user_id ] = $sharedUser->user_id;
				$user_id = $sharedUser->user_id;
				#echo "{$localUser->user_name} changed id from {$localUser->user_id} to {$sharedUser->user_id}\n";
			}
			else {
				#echo "unknown username for {$log_user} {$row->log_id}\n";
				$user_id = false;
			}
		}
	}

	/**
	 * only for known users
	 */
	if( $user_id ) {
		echo "fixing position: {$row->log_id} log_user = {$user_id}\n";
		$dbw->begin();
		$dbw->update(
			"logging",
			array( "log_user" => $user_id ),
			array( "log_id" => $row->log_id ),
			__METHOD__
		);
		$dbw->commit();
	}
}
