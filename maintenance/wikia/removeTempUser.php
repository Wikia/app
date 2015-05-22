<?php

/**
 * Script that removes old TempUser accounts
 *
 * @see PLATFORM-1146
 * @see CE-1182
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

class RemoveTempUserAccounts extends Maintenance {

	const BATCH = 1000;
	const TEMPUSER_PREFIX = 'TempUser';
	const USER_TABLE = '`user`';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->addOption( 'db', 'User database to clean [defaults to shared DB]', false, true /* $withArg */ );
		$this->mDescription = 'This script removes TempUser accounts';
	}

	/**
	 * Log helper
	 *
	 * @param string $msg
	 * @param array $context
	 */
	private function info( $msg, Array $context = [] ) {
		Wikia\Logger\WikiaLogger::instance()->info( $msg, $context );
	}

	/**
	 * Get temp user accounts
	 *
	 * - check if these accounts are really temp ones
	 * - skip accounts with user_touched changed in the last year
	 *
	 * @param DatabaseBase $db
	 * @return array
	 */
	private function getTempUserAccounts( DatabaseBase $db ) {
		$res = $db->select(
			self::USER_TABLE,
			[
				'user_id',
				'user_name'
			],
			[
				'user_name ' . $db->buildLike( self::TEMPUSER_PREFIX, $db->anyString() ),
				sprintf( 'user_touched < "%s"', wfTimestamp( TS_DB, time() - 86400 * 365 ) ),
			],
			__METHOD__
		);

		$users = [];
		while ( $user = $res->fetchObject() ) {
			// check if this is really a temp user: "TempUser" + <user ID>
			if ( $user->user_name === self::TEMPUSER_PREFIX . $user->user_id ) {
				$users[] = intval( $user->user_id );
			}
			else {
				$this->output( sprintf( " > skipped %s (#%d)\n", $user->user_name, $user->user_id ) );
			}
		}

		return $users;
	}

	/**
	 * Remove a batch of users
	 *
	 * @param DatabaseBase $dbw
	 * @param array $batch list of user IDs to remove
	 */
	private function removeBatch( DatabaseBase $dbw, Array $batch ) {
		$rows = 0;
		$dbw->begin( __METHOD__ );

		// remove entries from user table
		$dbw->delete( self::USER_TABLE,  [ 'user_id' => $batch ], __METHOD__ );
		$rows += $dbw->affectedRows();

		// remove entries from user_properties table
		$dbw->delete( 'user_properties', [ 'up_user' => $batch ], __METHOD__ );
		$rows += $dbw->affectedRows();

		$dbw->commit( __METHOD__ );

		// remove from wikicities_cX
		foreach ( $batch as $userId ) {
			ExternalUser_Wikia::removeFromSecondaryClusters( $userId );
		}

		$this->info( 'Batch removed', [
			'batch' => count( $batch ),
			'rows'  => $rows,
		] );
	}

	public function execute() {
		global $wgExternalSharedDB;
		$db = $this->getOption( 'db', $wgExternalSharedDB );
		$isDryRun = $this->hasOption( 'dry-run' );

		$this->output( "Removing temp user accounts from '$db'...\n" );

		$dbr = wfGetDB( DB_SLAVE, [], $db );
		$dbw = wfGetDB( DB_MASTER, [], $db );

		// get the list of accounts for remove
		$users = $this->getTempUserAccounts( $dbr );

		// split accounts into batches and remove them
		$batches = array_chunk( $users, self::BATCH );

		$this->output( "\nAccounts found:      " . count( $users ) );
		$this->output( "\nRemoving in batches: " . count( $batches ) );
		$this->output( "\n\n" );

		$this->info( 'Accounts found', [
			'accounts' => count( $users ),
			'batches'  => count( $batches ),
		] );

		if ( $isDryRun ) {
			return;
		}

		$this->readconsole( "Hit enter to continue..." );

		// close any open transaction
		$dbw->commit( __METHOD__ );

		foreach ( $batches as $batch ) {
			$this->removeBatch( $dbw, $batch );

			// prevent slave lag
			// we're potentially performing deletes on all clusters
			sleep( 15 );
		}

		$this->output( "\n\nDone!\n" );
	}
}

$maintClass = "RemoveTempUserAccounts";
require_once( RUN_MAINTENANCE_IF_MAIN );
