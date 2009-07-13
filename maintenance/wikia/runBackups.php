<?php
/**
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy)
 *
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');


/**
 * run backup for range of wikis
 */
function runBackups( $from, $to, $full ) {

	global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

	$range = array();
	if( $from !== false && $to !== false ) {
		$range = array( sprintf( "city_id >= %d AND city_id < %d", $from, $to ) );
		Wikia::log( __METHOD__, "info", "Running from {$from} to {$to}" );
	}
	else {
		Wikia::log( __METHOD__, "info", "Running for all wikis" );
	}
	$dbw = Wikifactory::db( DB_MASTER );

	$sth = $dbw->select(
			array( "city_list" ),
			array( "city_id", "city_dbname" ), # , "city_cluster"
			array( "city_public=1" ) + $range ,
			__METHOD__,
			array( "ORDER BY" => "city_id" )
	);
	while( $row = $dbw->fetchObject( $sth ) ) {
		Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname}");

		/**
		 * build command
		 */
		$status = false;
		if( $full ) {
			$path = sprintf("%s/pages_full.xml.gz", getDirectory( $row->city_dbname ) );
			$cmd = "SERVER_ID={$row->city_id} " . wfEscapeShellArg(
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--full",
				"--xml",
				"--quiet",
				"--output=gzip:{$path}"
			);
			print wfShellExec( $cmd, $status );
		}
		else {
			$path = sprintf("%s/pages_current.xml.gz", getDirectory( $row->city_dbname ) );
			$cmd = "SERVER_ID={$row->city_id} " . wfEscapeShellArg(
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--current",
				"--xml",
				"--quiet",
				"--output=gzip:{$path}"
			);
			print wfShellExec( $cmd, $status );
		}
		if( $status ) {
			/**
			 * update city_list table
			 */
		}
	}
}

/**
 * dump directory is created as
 *
 * <root>/<first letter>/<two first letters>/<database>
 */
function getDirectory( $database ) {
	global $wgDevelEnvironment;
	$dumpDirectory = empty( $wgDevelEnvironment ) ?  "/opt/dbdumps" : "/tmp/dumps";
	$database = strtolower( $database );
	$directory = sprintf(
		"%s/%s/%s/%s",
		$dumpDirectory,
		substr( $database, 0, 1),
		substr( $database, 0, 2),
		$database
	);
	if( !is_dir( $directory ) ) {
		Wikia::log( __METHOD__ , "dir", "create {$directory}" );
		wfMkdirParents( $directory );
	}

	return $directory;
}


/**
 * main part
 */
$optionsWithArgs = array( 'from', 'to' );
$from = isset( $options[ "from" ] ) ? $options[ "from" ] : false;
$to   = isset( $options[ "to" ] ) ? $options[ "to" ] : false;
$full = isset( $options[ "full" ] ) ? true : false;

runBackups( $from, $to, $full );
