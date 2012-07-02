<?php

/**
 * An extension creating a series of pages from one Semantic Form.
 *
 * @defgroup SemanticPageSeries Semantic Page Series
 * @author Stephan Gambke
 * @version 0.2 alpha
 */
/**
 * The main file of the SemanticPageSeries extension
 *
 * @author Stephan Gambke
 *
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

if ( !defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Page_Series">Semantic Page Series</a> depends on the Semantic MediaWiki extension. You need to install <a href="https://www.mediawiki.org/wiki/Extension:Semantic_MediaWiki">Semantic MediaWiki</a> first.' );
}

if ( !defined( 'SF_VERSION' ) ) {
	die( '<b>Error:</b> <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Page_Series">Semantic Page Series</a> depends on the Semantic Forms extension. You need to install <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Forms">Semantic Forms</a> first.' );
}

/**
 * The Semantic Page Series version
 */
define( 'SPS_VERSION', '0.2 alpha' );

// register the extension
$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Page Series',
	'author' => '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Semantic_Page_Series',
	'descriptionmsg' => 'semanticpageseries-desc',
	'version' => SPS_VERSION,
);


// server-local path to this file
$dir = dirname( __FILE__ );

// register message files
$wgExtensionMessagesFiles['SemanticPageSeries'] = $dir . '/SemanticPageSeries.i18n.php';
$wgExtensionMessagesFiles['SemanticPageSeriesMagic'] = $dir . '/SemanticPageSeries.magic.php';
$wgExtensionMessagesFiles['SemanticPageSeriesAlias'] = $dir . '/SemanticPageSeries.alias.php';

// register class files with the Autoloader
$wgAutoloadClasses['SPSUtils'] = $dir . '/includes/SPSUtils.php';
$wgAutoloadClasses['SPSSpecialSeriesEdit'] = $dir . '/includes/SPSSpecialSeriesEdit.php';
$wgAutoloadClasses['SPSException'] = $dir . '/includes/SPSException.php';
$wgAutoloadClasses['SPSPageCreationJob'] = $dir . '/includes/SPSPageCreationJob.php';

$wgAutoloadClasses['SPSIterator'] = $dir . '/includes/iterators/SPSIterator.php';
$wgAutoloadClasses['SPSDateIterator'] = $dir . '/includes/iterators/SPSDateIterator.php';
$wgAutoloadClasses['SPSCountIterator'] = $dir . '/includes/iterators/SPSCountIterator.php';


// register Special page
$wgSpecialPages['SeriesEdit'] = 'SPSSpecialSeriesEdit'; # Tell MediaWiki about the new special page and its class name

// register hook handlers

// Specify the function that will initialize the parser function.
$wgHooks['ParserFirstCallInit'][] = 'SPSUtils::initParserFunction';

// define constants
define('SPS_NOLIMIT', PHP_INT_MAX);

// register iterators
$spsgIterators = array (
	'date' => 'SPSDateIterator',
	'count' => 'SPSCountIterator',
);

$spsgPageGenerationLimits = array(
	'*' => 0,
	'user' => 10,
	'sysop' => SPS_NOLIMIT	
);


$wgJobClasses['spsCreatePage'] = 'SPSPageCreationJob';
