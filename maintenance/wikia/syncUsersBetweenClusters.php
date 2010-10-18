<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * take user_id from revision & logging table and check if exists in local
 * copy of wikicites
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

if( empty( $wgDBcluster ) ) {
	wfOut( "Do not run this script on first cluster\n" );
}

$missing = array();
$dbr = wfGetDB( DB_SLAVE );
$sth = $dbr->query(  "select log_user from logging where log_user not in ( select user_id from user )" );
while( $row = $dbr->fetchObject( $sth ) ) {
	$missing[] = $row->log_user;
}

$missing = array_unique( $missing );

foreach( $missing as $user_id ) {
	wfOut( "$user_id missing on wikicities_$wgDBcluster\n";
}
