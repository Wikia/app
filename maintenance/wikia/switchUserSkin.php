<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * change user_options entry for skin from monaco to oasis
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = WikiFactory::db( DB_SLAVE );
$sth = $dbr->select(
	array( "user" ),
	array( "user_id" ),
	array( "user_options like '%monaco%'" ),
	__METHOD__
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$user = User::newFromId( $row->user_id );
	if( $user ) {
		print $user->getOption( "skin" ) . "\n";
		//$user->invalidateCache();
	}
}
