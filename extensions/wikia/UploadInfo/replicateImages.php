<?php
/**
 * Replicate images through file servers
 *
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( 'commandLine.inc' );

class WikiaReplicateImages {

	/**
	 * flag is next value of 2^n
	 */
	private
		$mRunAs,
		$mTest,
		$mOptions,
		$mDatacenter,
		$mServers;

	/**
	 * constructor
	 */
	public function __construct( $options ) {

		global $wgWikiaDatacenter;
		$this->mOptions = $options;

		if( $wgWikiaDatacenter == "iowa" ) {
			$this->mDatacenter = "i";
			$this->mServers = array(
				"file3" => array(
					"address" => "10.8.44.133",
					"directory" => "/raid/images/by_id/",
					"flag" => 1
				),
				"file-s2" => array(
					"address" => "10.8.46.25",
					"directory" => "/raid/images/by_id/",
					"flag" => 2
				)
			);
		}
		else {
			$this->mDatacenter = "s";
			$this->mServers = array(
				"file-i4" => array(
					"address" => "10.6.32.35",
					"directory" => "/raid/images/by_id/",
					"flag" => 1
				),
				"file3" => array(
					"address" => "10.8.44.133",
					"directory" => "/raid/images/by_id/",
					"flag" => 2
				)
			);
		}

	}

	/**
	 * main entry point for class
	 *
	 * @access public
	 *
	 */
	public function execute() {

		global $wgErrorLog, $wgExternalDatawareDB;

		/**
		 * rsync must be run from root in order to save file's ownership
		 */
		$this->mRunAs = isset( $this->mOptions['u'] )
			? $this->mOptions['u']
			: 'root';
		$this->mTest  = isset( $this->mOptions['test'] )
			? true
			: false;
		$limit        = isset( $this->mOptions['limit'] )
			? $this->mOptions['limit']
			: 5000;
		$reverse      = isset( $this->mOptions['reverse'] )
			? true
			: false;
		$wgErrorLog   = isset( $this->mOptions['log'] )
			? true
			: false;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		/**
		 * count flag for image copied on all servers
		 */
		$copied = 0;
		foreach( $this->mServers as $server ) {
			$copied = $copied | $server["flag"];
		}
		Wikia::log( __CLASS__, "info", "flags for all copied is {$copied}" );
		Wikia::log( __CLASS__, "info", "Taking {$limit} rows" );

		$order = "up_id ";
		$order .= $reverse ? "DESC" : "ASC";

		$sth = $dbw->select(
			array( "upload_log" ),
			array( "*" ),
			array(
				"up_flags = 0 OR (up_flags & {$copied}) <> {$copied}",
				"up_flags <> -1",
				"up_datacenter" => $this->mDatacenter
			),
			__METHOD__,
			array(
				  "ORDER BY" => $order,
				  "LIMIT" => $limit
			)
		);

		if( $sth ) {
			$cnt = 1;
			while( $Row = $dbw->fetchObject( $sth ) ) {
				$flags = 0;

				/**
				 * just uploaded file
				 */
				Wikia::log( __CLASS__, "start", "===> {$cnt} up_id:{$Row->up_id} city_id:{$Row->up_city_id} created:{$Row->up_created} flags:{$Row->up_flags}" );

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
					$source = $Row->up_path;
					$target = $this->transformPath( $source, $name );

					if( file_exists( $source ) || $this->mTest ) {
						$flags = $this->sendToRemote( $server, $source, $target, $flags );
						/**
						 * if old version of file send as well, but this time
						 * ignore returned flags
						 */
						$oldsource = $Row->up_old_path;
						if( !empty( $oldsource ) && file_exists( $oldsource ) ) {
							$oldtarget = $this->transformPath( $oldsource, $name );
							$this->sendToRemote( $server, $oldsource, $oldtarget, $flags );
						}
					}
					else {
						Wikia::log( __CLASS__, "info", $source . " doesn't exists." );
						$flags = -1;
						break;
					}
				}

				if( !$this->mTest && $flags ) {
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
				}
				$cnt++;
			}
		}
		else {
			Wikia::log(__CLASS__, "info", "No new images to for replication.");
		}
		Wikia::log(__CLASS__, "info", "eot");
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
		/**
		 * transform path only for old directory layout
		 */
		$parts = explode( "/", ltrim( $source, "/" ) );
		array_shift( $parts );
		if( strlen( $parts[ 0 ] ) > 1) {
			/**
			 * add small first character
			 */
			$char = strtolower( substr( $parts[0], 0, 1 ) );
			array_unshift( $parts, $char );
		}
		return $this->mServers[ $server ][ "directory" ] . implode( "/", $parts );
	}

	/**
	 * send to remote server using rsync command
	 *
	 * @access public
	 *
	 * @param array   $server remote server definition
	 * @param string  $source source path
	 * @param string  $target destination path
	 * @param integer $flags current value for flags
	 *
	 * @return integer flags after operation
	 */
	public function sendToRemote( $server, $source, $target, $flags ) {
		$cmd = wfEscapeShellArg(
			"/usr/bin/rsync",
			"-axpr",
			"--quiet",
			"--owner",
			"--group",
			"--numeric-ids",
			"--chmod=g+w",
			$source,
			escapeshellcmd( $this->mRunAs . '@' . $server["address"] . ':' . $target )
		);

		if( $this->mTest ) {
			/**
			 * just testing
			 */
			Wikia::log( __CLASS__, "test", $cmd );
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
					$this->mRunAs . '@' . $server["address"],
					escapeshellcmd( "mkdir -p " . dirname( $target ) )
				);
				$output = wfShellExec( $cmd, $retval );
				Wikia::log( __CLASS__, "info", "s:{$server["address"]} f:{$server["flag"]} mkdir " . dirname( $target ) );
				$cmd = wfEscapeShellArg(
					"/usr/bin/rsync",
					"-axpr",
					"--quiet",
					"--owner",
					"--group",
					"--numeric-ids",
					"--chmod=g+w",
					$source,
					escapeshellcmd( $this->mRunAs . '@' . $server["address"] . ':' . $target )
				);
				$output = wfShellExec( $cmd, $retval );
				if( $retval == 0 ) {
					Wikia::log( __CLASS__, "info", "s:{$server["address"]} f:{$server["flag"]} {$source} -> {$target}" );
					$flags = $flags | $server["flag"];
				}
			}
			else {
				Wikia::log( __CLASS__, "info", "s:{$server["address"]} f:{$server["flag"]} {$source} -> {$target}" );
				$flags = $flags | $server["flag"];
			}
		}
		return $flags;
	}
}

$replicate = new WikiaReplicateImages( $options );
$replicate->execute();
