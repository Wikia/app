<?php

/**
 * Initializing file for Semantic MediaWiki Writer extension.
 *
 * @file
 * @ingroup SMWWriter
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'SMWWRITER_VERSION', '1.5.0 beta' );

$smwwgIP = dirname( __FILE__ );

include_once( "$smwwgIP/api/SMWWriter.php" );
include_once( "$smwwgIP/api/SMWWriter_API.php" );

global $wgExtensionCredits;

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'SMWWriter',
	'version' => SMWWRITER_VERSION,
	'author' => array( '[http://simia.net Denny&#160;Vrandecic]' ),
	'url' => 'http://semantic-mediawiki.org/wiki/Semantic_MediaWiki_Writer',
	'description' => 'API for editing metadata in Semantic MediaWiki'
);