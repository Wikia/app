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

$path = $IP . '/extensions/wikia/GameGuides/assets/GameGuidesAssets.json';

$resources = F::app()->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
	'scripts' => 'gameguides_js',
	'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
) );

$ret->styles = $resources->getVal( 'styles', '' );
$ret->scripts = $resources->getVal( 'scripts', '' );

file_put_contents($path, json_encode($ret));

echo 'Assets saved - ' . realpath($path) . "\n";