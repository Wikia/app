<?php
/**
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy)
 *
 */
ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once('commandLine.inc');


/**
 * run backup for range of wikis
 */
function runBackups( $from, $to, $full, $options ) {

	global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath,
		$wgMaxShellTime, $wgMaxShellFileSize;

	/**
	 * hardcoded for while
	 */
	$servers = array(
		"DEFAULT" => "10.6.10.36",
		"c2" => "10.6.10.19"
	);

	/**
	 * silly trick, if we have id defined we are defining $from & $to from it
	 * if we have db param defined we first resolve which id is connected to this
	 * database
	 */
	if( isset( $options[ "db" ] ) && is_string( $options[ "db" ] ) ) {
		$city_id = WikiFactory::DBtoID( $options[ "db" ] );
		if( $city_id ) {
			$from = $to = $city_id;
		}
	}
	elseif( isset( $options[ "id" ] ) && is_numeric( $options[ "id" ] ) ) {
		$from = $to = $options[ "id" ];
	}

	/**
	 * switch off limits for dumps
	 */
	$wgMaxShellTime     = 0;
	$wgMaxShellFileSize	= 0;

	$range = array( "city_public=1" );
	if( $from !== false && $to !== false ) {
		$range[] = sprintf( "city_id >= %d AND city_id < %d", $from, $to );
		Wikia::log( __METHOD__, "info", "Running from {$from} to {$to}" );
	}
	else {
		Wikia::log( __METHOD__, "info", "Running for all wikis" );
	}
	$dbw = Wikifactory::db( DB_MASTER );

	$sth = $dbw->select(
			array( "city_list" ),
			array( "city_id", "city_dbname" ), # , "city_cluster"
			$range,
			__METHOD__,
			array( "ORDER BY" => "city_id" )
	);
	while( $row = $dbw->fetchObject( $sth ) ) {
		/**
		 * get cluster for this wiki
		 */
		$cluster = WikiFactory::getVarValueByName( "wgDBcluster", $row->city_id );
		$server = ( $cluster == "c2" ) ? $servers[ "c2" ] : $servers[ "DEFAULT" ];
		/**
		 * build command
		 */
		$status  = false;
		$basedir = getDirectory( $row->city_dbname );
		if( $full ) {
			$path = sprintf("%s/pages_full.xml.gz", $basedir );
			$cmd = array(
				"SERVER_ID={$row->city_id}",
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--full",
				"--xml",
				"--quiet",
				"--server={$server}",
				"--output=gzip:{$path}"
			);
			wfShellExec( implode( " ", $cmd ), $status );
		}
		else {
			$path = sprintf("%s/pages_current.xml.gz", $basedir );
			$cmd = array(
				"SERVER_ID={$row->city_id}",
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--current",
				"--xml",
				"--quiet",
				"--server={$server}",
				"--output=gzip:{$path}"
			);
			wfShellExec( implode( " ", $cmd ), $status );
		}
		Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} {$path}");
		/**
		 * generate index.json
	     */
		$jsonfile = sprintf("%s/index.json", $basedir );
		$json = array();

		/**
		 * open dir and read info about files
		 */
		if( is_dir( $basedir ) ) {
			$dh = opendir( $basedir );
			while( ( $file = readdir( $dh ) ) !== false ) {
				$fullpath = $basedir . "/" . $file;
				if( is_file( $fullpath ) ) {
					$json[ $file ] = array(
						"name" => $file,
						"timestamp" => filectime( $fullpath ),
						"mwtimestamp" => wfTimestamp( TS_MW, filectime( $fullpath ) )
					);
				}
			}
			closedir( $dh );
		}
		if( count( $json ) ) {
			file_put_contents( $jsonfile, Wikia::json_encode( $json ) );
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
	$dumpDirectory = empty( $wgDevelEnvironment ) ?  "/backup/dumps" : "/tmp/dumps";
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
$optionsWithArgs = array( 'from', 'to', "id", "db" );
$from = isset( $options[ "from" ] ) ? $options[ "from" ] : false;
$to   = isset( $options[ "to" ] ) ? $options[ "to" ] : false;
$full = isset( $options[ "full" ] ) ? true : false;

runBackups( $from, $to, $full, $options );
