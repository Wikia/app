<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * move category to tags table
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = WikiFactory::db( DB_SLAVE );
$sth = $dbr->select(
	array( "city_list" ),
	array( "*" ),
	array( "city_public" => 1 ),
	__METHOD__
);

while( $row = $dbr->fetchObject( $sth ) ) {
	/**
	 * get category for wiki
	 */
	$hub = WikiFactoryHub::getInstance()->getCategoryName( $row->city_id );

	/**
	 * set this as tag
	 */
	$tags = new WikiFactoryTags( $row->city_id );
	$tags->addTagsByName( $hub );

	Wikia::log( "CatAsTag", false, "$hub added as tag in {$row->city_id}" );
}
