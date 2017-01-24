<?php
/**
 * Reindex one full wiki using Indexer class.
 * @package MediaWiki
 * @addtopackage maintenance
 */

require_once( "../../../../maintenance/commandLine.inc" );
include( "$IP/extensions/wikia/Search/WikiaSearch.setup.php" );

// Namespaces to refresh additionally to those in wgContentNamespaces and wgExtraNamespaces
$additionalNamespaces = [ NS_FILE ];

$namespaces = array_merge( $wgContentNamespaces, $additionalNamespaces );
if ( !empty( $wgExtraNamespaces ) ) {
	$namespaces = array_merge( $namespaces, $wgExtraNamespaces );
}

$dbr = wfGetDB( DB_MASTER );
$select = $dbr->select(
	'page',
	[ 'page_id', 'page_namespace', 'page_latest', 'page_title' ],
	[ 'page_namespace' => array_unique( $namespaces ) ]
);

$idCount = count( $select );
$current = 0;


foreach ( $select as $row ) {
	$current++;
	$title = Title::newFromRow( $row );
	Wikia\IndexingPipeline\PipelineEventProducer::reindexPage( $title );

	if ( $current % 100 == 0 ) {
		echo "Reindexed {$current}/{$idCount} docs\n";
	}
}

echo "Indexing process complete.\nReindexed {$idCount} docs.\n";
