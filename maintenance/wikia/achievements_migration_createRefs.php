<?php

ini_set( 'display_errors', 'stdout' );

require_once("../commandLine.inc");
require_once("../../extensions/wikia/AchievementsII/Ach_setup.php");

global $wgDBname, $wgCityId, $wgExternalSharedDB;

$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB );

echo "Creating references\n";
$cache = array();
$result = $dbw->select( 'ach_user_counters', '*' );
while( $row = $result->fetchRow() ) {
	$user = $row['user_id'];
	$data = unserialize( $row['data'] );
	foreach( $data as $wiki => $wikidata ) {
		$cacheid = "$user $wiki";
		if(!isset($cache[$cacheid])) {
			$cache[$cacheid] = true;
			$ins = array(
				'user_id' => $user,
				'wiki_id' => $wiki
			);
			$dbw->insert( 'ach_user_counters_refs', $ins );
		}
	}
}

echo "Done\n";
