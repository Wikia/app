<?php

/**
 * Script tests fetching revision texts from external clusters
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );

$optionsWithArgs = array(
);


require_once( "commandLine.inc" );

$urls = array(
	"DB://archive1/191",
	"DB://archive1/211",
	"DB://archive1/1910000000000",
//	"DB://archive2/191",
//	"DB://archive2/211",
);

foreach ($urls as $url) {
	$data = ExternalStore::fetchFromUrl($url);
	$text = gzinflate( $data );
	var_dump($url,$data,$text);
}