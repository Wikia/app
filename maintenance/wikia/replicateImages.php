<?php
/**
 * Replicate images through file servers
 *
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

class WikiaReplicateImages {

	/**
	 * flag is next value of 2^n
	 */
	private $mOptions;
	private $mServers = array(
		"file3" => array(
			"address" => "10.8.2.133",
			"transform" => array( "!^/images/(.)!", "/raid/images/by_id/$1/$1" ),
			"flag" => 1
		),
		"willow" => array(
			"address" => "10.8.2.136",
			"transform" => false,
			"flag" => 2
		)
	);

	/**
	 * constructor
	 */
	public function __construct( $options ) {
		$this->mOptions = $options;
	}

	/**
	 * main entry point for class
	 *
	 * @access public
	 *
	 */
	public function execute() {
		$iImageLimit = isset( $this->mOptions['limit'] ) ? $this->mOptions['limit'] : 10;
		$login = isset( $this->mOptions['u']) ? $this->mOptions['u'] : 'cron';
		$test = isset( $this->mOptions['test']) ? true : false;

		$dbr = wfGetDBExt( DB_SLAVE );
		$dbw = wfGetDBExt( DB_MASTER );


		$oResource = $dbr->select(
			array( "upload_log" ),
			array( "up_id", "up_path" ),
			array( "up_flags" => 0 ),
			__METHOD__,
			array(
				  "ORDER BY" => "up_created ASC",
				  "LIMIT" => $iImageLimit
			)
		);
		if( $oResource ) {
			while( $oResultRow = $dbr->fetchObject( $oResource ) ) {
				$success = false;
				$flags = 0;
				$source = $oResultRow->up_path;
				foreach( $this->mServers as $server ) {
					if( $server[ "transform" ] ) {
						$destination = preg_replace( $server["transform"][0], $server["transform"][1] , $source );
					}
					else {
						$destination = $source;
					}
					/**
					 * check if source file exists. I know, stats are bad
					 */
					if( file_exists( $source ) ) {
						$cmd = wfEscapeShellArg(
							"/usr/bin/scp",
							"-p",
							"-q",
							$oResultRow->up_path,
							$login . '@' . $server["address"] . ':' . $destination
						);

						if( $test ) {
							print( $cmd . "\n" );
						}
						else {
							$output = wfShellExec( $cmd, $retval );

							if( $retval > 0 ) {
								syslog( LOG_ERR, "{$cmd} command failed." );
								$success = false;
								break;
							}
							else {
								syslog( LOG_INFO, "{$cmd}." );
								$flags = $flags | $server["flag"];
								$success = true;
							}
						}
					}
					else {
						syslog( LOG_WARNING, "{$source} doesn't exists." );
					}
				}

				if( $success && !$test ) {
					$dbw->begin();
					$dbw->update(
						"upload_log",
						array(
							"up_sent" => wfTimestampNow(),
							"up_flags" => $flags
						),
						array( "up_id" => $oResultRow->up_id )
					);
					$dbw->commit();
					syslog( LOG_INFO, "{$source} copied to ".$login . '@' . $server["address"] . ':' . $destination );
				}
			}
		}
		else {
			print("No new images to be replicated.\n");
		}
	}
};


openlog( "wikia-replicate-images", LOG_PID | LOG_PERROR, LOG_LOCAL0 );
$replicate = new WikiaReplicateImages( $options );
$replicate->execute();
closelog();
