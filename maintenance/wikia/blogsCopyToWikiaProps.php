<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author tomek@wikia
 * @author tor@wikia
 * copy blog data from page_props to page_wikia_props  
 *  
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


if(!empty($wgBlogsInWikiaProps)) {
	echo "Already done";
	exit;
}

$list = BlogArticle::getPropsList();

$dbr = wfGetDB( DB_SLAVE );
$res = $dbr->select(
	array( "page_props" ),
	array( "*" ),
	array( "pp_propname" => array_keys($list), "pp_value" => 1, "pp_page in (select page_id from page where page_namespace = ".NS_BLOG_ARTICLE.") " ),
	__METHOD__
);

$dbr = wfGetDB( DB_MASTER );
while( $row = $dbr->fetchObject( $res ) ) {	
	wfSetWikiaPageProp($list[$row->pp_propname], $row->pp_page, $row->pp_value );
}

$dbr->commit();

WikiFactory::setVarByName("wgBlogsInWikiaProps", $wgCityId, true );
