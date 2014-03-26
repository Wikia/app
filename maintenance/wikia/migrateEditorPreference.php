<?php
/**
 * Migrates users' RTE setting to the new editor preference
 *
 * @author mklucsarits
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
//$dbr = wfGetDB( DB_MASTER );

$dbName = $dbr->getDBname();
echo "Database name: $dbName\n";
if ( !in_array( $dbName, array( 'wikicities', 'wikicities_c1' ) ) ) {
	exit( "*** Database name not in list of acceptable databases for this script. Aborting.\n" );
}

// Only users who don't have enablerichtext set should appear in this table
$result = $dbr->select( 'user_properties', 'count(up_user)', "up_property = 'enablerichtext' and up_value != '' && up_value != '0'" );
if ( (int)$dbr->fetchRow( $result )[0] > 0 ) {
	exit( "*** Non-null or non-zero values found in table user_properties for 'enablerichtext'. Aborting.\n" );
}

$result = $dbr->select( 'user_properties', 'up_user, up_property', "up_property = 'enablerichtext'" );

$allRows = array();
while ( $row = $dbr->fetchObject( $result ) ) {
	$allRows[] = $row;
}

$dbr->freeResult( $result );
$userCount = 0;
$start = time();

foreach ( $allRows as $row ) {
	$user = User::newFromId( $row->up_user );
	$output = 'User ID: '.$row->up_user;

	// User's editor preference will be set to "Source"
	$user->setOption( PREFERENCE_EDITOR, 1 );
	$output .= ' --> Setting editor preference to 1 (Source)';

	$user->saveSettings();
	echo "$output\n";
	$userCount++;
}

$delta = time() - $start;
echo "\nDone -- $userCount users updated, $delta seconds elapsed.\n";
