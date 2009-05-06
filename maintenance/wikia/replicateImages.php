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
			"transform" => true,
			"flag" => 1
		),
		"willow" => array(
			"address" => "10.8.2.136",
			"transform" => false,
			"flag" => 2
		),
		"file4" => array(
			"address" => "10.6.10.39",
			"transform" => true,
			"flag" => 4
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
		// rsync must be run from root in order to save file's ownership
		$login = isset( $this->mOptions['u']) ? $this->mOptions['u'] : 'root';
		$test = isset( $this->mOptions['test']) ? true : false;
		$dbr = wfGetDBExt( DB_SLAVE );
		$dbw = wfGetDBExt( DB_MASTER );


		$oResource = $dbr->select(
			array( "upload_log" ),
			array( "up_id", "up_path" ),
			array(
				$dbr->makeList(
					array( "up_flags" => 0, "up_flags" => -1 ),
					LIST_OR
				),
			),
			__METHOD__,
			array(
				  "ORDER BY" => "up_created ASC",
				  "LIMIT" => $iImageLimit
			)
		);

		if( $oResource ) {
			while( $oResultRow = $dbr->fetchObject( $oResource ) ) {
				$flags = 0;
				$source = $oResultRow->up_path;

				foreach( $this->mServers as $server ) {

					/**
					 * some server have other directories layout
					 */
					if( $server[ "transform" ] ) {
						$destination = $this->transformPath( $source, $server );
					}
					else {
						$destination = $source;
					}

					/**
					 * check if source file exists. I know, stats are bad
					 */
					if( file_exists( $source ) || $test ) {
						$cmd = wfEscapeShellArg(
							"/usr/bin/rsync",
							"-axp",
							"--chmod=g+w",
							$oResultRow->up_path,
							escapeshellcmd( $login . '@' . $server["address"] . ':' . $destination )
						);

						if( $test ) {
							print( $cmd . "\n" );
						}
						else {
							$output = wfShellExec( $cmd, $retval );

							if( $retval > 0 ) {
								Wikia::log( __CLASS__, "error", "{$cmd} command failed." );
							}
							else {
								Wikia::log( __CLASS__, "info", "{$cmd}." );
								$flags = $flags | $server["flag"];
							}
						}
					}
					else {
						Wikia::log( __CLASS__, "info", "{$source} doesn't exists." );
						$flags = -1;
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
					if( $flags > 0 ) {
						Wikia::log( __CLASS__, "info", "{$source} copied to ".$login . '@' . $server["address"] . ':' . $destination );
					}
				}
			}
		}
		else {
			print("No new images to for replication.\n");
		}
	}

	/**
	 * use regexp to translate paths
	 *
	 * @access public
	 * @param string $source
	 *
	 * @return string translated path
	 */
	public function transformPath( $source, $server ) {
		$destination = $source;

		switch( $server ) {
			case "file3":
			case "file4":
				if( preg_match('!^/images/(.)!', $source, $matches ) ) {
					$first_char = $matches[1];
					$replace = '/raid/images/by_id/' . strtolower( $first_char ) . '/' . $first_char;
					$destination = preg_replace( '!^/images/(.)!', $replace, $source );
				}
				break;
		}
		return $destination;
	}
}

$replicate = new WikiaReplicateImages( $options );
$replicate->execute();
