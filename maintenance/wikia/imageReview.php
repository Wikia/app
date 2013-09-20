<?php
/**
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author:  Tomasz Odrobny (Tomek) tomek@wikia-inc.com
 *
 * @copyright Copyright (C) 2008 Tomasz Odrobny (Tomek), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *

 */
error_reporting(E_ALL);
define("package_size", 100);
$optionsWithArgs = array( 'list' );

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "indexer for blog listing pages" );
}

$added = 0;
$updated = 0;

$sizeOfPack = 3;

$lastRun = $wgImageReviewImportLastRun;

if(!empty($lastRun)) {
	$startFrom = $lastRun - 60*60;
} else {
	$startFrom = 0;
}
//$startFrom = 0;


$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
$dbm = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);

function import($wikiIdstart, $size) {
	global $dbs, $startFrom;
	$wikiIdEnd = $wikiIdstart + $size - 1;
	
	$res = $dbs->select(
			array( 'pages' ),
			array( 
				'count(*) as cnt' 
			),
			array(
				"page_namespace = ".NS_FILE,
				"page_wikia_id BETWEEN $wikiIdstart and $wikiIdEnd",
				"page_last_edited BETWEEN FROM_UNIXTIME($startFrom) and NOW()",
			),
			__METHOD__
	);
	
	$row = $dbs->fetchRow($res);
	
	echo "we are on: $wikiIdstart - $wikiIdEnd count: {$row['cnt']}\n";
	
	$count = (int) $row['cnt'];
	for($i = 0; $i < $count; $i = $i + 10000 ) {
		importSlice($wikiIdstart, $wikiIdEnd, $i, 10000);
	}
}


function importSlice($wikiIdstart, $wikiIdEnd, $start, $slice) {
	global $dbs, $startFrom;
	$res = $dbs->select(
			array( 'pages' ),
			array( 
				'page_id',
				'page_wikia_id',
				'page_last_edited',
				'UNIX_TIMESTAMP(page_last_edited) as page_last_edited_unix'
			),
			array(
				"page_namespace = ".NS_FILE,
				"page_wikia_id BETWEEN $wikiIdstart and $wikiIdEnd",
				"page_last_edited BETWEEN FROM_UNIXTIME($startFrom) and NOW()",
			),
			__METHOD__,
			array(
				'ORDER BY' => 'page_latest ASC', 
				'OFFSET' => $start, 
				'LIMIT' => $slice
			)
	);

	while ($row = $dbs->fetchRow($res)) {
		insert($row);
	}	
}

function insert($row) {
	global $dbm, $added, $updated;
	$dbm->insert( 'image_review', array(
 		'wiki_id' => $row['page_wikia_id'],
 		'page_id' => $row['page_id'],
 		'last_edited'  => $row['page_last_edited']),
		__METHOD__,
 		'IGNORE'
 	);
 	
	if($dbm->affectedRows() < 1){
		echo "ROW already in DB\n";
		$res = $dbm->select(
			array( 'image_review' ),
			array( 'UNIX_TIMESTAMP(last_edited) as last_edited_unix' ),
			array( "page_id = {$row['page_id']} and wiki_id = {$row['page_wikia_id']}" )
		);
			
		$irRow = $dbm->fetchRow($res);
		
		if(empty($irRow)){
			return true;
		}
		
		if($row['page_last_edited_unix'] > $irRow['last_edited_unix']) {
			$dbm->update(
					'image_review',
					array( 
						'state' => 0,
						'last_edited' =>  $row['page_last_edited']
					),
					array( "page_id = {$row['page_id']} and wiki_id = {$row['page_wikia_id']}" )
			);
			$updated++;	
		} else {
			
		}
	} else {
		$added++;
	}
}

$wikisNumber = 3;

for($i = 0; $i < $wikisNumber; $i = $i + $sizeOfPack ) {
	import($i, $sizeOfPack);
}

WikiFactory::setVarByName('wgImageReviewImportLastRun', $wgCityId, time());