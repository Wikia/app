<?php

/**
 * Base class used by:
 *  - removeTempUser.php
 *  - removeRenamedUser.php
 *
 * @see PLATFORM-1146
 * @see PLATFORM-1318
 * @see CE-1182
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

abstract class RemoveUserBase extends Maintenance {

	const BATCH = 1000;
	const USER_TABLE = '`user`';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->addOption( 'db', 'User database to clean [defaults to shared DB]', false, true /* $withArg */ );
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
	 * Get the list of user accounts to remove
	 *
	 * @param DatabaseBase $db
	 * @return int[] array with user IDs to be removed
	 */
	abstract protected function getAccountsToRemove( DatabaseBase $db ) ;

	/**
	 * Remove a batch of users
	 *
	 * @param DatabaseBase $dbw
	 * @param int[] $batch list of user IDs to remove
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

		$this->info( 'Batch removed', [
			'batch' => count( $batch ),
			'rows'  => $rows,
		] );
	}

	public function execute() {
		global $wgExternalSharedDB;
		$db = $this->getOption( 'db', $wgExternalSharedDB );
		$isDryRun = $this->hasOption( 'dry-run' );

		$this->output( "Removing user accounts from '$db'...\n" );

		$dbr = wfGetDB( DB_SLAVE, [], $db );
		$dbw = wfGetDB( DB_MASTER, [], $db );

		// get the list of accounts for remove
		$users = $this->getAccountsToRemove( $dbr );
		$this->output( "\nSQL used:            " . $dbr->lastQuery() );

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
			/* @var int[] $batch */
			$this->removeBatch( $dbw, $batch );

			// prevent slave lag
			// we're potentially performing deletes on all clusters
			wfWaitForSlaves( $db );
		}

		$this->output( "\n\nDone!\n" );
	}
}
