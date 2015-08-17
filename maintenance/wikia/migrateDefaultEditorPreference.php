<?php
/**
 * Migrates users' Default editor setting to VisualEditor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

function formatRegDateParam( $regDate ) {
	if ( strlen( $regDate ) === 8 ) {
		// If registration value is a date without time, append time values (HHMMSS) as midnight
		$regDate .= '000000';
	}
	return (int)$regDate;
}

// Get database resource
$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

$dbName = $dbr->getDBname();
if ( $dbName !== 'wikicities' ) {
	exit( "*** Shared database name does not match expected name. Aborting.\n" );
}

// Build the query
echo "Querying $dbName database for users...\n";

$query = ( new WikiaSQL() )
	->SELECT( 'user_id', 'user_registration' )
	->FROM( 'user' )
	->WHERE( 'user_registration' );

// Add clause on registration date
if ( isset( $options['reg_start'] ) ) {
	// Registration in DB is in the form of an integer, with year, month, date, hour, minute
	// and second values concatenated in this format: YYYYMMDDHHMMSS
	$query->GREATER_THAN_OR_EQUAL( formatRegDateParam( $options['reg_start'] ) );
	if ( isset( $options['reg_end'] ) ) {
		$query->AND_( 'user_registration' )->LESS_THAN( formatRegDateParam( $options['reg_end'] ) );
	}
} else {
	$query->IS_NULL();
}

// Add subquery to check that a user does not have a non-default option set for the editor perference
$subquery = ( new WikiaSQL() )
	->SELECT( 'up_user' )
	->FROM( 'user_properties' )
	->WHERE( 'up_user' )->EQUAL_TO_FIELD( 'user_id' )
	->AND_( 'up_property' )->EQUAL_TO( PREFERENCE_EDITOR );
$query->AND_( null )->NOT_EXISTS( $subquery );

// Optional limit
if ( isset( $options['limit'] ) ) {
	$query->LIMIT( (int)$options['limit'] );
}

// Optional offset
if ( isset( $options['offset'] ) ) {
	$query->OFFSET( (int)$options['offset'] );
}

// Run query and get results
$allRows = $query->runLoop( $dbr, function( &$results, $row ) {
	$results[] = $row;
} );

// Ready to modify the resulting users
echo count( $allRows ) . " users to modify.\n";

$userCount = 0;
$start = time();

// Modify user options for each user in the results
foreach ( $allRows as $row ) {
	$user = User::newFromId( $row->user_id );
	$output = 'User ID ' . $row->user_id;

	// If a registration date is used to bucket users, add registration date to output
	if ( isset( $options['reg_start'] ) ) {
		$output .= ' (registered ' . wfTimestamp( TS_DB, $row->user_registration ) . ')';
	}

	// Set editor preference to VE
	$user->setGlobalPreference( PREFERENCE_EDITOR, EditorPreference::OPTION_EDITOR_VISUAL );
	// Set option that flags that a user should see an orientation dialog when loading VE
	$user->setGlobalPreference( 'showVisualEditorTransitionDialog', 1 );
	$output .= ' editor preference set to VisualEditor';

	// Uncomment below before executing, to actually make changes to user settings
	//$user->saveSettings();
	echo "$output\n";
	$userCount++;
}

$delta = time() - $start;
echo "\nDone -- $userCount users updated, $delta seconds elapsed.\n";
