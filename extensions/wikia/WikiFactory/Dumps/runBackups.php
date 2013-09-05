<?php
/**
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy)
 *
 *
 * SERVER_ID=177 php runBackups.php --full -- generate full backups for
 * 	all active wikis
 *
 * SERVER_ID=177 php runBackups.php  -- generate current backups for all
 *	active wikis
 *
 * SERVER_ID=177 php runBackups.php  --both --id=177 -- generate full & current
 * 	backups for city_id = 177
 *
 * SERVER_ID=177 php runBackups.php  --both --db=wikicities -- generate full & current
 * 	backups for city_dbname = wikicities
 */
ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once('commandLine.inc');


/**
 * run backup for range of wikis
 */
function runBackups( $from, $to, $full, $options ) {

	global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath,
		$wgMaxShellTime, $wgMaxShellFileSize, $wgDumpsDisabledWikis;

	$range = array();

	/**
	 * shortcut for full & current together
	 */
	$both = isset( $options[ "both" ] );

	/**
	 * store backup in another folder, not available for users
	 */
	$hide = isset( $options[ "hide" ] );

	/**
	 * store backup in the system tmp dir
	 */
	$basedir = isset( $options['tmp'] ) ? sys_get_temp_dir() : '';

	/**
	 * send backup to Amazon S3 and delete the local copy
	 */
	$s3 = isset( $options['s3'] );

	/**
	 * silly trick, if we have id defined we are defining $from & $to from it
	 * if we have db param defined we first resolve which id is connected to this
	 * database
	 */
	if( isset( $options[ "db" ] ) && is_string( $options[ "db" ] ) ) {
		$city_id = WikiFactory::DBtoID( $options[ "db" ] );
		if( $city_id ) {
			$from = $to = $city_id;
			$to++;
		}
	}
	elseif( isset( $options[ "id" ] ) && is_numeric( $options[ "id" ] ) ) {
		$from = $to = $options[ "id" ];
		$to++;
	}
	elseif( isset ( $options[ "even" ] ) ) {
		$range[] = "city_id % 2 = 0";
		$range[] = "city_public = 1";
	}
	elseif( isset( $options[ "odd" ] ) ) {
		$range[] = "city_id % 2 <> 0";
		$range[] = "city_public = 1";
	}
	else {
		/**
		 * if all only for active
		 */
		$range[] = "city_public = 1";
	}

	/**
	 * exclude wikis with dumps disabled
	 */
	if( !empty( $wgDumpsDisabledWikis ) && is_array( $wgDumpsDisabledWikis ) ) {
		$range[] = 'city_id NOT IN (' . implode( ',', $wgDumpsDisabledWikis ) . ')';
	}

	/**
	 * switch off limits for dumps
	 */
	$wgMaxShellTime     = 0;
	$wgMaxShellFileSize	= 0;

	if( $from !== false && $to !== false ) {
		$range[] = sprintf( "city_id >= %d AND city_id < %d", $from, $to );
		Wikia::log( __METHOD__, "info", "Running from {$from} to {$to}", true, true );
	}
	else {
		Wikia::log( __METHOD__, "info", "Running for all wikis", true, true );
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
		$server  = wfGetDB( DB_SLAVE, 'dumps', $row->city_dbname )->getProperty( "mServer" );
		/**
		 * build command
		 */
		$status  = false;
		
		if ( '' == $basedir ) {
			$basedir = getDirectory( $row->city_dbname, $hide );
		}
		if( $full || $both ) {
			$path = sprintf("%s/%s_pages_full.xml.gz", $basedir, $row->city_dbname );
			$time = wfTime();
			Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} {$path}", true, true );
			$cmd = array(
				"SERVER_ID={$row->city_id}",
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--full",
				"--xml",
				"--quiet",
				"--server=$server",
				"--output=gzip:{$path}"
			);
			wfShellExec( implode( " ", $cmd ), $status );
			$time = Wikia::timeDuration( wfTime() - $time );
			Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} status: {$status}, time: {$time}", true, true );
			if ( $s3 ) {
				DumpsOnDemand::putToAmazonS3( $path, !$hide );
			}

		}
		if( !$full || $both ) {
			$path = sprintf("%s/%s_pages_current.xml.gz", $basedir, $row->city_dbname );
			$time = wfTime();
			Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} {$path}", true, true);
			$cmd = array(
				"SERVER_ID={$row->city_id}",
				"php",
				"{$IP}/maintenance/dumpBackup.php",
				"--conf {$wgWikiaLocalSettingsPath}",
				"--aconf {$wgWikiaAdminSettingsPath}",
				"--current",
				"--xml",
				"--quiet",
				"--server=$server",
				"--output=gzip:{$path}"
			);
			wfShellExec( implode( " ", $cmd ), $status );
			$time = Wikia::timeDuration( wfTime() - $time );
			Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} status: {$status}, time: {$time}", true, true);
			if ( $s3 ) {
				DumpsOnDemand::putToAmazonS3( $path, !$hide );
			}
		}
	}
}

/**
 * dump directory is created as
 *
 * <root>/<first letter>/<two first letters>/<database>
 */
function getDirectory( $database, $hide = false ) {
	global $wgDevelEnvironment;

	$folder     = empty( $wgDevelEnvironment ) ?  "raid" : "tmp";
	$subfolder = $hide ? "dumps-hidden" : "dumps";
	$database   = strtolower( $database );

	$directory = sprintf(
		"/%s/%s/%s/%s/%s",
		$folder,
		$subfolder,
		substr( $database, 0, 1),
		substr( $database, 0, 2),
		$database
	);
	if( !is_dir( $directory ) ) {
		Wikia::log( __METHOD__ , "dir", "create {$directory}", true, true );
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
