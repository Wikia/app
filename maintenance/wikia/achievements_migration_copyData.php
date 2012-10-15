<?php

ini_set( 'display_errors', 'stdout' );

require_once("../commandLine.inc");
require_once("../../extensions/wikia/AchievementsII/Ach_setup.php");

global $wgDBname, $wgCityId, $wgExternalSharedDB;

$dbw = wfGetDB(DB_MASTER);
$dbr_wikicities = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB );

echo "Coping data for: $wgDBname\n";

$tables = array(
	'ach_user_score',
	'ach_user_badges',
	'ach_custom_badges',
	'ach_ranking_snapshots'
);

foreach($tables as $t) {

	$result = $dbr_wikicities->select( $t, '*', array('wiki_id' => $wgCityId ) );

	while( $row = $result->fetchRow() ) {
		unset( $row['wiki_id'] );
		foreach ($row as $k => &$v) {
			if (is_numeric($k)) {
				unset($row[$k]);
			}
		}
		try {
			$dbw->insert( $t, $row );
		} catch(Exception $e) {
			null;
		}
	}

	$dbr_wikicities->freeResult( $result );
}

echo "Getting references for table `ach_user_counters`\n";

$result = $dbr_wikicities->select( 'ach_user_counters_refs', '*', array('wiki_id' => $wgCityId) );
$usersWithData = array();
while( $row = $result->fetchRow() ) {
	$usersWithData[$row['user_id']] = true;
}
$dbr_wikicities->freeResult( $result );
$num = count($usersWithData);
echo "Processing for $num users\n";

foreach( $usersWithData as $user=>$nnn ) {
	$result = $dbr_wikicities->select( 'ach_user_counters', '*', array( 'user_id' => $user ) );
	while( $row = $result->fetchRow() ) {
		$data = unserialize( $row['data'] );
		if(!isset($data[$wgCityId])) {
			echo "WARNING: for user $user there is a reference but no data for wiki_id $wgCityId \n";
			continue;
		}
		$data_for_wiki = $data[$wgCityId];

		$ins = array(
			'user_id' => $user,
			'data' => serialize(array( $wgCityId => $data_for_wiki ))
		);
		$dbw->insert( 'ach_user_counters', $ins );
	}
}

echo "Flipping the switch\n";
WikiFactory::setVarByName('wgEnableAchievementsStoreLocalData', $wgCityId, 1);


wfWaitForSlaves(2);