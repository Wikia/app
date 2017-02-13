<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

/**
 * Removes old entries from dataware.wall_notification table,
 * i.e. for Wall messages that were created more than 90 days ago
 *
 * @see SUS-1643
 */
class CleanupWallNotifications extends Maintenance {

	const NOTIFICATIONS_PER_USER_THRESHOLD = 1000; // process users with more than X notifications site-wide
	const NOTIFICATIONS_DAYS_THRESHOLD = 90; // delete notifications for messages older than X days

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption('dry-run', 'Do not perform any database operations');
		$this->mDescription = 'Removes old entries from dataware.wall_notification table';
	}

	public function execute() {
		$rowsCounter = 0;

		// get the list of users that have more than X notifications
		$res = $this->getDatawareDB()->query(
			sprintf( 'SELECT user_id, count(*) AS cnt FROM wall_notification GROUP BY user_id HAVING cnt > %d', self::NOTIFICATIONS_PER_USER_THRESHOLD )
		);
		$count = $res->numRows();

		$this->output( sprintf( "Got list of %d users to perform cleanup for\n", $count ) );

		$i = 0;
		while ( $row = $res->fetchObject() ) {
			$i++;

			$this->output( sprintf( "\n(%d/%d) Running cleanup for user #%d (%d notifications)...\n", $i, $count, $row->user_id, $row->cnt ) );
			$rowsCounter += $this->doCleanupForUser( $row->user_id );
		}

		$this->output( sprintf( "\n\nCompleted - %d rows removed", $rowsCounter ) );
	}

	/**
	 * Runs a cleanup for a given user_id
	 *
	 * @param int $user_id
	 * @return int rows (to be) removed
	 */
	private function doCleanupForUser(int $user_id) : int {
		$rowsCounter = 0;

		// get the list of wikis given user has notifications on
		$res = $this->getDatawareDB()->select(
			'wall_notification',
			[
				'wiki_id',
				'count(*) as cnt'
			],
			[
				'user_id' => $user_id
			],
			__METHOD__
		);

		while ( $row = $res->fetchObject() ) {
			$this->output( sprintf( "\twiki #%d (%d notifications)... ", $row->wiki_id, $row->cnt ) );

			$rowsAffected = $this->doCleanupForUserAndWiki( $user_id, $row->wiki_id );
			$this->output( sprintf( "%d rows removed\n", $rowsAffected ) );

			$rowsCounter += $rowsAffected;
		}

		return $rowsCounter;
	}

	/**
	 * Runs a cleanup for a given user_id and wiki_id pair
	 *
	 * @param int $user_id
	 * @param int $wiki_id
	 * @return int rows (to be) removed
	 */
	private function doCleanupForUserAndWiki(int $user_id, int $wiki_id ) : int {
		// first, let's get the revision ID that is old enough that we can remove all notifications prior to it
		$wiki_db = $this->getWikiDB( $wiki_id );
		$wiki_db->ping(); // this script runs for a while, make sure the connection to DB is still up, reconnect when needed

		$revision_id =  $wiki_db->selectField(
			'revision',
			'MAX(rev_id)',
			[
				sprintf( 'rev_timestamp < "%s"', wfTimestamp( TS_DB, time() - self::NOTIFICATIONS_DAYS_THRESHOLD * 86400 ) )
			],
			__METHOD__
		);

		// in --dry-run mode only calculate how many rows will be removed
		if ( $this->hasOption('dry-run' ) ) {
			return $this->getDatawareDB()->selectField(
				'wall_notification',
				'count(*)',
				[
					'user_id' => $user_id,
					'wiki_id' => $wiki_id,
					sprintf( 'entity_key < %d', $revision_id )
				],
				__METHOD__
			);
		}
		else {
			// TODO
			return 0;
		}
	}

	/**
	 * @param int $flags
	 * @return DatabaseMysqli
	 */
	private function getDatawareDB( int $flags = DB_SLAVE ) : DatabaseMysqli {
		global $wgExternalDatawareDB;
		return wfGetDB( $flags, [], $wgExternalDatawareDB );
	}

	/**
	 * @param int $wiki_id
	 * @return DatabaseMysqli
	 */
	private function getWikiDB( int $wiki_id ) : DatabaseMysqli {
		return wfGetDB( DB_SLAVE, [], WikiFactory::IDtoDB( $wiki_id ) );
	}
}

$maintClass = CleanupWallNotifications::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
