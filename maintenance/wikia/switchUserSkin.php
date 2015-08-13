<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * change user_options entry for skin from monaco to oasis
 *
 */

$optionsWithArgs = array( 'limit', "user-id" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$limits = isset( $options[ "limit" ] )
	? array( "LIMIT" => $options[ "limit" ] )
	: array();

$where = array( "user_options not like '%skin=wowwiki%' and user_options not like '%skin=monaco%' and user_options not like '%skin=oasis%' and user_options not like '%skin=monobook%' and user_options not like '%skin=lostbook%'" );

if( isset( $options[ "user-id"] ) ) {
    $where = array( "user_id" => $options[ "user-id"] );
}

$dbr = WikiFactory::db( DB_SLAVE );
$sth = $dbr->select(
	array( "user" ),
	array( "user_id", "user_name" ),
	$where,
	__METHOD__,
	$limits
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$user = User::newFromId( $row->user_id );
	if( $user ) {
		/**
		 * not needed but maybe user changed something meanwhile
		 */
		if( $user->getGlobalPreference( "skin" ) === "" ) {
			wfOut ("Moving {$user->getName()} ({$user->getId()}) skin preferences from {$user->getGlobalPreference( "skin" )} to oasis\n");
			$user->setGlobalPreference( "skin", "oasis" );
			$user->saveSettings();
			$user->invalidateCache();
		}
	}
}
