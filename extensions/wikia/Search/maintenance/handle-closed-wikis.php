<?php

/**
 * This script is responsible for "handling" all closed wikis with respect to search in a batch process.
 * At this point, it means removing all documents from the index. 
 * 
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

include_once("$IP/extensions/wikia/Search/WikiaSearch.setup.php");

$indexer = (new WikiaSearchIndexer);

if ( empty( $wgExternalSharedDB ) ) {
	echo "This script should not run on a single-wiki instance.\n"; die;
}

$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

$select = $dbr->select(
		'city_list',
		'city_id',
		'city_public < 1'
		);

$rowCount = $select->numRows() ;

echo $rowCount . " closed wikis\n";

$counter = 1;
$wids = array();
foreach ( $select as $row ) {
	$wids[] = $row->city_id;
	if ( $counter++ % 25 == 0 ) {
		$indexer->deleteManyWikiDocs( $wids );
		echo "Handled {$counter}/{$rowCount} wikis\n";
		$wids = array();
	}
}

echo "Finished removing closed wiki documents from index.\n";