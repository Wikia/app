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
		$n = 0;
		$this->output( "Creating username spoofs...\n" );
		$current = 0;
		do {
			$from = $current;
			$to = $current + $batchSize;
			$cond = [ "user_id >= $from", "user_id<$to" ];
			$result = $dbw->select( '`user`', 'user_name', $cond, __FUNCTION__ );
			$items = [];
			foreach ( $result as $row ) {
				$items[] = new SpoofUser( $row->user_name );
				$n++;
			}
			$this->batchRecord( $items );
			$this->output( "$n user(s) done. Current user_id $current\n" );
			$current += $batchSize;
		} while ( $result->numRows() > 0 );
	}
}

$maintClass = "BatchAntiSpoof";
require_once( DO_MAINTENANCE );
