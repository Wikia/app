<?php
/**
 * indexer for images order in articles
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
//error_reporting(E_ALL);

define("package_size", 100);
$optionsWithArgs = array( 'list' );

require_once('../commandLine.inc');
if (isset($options['help'])) {
	die( "indexer for blog listing pages" );
}

if ( WikiFactory::getVarValueByName("wgImagesIndexed", $wgCityId ) ) {
	echo "This wiki is already indexed change wgImagesIndexed to false to reindex\n";
	exit;
}

$db = wfGetDB(DB_SLAVE, array());

/*
 * first time it run only count on pages and then it run this script with param -do and list 
 * it is hack for problem with memory leak from parser 
 */

if ((!empty($options['do'])) && $options['do'] == 1 ) {
	$pages = explode(",",$options['list']);
	foreach ($pages as $value) {
		$qArticle = Article::newFromID(trim($value));
		$wgTitle = $qArticle->getTitle(); //title for parser  
		imageServingHelper::buildAndGetIndex( $qArticle, true );
		unset($qArticle);
	}
	exit;
}


if (empty($options['do']) || $options['do'] != 1) {
	$res = $db->select(
	            array( 'imagelinks' ),
	            array( 'il_from,il_to,count(*) as cnt'),
	            "",
	            __METHOD__,
	            array(
	            	"GROUP BY" => "il_from",
	            	"HAVING" => "cnt = 1"
	            )
	);
	
	echo "Indexing one count pages\n";
	
	while ($row = $db->fetchRow($res)) {
		imageServingHelper::bulidIndex($row['il_from'], array( $row['il_to'] ));
	}            
	
	echo "Indexing more then one count pages\n";
	
	$res = $db->select(
	            array( 'imagelinks' ),
	            array( 'il_from,count(*) as cnt'),
	            "",
	            __METHOD__,
	            array(
	            	"GROUP BY" => "il_from",
	            	"HAVING" => "cnt > 1",
	            //	"LIMIT" => 1
	            )
	);
	$totalNum = $res->numRows();	            
	$out = array();
	$count = 0;
	$total_count = 0;
	$startTime = Time();
	Wikia::log( __METHOD__, 'imageServingIndexer', 'starting for:'.$wgCityId. " total number:".$totalNum );
	while ($row = $db->fetchRow($res)) {
		$total_count ++;
		$count ++;
		$out[] = $row['il_from'];
		if ($count == package_size ) {
			Wikia::log( __METHOD__, 'imageServingIndexer', 'next pack for:'.$wgCityId." ".$total_count."/".$totalNum );
			$count = 0;
			$cmd = array(
				"SERVER_ID={$wgCityId}",
				"php",
				"{$IP}/maintenance/wikia/imageServingIndexer.php",
				"--do",
				"--list ".implode(",",$out),
				"--conf {$wgWikiaLocalSettingsPath}"
			);	
			$out = array();
			system( implode( " ", $cmd ), $status );
		}
	}
	Wikia::log( __METHOD__, 'imageServingIndexer', 'end for:'.$wgCityId. " total time:".(Time() - $startTime) );
	WikiFactory::setVarByName("wgImagesIndexed", $wgCityId, true );
}
