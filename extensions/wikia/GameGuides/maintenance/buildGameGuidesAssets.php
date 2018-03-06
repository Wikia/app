<?php
/**
 * @brief Script to 'freeze' assets for GameGuides
 *
 * @package MediaWiki
 * @author Jakub Olek
 */

require_once( __DIR__ . "/../../../../maintenance/commandLine.inc" );

//Path where to save assets
$path = $IP . '/extensions/wikia/GameGuides/assets/';
$file = $path . 'GameGuidesAssets.json';

if ( !is_dir( $path ) ) {
	mkdir( $path );
}

//Get assets
$resources = F::app()->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
	'scripts' => 'gameguides_js',
	'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
) );

$ret = new StdClass();
$ret->styles = $resources->getVal( 'styles', '' );
$ret->scripts = $resources->getVal( 'scripts', '' );

file_put_contents( $file, json_encode( $ret ) );

echo 'Assets saved - ' . realpath( $file ) . "\n";