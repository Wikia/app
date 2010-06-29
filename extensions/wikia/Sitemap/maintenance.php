<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );

require_once( "commandLine.inc" );

$sitemap = new SitemapPage();
$namespaces = $sitemap->getNamespacesList();
$indexes = array();
foreach( $namespaces as $namespace ) {
	echo "Caching namespace $namespace...";
	$indexes[ $namespace ] = $sitemap->cachePages( $namespace );
	echo " pages " . count( $indexes[ $namespace ] );
	echo " done\n";
}

/**
 * cache for week
 */
$wgMemc->set( wfMemcKey( "sitemap-index"), $indexes, 86400*7 );
