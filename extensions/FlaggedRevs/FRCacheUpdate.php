<?php

class FRCacheUpdate extends HTMLCacheUpdate
{
	public function doUpdate() {
		global $wgFlaggedRevsCacheUpdates;
		if( !isset($wgFlaggedRevsCacheUpdates) ) {
			$wgFlaggedRevsCacheUpdates = array();
		}
		# No duplicates...
		$key = $this->mTitle->getPrefixedDBKey();
		if( isset($wgFlaggedRevsCacheUpdates[$key]) ) {
			return;
		}
		# Fetch the IDs
		$cond = $this->getToCondition();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->mTable, $this->getFromField(), $cond, __METHOD__ );
		if( $dbr->numRows( $res ) != 0 ) {
			$this->insertJobs( $res );
		}
		$wgFlaggedRevsCacheUpdates[$key] = 1;
	}

	function insertJobs( ResultWrapper $res ) {
		$numRows = $res->numRows();
		$numBatches = ceil( $numRows / $this->mRowsPerJob );
		$realBatchSize = $numRows / $numBatches;
		$start = false;
		$jobs = array();
		do {
			for ( $i = 0; $i <= $realBatchSize - 1; $i++ ) {
				$row = $res->fetchRow();
				if( $row ) {
					$id = $row[0];
				} else {
					$id = false;
					break;
				}
			}
			$params = array(
				'table' => $this->mTable,
				'start' => $start,
				'end' => ( $id !== false ? $id - 1 : false ),
			);
			$jobs[] = new FRCacheUpdateJob( $this->mTitle, $params );
			$start = $id;
		} while ( $start );
		Job::batchInsert( $jobs );
	}

	function getPrefix() {
		return 'ftr';
	}

	function getFromField() {
		return $this->getPrefix() . '_from';
	}

	function getToCondition() {
		if( $this->mTable !== 'flaggedrevs_tracking' ) {
			throw new MWException( 'Invalid table type in ' . __CLASS__ );
		}
		$prefix = $this->getPrefix();
		return array(
			"{$prefix}_namespace" => $this->mTitle->getNamespace(),
			"{$prefix}_title"     => $this->mTitle->getDBkey()
		);
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
		$update = new FRCacheUpdate( $this->title, $this->table );

		$fromField = $update->getFromField();
		$conds = $update->getToCondition();
		if( $this->start ) {
			$conds[] = "$fromField >= {$this->start}";
		}
		if( $this->end ) {
			$conds[] = "$fromField <= {$this->end}";
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->table, $fromField, $conds, __METHOD__ );
		$update->invalidateIDs( $res );

		return true;
	}
}
