<?php
$dir = dirname( __FILE__ ) . '/';
$cmdLineScript = realpath( $dir . '../../commandLine.inc' );
require_once( $cmdLineScript );

/** EXIT STATUSES **/
define( 'CNW_MAINTENANCE_SUCCESS', 0 );
define( 'CNW_MAINTENANCE_DB_ERROR', 1 );

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

/**
 * @brief Gets timestamp from passed options or returns result of time() function
 *
 * @param Array $options
 * @return int
 */
function getTimestamp( $options ) {
	$timestamp = isset( $options['timestamp'] ) ? $options['timestamp'] : time();
	// edge case when somebody run the script with "--timestamp 1391005260" instead of "--timestamp=1391005260"
	$timestamp = $timestamp > 1 ? $timestamp : time();
	return (int) $timestamp;
}

/**
 * @briefs Basing on the passed timestamp it returns an array with two dates used later in SQL condition
 *
 * @desc The timestamp is being changed to data in Y-m-d H:i:s format.
 *       It's an "end date" and by using strtotime() function we calculate
 *       the "start date" by deducting "1 day" from the "end date".
 *
 * @param String $timestamp
 * @return array
 */
function getDates( $timestamp ) {
	$dateFormat = 'Y-m-d H:i:s';
	$startDate = date( $dateFormat, strtotime( '-1 day', $timestamp ) );
	$endDate = date( $dateFormat, $timestamp );
	return [ $startDate, $endDate ];
}

/**
 * @brief Selects recent founders from DB
 *
 * @desc Returns false in case of DB error or array with found founders ids
 *
 * @param Integer $timestamp based on this timestamp the where condition is created
 *
 * @return array|bool
 */
function findFounders( $timestamp ) {
	list( $startDate, $endDate ) = getDates( $timestamp );

	$db = wfGetDB( DB_SLAVE, [], 'wikicities' );
	$table = 'city_list';
	$fields = [ 'city_founding_user' ];
	$where = [ 'city_founding_user > 0', "city_created between '$startDate' and '$endDate'" ];
	$founders = [];

	try {
		$resultWrapper = $db->select( $table, $fields, $where, __METHOD__ );
		while( $row = $resultWrapper->fetchObject() ) {
			$founders[] = $row->city_founding_user;
		}

		return $founders;
	} catch( DBQueryError $e ) {
		echo "Database error: " . $e->getMessage() . "\n";
		echo "SQL statement was: " . $e->getSQL() . "\n\n";
		return false;
	}
}

/**
 * @brief Displays help content
 */
function help() {
	echo "This script checks if a founder of a wiki is present in `wikicities.user` table.\n";
	echo "Available options: \n";
	echo "\thelp or ? -- displays this text\n";
	echo "\ttimestamp -- (optional) starting point\n\n";
}

/** APPLICATION **/

if( shouldDisplayHelp( $argv, $options ) ) {
	help();
	exit(CNW_MAINTENANCE_SUCCESS);
} else {
	$timestamp = getTimestamp( $options );
	$founders = findFounders( $timestamp );

	if( $founders === false ) {
		exit(CNW_MAINTENANCE_DB_ERROR);
	} else if( empty( $founders ) ) {
		echo "No recent founders found.\n\n";
		exit(CNW_MAINTENANCE_SUCCESS);
	} else {
		echo 'Founders found: ' . rtrim( implode( ', ', $founders ), ', ' ) . "\n";
	}
}