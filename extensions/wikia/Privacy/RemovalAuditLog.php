<?php

/**
 * A set of functions for creating a log of events related to a "request to be forgotten" process.
 */
class RemovalAuditLog {

	const LOG_TABLE = 'rtbf_log';
	const DETAILS_TABLE = 'rtbf_log_details';

	public static function createLog( $userId ) {
		$db = self::getDb( DB_MASTER );
		$db->insert( self::LOG_TABLE, [ 'user_id' => $userId, 'global_data_removed' => false ], __METHOD__ );

		return $db->insertId();
	}

	/**
	 * Mark that global user data was removed for the given log id.
	 *
	 * @param $logId
	 */
	public static function markGlobalDataRemoved( $logId ) {
		self::getDb( DB_MASTER )
			->update( self::LOG_TABLE, [ 'global_data_removed' => true ], [ 'id' => $logId ], __METHOD__ );
	}

	public static function allWikiDataWasRemoved( $logId, $detailsDbType ) {
		$expectedWikis = (int)self::getDb( DB_SLAVE )
			->selectField( self::LOG_TABLE, 'number_of_wikis', [ 'id' => $logId ], __METHOD__ );

		// since we're usually using this right after updating a row, we must use DB_MASTER to read the current state of the db
		// when checking a (potentially) finished process, DB_SLAVE can be used as well
		$finishedWikis = (int)self::getDb( $detailsDbType )->selectField(
			RemovalAuditLog::DETAILS_TABLE,
			'count(*)',
			[
				'log_id' => $logId,
				'was_successful' => true
			]
		);

		return $expectedWikis == $finishedWikis;
	}

	public static function allDataWasRemoved( $logId ) {
		$wikiDataRemoved = self::allWikiDataWasRemoved( $logId, DB_SLAVE );
		$globalDataRemoved = (bool)self::getDb(DB_SLAVE )
			->selectField( self::LOG_TABLE, [ 'global_data_removed' ], [ 'id' => $logId ], __METHOD__ );
		return $wikiDataRemoved && $globalDataRemoved;
	}

	public static function setNumberOfWikis( $logId, $numberOfWikis ) {
		self::getDb( DB_MASTER )
			->update( self::LOG_TABLE, [ 'number_of_wikis' => $numberOfWikis ], [ 'id' => $logId ],
				__METHOD__ );
	}

	public static function addWikiTask( $logId, $wikiId, $taskId ) {
		self::getDb( DB_MASTER )
			->insert( self::DETAILS_TABLE,
				[ 'log_id' => $logId, 'wiki_id' => $wikiId, 'celery_task' => $taskId ],
				__METHOD__ );
	}

	public static function markTaskAsFinished( $logId, $wikiId, $wasSuccessful ) {
		self::getDb( DB_MASTER )
			->update( self::DETAILS_TABLE,
				[ 'finished' => wfTimestamp( TS_DB ), 'was_successful' => $wasSuccessful ],
				[ 'log_id' => $logId, 'wiki_id' => $wikiId ], __METHOD__ );
	}

	public static function getNumberOfFinishedTasks( $logId ) {
		return (int)self::getDb( DB_MASTER )
			->selectField( self::DETAILS_TABLE, 'count(*)', [ 'log_id' => $logId ], __METHOD__ );
	}

	private static function getDb( $type ) {
		global $wgSpecialsDB;

		return wfGetDB( $type, [], $wgSpecialsDB );
	}

}
