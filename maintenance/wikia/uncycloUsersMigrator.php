<?php

/**
 * Script migrating users from uncyclopedia local database to shared users database.
 *
 * Handle the following cases:
 *
 * 1) check if there's the same account in shared DB (same user name and email) -> use global user_id
 * 2) there's no account in shared DB -> move the account from uncyclopedia DB, use new global user_id
 * 3) there's an account conflict: perform the logic from resolveAccountsConflict method
 *
 * @see PLATFORM-1055
 * @see PLATFORM-1146
 *
 * @author Macbre
 * @ingroup Maintenance
 */

define('SERVER_ID', 425); // run in the cobtext of uncyclopedia wiki

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class UncycloUserMigrator extends Maintenance {

	const USER_TABLE = '`user`'; # backticks prevent any magical prefixes appends

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t perform any operations' );

		$this->mDescription = 'This script migrates uncyclopedia user accounts to the shared database';
	}

	/**
	 * Get the uncyclopedia database
	 *
	 * @param int $flag
	 * @return DatabaseMysqli
	 */
	private function getUncycloDB($flag = DB_SLAVE) {
		return wfGetDB($flag);
	}

	/**
	 * Get the shared database
	 *
	 * @param int $flag
	 * @return DatabaseMysqli
	 */
	private function getSharedDB($flag = DB_SLAVE) {
		global $wgExternalSharedDB;
		return wfGetDB($flag, [], $wgExternalSharedDB);
	}

	/**
	 * Perform the migration of a given uncyclopedia account
	 *
	 * @param User $user
	 */
	private function migrateUser(User $user) {
		$this->output( sprintf( "%d: %s <%s>", $user->getId(), $user->getName(), $user->getEmail() ) );
	}

	public function execute() {
		// get all uncyclopedia accounts
		$res = $this->getUncycloDB()->select( self::USER_TABLE, '*', [], __METHOD__ );

		$this->output( sprintf( "Migrating %d accounts...\n", $res->numRows() ) );

		while($user = $res->fetchRow()) {
			$this->migrateUser( User::newFromRow($user) );
		}
	}
}

$maintClass = "UncycloUserMigrator";
require_once( RUN_MAINTENANCE_IF_MAIN );
