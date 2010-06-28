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
foreach( $namespaces as $namespace ) {
	echo "Caching namespace $namespace...";
	$out = $sitemap->cachePages( $namespace );
	echo "done\n";
	print_r( $out );
}
