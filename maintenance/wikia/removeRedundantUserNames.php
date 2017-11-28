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

	const UPDATE_BATCH = 500;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t perform any operations, just estimate modified rows count' );
		$this->mDescription = 'This script removes duplicated user-name related data from local wiki tables';
	}

	public function execute() {
		global $wgDBname;
		$this->isDryRun = $this->hasOption( 'dry-run' );

		$rows_affected = 0;
		$db = $this->getDB(DB_MASTER);

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
			}

			// OPTIMIZE the table to reclaim the disk space and wait for slaves to catch-up
			$db->query( sprintf( 'OPTIMIZE TABLE %s', $entry['table'] ), __METHOD__ );
			wfWaitForSlaves( $db->getDBname() );

			$this->output( sprintf( " %d rows updated\n", $rows_updated ) );
			$rows_affected += $rows_updated;
		}

		$this->output( sprintf( "%s: %d rows updated in total\n", $wgDBname, $rows_affected ) );
		WikiaLogger::instance()->info( __CLASS__, [ 'rows_affected' => $rows_affected ] );
	}
}

$maintClass = RemoveRedundantUserNames::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
