<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PopulateAFRevisions extends Maintenance {
	const REPORTING_INTERVAL = 100;
	const BATCH_SIZE = 100;
	
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates the article_feedback_revisions table";
	}
	
	public function syncDBs() {
		// FIXME: Copied from updateCollation.php, should be centralized somewhere
		$lb = wfGetLB();
		// bug 27975 - Don't try to wait for slaves if there are none
		// Prevents permission error when getting master position
		if ( $lb->getServerCount() > 1 ) {
			$dbw = $lb->getConnection( DB_MASTER );
			$pos = $dbw->getMasterPos();
			$lb->waitForAll( $pos );
		}
	}

	public function execute() {
		global $wgArticleFeedbackRatingTypes;
		
		$this->output( "Populating article_feedback_revisions table ...\n" );
		
		// Data structure where we accumulate the data
		// We need this because more recent ratings of the same user to the same page
		// need to overwrite older ratings
		// array( pageid => array( 'userid|anontoken' => array( 'revid' => revid, 'ratings' => array( id => value ) ) ) )
		$data = array();
		
		$lastRevID = 0;
		$i = 0;
		$dbw = wfGetDB( DB_MASTER );
		$this->output( "Reading data from article_feedback ...\n" );
		while ( true ) {
			// Get the next revision ID
			$row = $dbw->selectRow( 'article_feedback', array( 'aa_revision', 'aa_page_id' ),
				"aa_revision > $lastRevID", __METHOD__,
				array( 'ORDER BY' => 'aa_revision', 'LIMIT' => 1 )
			);
			if ( $row === false ) {
				// No next revision, we're done
				break;
			}
			$revid = intval( $row->aa_revision );
			$pageid = intval( $row->aa_page_id );
			
			// Get all article_feedback rows for this revision
			$res = $dbw->select( 'article_feedback',
				array( 'aa_rating_id', 'aa_rating_value', 'aa_user_id', 'aa_user_anon_token' ),
				array( 'aa_revision' => $revid ),
				__METHOD__
			);
			
			// Initialize counts and sums for each rating
			// If array_keys( $wgArticleFeedbackRatingTypes ) = array( 1, 2, 3, 4 ) this initializes them
			// to array( 1 => 0, 2 => 0, 3 => 0, 4 => 0 )
			$counts = $sums = array_combine( array_keys( $wgArticleFeedbackRatingTypes ),
				array_fill( 0, count( $wgArticleFeedbackRatingTypes ), 0 )
			);
			
			// Process each of the queried rows and update $data
			foreach ( $res as $row ) {
				$u = "{$row->aa_user_id}|{$row->aa_user_anon_token}";
				// Add entry if not present
				if ( !isset( $data[$pageid][$u] ) ) {
					$data[$pageid][$u] = array( 'revid' => $revid );
				}
				// Update the entry if this row belongs to the same or a more recent revision
				// for the specific user
				if ( $data[$pageid][$u]['revid'] <= $revid ) {
					$data[$pageid][$u]['ratings'][$row->aa_rating_id] = $row->aa_rating_value;
					$data[$pageid][$u]['revid'] = $revid;
				}
			}
			
			$lastRevID = $revid;
			
			$i++;
			if ( $i % self::REPORTING_INTERVAL ) {
				$this->output( "$lastRevID\n" );
			}
		}
		$this->output( "done\n" );
		
		// Reorganize the data into per-revision counts and totals
		$data2 = array(); // array( revid => array( 'pageid' => pageid, 'ratings' => array( ratingid => array( 'count' => count, 'total' => total ) )
		foreach ( $data as $pageid => $pageData ) {
			foreach ( $pageData as $user => $userData ) {
				$data2[$userData['revid']]['pageid'] = $pageid;
				foreach ( $userData['ratings'] as $id => $value ) {
					if ( !isset( $data2[$userData['revid']]['ratings'][$id] ) ) {
						$data2[$userData['revid']]['ratings'][$id] = array( 'count' => 0, 'total' => 0 );
					}
					if ( $value > 0 ) {
						$data2[$userData['revid']]['ratings'][$id]['count']++;
					}
					$data2[$userData['revid']]['ratings'][$id]['total'] += $value;
				}
			}
		}
		// Reorganize the data again, into DB rows this time
		$rows = array();
		foreach ( $data2 as $revid => $revData ) {
			foreach ( $revData['ratings'] as $ratingID => $ratingData ) {
				$rows[] = array(
					'afr_page_id' => $revData['pageid'],
					'afr_revision' => $revid,
					'afr_rating_id' => $ratingID,
					'afr_total' => $ratingData['total'],
					'afr_count' => $ratingData['count']
				);
			}
		}
		
		$this->output( "Writing data to article_feedback_revisions ...\n" );
		$rowsInserted = 0;
		while ( $rows ) {
			$batch = array_splice( $rows, 0, self::BATCH_SIZE );
			$dbw->replace( 'article_feedback_revisions',
				array( array( 'afr_page_id', 'afr_rating_id', 'afr_revision' ) ),
				$batch, __METHOD__
			);
			$rowsInserted += count( $batch );
			$this->syncDBs();
			$this->output( "$rowsInserted rows\n" );
		}
		$this->output( "done\n" );
		
	}
}

$maintClass = "PopulateAFRevisions";
require_once( DO_MAINTENANCE );
