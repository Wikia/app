<?php
/**
 * @brief Script to 'freeze' assets for GameGuides
 *
 * @package MediaWiki
 * @author Jakub Olek
 */

ini_set( "include_path", dirname(__FILE__) . "/.." );
require_once( "commandLine.inc" );

$ret = new StdClass();

//Path where to save assets
$path = $IP . '/extensions/wikia/GameGuides/assets/';


if ( !is_dir( $path ) ) {
	mkdir($path);
} else {
	//If dir exists remove all files inside
	array_map( 'unlink', glob( $path . '*' ) );
}

//Get assets
$resources = F::app()->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
	'scripts' => 'gameguides_js',
	'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
) );

$file = $path . md5( $resources ) . '.json';

$ret->styles = $resources->getVal( 'styles', '' );
$ret->scripts = $resources->getVal( 'scripts', '' );

file_put_contents( $file, json_encode( $ret ) );

echo 'Assets saved - ' . realpath( $file ) . "\n";