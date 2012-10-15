<?php

/**
 * Clear the msg_resource table on all wikis if any message file has been updated.
 */

require_once( dirname( __FILE__ ) . '/WikimediaMaintenance.php' );

class ClearMessageBlobs extends WikimediaMaintenance {
	function __construct() {
		parent::__construct();
	}

	function execute() {
		global $wgExtensionMessagesFiles, $IP;

		$maxTime = 0;

		foreach ( $wgExtensionMessagesFiles as $file ) {
			if ( !file_exists( $file ) ) {
				continue;
			}
			$maxTime = max( $maxTime, filemtime( $file ) );
		}

		foreach ( glob( "$IP/languages/messages/Messages*.php" ) as $file ) {
			$maxTime = max( $maxTime, filemtime( $file ) );
		}

		# LocalisationUpdate
		foreach ( glob( "$IP/cache/l10n/*.cache" ) as $file ) {
			$maxTime = max( $maxTime, filemtime( $file ) );
		}

		if ( !file_exists( "$IP/cache/message-timestamp" ) ) {
			$this->clearBlobs();
		} else {
			$oldTime = intval( trim( file_get_contents( "$IP/cache/message-timestamp" ) ) );
			if ( $maxTime > $oldTime ) {
				$this->clearBlobs();
			}
		}

		file_put_contents( "$IP/cache/message-timestamp", "$maxTime\n" );
	}

	function clearBlobs() {
		global $wgConf;

		echo "Clearing blobs...\n";
		foreach ( $wgConf->getLocalDatabases() as $wiki ) {
			$lb = wfGetLB( $wiki );
			$db = $lb->getConnection( DB_MASTER, array(), $wiki );
			$db->query( "TRUNCATE TABLE " . $db->tableName( 'msg_resource' ), __METHOD__ );
			$db->query( "TRUNCATE TABLE " . $db->tableName( 'msg_resource_links' ), __METHOD__ );
			$lb->reuseConnection( $db );
		}
		echo "Done.\n";
	}
}

$maintClass = 'ClearMessageBlobs';
require_once( DO_MAINTENANCE );
