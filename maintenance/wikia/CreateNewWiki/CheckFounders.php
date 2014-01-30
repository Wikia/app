<?php
$dir = dirname( __FILE__ ) . '/';
$cmdLineScript = realpath( $dir . '../../commandLine.inc' );
require_once( $cmdLineScript );

/** EXIT STATUSES **/
define( 'CNW_MAINTENANCE_SUCCESS', 0 );
define( 'CNW_MAINTENANCE_DB_ERROR', 1 );
define( 'CNW_MAINTENANCE_READ_ONLY', 2 );
define( 'CNW_MAINTENANCE_NO_SHAREDDB_ERR', 3 );

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
	global $wgExternalSharedDB;

	list( $startDate, $endDate ) = getDates( $timestamp );
	$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
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
		echo "Database error: " . $e->getMessage() . "\n";
		echo "SQL statement was: " . $e->getSQL() . "\n\n";
		return false;
	}
}

/**
 * @brief Displays help content
 */
function help() {
	echo "This script checks if a founder of a wiki is present in `wikicities.user` table.\nIf he's not present in the table then he's marked as 'invalid founder'.";
	echo "Available options: \n";
	echo "\thelp or ? -- displays this text\n";
	echo "\ttimestamp -- (optional) the end date in 'between' condition while selecting recent founders; default: time() result\n\n";
}

/** APPLICATION **/

if( shouldDisplayHelp( $argv, $options ) ) {
	help();
	exit( CNW_MAINTENANCE_SUCCESS );
} else {
	global $wgReadOnly, $wgExternalSharedDB;

	if( !empty( $wgReadOnly ) ) {
		echo "Database is in read-only mode at this moment. Try again later.\n\n";
		exit( CNW_MAINTENANCE_READ_ONLY );
	}

	if( empty( $wgExternalSharedDB ) ) {
		echo "Could not find shared DB.\n\n";
		exit( CNW_MAINTENANCE_NO_SHAREDDB_ERR );
	}

	$timestamp = getTimestamp( $options );
	$founders = findFounders( $timestamp );

	if( $founders === false ) {
		exit( CNW_MAINTENANCE_DB_ERROR );
	} else if( empty( $founders ) ) {
		echo "No recent founders found.\n\n";
		exit( CNW_MAINTENANCE_SUCCESS );
	} else {
		echo 'Founders found: ' . rtrim( implode( ', ', $founders ), ', ' ) . "\n";
		$invalidFounders = findInvalidFounders( $founders );

		if( $invalidFounders === false ) {
			exit( CNW_MAINTENANCE_DB_ERROR );
		} else if( empty( $invalidFounders ) ) {
			echo "No invalid founders found.\n\n";
			exit( CNW_MAINTENANCE_SUCCESS );
		} else {
		// once "invalid founder" is found display the message and add it to our logs with MOLI: label
			$msg = 'Invalid founders found: ' . rtrim( implode( ', ', $invalidFounders ), ', ' );
			echo $msg . "\n\n";
			Wikia::log( __METHOD__, false, 'MOLI: ' . $msg );
			exit( CNW_MAINTENANCE_SUCCESS );
		}
	}
}
