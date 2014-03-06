<?php
$dir = dirname( __FILE__ ) . '/';
$cmdLineScript = realpath( $dir . '../../commandLine.inc' );
require_once( $cmdLineScript );

/** EXIT STATUSES **/
define( 'CNW_MAINTENANCE_SUCCESS', 0 );
define( 'CNW_MAINTENANCE_DB_ERROR', 1 );
define( 'CNW_MAINTENANCE_READ_ONLY', 2 );
define( 'CNW_MAINTENANCE_NO_SHAREDDB_ERR', 3 );

/** OTHER CONSTANTS **/
define( 'CNW_MAINTENANCE_DATE_FORMAT', 'Ymd' );
define( 'CNW_MAINTENANCE_MAX_DAYS_BACK', 365 );
define( 'CNW_MAINTENANCE_LOG_LABEL', 'MOLI: ' );

/** FUNCTIONS' DEFINITIONS **/

/**
 * @brief Whether display help contents or not
 *
 * @param Array $argv
 * @param Array $options
 * @return bool
 */
function shouldDisplayHelp( $argv, $options ) {
	$out = false;

	if( in_array( '?', $argv ) ) {
	// additional argument ? passed
		$out = true;
	} elseif( isset( $options['help'] ) ) {
	// additional argument --help passed
		$out = true;
	}

	return $out;
}

function getCreationDate( $interval ) {
	$date = date( CNW_MAINTENANCE_DATE_FORMAT, strtotime( '-' . $interval . ' day' ) );
	$date .= '000000';

	return $date;
}

/**
 * @brief Selects recent founders from DB
 *
 * @desc Returns false in case of DB error or array with found founders ids
 *
 * @param Integer $interval number of days we should go back; default: 1; max: 365;
 *
 * @return array|bool
 */
function findInvalidFounders( $interval ) {
	global $wgExternalSharedDB;

	$interval = intval( $interval );
	$interval = ( $interval <= 0 || $interval > CNW_MAINTENANCE_MAX_DAYS_BACK ) ? 1 : $interval;

	$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

	$table = [ 'l' => 'city_list', 'u' => '`user`' ];
	$fields = [ 'l.city_founding_user' ];
	$joins = [ 'u' => [
		'LEFT JOIN',
		'l.city_founding_user = u.user_id'
	] ];
	$where = [
		'l.city_founding_user <> 0',
		'l.city_founding_user IS NOT NULL',
		'u.user_id IS NULL',
		'l.city_created > \'' . getCreationDate( $interval ) . '\''
	];
	$options = [ 'DISTINCT' ];
	$invalidFounders = [];
	
	try {
		$resultWrapper = $db->select( $table, $fields, $where, __METHOD__, $options, $joins );
		while( $row = $resultWrapper->fetchObject() ) {
			$invalidFounders[] = $row->city_founding_user;
		}

		return $invalidFounders;
	} catch( DBQueryError $e ) {
		echo "Database error: " . $e->getMessage() . PHP_EOL;
		echo "SQL statement was: " . $e->getSQL() . PHP_EOL . PHP_EOL;
		return false;
	}
}

/**
 * @brief Displays help content
 */
function help() {
	echo "This script checks if a founder of a wiki is present in `wikicities.user` table." . PHP_EOL;
	echo "If he's not present in the table then he's marked as 'invalid founder'." . PHP_EOL;
	echo "Available options:" . PHP_EOL;
	echo "\thelp or ? -- displays this text" . PHP_EOL;
	echo "\tinterval -- (optional) how many days back we should check; default: 1 day; max: 365;" . PHP_EOL . PHP_EOL;
}

/** APPLICATION **/
global $wgReadOnly, $wgExternalSharedDB;

if( shouldDisplayHelp( $argv, $options ) ) {
	help();
	exit( CNW_MAINTENANCE_SUCCESS );
}

if( !empty( $wgReadOnly ) ) {
	echo "Database is in read-only mode at this moment. Try again later." . PHP_EOL . PHP_EOL;
	exit( CNW_MAINTENANCE_READ_ONLY );
}

if( empty( $wgExternalSharedDB ) ) {
	echo "Could not find shared DB." . PHP_EOL . PHP_EOL;
	exit( CNW_MAINTENANCE_NO_SHAREDDB_ERR );
}

$interval = ( isset( $options['interval'] ) ? $options['interval'] : false );
$invalidFounders = findInvalidFounders( $interval );

if( $invalidFounders === false ) {
	exit( CNW_MAINTENANCE_DB_ERROR );
} else if( empty( $invalidFounders ) ) {
	echo "No invalid founders found." . PHP_EOL . PHP_EOL;
	exit( CNW_MAINTENANCE_SUCCESS );
} else {
	// once "invalid founder" is found display the message and add it to our logs with MOLI: label
	$msg = 'Invalid founders found: ' . implode( ', ', $invalidFounders );
	echo $msg . PHP_EOL . PHP_EOL;
	Wikia::log( __METHOD__, false, CNW_MAINTENANCE_LOG_LABEL . $msg );
	exit( CNW_MAINTENANCE_SUCCESS );
}
