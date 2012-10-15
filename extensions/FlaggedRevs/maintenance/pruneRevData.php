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

class PruneFRIncludeData extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "This script clears template/image data for reviewed versions" . 
			"that are 1+ month old and have 50+ newer versions in page. By default," .
			"it will just output how many rows can be deleted. Use the 'prune' option " .
			"to actually delete them.";
		$this->addOption( 'prune', 'Actually do a live run', false );
		$this->addOption( 'start', 'The ID of the starting rev', false, true );
		$this->setBatchSize( 500 );
	}

	public function execute() {
		$start = $this->getOption( 'start' );
		$prune = $this->getOption( 'prune' );
		$this->prune_flaggedrevs( $start, $prune );
	}

	protected function prune_flaggedrevs( $start = null, $prune = false ) {
		if ( $prune ) {
			$this->output( "Pruning old flagged revision inclusion data...\n" );
		} else {
			$this->output( "Running dry-run of old flagged revision inclusion data pruning...\n" );
		}

		$db = wfGetDB( DB_MASTER );

		if ( $start === null ) {
			$start = $db->selectField( 'flaggedpages', 'MIN(fp_page_id)', false, __METHOD__ );
		}
		$end = $db->selectField( 'flaggedpages', 'MAX(fp_page_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...flaggedpages table seems to be empty.\n" );
			return;
		}
		$end += $this->mBatchSize - 1; # Do remaining chunk
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;
		
		$tDeleted = $fDeleted = 0; // tallies
		
		$newerRevs = 50;
		$cutoff = $db->timestamp( time() - 3600 );
		while ( $blockEnd <= $end ) {
			$this->output( "...doing fp_page_id from $blockStart to $blockEnd\n" );
			$cond = "fp_page_id BETWEEN $blockStart AND $blockEnd";
			$res = $db->select( 'flaggedpages', 'fp_page_id', $cond, __METHOD__ );
			$batchCount = 0; // rows deleted without slave lag check
			// Go through a chunk of flagged pages...
			foreach ( $res as $row ) {
				// Get the newest X ($newerRevs) flagged revs for this page
				$sres = $db->select( 'flaggedrevs',
					'fr_rev_id',
					array( 'fr_page_id' => $row->fp_page_id ),
					__METHOD__,
					array( 'ORDER BY' => 'fr_rev_id DESC', 'LIMIT' => $newerRevs )
				);
				// See if there are older revs that can be pruned...
				if ( $db->numRows( $sres ) == $newerRevs ) {
					// Get the oldest of the top X revisions
					$sres->seek( $newerRevs - 1 );
					$lrow = $db->fetchObject( $sres );
					$oldestId = (int)$lrow->fr_rev_id; // oldest revision Id
					// Get revs not in the top X that were not reviewed recently
					$db->freeResult( $sres );
					$sres = $db->select( 'flaggedrevs',
						'fr_rev_id',
						array(
							'fr_page_id' => $row->fp_page_id,
							'fr_rev_id < '.$oldestId, // not in the newest X
							'fr_timestamp < '.$db->addQuotes( $cutoff ) // not reviewed recently
						),
						__METHOD__,
						// Sanity check (start with the oldest)
						array( 'ORDER BY' => 'fr_rev_id ASC', 'LIMIT' => 5000 )
					);
					// Build an array of these rev Ids
					$revsClearIncludes = array();
					foreach ( $sres as $srow ) {
						$revsClearIncludes[] = $srow->fr_rev_id;
					}
					$batchCount += count( $revsClearIncludes ); // # of revs to prune
					$db->freeResult( $sres );
					// Write run: clear the include data for these old revs
					if ( $prune ) {
						$db->begin();
						$db->delete( 'flaggedtemplates',
							array('ft_rev_id' => $revsClearIncludes),
							__METHOD__
						);
						$tDeleted += $db->affectedRows();
						$db->delete( 'flaggedimages',
							array('fi_rev_id' => $revsClearIncludes),
							__METHOD__
						);
						$fDeleted += $db->affectedRows();
						$db->commit();
					// Dry run: say how many includes rows would have been cleared
					} elseif ( count( $revsClearIncludes ) ) {
						$tDeleted += $db->selectField( 'flaggedtemplates',
							'COUNT(*)',
							array('ft_rev_id' => $revsClearIncludes),
							__METHOD__
						);
						$fDeleted += $db->selectField( 'flaggedimages',
							'COUNT(*)',
							array('fi_rev_id' => $revsClearIncludes),
							__METHOD__
						);
					}
					// Check slave lag...
					if ( $batchCount >= $this->mBatchSize ) {
						$batchCount = 0;
						wfWaitForSlaves( 5 );
					}
				} else {
					$db->freeResult( $sres );
				}
			}
			$db->freeResult( $res );
			$blockStart += $this->mBatchSize;
			$blockEnd += $this->mBatchSize;
		}
		if ( $prune ) {
			$this->output( "Flagged revision inclusion prunning complete ...\n" );
		} else {
			$this->output( "Flagged revision inclusion prune test complete ...\n" );
		}
		$this->output( "Rows: \tflaggedtemplates:$tDeleted\t\tflaggedimages:$fDeleted\n" );
	}
}

$maintClass = "PruneFRIncludeData";
require_once( RUN_MAINTENANCE_IF_MAIN );
