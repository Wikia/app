<?php
/**
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class PopulateFRRevTimestamp extends Maintenance {

	public function __construct() {
		$this->mDescription = 'Populates fr_rev_timestamp column in the flaggedrevs table.';
		$this->addOption( 'startrev', 'The ID of the starting rev', false, true );
		$this->setBatchSize( 1000 );
	}

	public function execute() {
		$startRev = $this->getOption( 'startrev' );
		if ( $startRev !== null ) {
			if ( $startRev === 'prev' ) {
				$startRev = (int)file_get_contents( $this->last_pos_file() );
			} else {
				$startRev = (int)$startRev;
			}
		}
		$this->populate_fr_rev_timestamp( $startRev );
	}

	protected function populate_fr_rev_timestamp( $start = null ) {
		$this->output( "Populating and correcting flaggedrevs columns from $start\n" );

		$db = wfGetDB( DB_MASTER );

		if ( $start === null ) {
			$start = $db->selectField( 'flaggedrevs', 'MIN(fr_rev_id)', false, __METHOD__ );
		}
		$end = $db->selectField( 'flaggedrevs', 'MAX(fr_rev_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...flaggedrevs table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $this->mBatchSize - 1;
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;
		$count = 0;
		$changed = 0;
		while ( $blockEnd <= $end ) {
			$this->output( "...doing fr_rev_id from $blockStart to $blockEnd\n" );
			$cond = "fr_rev_id BETWEEN $blockStart AND $blockEnd AND fr_rev_timestamp = ''";
			$res = $db->select(
				array( 'flaggedrevs', 'revision', 'archive' ),
				array( 'fr_rev_id', 'rev_timestamp', 'ar_timestamp' ),
				$cond,
				__METHOD__,
				array(),
				array( 'revision' => array( 'LEFT JOIN', 'rev_id = fr_rev_id' ),
					'archive' => array( 'LEFT JOIN', 'ar_rev_id = fr_rev_id' ) ) // non-unique but OK
			);
			$db->begin();
			# Go through and clean up missing items, as well as correct fr_quality...
			foreach ( $res as $row ) {
				$timestamp = '';
				if ( $row->rev_timestamp ) {
					$timestamp = $row->rev_timestamp;
				} elseif ( $row->ar_timestamp ) {
					$timestamp = $row->ar_timestamp;
				}
				if ( $timestamp != '' ) {
					# Update the row...
					$db->update( 'flaggedrevs',
						array( 'fr_rev_timestamp'   => $timestamp ),
						array( 'fr_rev_id'          => $row->fr_rev_id ),
						__METHOD__
					);
					$changed++;
				}
				$count++;
			}
			$db->commit();
			$db->freeResult( $res );
			$blockStart += $this->mBatchSize;
			$blockEnd += $this->mBatchSize;
			wfWaitForSlaves( 5 );
		}
		file_put_contents( $this->last_pos_file(), $end );
		$this->output( "fr_rev_timestamp columns update complete ..." .
			" {$count} rows [{$changed} changed]\n" );
	}

	protected function last_pos_file() {
		return dirname( __FILE__ ) . "/popRevTimestampLast-" . wfWikiID();
	}
}

$maintClass = "PopulateFRRevTimestamp";
require_once( RUN_MAINTENANCE_IF_MAIN );
