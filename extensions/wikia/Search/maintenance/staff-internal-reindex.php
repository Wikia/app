<?php
/**
 * Responsible for reindexing on staff and internal, using Indexer class.
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", "{$IP}/maintenance/" );
require_once( "commandLine.inc" );

include("$IP/extensions/wikia/Search/WikiaSearch.setup.php");

global $wgContentNamespaces, $wgExtraNamespaces;
$wgUser = User::newFromName('Owen Davis');
$wgTitle = Title::newMainPage();
$c = RequestContext::getMain();
$c->setUser($wgUser);
$c->setTitle($wgTitle);

$indexer = (new WikiaSearchIndexer);

$dbr = wfGetDB( DB_MASTER );

$namespaces = !empty( $wgExtraNamespaces ) ? array_merge( $wgContentNamespaces, $wgExtraNamespaces ) : $wgContentNamespaces;

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

$idCount = count($ids);
$sliceCount = 0;
foreach ( array_chunk( $ids, 10 ) as $idSlice ) {
	$sliceCount += 10;
	$indexer->reindexBatch( $idSlice );
	echo "Reindexed {$sliceCount}/{$idCount} docs\n";
}

echo "Indexing process complete.\n";