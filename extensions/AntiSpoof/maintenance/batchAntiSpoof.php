<?php
// Go through all usernames and calculate and record spoof thingies

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class BatchAntiSpoof extends Maintenance {

	/**
	 * @param $items array
	 */
	protected function batchRecord( $items ) {
		SpoofUser::batchRecord( $items );
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$dbw = wfGetDB( DB_MASTER, null, 'wikicities' );

		$dbw->bufferResults( false );

		$batchSize = 1000;

		$this->output( "Creating username spoofs...\n" );
		$result = $dbw->select( 'user', 'user_name', null, __FUNCTION__ );
		$n = 0;
		$items = array();
		foreach( $result as $row ) {
			if ( $n++ % $batchSize == 0 ) {
				$this->output( "...$n\n" );
			}

			$items[] = new SpoofUser( $row->user_name );

			if ( $n % $batchSize == 0 ) {
				$this->batchRecord( $items );
				$items = array();
			}
		}

		$this->batchRecord( $items );
		$this->output( "$n user(s) done.\n" );
	}
}

$maintClass = "BatchAntiSpoof";
require_once( DO_MAINTENANCE );
