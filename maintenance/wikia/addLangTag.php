<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 * @author tor@wikia
 *
 * add language tag to all wikis
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
	array( "city_public" => 1, "city_lang != 'en'" ),
	__METHOD__
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$lang = $row->city_lang;
	switch ( $lang ) {
		case 'zh-tw':
		case 'zh-hk':
		case 'zh-clas':
		case 'zh-class':
		case 'zh-cn':
		case 'zh-hans':
		case 'zh-hant':
		case 'zh-min-':
		case 'zh-min-n':
		case 'zh-mo':
		case 'zh-sg':
		case 'zh-yue':
			$lang = 'zh';
			break;
		case 'pt-br':
			$lang = 'pt';
			break;
	}

	/**
	 * set this as tag
	 */
	$tags = new WikiFactoryTags( $row->city_id );
	wfWaitForSlaves( 5 );
	$tags->addTagsByName( $lang );

	Wikia::log( "AddLangTag", false, "$hub added as tag in {$row->city_id}" );
}
