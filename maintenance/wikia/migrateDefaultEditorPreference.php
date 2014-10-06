<?php
/**
 * Migrates users' Default editor setting to VisualEditor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

$dbName = $dbw->getDBname();
if ( $dbName !== 'wikicities' ) {
	exit( "*** Shared database name does not match expected name. Aborting.\n" );
}

echo "Querying $dbName database for users...\n";
$query = ( new WikiaSQL() )
	->SELECT( 'user_id', 'user_registration' )
	->FROM( 'user' )
	->WHERE( 'user_registration' );

if ( isset( $options['registration'] ) ) {
	// Registration in DB is in the form of an integer, with year, month, date, hour, minute
	// and second values concatenated in this format: YYYYMMDDHHMMSS
	if ( strlen( $options['registration'] ) === 8 ) {
		// Registration value is a date without time, so append time values (HHMMSS) as midnight
		$options['registration'] .= '000000';
	}
	$query->GREATER_THAN_OR_EQUAL( (int)$options['registration'] );
} else {
	$query->IS_NULL();
}

$subquery = ( new WikiaSQL() )
	->SELECT( 'up_user' )
	->FROM( 'user_properties' )
	->WHERE( 'up_user' )->EQUAL_TO_FIELD( 'user_id' )
	->AND_( 'up_property' )->EQUAL_TO( PREFERENCE_EDITOR );
$query->AND_( null )->NOT_EXISTS( $subquery );

if ( isset( $options['limit'] ) ) {
	$query->LIMIT( (int)$options['limit'] );
}

if ( isset( $options['offset'] ) ) {
	$query->OFFSET( (int)$options['offset'] );
}

$allRows = $query->run( $dbw, function( $result ) {
	$rows = array();
	while ( $row = $result->fetchObject( $result ) ) {
		$rows[] = $row;
	}
	return $rows;
} );

echo count( $allRows ) . " users to modify.\n";

$userCount = 0;
$start = time();

foreach ( $allRows as $row ) {
	$user = User::newFromId( $row->user_id );
	$output = 'User ID ' . $row->user_id;
	if ( isset( $options['registration'] ) ) {
		$output .= ' (registered ' . wfTimestamp( TS_DB, $row->user_registration ) . ')';
	}
	$user->setOption( PREFERENCE_EDITOR, EditorPreference::OPTION_EDITOR_VISUAL );
	$user->setOption( 'showVisualEditorTransitionDialog', 1 );
	$output .= ' editor preference set to VisualEditor';

	// Uncomment below before executing, to actually make changes to user settings
	//$user->saveSettings();
	echo "$output\n";
	$userCount++;
}

$delta = time() - $start;
echo "\nDone -- $userCount users updated, $delta seconds elapsed.\n";
