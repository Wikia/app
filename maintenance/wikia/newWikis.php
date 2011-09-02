<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {
	require_once( dirname(__FILE__) . '/../commandLine.inc' );

	$fname = 'newWikis';
	$allowedFormat = array('xml', 'csv');
	$format = isset( $options[ "format" ] ) ? $options[ "format" ] : false;

	if ( !$format ) {
		print "Usage: php newWikis.php --format=xml[,csv]\n";
		exit;
	}

	$aFormat = explode(",", $format);
	if (!empty($aFormat)) {
		foreach ($aFormat as $f) {
			if ( in_array($f, $allowedFormat) ) {
				generateList( $f );
			}
		}
	}
}

function begin_xml() {
	return Xml::openElement( "citylist" ) . "\n";
}

function begin_csv() {
	return implode( ",", array(
		__quote( "id" ),
		__quote( "sitename" ),
		__quote( "url" ),
		__quote( "language" ),
		__quote( "category-name" ),
		__quote( "category-id" )
	) )  . "\n";
}

function body_xml($oRow) {
	return Xml::element( "siteinfo",
		array(
			"id"            => $oRow->city_id,
			"sitename"      => $oRow->city_title,
			"url"           => $oRow->city_url,
			"language"      => $oRow->city_lang,
			"category-name" => empty( $oRow->category->cat_name ) ? 'unknown' : $oRow->category->cat_name,
			"category-id"   => empty( $oRow->category->cat_id ) ? 0 : $oRow->category->cat_id
		)
	) . "\n";
}

function body_csv($oRow) {
	return implode( ",", array(
		__quote( $oRow->city_id ),
		__quote( $oRow->city_title ),
		__quote( $oRow->city_url ),
		__quote( $oRow->city_lang ),
		empty( $oRow->category->cat_name ) ? __quote( 'unknown' ) : __quote( $oRow->category->cat_name ),
		empty( $oRow->category->cat_id ) ? __quote( 0 ) : __quote( $oRow->category->cat_id )
	) ) ."\n";
}

function end_xml() {
	return Xml::closeElement( "citylist" ) . "\n";
}

function end_csv() {
	return "";
}

function __quote( $str ) {
	return '"'. str_replace( '"', '\"', $str ). '"';
}


function generateList( $format ) {
	global $wgMemc, $wgExternalSharedDB;
	
	$func = "begin_".$format; $res = $func();
	$dbr = WikiFactory::db( DB_SLAVE, array(), $wgExternalSharedDB );
	$sth = $dbr->select(
		array( "city_list" ),
		array( "city_title", "city_lang", "city_url", "city_id" ),
		array( "city_public = 1" ),
		__METHOD__
	);
	while( $row = $dbr->fetchObject( $sth ) ) {
		$row->category = WikiFactory::getCategory( $row->city_id );
		$func = "body_".$format; $res .= $func($row);
	}
	$func = "end_".$format; $res .= $func();
	
	if ( !empty($res) ) {
		$gz_res = gzdeflate($res, 3);
		$wgMemc->set( wfSharedMemcKey( "{$format}-city-list" ), $gz_res, 3600 * 6 );
	}
}

