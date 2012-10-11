<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

include("$IP/extensions/wikia/Search/WikiaSearch.setup.php");

$indexer = F::build( 'WikiaSearchIndexer' );

$dbr = wfGetDB( DB_MASTER );

$select = $dbr->select(
		'page',
		'id'
		);

foreach ( $select as $row ) {
	$ids[] = $row->id;
}

for ( $i = 0; $i < count($ids); $i += 10 ) {
	$idSlice = array_slice( $ids, $i, $i + 10 );
	$indexer->reindexBatch( $idSlice, WikiaSearchIndexer::REINDEX_VERBOSE );
}

echo "Indexing process complete.";