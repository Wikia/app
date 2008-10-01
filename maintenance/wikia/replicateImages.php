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
	private $mServers = array(
		"file3" => array(
			"address" => "file3.sjc.wikia-inc.com",
			"transform" => array( "!^/images/(.)!", "/raid/images/by_id/$1/$1" ),
			"flag" => 1
		),
		"willow" => array(
			"address" => "willow.sjc.wikia-inc.com",
			"transform" => false,
			"flag" => 2
		)
	);

	/**
	 * main entry point for class
	 *
	 * @access public
	 *
	 * @param	array	$options	commandline options
	 */
	public function execute( $options ) {
		$iImageLimit = isset($options['limit']) ? $options['limit'] : 10;
		$sUserLogin = isset($options['u']) ? $options['u'] : 'cron';
		$bIsDryRun = isset($options['dryrun']) ? true : false;

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
				$success = true;
				$flags = 0;
				foreach( $this->mServers as $server ) {
					if( $server[ "transform" ] ) {
						$sDestPath = preg_replace( $server["transform"][0], $server["transform"][1] , $oResultRow->up_path );
					}
					else {
						$sDestPath = $oResultRow->up_path;
					}
					$sScpCommand = '/usr/bin/scp -p ' . $oResultRow->up_path . ' ' . $sUserLogin . '@' . $server["address"] . ':' . $sDestPath;
					$sScpCommand.= ' >/dev/null 2>&1';

					if( 1 ) {
						print($sScpCommand . "\n");
					}
					else {
						$aOutput = null;
						$iReturnValue = 1;
						@exec($sScpCommand, $aOutput, $iReturnValue);

						if( $iReturnValue > 0 ) {
							print("ERROR: $sScpCommand - command failed.\n\n");
							$success = false;
							break;
						}
						else {
							$flags = $flags | $server["flag"];
						}
					}
				}

				if( $success && 0 ) {
					$dbw->update(
						"upload_log",
						array(
							"up_sent" => wfTimestampNow(),
							"up_flags" => $flags
						),
						array( "up_id" => $oResultRow->up_id )
					);
					$dbw->immediateCommit();
				}
			}
		}
		else {
			print("No new images to be replicated.\n");
		}
	}
};


$replicate = new WikiaReplicateImages();
$replicate->execute( $options );
