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
$dbr = wfGetDB( DB_MASTER );
$sth = $dbr->query(  "select log_user from logging where log_user not in ( select user_id from user )" );
while( $row = $dbr->fetchObject( $sth ) ) {
	$missing[] = $row->log_user;
}

$missing = array_unique( $missing );

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB ); // main wikicities
$dbw = wfGetDB( DB_MASTER, array(), "wikicities_$wgDBcluster" ); // local wikicities for cluster

foreach( $missing as $user_id ) {
	wfOut( "$user_id missing on wikicities_$wgDBcluster\n" );
	$sth = $dbr->select(
		array( "`user`" ),
		array( "*" ),
		array( "user_id" => $user_id ),
		__METHOD__
	);
	$user = $dbr->fetchRow( $sth );

	$user = array(
		"user_id" => $user[ "user_id" ],
		"user_name" => $user[ "user_name" ],
		"user_real_name" => $user[ "user_real_name" ],
		"user_password" => $user[ "user_password" ],
		"user_newpassword" => $user[ "user_newpassword" ],
		"user_email" => $user[ "user_email" ],
		"user_options" => $user[ "user_options" ],
		"user_touched" => $user[ "user_touched" ],
		"user_token" => $user[ "user_token" ],
		"user_email_authenticated" => $user[ "user_email_authenticated" ],
		"user_email_token" => $user[ "user_email_token" ],
		"user_email_token_expires" => $user[ "user_email_token_expires" ],
		"user_registration" => $user[ "user_registration" ],
		"user_newpass_time" => $user[ "user_newpass_time" ],
		"user_editcount" => $user[ "user_editcount" ],
		"user_birthdate" => $user[ "user_birthdate" ]
	);

	if( $dbw->insert( "user", $user, __METHOD__ )) {
		wfOut( "{$user["user_id"]} {$user["user_name"]} copied.\n" );
	}
}
