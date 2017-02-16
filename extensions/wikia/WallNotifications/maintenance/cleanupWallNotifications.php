<?php

/**
 * Script that removes dataware.wall_notification entries that are old than X days
  *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

/**
 * Maintenance script class
 */
class CleanUpWallNotifications extends Maintenance {

	const WALL_NOTIFICATION_TABLE = 'wall_notification';
	const DELETE_BATCH = 200000; // takes 1-2 seconds

	const DAYS_DEFAULT = 90; // remove notifications older than X days, can be customized via --days option

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "days", "Remove notifications older than X days" );
		$this->addOption( "really-delete", "Yes, I am aware of the consequences and want to remove these rows" );
		$this->mDescription = "Removes dataware.wall_notification entries that are older than X days";
	}

	public function execute() {
		$days = $this->getOption( 'days', self::DAYS_DEFAULT );
		$timestamp_threshold = wfTimestamp( TS_MW, time() - $days * 86400 );

		$this->output( wfTimestamp( TS_DB ) . "\n" );
		$this->output( sprintf( "Looking for notifications added before %s to remove...\n\n", $timestamp_threshold ) );

		// get the initial range
		list( $min_id, $max_id ) = $this->getNotificationsIdsRange();

		// narrow the range
		for ( $i=0; $i < 10; $i++ ) {
			$notification_id = intval( ($min_id + $max_id) / 2 );
			$this->output( sprintf( 'Checking the range %d - %d (id #%d) ... ', $min_id, $max_id, $notification_id ) );

			$timestamp = $this->getNotificationTimestamp( $notification_id );
			$this->output( sprintf( "%s\n", $timestamp ) );

			// validate the timestamp
			Wikia\Util\Assert::true(
				strtotime( $timestamp ) !== false,
				__METHOD__ . ' - timestamp needs to be valid, got ' . var_export( $timestamp, true )
			);

			if ( $timestamp < $timestamp_threshold ) {
				$affected_rows = $this->deleteNotificationsOlderThan( $notification_id );

				$this->output( sprintf( "Affected %d rows\n", $affected_rows ) );
				return;
			}
			else {
				// narrow the range - check the lower half now
				$max_id = $notification_id;
			}
		}

		$this->output( "No rows found to be deleted.\n" );
	}

	/**
	 * Get the initial range of IDs to devide and check
	 *
	 * @return int[] an array with min and max value of ID column
	 */
	private function getNotificationsIdsRange() : array {
		$row = $this->getDatawareDB()->selectRow(
			self::WALL_NOTIFICATION_TABLE,
			[
				'MIN(id) AS min',
				'MAX(id) AS max',
			],
			[],
			__METHOD__
		);

		return [
			intval( $row->min ),
			intval( $row->max ),
		];
	}

	/**
	 * Delete all notifications with ID smaller than the one we've found
	 *
	 * @param int $notification_id
	 * @return int number of rows affected
	 */
	private function deleteNotificationsOlderThan( int $notification_id ) : int {
		if ( $this->hasOption( 'really-delete' ) ) {
			$this->output( sprintf( "Deleting notifications with id < %d ... ", $notification_id ) );

			$affected_rows = 0;
			$dbw = $this->getDatawareDB( DB_MASTER );

			// perform deletes in batches
			do {
				$dbw->query(
					sprintf(
						'DELETE FROM %s WHERE id < %d LIMIT %d',
						self::WALL_NOTIFICATION_TABLE,
						$notification_id,
						self::DELETE_BATCH
					),
					__METHOD__
				);

				$deleted = $dbw->affectedRows();
				$affected_rows += $deleted;

				$this->output( '.' );

				wfWaitForSlaves( $dbw->getDBname() );

			} while( $deleted > 0 );

			$this->output( "done\n" );

			// optimize the table - takes ~30-40 seconds
			$this->output( "Optimizing the table ... " );

			$dbw->query( 'OPTIMIZE TABLE ' . self::WALL_NOTIFICATION_TABLE, __METHOD__ );

			$this->output( "done\n" );
		}
		else {
			$affected_rows = $this->getDatawareDB()->selectField(
				self::WALL_NOTIFICATION_TABLE,
				'count(*)',
				[
					sprintf( 'id < %d', $notification_id )
				],
				__METHOD__
			);

			$this->output( sprintf( "Dry-run, there are %d rows that can be deleted\n", $affected_rows ) );
		}
		return intval( $affected_rows );
	}

	/**
	 * Returns TS_MW formatted timestamp of a given notification
	 *
	 * We use revision table entry from a specified wiki
	 *
	 * @param int $notification_id
	 * @return int
	 */
	private function getNotificationTimestamp( int $notification_id ) : string {
		$row = $this->getDatawareDB()->selectRow(
			self::WALL_NOTIFICATION_TABLE,
			'entity_key', // e.g. 1401655_7976 (rev_id, wiki_id)
			[
				sprintf( 'id < %d', $notification_id ) // get notification that is the nearest one
			],
			__METHOD__
		);

		list( $revision_id, $wiki_id ) = explode( '_', $row->entity_key );

		// now connect to a wiki DB and fetch revision timestamp
		return $this->getWikiDB( $wiki_id )->selectField(
			'revision',
			'rev_timestamp',
			[
				'rev_id' => $revision_id
			],
			__METHOD__
		);
	}

	/**
	 * Get dataware database connection
	 *
	 * @param int $flags
	 * @return DatabaseMysqli
	 */
	private function getDatawareDB( int $flags = DB_SLAVE ) : DatabaseMysqli {
		global $wgExternalDatawareDB;
		return wfGetDB( $flags, [], $wgExternalDatawareDB );
	}

	/**
	 * Get wiki database connection by its wiki id
	 *
	 * @param int $wiki_id
	 * @return DatabaseMysqli
	 */
	private function getWikiDB( int $wiki_id ) : DatabaseMysqli {
		$dbname = WikiFactory::IDtoDB( $wiki_id );

		$dbr = wfGetDB( DB_SLAVE, [], $dbname );
		$dbr->ping(); // just in case we reuse an existing connection, but it managed to time out

		return $dbr;
	}
}

$maintClass = CleanUpWallNotifications::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
