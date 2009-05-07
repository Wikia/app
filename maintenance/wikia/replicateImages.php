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
		$limit = isset( $this->mOptions['limit'] ) ? $this->mOptions['limit'] : 10000;
		// rsync must be run from root in order to save file's ownership
		$login = isset( $this->mOptions['u']) ? $this->mOptions['u'] : 'root';
		$test = isset( $this->mOptions['test']) ? true : false;
		$dbr = wfGetDBExt( DB_SLAVE );
		$dbw = wfGetDBExt( DB_MASTER );

		/**
		 * count flag for image copied on all servers
		 */
		$copied = 0;
		foreach( $this->mServers as $server ) {
			$copied = $copied | $server["flag"];
		}
		Wikia::log( __CLASS__, "info", "flags for all copied is {$copied}" );

		$oResource = $dbr->select(
			array( "upload_log" ),
			array( "up_id", "up_path", "up_flags" ),
			array(
				"up_flags = 0 OR (up_flags & {$copied}) <> {$copied}",
				"up_flags <> -1"
			),
			__METHOD__,
			array(
				  "ORDER BY" => "up_created ASC",
				  "LIMIT" => $limit
			)
		);

		if( $oResource ) {
			while( $Row = $dbr->fetchObject( $oResource ) ) {
				$flags = 0;
				$source = $Row->up_path;

				foreach( $this->mServers as $name => $server ) {

					/**
					 * check flags. Maybe file is already copied to destination
					 * server
					 */
					if( ( $Row->up_flags & $server["flag"] ) == $server["flag"] ) {
						$flags = $flags | $server["flag"];
						Wikia::log( __CLASS__, "info", "{$Row->up_flags} vs {$server["flag"]}: already uploaded to {$name}" );
						continue;
					}

					/**
					 * some server have other directories layout
					 */
					if( $server[ "transform" ] ) {
						$destination = $this->transformPath( $source, $name );
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
							"-axpr",
							"--chmod=g+w",
							$Row->up_path,
							escapeshellcmd( $login . '@' . $server["address"] . ':' . $destination )
						);

						if( $test ) {
							print( $cmd . "\n" );
						}
						else {
							$output = wfShellExec( $cmd, $retval );

							if( $retval > 0 ) {
								Wikia::log( __CLASS__, "error", "{$cmd} command failed." );
								/**
								 * maybe we don't have target directory?
								 * try to create remote directory
								 */
								$cmd = wfEscapeShellArg(
									"/usr/bin/ssh",
									$login . '@' . $server["address"],
									escapeshellcmd( "mkdir -p " . dirname( $destination ) )
								);
								$output = wfShellExec( $cmd, $retval );
								Wikia::log( __CLASS__, "info", "{$cmd}" );
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
						break;
					}
				}

				if( !$test && $flags ) {
					$dbw->begin();
					$dbw->update(
						"upload_log",
						array(
							"up_sent" => wfTimestampNow(),
							"up_flags" => $flags
						),
						array( "up_id" => $Row->up_id )
					);
					$dbw->commit();
					if( $flags > 0 ) {
						Wikia::log( __CLASS__, "info", "{$source} copied to ".$login . '@' . $server["address"] . ':' . $destination );
					}
				}
			}
		}
		else {
			Wikia::log(__CLASS__, "info", "No new images to for replication.");
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
