<?php

require dirname(__FILE__) . '/../../maintenance/commandLine.inc';

echo "Populating global groups table with stewards...\n";

// Fetch local stewards
$dbl = wfGetDB( DB_SLAVE );	//Get local database
$result = $dbl->select(
	array( 'user', 'user_groups' ),
	array( 'user_name' ),
	array(
		'ug_group' => 'steward',
		'user_id = ug_user'
	),
	'migrateStewards.php'
);
$localStewards = array();
while( $row = $dbl->fetchObject( $result ) ) {
	$localStewards[] = $row->user_name;
}

echo "Fetched " . count( $localStewards ) . " from local database... Checking for attached ones\n";
$dbg = CentralAuthUser::getCentralDB();
$globalStewards = array();
$result = $dbg->select(
	array( 'globaluser', 'localuser' ),
	array( 'gu_name', 'gu_id' ),
	array(
		'gu_name = lu_name',
		'lu_wiki' => wfWikiId(),
		'gu_name IN (' . $dbg->makeList( $localStewards ) . ')',
	),
	'migrateStewards.php'
);
while( $row = $dbl->fetchObject( $result ) ) {
	$globalStewards[$row->gu_name] = $row->gu_id;
}

echo "Fetched " . count( $localStewards ) . " SULed stewards... Adding them in group\n";
foreach( $globalStewards as $user => $id ) {
	$dbg->insert( 'global_user_groups',
		array(
			'gug_user' => $id,
			'gug_group' => 'steward' ),
		'migrateStewards.php' );
	echo "Added {$user}\n";
	
	$u = new CentralAuthUser( $user );
	$u->quickInvalidateCache(); // Don't bother regenerating the steward's cache.
}
