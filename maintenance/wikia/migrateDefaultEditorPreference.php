<?php
/**
 * Migrates users' Default editor setting to VisualEditor
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

$dbName = $dbr->getDBname();
echo "Database name: $dbName\n";
if ( !in_array( $dbName, array( 'wikicities', 'wikicities_c1' ) ) ) {
	exit( "*** Database name not in list of acceptable databases for this script. Aborting.\n" );
}

echo "Querying database for users...\n";
$query = 'SELECT u.user_id, u.user_registration FROM wikicities.user u'
	. ' INNER JOIN wikicities.user_properties up ON u.user_id = up.up_user'
	. ' AND up.up_property = \'' . PREFERENCE_EDITOR . '\''
	. ' AND up.up_value = \'' . EditorPreference::OPTION_EDITOR_DEFAULT . '\''
	. ' WHERE u.user_registration';

if ( isset( $options['registration'] ) ) {
	// Registration in DB is in the form of an integer, with year, month, date, hour, minute
	// and second values concatenated in this format: YYYYMMDDHHMMSS
	if ( strlen( $options['registration'] ) === 8 ) {
		// Registration value is a date without time, so append time values (HHMMSS) as midnight
		$options['registration'] .= '000000';
	}
	$query .= ' > ' . (int)$options['registration'];
} else {
	$query .= ' IS NULL';
}

if ( isset( $options['limit'] ) ) {
	$query .= ' LIMIT ' . (int)$options['limit'];
}

if ( isset( $options['offset'] ) ) {
	$query .= ' OFFSET ' . (int)$options['offset'];
}

$result = $dbr->query( $query );
$allRows = array();

while ( $row = $dbr->fetchObject( $result ) ) {
	$allRows[] = $row;
}

$dbr->freeResult( $result );
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

	//$user->saveSettings();
	echo "$output\n";
	$userCount++;
}

$delta = time() - $start;
echo "\nDone -- $userCount users updated, $delta seconds elapsed.\n";
