<?php
/**
 * Reindex one full wiki using Indexer class.
 * @package MediaWiki
 * @addtopackage maintenance
 */

require_once( "../../../../maintenance/commandLine.inc" );
include( "$IP/extensions/wikia/Search/WikiaSearch.setup.php" );

$options = getopt( '', [ 'id:', 'reindex-missing', 'dry-run' ] );

$isDryRun = isset( $options[ 'dry-run' ] );
$reindexMissing = isset( $options[ 'reindex-missing' ] );

if ( isset( $options[ 'id' ] ) ) {
	$ids = $options[ 'id' ];
}

// Namespaces to refresh additionally to those in wgContentNamespaces and wgExtraNamespaces
$additionalNamespaces = [ NS_FILE ];

$namespaces = array_merge( $wgContentNamespaces, $additionalNamespaces );
if ( !empty( $wgExtraNamespaces ) ) {
	$namespaces = array_merge( $namespaces, $wgExtraNamespaces );
}

$dbr = wfGetDB( DB_MASTER );
$whereClause = [
	'page_namespace' => array_unique( $namespaces ),
	'page_is_redirect' => 0
];
if ( !empty( $ids ) ) {
	$whereClause[ 'page_id' ] = $ids;
}
$select = $dbr->select(
	'page',
	[ 'page_id', 'page_namespace', 'page_latest', 'page_title' ],
	$whereClause
);

$titles = [];
foreach ( $select as $row ) {
	$title = Title::newFromRow( $row );
	$titles[ $row->page_id ] = $title;
}

if ( $reindexMissing ) {
	global $wgSolrHost, $wgSolrPort, $wgCityId;
	$solariumConfig = [
		'adapter' => 'Solarium_Client_Adapter_Curl',
		'adapteroptions' => [
			'host' => $wgSolrHost,
			'port' => $wgSolrPort,
			'path' => '/solr/',
			'core' => 'main',
		]
	];
	$notIndexedTitles = [];

	$current = 0;
	$current++;
	/** @var Title $title */
	foreach ( $titles as $title ) {
		$client = new Solarium_Client( $solariumConfig );
		$select = $client->createSelect();
		$select->createFilterQuery( 'id' )->setQuery( 'id:' . sprintf( "%s_%s", $wgCityId, $title->getArticleID() ) );
		$select->setFields( [ 'id' ] );
		$result = $client->select( $select );
		if ( $current % 100 == 0 ) {
			echo "checking solr for missing docs {$current}/{$idCount} docs\n";
		}
		if ( $result->getNumFound() == 0 ) {
			$notIndexedTitles[] = $title;
		}
	}
	$titles = $notIndexedTitles;
}

$idCount = count( $titles );
$current = 0;

foreach ( $titles as $title ) {
	$current++;
	if ( $isDryRun ) {
		echo "Reindexed in dry run mode articleId: {$title->getArticleID()}, title: {$title->getText()}\n";
	} else {
		Wikia\IndexingPipeline\PipelineEventProducer::reindexPage( $title );
	}

	if ( $current % 100 == 0 ) {
		echo "Reindexed {$current}/{$idCount} docs\n";
	}
}

echo "Indexing process complete.\nReindexed {$current} docs.\n";
