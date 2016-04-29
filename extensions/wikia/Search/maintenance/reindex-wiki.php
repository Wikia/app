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
	'page_id',
	array( 'page_namespace' => array_unique( $namespaces ) )
);

$ids = [];
foreach ( $select as $row ) {
	if ( $row->page_id ) {
		$ids[] = $row->page_id;
	}
}

$indexer = new Wikia\Search\Indexer();
$idCount = count( $ids );
$sliceCount = 0;
$batchSize = 100;
foreach ( array_chunk( $ids, $batchSize ) as $idSlice ) {
	$sliceCount += $batchSize;
	$indexer->reindexBatch( $idSlice );
	echo "Reindexed {$sliceCount}/{$idCount} docs\n";
}

echo "Indexing process complete.\n";
