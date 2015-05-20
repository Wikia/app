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

putenv('SERVER_ID=425'); // run in the context of uncyclopedia wiki

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class UncycloUserMigrator extends Maintenance {

	const USER_TABLE = '`user`'; # backticks prevent any magical prefixes appends

	const PREFIX_RENAME_UNCYCLO = 'Un-';
	const PREFIX_RENAME_GLOBAL = 'W-';

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
	 * Get the global user object by the given user name
	 *
	 * @param string $userName
	 * @return null|User
	 */
	private function getGlobalUserByName( $userName ) {
		$row = $this->getSharedDB()->selectRow(
			self::USER_TABLE,
			'*',
			[ 'user_name' => $userName],
			__METHOD__
		);

		return $row ? User::newFromRow( (object) $row ) : null;
	}

	/**
	 * Rename uncyclopedia user
	 *
	 * @param User $user
	 */
	protected function doRenameUncycloUser( User $user ) {
		$newName = self::PREFIX_RENAME_UNCYCLO . $user->getName();
		$this->output( sprintf('> renaming uncyclo user to "%s"...', $newName) );

		// TODO
	}

	/**
	 * Rename global user
	 *
	 * @param User $user
	 */
	protected function doRenameGlobalUser( User $user ) {
		$newName = self::PREFIX_RENAME_GLOBAL . $user->getName();
		$this->output( sprintf('> renaming global user to "%s"...', $newName) );

		// TODO
	}

	/**
	 * Perform the migration of a given uncyclopedia account
	 *
	 * @param User $user
	 */
	private function migrateUser(User $user) {
		$this->output( sprintf( "%d: %s <%s>", $user->getId(), $user->getName(), $user->getEmail() ?: 'MISSING_EMAIL' ) );

		// check the shared users database
		$globalUser = $this->getGlobalUserByName( $user->getName() );

		if ( $globalUser instanceof User ) {
			$this->output( sprintf(' - conflicts with the global user #%d <%s>', $globalUser->getId(), $globalUser->getEmail() ?: 'MISSING_EMAIL' ) );

			if ( $user->getEmail() !== '' && $globalUser->getEmail() === $user->getEmail() ) {
				$this->output( ' - emails match' );

				// TODO: merge the accounts
				$this->output( "\n\tmerging accounts..." );
			}
			else {
				// resolve conflicts
				$this->output( "\n\tresolving account conflicts..." );

				$uncycloEdits = $user->getEditCount();
				$globalEdits  = $globalUser->getEditCount();

				$this->output( sprintf(" uncyclo edits: %d / global edits: %d\n\t", $uncycloEdits, $globalEdits ) );

				/**
				Sannse says:
				No edits on either wikia = rename Uncyclopedia account
				No edits on Wikia/edits on Uncyclopedia = rename Wikia account
				< 1000 edits on Uncyclopedia = rename Uncyclopedia account
				> 1000 edits on Uncyclopedia = rename account with least edits
				 **/
				if ( $uncycloEdits == 0 && $globalEdits == 0 ) {
					$this->doRenameUncycloUser( $user );
				}
				elseif ( $uncycloEdits > 0 && $globalEdits == 0 ) {
					$this->doRenameGlobalUser( $user );
				}
				elseif ( $uncycloEdits < 1000 ) {
					$this->doRenameUncycloUser( $user );
				}
				else {
					// rename the one with the least edits
					if ( $uncycloEdits > $globalEdits ) {
						$this->doRenameGlobalUser( $user );
					}
					else {
						$this->doRenameUncycloUser( $user );
					}
				}
			}
		}
		else {
			// there's no accounts conflict - create a shared account and update the uncyclopedia user_id entries
			$this->output( sprintf( "\n\tcreating a shared account for %s...", $user->getName() ) );
		}

		$this->output( "\n" );
	}

	/**
	 * Script entry point
	 */
	public function execute() {
		// get all uncyclopedia accounts
		$res = $this->getUncycloDB()->select(
			self::USER_TABLE,
			'*',
			[],
			__METHOD__,
			[ 'LIMIT' => 250 ] // FIXME
		);

		$this->output( sprintf( "Migrating %d accounts...\n", $res->numRows() ) );

		while( $user = $res->fetchObject() ) {
			$this->migrateUser( User::newFromRow((object) $user ) );
		}
	}
}

$maintClass = "UncycloUserMigrator";
require_once( RUN_MAINTENANCE_IF_MAIN );
