<?php
/**
 * User: artur
 * Date: 16.04.13
 * Time: 15:49
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/initial_sync.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

global $IP;
require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

global $wgExternalSharedDB, $wgDatamartDB;
$app = F::app();
$dbmart = $app->wf->getDB( DB_SLAVE, array(), $wgDatamartDB);
$db = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);

$query = "select wiki_id, count(article_id) as page_count from rollup_wiki_article_pageviews group by wiki_id having count(article_id) >= 1";
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
	if( count($group) == 0 ) break;
	$group = filterGroup( $db, $group );
	if( count($group) == 0 ) continue;
	//var_dump($group);
	echo "fetching " . count($group) . " wikis from mart\n";
	var_dump($group);
	$db->insert("webmaster_sitemaps", $group);
	sleep(1);
}
