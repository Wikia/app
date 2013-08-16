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

$path = $IP . '/extensions/wikia/GameGuides/assets/';

$resources = F::app()->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
	'scripts' => 'gameguides_js',
	'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
) );

$ret->styles = $resources->getVal( 'styles', '' );
$ret->scripts = $resources->getVal( 'scripts', '' );

if ( !is_dir( $path ) ) {
	mkdir($path);
}

$cb = (int) file_get_contents( $path . 'GameGuidesCacheBuster' ) + 1;

file_put_contents( $path . 'GameGuidesAssets.json', json_encode( $ret ) );
file_put_contents( $path . 'GameGuidesCacheBuster', $cb );

echo 'Assets saved - ' . realpath($path) . "\n";
echo 'Cache Buster - ' . $cb . "\n";