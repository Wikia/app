<?php
/**
 * Reindex one full wiki using Indexer class.
 * @package MediaWiki
 * @addtopackage maintenance
 */

require_once( "../../../../maintenance/commandLine.inc" );

include( "$IP/extensions/wikia/Search/WikiaSearch.setup.php" );

global $wgContentNamespaces, $wgExtraNamespaces;
$wgUser = User::newFromName( 'Owen Davis' );
$wgTitle = Title::newMainPage();
$c = RequestContext::getMain();
$c->setUser( $wgUser );
$c->setTitle( $wgTitle );

$indexer = ( new Wikia\Search\Indexer );

$dbr = wfGetDB( DB_MASTER );

$namespaces = !empty( $wgExtraNamespaces ) ? array_merge( $wgContentNamespaces, $wgExtraNamespaces ) : $wgContentNamespaces;

if ( !in_array( NS_FILE, $namespaces ) ) {
	$namespaces[] = NS_FILE;
}

$select = $dbr->select(
	'page',
	'page_id',
	array( 'page_namespace' => $namespaces )
);

foreach ( $select as $row ) {
	if ( $row->page_id ) {
		$ids[] = $row->page_id;
	}
}

$idCount = count( $ids );
$sliceCount = 0;
$batchSize = 100;
foreach ( array_chunk( $ids, $batchSize ) as $idSlice ) {
	$sliceCount += $batchSize;
	$indexer->reindexBatch( $idSlice );
	echo "Reindexed {$sliceCount}/{$idCount} docs\n";
}

echo "Indexing process complete.\n";
