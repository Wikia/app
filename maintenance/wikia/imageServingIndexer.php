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

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "indexer for blog listing pages" );
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
		ImageServingHelper::buildAndGetIndex( $qArticle, true );
		unset($qArticle);
	}
	exit;
}

if(!isset($options['force'])) {
	if ( WikiFactory::getVarValueByName("wgImagesIndexed", $wgCityId ) ) {
		echo "This wiki is already indexed change wgImagesIndexed to false to reindex\n";
		exit;
	}
}

if (empty($options['do']) || $options['do'] != 1) {
	$res = $db->select(
	            array( 'imagelinks' ),
	            array( 'il_from,il_to,count(*) as cnt'),
                    array("il_from in (select il_from from image inner join imagelinks where  img_media_type != 'VIDEO' and il_to = img_name and il_from not in (select page_id from page_wikia_props))"),
	            __METHOD__,
	            array(
	            	"GROUP BY" => "il_from",
	            	"HAVING" => "cnt = 1",
	            )
	);
	
	
	echo "Indexing one count pages\n";
	
	while ($row = $db->fetchRow($res)) {
		ImageServingHelper::buildIndex($row['il_from'], array( $row['il_to'] ));
	}            
	
	echo "Indexing more then one count pages\n";
	
	$res = $db->select(
	            array( 'imagelinks' ),
	            array( 'il_from,count(*) as cnt'),
	            array("il_from in (select il_from from image inner join imagelinks where  img_media_type != 'VIDEO' and il_to = img_name and il_from not in (select page_id from page_wikia_props))"),
	            __METHOD__,
	            array(
	            	"GROUP BY" => "il_from",
	            	"HAVING" => "cnt > 1",
	            //	"LIMIT" => 1
	            )
	);
	$total_num = $res->numRows();	            
	$out = array();
	$count = 0;
	$total_count = 0;
	$startTime = Time();
	Wikia::log( __METHOD__, 'imageServingIndexer', 'starting for:'.$wgCityId. " total number:".$total_num );
	while ($row = $db->fetchRow($res)) {
		$total_count ++;
		$count ++;
		$out[] = $row['il_from'];
		if ($count == package_size ) {
			runIndexer( $out, $total_count, $total_num );
			$out = array(); 
		}
	}
	if(!empty($out)) {
		runIndexer( $out, $total_count, $total_num );
	}
	Wikia::log( __METHOD__, 'imageServingIndexer', 'end for:'.$wgCityId. " total time:".(Time() - $startTime) );
}

function runIndexer( $out, $total_count, $total_num  ) {
	global $IP, $wgCityId, $wgWikiaLocalSettingsPath;
	Wikia::log( __METHOD__, 'imageServingIndexer', 'next pack for:'.$wgCityId." ".$total_count."/".$total_num );
	$count = 0;
	$cmd = array(
		"SERVER_ID={$wgCityId}",
		"php",
		"{$IP}/maintenance/wikia/imageServingIndexer.php",
		"--do",
		"--list ".implode(",",$out),
		"--conf {$wgWikiaLocalSettingsPath}"
	);	
	system( implode( " ", $cmd ), $status );	
}
