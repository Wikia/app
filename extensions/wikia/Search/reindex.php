<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

include("$IP/extensions/wikia/Search/WikiaSearch.setup.php");

$wgUser = User::newFromName('Owen Davis');
$wgTitle = Title::newMainPage();
$c = RequestContext::getMain();
$c->setUser($wgUser);
$c->setTitle($wgTitle);

$indexer = F::build( 'WikiaSearchIndexer' );

$dbr = wfGetDB( DB_MASTER );

$select = $dbr->select(
		'page',
		'id'
		);

foreach ( $select as $row ) {
	$ids[] = $row->id;
}

$idCount = count($ids);
for ( $i = 0; $i < $idCount; $i += 10 ) {
	$idSlice = array_slice( $ids, $i, $i + 10 );
	$sliceCount = count( $idSlice );
	$indexer->reindexBatch( $idSlice );
	echo "Reindexed {$sliceCount}/{$idCount} docs\n";
}

echo "Indexing process complete.\n";