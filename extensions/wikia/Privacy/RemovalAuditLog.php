<?php

/**
 * A set of functions for creating a log of events related to a "request to be forgotten" process.
 */
class RemovalAuditLog {

	const LOG_TABLE = 'rtbf_log';
	const DETAILS_TABLE = 'rtbf_log_details';

	public static function createLog( $userId ) {
		$db = self::getDb( DB_MASTER );
		$db->insert( self::LOG_TABLE, ['user_id' => $userId], __METHOD__ );
		return $db->insertId();
	}

	public static function getNumberOfWikis( $logId ) {
		return (int)self::getDb( DB_MASTER )
			->selectField( self::LOG_TABLE, 'number_of_wikis', [ 'id' => $logId ], __METHOD__ );
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