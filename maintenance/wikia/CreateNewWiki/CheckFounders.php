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
 * @brief Selects recent founders from DB
 *
 * @desc Returns false in case of DB error or array with found founders ids
 *
 * @param Integer $timestamp based on this timestamp the where condition is created
 *
 * @return array|bool
 */
function findFounders( $timestamp ) {
	global $wgExternalSharedDB;

	$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
	$startDate = $db->timestamp( strtotime( '-1 day', $timestamp ) );
	$endDate = $db->timestamp( $timestamp );
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
		echo "Database error: " . $e->getMessage() . PHP_EOL;
		echo "SQL statement was: " . $e->getSQL() . PHP_EOL . PHP_EOL;
		return false;
	}
}

/**
 * @brief Checks if recent founders are present in wikicities.user table if now there are returned as "invalid founders"
 *
 * @param Array $founders list of ids of recent founders from wikicities.city_list table
 *
 * @return array|bool
 */
function findInvalidFounders( $founders ) {
	global $wgExternalSharedDB;

	$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
	$table = '`user`';
	$fields = [ 'user_id' ];
	$where = [ 'user_id in (' . $db->makeList( $founders ) . ')' ];
	// $invalidFounders are users who founded a wiki but are not in wikicities.user table
	$invalidFounders = [];
	$recentUsers = [];
	$recentFoundersNo = count( $founders );

	try {
		$resultWrapper = $db->select( $table, $fields, $where, __METHOD__ );
		while( $row = $resultWrapper->fetchObject() ) {
			$recentUsers[] = $row->user_id;
		}
		$recentUsersNo = count( $recentUsers );

		if( $recentFoundersNo > $recentUsersNo ) {
			$invalidFounders = array_diff( $founders, $recentUsers );
		}

		return $invalidFounders;
	} catch( DBQueryError $e ) {
		echo "Database error: " . $e->getMessage() . PHP_EOL;
		echo "SQL statement was: " . $e->getSQL()  . PHP_EOL . PHP_EOL;
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
	echo "\ttimestamp -- (optional) the end date in 'between' condition while selecting recent founders;"
		 . " default: time() result" . PHP_EOL . PHP_EOL;
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

$timestamp = getTimestamp( $options );
$founders = findFounders( $timestamp );

if( $founders === false ) {
	exit( CNW_MAINTENANCE_DB_ERROR );
} else if( empty( $founders ) ) {
	echo "No recent founders found." . PHP_EOL . PHP_EOL;
	exit( CNW_MAINTENANCE_SUCCESS );
} else {
	echo 'Founders found: ' . implode( ', ', $founders ) . PHP_EOL;
	$invalidFounders = findInvalidFounders( $founders );

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
}
