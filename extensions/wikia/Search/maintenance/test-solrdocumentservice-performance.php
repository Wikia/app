<?php
/**
 * Lets us test the performance of a given snippetting approach
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$options = getopt( 'i:s::fc::', [ 'id:', 'service::', 'force', 'conf::' ] );

global $wgEnableParserCache, $wgAllowMemcacheReads;
$wgEnableParserCache = false;
$wgAllowMemcacheReads = false;

$articleId = $options['id'];
$mws = new Wikia\Search\MediaWikiService();
$service = new ArticleService( $mws->getCanonicalPageIdFromPageId( $articleId ) );

$start = microtime( true );
$type = 'default';
if ( isset( $options['service'] ) && $options['service'] == 'solr' ) {
	$type = 'solr';
	$response = $service->getTextSnippetFromSolr();
} else {
	$response = $service->getTextSnippet();
}
echo sprintf( "%.2f (%s) %s\n", microtime( true ) - $start, $type, $response );
