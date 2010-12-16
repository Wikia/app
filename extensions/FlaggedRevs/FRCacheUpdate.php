<?php
/**
 * Class containing cache update methods and job construction
 * for the special case of purging pages due to links contained
 * only in the stable version of pages
 */
class FRCacheUpdate {
	public $mTitle, $mTable;
    public $mRowsPerJob, $mRowsPerQuery;

    public function __construct( $titleTo ) {
        global $wgUpdateRowsPerJob, $wgUpdateRowsPerQuery;
        $this->mTitle = $titleTo;
        $this->mTable = 'flaggedrevs_tracking';
        $this->mRowsPerJob = $wgUpdateRowsPerJob;
        $this->mRowsPerQuery = $wgUpdateRowsPerQuery;
    }

	public function doUpdate() {
		global $wgFlaggedRevsCacheUpdates;
		if ( !isset( $wgFlaggedRevsCacheUpdates ) ) {
			$wgFlaggedRevsCacheUpdates = array(); // temp var
		}
		$key = $this->mTitle->getPrefixedDBKey();
		if ( isset( $wgFlaggedRevsCacheUpdates[$key] ) )
			return; // No duplicates...
		# Fetch the IDs
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->mTable, $this->getFromField(),
			$this->getToCondition(), __METHOD__ );
		if ( $dbr->numRows( $res ) > 0 ) {
			# Do it right now?
			if ( $dbr->numRows( $res ) <= $this->mRowsPerJob ) {
				$this->invalidateIDs( $res );
			# Defer to job queue...
			} else {
				$this->insertJobs( $res );
			}
		}
		$wgFlaggedRevsCacheUpdates[$key] = 1; // No duplicates...
	}

	protected function insertJobs( ResultWrapper $res ) {
		$numRows = $res->numRows();
		if ( !$numRows ) return; // sanity check
		$numBatches = ceil( $numRows / $this->mRowsPerJob );
		$realBatchSize = ceil( $numRows / $numBatches );
		$start = false;
		$jobs = array();
		do {
			$first = $last = false; // first/last page_id of this batch
			# Get $realBatchSize items (or less if not enough)...
			for ( $i = 0; $i < $realBatchSize; $i++ ) {
				$row = $res->fetchRow();
				# Is there another row?
				if ( $row ) {
					$id = $row[0];
					$last = $id; // $id is the last page_id of this batch
					if ( $first === false )
						$first = $id; // set first page_id of this batch
				# Out of rows?
				} else {
					$id = false;
					break;
				}
            }
			# Insert batch into the queue if there is anything there
			if ( $first ) {
				$params = array(
					'table' => $this->mTable,
					'start' => $first,
					'end'   => $last,
				);
				$jobs[] = new FRCacheUpdateJob( $this->mTitle, $params );
			}
            $start = $id; // Where the last ID left off
		} while ( $start );
		Job::batchInsert( $jobs );
    }

	public function getFromField() {
		return 'ftr_from';
	}

	public function getToCondition() {
		return array( 'ftr_namespace' => $this->mTitle->getNamespace(),
			'ftr_title' => $this->mTitle->getDBkey() );
	}
	
	/**
     * Invalidate a set of IDs, right now
     */
    public function invalidateIDs( ResultWrapper $res ) {
        global $wgUseFileCache, $wgUseSquid;
        if ( $res->numRows() == 0 ) return; // sanity check

        $dbw = wfGetDB( DB_MASTER );
        $timestamp = $dbw->timestamp();
        $done = false;

        while ( !$done ) {
            # Get all IDs in this query into an array
            $ids = array();
            for ( $i = 0; $i < $this->mRowsPerQuery; $i++ ) {
                $row = $res->fetchRow();
                if ( $row ) {
                    $ids[] = $row[0];
                } else {
                    $done = true;
                    break;
                }
            }
            if ( count( $ids ) == 0 ) break;
            # Update page_touched
            $dbw->update( 'page', array( 'page_touched' => $timestamp ),
				array( 'page_id' => $ids ), __METHOD__ );
            # Update static caches
            if ( $wgUseSquid || $wgUseFileCache ) {
                $titles = Title::newFromIDs( $ids );
				# Update squid cache
                if ( $wgUseSquid ) {
                    $u = SquidUpdate::newFromTitles( $titles );
                    $u->doUpdate();
                }
                # Update file cache
                if ( $wgUseFileCache ) {
                    foreach ( $titles as $title ) {
                        HTMLFileCache::clearFileCache( $title );
                    }
                }
            }
        }
    }
}

/**
 * @todo document (e.g. one-sentence top-level class description).
 * @ingroup JobQueue
 */
class FRCacheUpdateJob extends Job {
	var $table, $start, $end;

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	function __construct( $title, $params, $id = 0 ) {
		parent::__construct( 'flaggedrevs_CacheUpdate', $title, $params, $id );
		$this->table = $params['table'];
		$this->start = $params['start'];
		$this->end = $params['end'];
	}

	function run() {
		$update = new FRCacheUpdate( $this->title );
		# Get query conditions
		$fromField = $update->getFromField();
		$conds = $update->getToCondition();
		if ( $this->start ) {
			$conds[] = "$fromField >= {$this->start}";
		}
		if ( $this->end ) {
			$conds[] = "$fromField <= {$this->end}";
		}

		# Run query to get page Ids
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->table, $fromField, $conds, __METHOD__ );
		# Invalidate the pages
		$update->invalidateIDs( $res );
		return true;
	}
}
