<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

// Log time of Sitemap generation for SEO-382
$timeStart = microtime( true );

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );

require_once( "commandLine.inc" );

$sitemap = new SitemapPage();
$namespaces = $sitemap->getNamespacesList();

wfOut( "Caching {$wgDBname} ({$wgCityId}) for {$sitemap->mCacheTime} sec.\n");

/*
 * DPL causes some problems while parsing wiki text ( Video description )
 * so let's unset DPL parser hooks for maintenance script
 */
$key = array_search( "ExtDynamicPageList::setupDPL", $wgHooks['ParserFirstCallInit'] );
if ( $key > 0 ) {
	unset( $wgHooks['ParserFirstCallInit'][$key] );
}

$indexes = array();
foreach( $namespaces as $namespace ) {
	echo "Caching namespace $namespace...";
	$indexes[ $namespace ] = $sitemap->cachePages( $namespace );
	echo " pages " . count( $indexes[ $namespace ] );
	echo " done\n";

	$includeVideo = (bool) F::app()->wg->EnableVideoSitemaps;
	if( $includeVideo && ( $namespace !=  NS_FILE ) ) {
		$includeVideo = false;
	}

	if($includeVideo) {
		echo  "`-> Caching sitemaps for namespace: $namespace ...\n";
		$sitemap->cacheSitemap( $namespace, $indexes );
	}

}

/**
 * cache for week
 */
$wgMemc->set( wfMemcKey( "sitemap-index"), $indexes, $sitemap->mCacheTime );

// Log time of Sitemap generation for SEO-382:
$timeEnd = microtime( true );

// Only log times for "top" "1k" wikis (doesn't need to be very precise top or 1k)
if ( !empty( $wgAdDriverWikiIsTop1000 ) ) {
	$sitemapPagesPerNs = [];
	foreach ( $indexes as $namespace => $index ) {
		$sitemapPagesPerNs['NS_' . $namespace] = count( $index );
	}
	\Wikia\Logger\WikiaLogger::instance()->info( 'Sitemap generation', [
		'generationTimeMS' => ( $timeEnd - $timeStart ) * 1000,
		'dbName' => $wgDBname,
		'sitemapPagesPerNs' => $sitemapPagesPerNs,
		'sitemapPagesTotal' => array_sum( $sitemapPagesPerNs ),
	] );
}
