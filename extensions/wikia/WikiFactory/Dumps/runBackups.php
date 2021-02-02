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
 * SERVER_ID=177 php runBackups.php  --both --id=177 --s3 -- generate full & current
 * 	backups for city_id = 177 and upload it to S3
 *
 * SERVER_ID=177 php runBackups.php  --both --db=wikicities -- generate full & current
 * 	backups for city_dbname = wikicities
 *
 * This script is executed by /lib/Wikia/src/Tasks/Tasks/DumpsOnDemandTask.php
 * and //extensions/wikia/WikiFactory/Close/maintenance.php
 */

require_once(__DIR__ .'/../../../../maintenance/commandLine.inc');

/**
 * run backup for range of wikis
 */
function runBackups( $from, $to, $full, $options ) {

	global $wgMaxShellTime, $wgMaxShellFileSize, $wgDumpsDisabledWikis;

	$range = array();

	/**
	 * shortcut for full & current together
	 */
	$both = isset( $options[ "both" ] );

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
		if( $full || $both ) {
			doDumpBackup( $row, sprintf("%s/%s_pages_full.xml.7z", sys_get_temp_dir(), $row->city_dbname ), [ '--full' ] );
		}
		if( !$full || $both ) {
			doDumpBackup( $row, sprintf("%s/%s_pages_current.xml.7z", sys_get_temp_dir(), $row->city_dbname ), [ '--current' ] );
		}
	}
}

/**
 * Perform backup generation and upload to S3
 *
 * @param object $row wiki entry from city_list
 * @param string $path where to upload the generated dump
 * @param string $path where to upload the generated dump
 * @param array $args optional extra arguments for dumpBackup.php
 */
function doDumpBackup( $row, $path, array $args = [] ) {
	global $IP, $wgWikiaLocalSettingsPath, $options;
	$logger = Wikia\Logger\WikiaLogger::instance();

	$time = wfTime();
	Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} {$path}", true, true);

	$server = wfGetDB( DB_SLAVE, 'dumps', $row->city_dbname )->getProperty( "mServer" );
	$cmd = implode( ' ', array_merge( [
		"SERVER_ID={$row->city_id}",
		"php -d display_errors=1",
		"{$IP}/maintenance/dumpBackup.php",
		"--conf {$wgWikiaLocalSettingsPath}",
		"--xml",
		"--quiet",
		"--server=$server",
		"--output=".DumpsOnDemand::DEFAULT_COMPRESSION_FORMAT.":{$path}"
	], $args ) );

	// redirect stderr to stdout, so it becomes a part of $output
	$cmd .= ' 2>&1';

	Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} command: {$cmd}", true, true);

	$output = wfShellExec( $cmd, $status );
	$time = Wikia::timeDuration( wfTime() - $time );

	Wikia::log( __METHOD__, "info", "{$row->city_id} {$row->city_dbname} status: {$status}, time: {$time}", true, true);
	Wikia::log( __METHOD__, "info", $output, true, true);

	if ( $status === 0 ) {
		if ( isset( $options['s3'] ) ) {
			Wikia\Util\Assert::true( file_exists( $path ), __FUNCTION__ . ': Dump file does not exist' );

			$res = DumpsOnDemand::putToAmazonS3( $path, !isset( $options[ "hide" ] ),  MimeMagic::singleton()->guessMimeType( $path ) );
			unlink( $path );

			if ( !$res ) {
				$logger->error( __METHOD__ . '::putToAmazonS3', [
					'exception' => new Exception( 'putToAmazonS3 failed', $res ),
					'row' => (array) $row,
				] );

				exit( 1 );
			}
		}
	}
	else {
		$logger->error( __METHOD__ . '::dumpBackup', [
			'exception' => new Exception( $cmd, $status ),
			'row' => (array) $row,
			'output' => $output
		]);

		exit( 2 );
	}
}

// SUS-4313 | make this dependency obvious
$wgAutoloadClasses[ "DumpsOnDemand" ] = __DIR__ . '/DumpsOnDemand.php';

/**
 * main part
 */
$optionsWithArgs = array( 'from', 'to', "id", "db" );
$from = isset( $options[ "from" ] ) ? $options[ "from" ] : false;
$to   = isset( $options[ "to" ] ) ? $options[ "to" ] : false;
$full = isset( $options[ "full" ] ) ? true : false;

runBackups( $from, $to, $full, $options );
