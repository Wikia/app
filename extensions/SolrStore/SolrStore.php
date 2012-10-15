<?php

/**
 * The SolrStore Extension is a Semantic Mediawiki Search provider based on
 * Apache Solr.
 *
 * @defgroup SolrStore
 * @author Stephan Gambke, Simon Bachenberg
 * @version 0.5 Beta
 */

/**
 * The main file of the SolrConnector extension
 *
 * @file
 * @ingroup SolrStore
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

if ( !defined( 'SMW_VERSION' ) ) {
	die( 'SolrConnector depends on the Semantic MediaWiki extension. You need to install Semantic MediaWiki first.' );
}

/**
 * The Solr Connector version
 */
define( 'SC_VERSION', '0.5 Beta' );

// register the extension
// TODO: Add other authors here and in the file header
$wgExtensionCredits[ defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other' ][ ] = array(
	'path'			=>__FILE__,
	'name'			=>'SolrStore',
	'author'		=>array( '[https://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]', '[https://www.mediawiki.org/wiki/User:SBachenberg Simon Bachenberg]', 'Sascha Schüller' ),
	'url'			=>'https://www.mediawiki.org/wiki/Extension:SolrStore',
	'descriptionmsg'=>'solrstore-desc',
	'version'		=>SC_VERSION,
);


// server-local path to this file
$dir = dirname( __FILE__ );

// register message file
$wgExtensionMessagesFiles[ 'SolrStore' ]		= $dir . '/SolrStore.i18n.php';
$wgExtensionMessagesFiles[ 'SolrStoreAlias' ]	= $dir . '/SolrStore.alias.php';

// register class files with the Autoloader
$wgAutoloadClasses[ 'SolrConnectorStore' ]		= $dir . '/SolrConnectorStore.php';
$wgAutoloadClasses[ 'SolrDoc' ]					= $dir . '/SolrDoc.php';
$wgAutoloadClasses[ 'SolrTalker' ]				= $dir . '/SolrTalker.php';
$wgAutoloadClasses[ 'SolrSearch' ]				= $dir . '/SolrSearch.php';
$wgAutoloadClasses[ 'SolrResult' ]				= $dir . '/SolrSearch.php';
$wgAutoloadClasses[ 'SolrSearchSet' ]			= $dir . '/SolrSearch.php';
$wgAutoloadClasses[ 'SpecialSolrSearch' ]		= $dir . '/SpecialSolrSearch.php';
$wgAutoloadClasses[ 'SolrSearchFieldSet' ]		= $dir . '/SolrSearchFieldSet.php';


// Specialpage
$wgSpecialPages[ 'SolrSearch' ]			= 'SpecialSolrSearch'; # Tell MediaWiki about the new special page and its class name
$wgSpecialPageGroups[ 'SolrSearch' ]	= 'smw_group';


// original store
$wgscBaseStore				= $smwgDefaultStore;
$smwgDefaultStore			= "SolrConnectorStore";
$smwgQuerySources[ "solr" ] = "SolrConnectorStore";
$wgSearchType				= 'SolrSearch';

// Solr Configuration
$wgSolrTalker		= new SolrTalker();
$wgSolrShowRelated	= true;
$wgSolrDebug		= false;
$wgSolrUrl			= 'http://127.0.0.1:8080/solr';
$wgSolrFields		= array( );
