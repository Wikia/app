<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Script that removes duplicated user-name related data from local wiki tables
 *
 * Set user name related fields to an empty string ("") in cases where user ID related field is non-zero
 * (i.e. entry is for a user, not an anon).
 *
 * @see SUS-3210
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class RemoveRedundantUserNames extends Maintenance {

	private $isDryRun = false;

	// set username_column to "" in rows where userid_column value is non-zero
	const TABLES = [
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'cu_log', 'userid_column' => 'cul_user', 'username_column' => 'cul_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'image', 'userid_column' => 'img_user', 'username_column' => 'img_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[ 'table' => 'oldimage', 'userid_column' => 'oi_user', 'username_column' => 'oi_user_text' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ],
	];

	const UPDATE_BATCH = 5000;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t perform any operations, just estimate modified rows count' );
		$this->mDescription = 'This script removes duplicated user-name related data from local wiki tables';
	}

	/**
	 * ipblocks table can contain multiple entries for the same user ID, remove them
	 *
	 * This will allow us to avoid "Duplicate entry '31136422-0-0' for key 'ipb_address'
	 * (geo-db-d-master.query.consul)" DB errors
	 *
	 * @see SUS-3538
	 *
	 * @param DatabaseBase $db
	 */
	private function fixIpBlocks( DatabaseBase $db ) {
		$this->output( 'Removing multiple entries in ipblocks table ...');

		// select ipb_user from ipblocks group by ipb_user having count(*) > 1 AND user_id > 0;
		$block_user_ids = $db->selectFieldValues(
			'ipblocks',
			'ipb_user',
			'',
			__METHOD__,
			[
				'GROUP BY' => 'ipb_user',
				'HAVING' => 'count(*) > 1 AND ipb_user > 0'
			]
		);

		if ( empty( $block_user_ids ) ) {
			$this->output( " no entries to fix\n");
			return;
		}

		// now process each user and keep the oldest entry in ipblocks table
		foreach( $block_user_ids as $ipb_user ) {
			// select ipb_id from ipblocks where ipb_user = 5693154 order by ipb_id DESC limit 1
			$ipb_block = $db->selectField(
				'ipblocks',
				'ipb_id',
				[
					'ipb_user' => $ipb_user,
				],
				__METHOD__,
				[
					'ORDER BY' => 'ipb_id DESC'
				]
			);

			if ( !$this->isDryRun ) {
				$db->delete(
					'ipblocks',
					[
						'ipb_id' => $ipb_block
					],
					__METHOD__ . '::deleteBlockById'
				);
			}

			$this->output( sprintf( ' #%d', $ipb_block ) );
		}

		$this->output(" done\n");
	}

	public function execute() {
		global $wgDBname;
		$this->isDryRun = $this->hasOption( 'dry-run' );

		$rows_affected = 0;
		$db = $this->getDB(DB_MASTER);

		// SUS-3538: let's first clean up the ipblocks table that contain multiple entries for
		// the same user ID
		$this->fixIpBlocks( $db );

		foreach(self::TABLES as $entry) {
			$this->output( sprintf( 'Processing %s table ...', $entry['table'] ) );

			if ($this->isDryRun) {
				// just estimate affected rows
				$rows_updated = $db->selectField(
					$entry['table'],
					'count(*)',
					sprintf('%s > 0', $db->strencode($entry['userid_column'])),
					__METHOD__
				);
			}
			else {
				$rows_updated = 0;

				do {
					// Example: UPDATE revision SET rev_user_text = "" WHERE rev_user > 0 AND rev_user_text <> "" LIMIT 500
					$db->query(
						sprintf( 'UPDATE %s SET %s = "" WHERE %s > 0 AND %s <> "" LIMIT %d',
							$entry['table'], $entry['username_column'], $entry['userid_column'], $entry['username_column'], self::UPDATE_BATCH ),
						__METHOD__
					);

					$updated_in_batch = $db->affectedRows();

					$rows_updated += $updated_in_batch;
					$this->output( '.' );
				}
				while ( $updated_in_batch > 0 );

				// OPTIMIZE the table to reclaim the disk space and wait for slaves to catch-up
				if ( $rows_updated > 0 ) {
					$db->query( sprintf( 'OPTIMIZE TABLE %s', $entry['table'] ), __METHOD__ );
					wfWaitForSlaves( $db->getDBname() );
				}
			}

			$this->output( sprintf( " %d rows updated\n", $rows_updated ) );
			$rows_affected += $rows_updated;
		}

		$this->output( sprintf( "%s: %d rows updated in total\n", $wgDBname, $rows_affected ) );
		WikiaLogger::instance()->info( __CLASS__, [ 'rows_affected' => $rows_affected ] );
	}
}

$maintClass = RemoveRedundantUserNames::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
