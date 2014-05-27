<?php
// Go through all usernames and calculate and record spoof thingies

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/extensions/AntiSpoof/maintenance/batchAntiSpoof.php" );

class BatchCAAntiSpoof extends BatchAntiSpoof {

	/**
	 * @param $items array
	 */
	protected function batchRecord( $items ) {
		CentralAuthSpoofUser::batchRecord( $items );
	}

	/**
	 * @return DatabaseBase
	 */
	protected function getDB() {
		CentralAuthUser::getCentralDB();
	}
}

$maintClass = "BatchCAAntiSpoof";
require_once( DO_MAINTENANCE );
