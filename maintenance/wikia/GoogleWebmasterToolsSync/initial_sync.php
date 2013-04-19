<?php
/**
 * User: artur
 * Date: 16.04.13
 * Time: 15:49
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/initial_sync.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

global $IP;
require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
$minCountOfPagesToSync = 100;

try {
	global $wgExternalSharedDB, $wgDatamartDB;
	$app = F::app();
	$dbmart = $app->wf->getDB( DB_SLAVE, array(), $wgDatamartDB);
	$db = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);

	$query = "select wiki_id, count(article_id) as page_count from rollup_wiki_article_pageviews group by wiki_id having count(article_id) >= $minCountOfPagesToSync";
	$result = $dbmart->query($query);

	function fetchGroup ( $result, $count ) {
		$i = 0;
		$resultGroup = array();
		while( ( $row = $result->fetchObject() ) && ( $i < $count ) ) {
			$resultGroup[] = array(
				"wiki_id" => $row->wiki_id,
				"user_id" => null,
				"upload_date" => null,
			);
			$i ++;
		}
		return $resultGroup;
	}

	function filterGroup( $db, $group ) {
		$arr = array();
		foreach( $group as $i => $wiki ) {
			$arr[] = $wiki['wiki_id'];
		}
		$query = "
			SELECT wiki_id
			FROM webmaster_sitemaps
			WHERE wiki_id IN (". implode(",",$arr) .")

		";
		$exists = array();
		$result = $db->query($query);
		while ( $obj = $result->fetchObject() ) {
			$exists[$obj->wiki_id] = true;
		}
		$resultGroup = array();
		foreach( $group as $i => $wiki ) {
			if( !isset($exists[$wiki['wiki_id']]) ) {
				$resultGroup[] = $wiki;
			}
		}
		return $resultGroup;
	}

	while( true ) {
		$group = fetchGroup( $result, 50 );
		$groupSize = count( $group );
		GWTLogHelper::debug( "Group size: " . $groupSize );
		if( count($group) == 0 ) break;
		$group = filterGroup( $db, $group );
		$filteredGroupSize = count( $group );
		GWTLogHelper::debug( "Filtered group size: " . $filteredGroupSize );
		if( count($group) == 0 ) continue;
		//var_dump($group);
		GWTLogHelper::notice( "Fetching " . count($group) . " wikis from mart." );
		var_dump($group);
		$db->insert("webmaster_sitemaps", $group);
		sleep(1);
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
