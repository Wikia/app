<?php

/**
 * Initialization file for the Semantic Data Types extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Semantic_Data_Types
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Semantic_Data_Types
 * Source code:			    http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SemanticDataTypes
 *
 * @file SemanticDataTypes.php
 * @ingroup SDT
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Semantic Data Types.
 *
 * @defgroup SDT Semantic Data Types
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.16c', '<' ) ) { // Needs to be 1.16c because version_compare() works in confusing ways
	die( '<b>Error:</b> the Semantic Data Types requires MediaWiki 1.16 or above.' );
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( ! defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:Semantic_Data_Types">Semantic Data Types</a>.<br />' );
}

if ( version_compare( SMW_VERSION, '1.6 alpha', '<' ) ) {
	die( '<b>Error:</b> Semantic Data Types requires Semantic MediaWiki 1.6 or above.' );
}

define( 'SDT_VERSION', '0.1 alpha' );

$wgExtensionCredits['semantic'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Data Types',
	'version' => SDT_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Data_Types',
	'descriptionmsg' => 'sdt-desc'
);

// i18n
$wgExtensionMessagesFiles['SDT'] 				= dirname( __FILE__ ) . '/SemanticDataTypes.i18n.php';

// Autoloading
$wgAutoloadClasses['SDTSettings'] 				= dirname( __FILE__ ) . '/SemanticDataTypes.settings.php';

$wgAutoloadClasses['SDTDuration'] 				= dirname( __FILE__ ) . '/datavelues/SDT_Duration.php';

// Resource loader modules
$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'SemanticDataTypes/datavelues'
);

unset( $moduleTemplate );

$wgHooks['smwInitDatatypes'][] = 'initSDTypes';

function initSDTypes() {
	SMWDataValueFactory::registerDatatype( '_sdt', 'SDTDuration', SMWDataItem::TYPE_NUMBER, wfMsg( 'sdt-duration' ) );
	return true;
}

$egSDTSettings = array();
