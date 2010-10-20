<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * change user_options entry for skin from monaco to oasis
 *
 */

$optionsWithArgs = array( 'limit' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$limits = isset( $options[ "limit" ] )
	? array( "LIMIT" => $options[ "limit" ] )
	: array();

$dbr = WikiFactory::db( DB_SLAVE );
$sth = $dbr->select(
	array( "user" ),
	array( "user_id", "user_name" ),
	array( "user_options not like '%skin=wowwiki%' and user_options not like '%skin=monaco%' and user_options not like '%skin=oasis%' and user_options not like '%skin=monobook%' and user_options not like '%skin=lostbook%'" ),
	__METHOD__,
	$limits
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$user = User::newFromId( $row->user_id );
	if( $user ) {
		/**
		 * not needed but maybe user changed something meanwhile
		 */
		if( $user->getOption( "skin" ) === "" ) {
			wfOut ("Moving {$user->getName()} ({$user->getId()}) skin preferences from monaco to oasis\n");
#			$user->setOption( "skin", "oasis" );
#			$user->saveSettings();
#			$user->invalidateCache();
		}
	}
}
