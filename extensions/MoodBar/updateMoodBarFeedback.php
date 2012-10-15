<?php
/**
 * Update moodbar_feedback.mbf_latest_response with the latest response id
 *
 * @ingroup Maintenance
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class UpdateMoodBarFeedback extends LoggedUpdateMaintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update moodbar_feedback.mbf_latest_response with the corresponding latest moodbar_feedback_response.mbfr_id";
	}

	protected function getUpdateKey() {
		return 'update moodbar_feedback.mbf_latest_response';
	}

	protected function updateSkippedMessage() {
		return 'mbf_latest_response in moodbar_feedback table is already updated.';
	}

	protected function doDBUpdates() {
		$db = wfGetDB( DB_MASTER );

		$this->output( "Updating mbf_latest_response in moodbar_feedback table...\n" );

		// Grab the feedback record with mbf_latest_response = 0
		$lastMbfId = $totalCount = 0;
		$batchSize = $count = 100;
		
		while ( $batchSize == $count ) {
			$count = 0;
			$res = $db->select( array( 'moodbar_feedback', 'moodbar_feedback_response' ), 
						array( 'MAX(mbfr_id) AS latest_mbfr_id', 'mbf_id' ),
						array( 'mbf_id=mbfr_mbf_id', 'mbf_latest_response' => 0, 'mbf_id > ' . $lastMbfId ),
						__METHOD__,
						array( 'ORDER BY' => 'mbf_id', 'GROUP BY' => 'mbf_id', 'LIMIT' => $batchSize )
			);
			
			foreach ( $res as $row ) {
				$count++;
				$mbfrId = intval( $row->latest_mbfr_id );
				$mbfId  = intval( $row->mbf_id );
				
				$db->update( 'moodbar_feedback',
						array( 'mbf_latest_response' => $mbfrId ),
						array( 'mbf_id' => $mbfId ),
						__METHOD__ );
				
				$lastMbfId = $mbfId;
			}
			
			$totalCount += $count;
			
			$this->output( $count . "\n" );
			wfWaitForSlaves();

		}
		
		$this->output( "Done, $totalCount rows updated.\n" );
		return true;
	}
}

$maintClass = "UpdateMoodBarFeedback";
require_once( RUN_MAINTENANCE_IF_MAIN );
