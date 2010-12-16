<?php
$IP = getenv( 'MW_INSTALL_PATH' );
if ( strval( $IP ) === '' ) {
	$IP = dirname( __FILE__ ).'/../..';
}
if ( !file_exists( "$IP/includes/WebStart.php" ) ) {
	$IP .= '/phase3';
}

$optionsWithArgs = array( 'before', 'edits' );
require( $IP . '/maintenance/commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$fname = 'voterList.php';
$maxUser = $dbr->selectField( 'user', 'MAX(user_id)', false );
$before = isset( $options['before'] ) ? wfTimestamp( TS_MW, strtotime( $options['before'] ) ) : false;
$minEdits = isset( $options['edits'] ) ? intval( $options['edits'] ) : false;

if ( !isset( $args[0] ) ) {
	echo "Usage: php voterList.php [--before=<date>] [--edits=<date>] <name>\n";
	exit( 1 );
}
$name = $args[0];

for ( $user = 1; $user <= $maxUser; $user++ ) {
	$insertRow = array( 'li_name' => $name, 'li_member' => $user );
	if ( $minEdits === false ) {
		$dbw->insert( 'securepoll_lists', $insertRow, $fname );
		continue;
	}

	# Count edits
	$conds = array( 'rev_user' => $user );
	if ( $before !== false ) {
		$conds[] = 'rev_timestamp < ' . $dbr->addQuotes( $before );
	}
	$edits = $dbr->selectField( 'revision', 'COUNT(*)', $conds, $fname );
	if ( $edits >= $minEdits ) {
		$dbw->insert( 'securepoll_lists', $insertRow, $fname );
	}
}
