<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

print $IP."/maintenance/wikia/sql/tags.csv";
$csv = file_get_contents( $IP."/maintenance/wikia/sql/tags20100310.csv" );

$ready = array();
foreach( explode( "\n", $csv) as $line ) {
	$tags  = explode( ",", $line );
	$city_id     = array_shift( $tags );
	$city_dbname = array_shift( $tags );
	$city_cat    = array_shift( $tags );
	$city_url    = array_shift( $tags );

	/**
	 * add category as tag
	 */
	$tags[] = $city_cat;

	/**
	 * skip first row = labels
	 */
	if( !is_numeric( $city_id ) ) {
		continue;
	}
	$wfTags = new WikiFactoryTags( $city_id );
	$wfTags->removeTagsAll();
	/**
	 * first remove all tags
	 */
	foreach( $tags as $tag ) {
		if( strlen( $tag ) ) {
			$tag = str_replace( " ", "_", strtolower( trim( $tag ) ) );
			$ready[ $tag ]++;
			$wfTags->addTagsByName( $tag );
		}
	}
}
ksort( $ready );
print_r( $ready );
