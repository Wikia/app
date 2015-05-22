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

	const UNCYCLO_EDITS_AFTER = '20140101000000' ; // Jan 2014

	private $createdAccounts         = 0;
	private $mergedAccounts          = 0;
	private $renamedUnclycloAccounts = 0;
	private $renamedWikiaAccounts    = 0;
	private $accountsWithNoEmail     = 0;
	private $accountsWithNoEmailWithEdits = 0;

	/* @var resource $csv */
	private $csv;
	private $isDryRun = true;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'csv', 'Generate a report in CSV file' );
		$this->addOption( 'dry-run', 'Don\'t perform any operations' );

		$this->mDescription = 'This script migrates uncyclopedia user accounts to the shared database';
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
	 * Error log helper
	 *
	 * @param string $msg
	 * @param array $context
	 */
	private function error( $msg, Array $context = [] ) {
		Wikia\Logger\WikiaLogger::instance()->error( $msg, $context );
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
	 * Count all user edits performed after given date
	 *
	 * @param User $user user to count edits of
	 * @param string $since MW timestamp string
	 * @param int $since edits count
	 */
	protected function getEditsCountAfter( User $user, $since ) {
		return $this->getUncycloDB()->selectField(
			'revision',
			'count(*)',
			[
				'rev_user' => $user->getId(),
				sprintf( 'rev_timestamp > "%s"', $since )
			],
			__METHOD__
		);
	}

	/**
	 * Change uncyclo user ID
	 *
	 * @param User $user uncyclo account to migrate
	 * @param $newUserId new user ID
	 */
	protected function doChangeUncycloUserId( User $user, $newUserId ) {
		// check if there's the uncyclo user with the ID from shared DB
		$whoIs = User::whoIs( $newUserId );

		if ( $whoIs !== false ) {
			$this->output( sprintf( "\nCan't change the ID of %s - clashes with %s!\n", $user->getName(), $whoIs ) );
			return;
		}

		if ( $this->isDryRun ) {
			return;
		}

		// TODO
	}

	/**
	 * Rename uncyclopedia user
	 *
	 * @param User $user
	 * @return User user object with a changed name
	 */
	protected function doRenameUncycloUser( User $user ) {
		$newName = self::PREFIX_RENAME_UNCYCLO . $user->getName();
		$this->output( sprintf('> renaming uncyclo user to "%s"...', $newName) );

		// TODO

		$this->renamedUnclycloAccounts++;

		$user->setName( $newName );
		return $user;
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

		$this->renamedWikiaAccounts++;
	}

	/**
	 * Create a shared DB account using given Uncyclo account
	 *
	 * @param User $user
	 * @return User|false created global account (with a new ID and migrated user settings)
	 */
	protected function doCreateGlobalUser( User $user ) {
		if ( $this->isDryRun ) {
			return false;
		}

		$extUser = clone $user;

		// this code was borrowed from ExternalUser_Wikia::addToDatabase
		$dbw = wfGetDB( DB_MASTER, [], 'wikicities' ); // $wgExternalSharedDB is not set on uncyclo
		$dbw->begin( __METHOD__ );

		try {
			$dbw->insert(
				self::USER_TABLE,
				[
					'user_id' => null,
					'user_name' => $user->getName(),
					'user_real_name' => $user->getRealName(),
					'user_password' => $user->mPassword,
					'user_newpassword' => '',
					'user_email' => $user->getEmail(),
					'user_touched' => '',
					'user_token' => '',
					'user_options' => '',
					'user_registration' => $dbw->timestamp($user->mRegistration),
					'user_editcount' => $user->getEditCount(), // use uncyclo counter
					'user_birthdate' => $user->mBirthDate
				],
				__METHOD__
			);

			$extUser->setId( $dbw->insertId() );
			$extUser->setToken();
			$extUser->saveSettings();

			$dbw->commit(__METHOD__);
		}
		catch(Exception $e) {
			$dbw->rollback();
			throw $e;
		}

		$this->info( __METHOD__, [
			'user'     => $user->getName(),
			'local_id' => $user->getId(),
			'ext_id'   => $extUser->getId(),
		] );

		return $extUser;
	}

	/**
	 * Perform the migration of a given uncyclopedia account
	 *
	 * @param User $user
	 */
	private function migrateUser(User $user) {
		$this->output( sprintf( "%d: %s <%s>", $user->getId(), $user->getName(), $user->getEmail() ?: 'MISSING_EMAIL' ) );

		// keep data that will be saved to CSV file
		$action = false;
		$userName = $user->getName();
		$isMerged = false;

		// check if the uncyclo account has a valid email set
		$isValidEmail = Sanitizer::validateEmail( $user->getEmail() );
		$uncycloEditsSince = $this->getEditsCountAfter( $user, self::UNCYCLO_EDITS_AFTER );

		if ( !$isValidEmail ) {
			$this->accountsWithNoEmail++;

			if ( $uncycloEditsSince > 0 ) {
				$this->accountsWithNoEmailWithEdits++;

				$this->output( sprintf( "\n\tEmail missing for %s [active after Jan 2014]\n", $userName ) );
			}
		}

		// check the shared users database
		$globalUser = $this->getGlobalUserByName( $user->getName() );

		if ( $globalUser instanceof User ) {
			$this->output( sprintf(' - conflicts with the global user #%d <%s>', $globalUser->getId(), $globalUser->getEmail() ?: 'MISSING_EMAIL' ) );

			// global and shared DB accounts match
			if ( $isValidEmail && $globalUser->getEmail() === $user->getEmail() ) {
				$this->output( ' - emails match' );
				$this->output( "\n\tmerging accounts..." );

				$this->mergedAccounts++;

				$isMerged = true;
				$action = 'merge';

				$this->doChangeUncycloUserId( $user, $globalUser->getId() );
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
					$user = $this->doRenameUncycloUser( $user );
					$action = 'rename uncyclo account';
				}
				elseif ( $uncycloEdits > 0 && $globalEdits == 0 ) {
					$this->doRenameGlobalUser( $user );
					$action = 'rename wikia account';
				}
				elseif ( $uncycloEdits < 1000 ) {
					$user = $this->doRenameUncycloUser( $user );
					$action = 'rename uncyclo account';
				}
				else {
					// rename the one with the least edits
					if ( $uncycloEdits > $globalEdits ) {
						$this->doRenameGlobalUser( $user );
						$action = 'rename wikia account';
					}
					else {
						$user = $this->doRenameUncycloUser( $user );
						$action = 'rename uncyclo account';
					}
				}

				// now create a shared account using the "local" uncyclo user object
				$migratedSharedUser = $this->doCreateGlobalUser( $user );
			}
		}
		else {
			// there's no accounts conflict - create a shared account and update the uncyclopedia user_id entries
			$this->output( sprintf( "\n\tcreating a shared account for %s...", $user->getName() ) );

			$this->createdAccounts++;

			$action = 'move to shared DB';

			// now create a shared account using the "local" uncyclo user object
			$migratedSharedUser = $this->doCreateGlobalUser( $user );
		}

		// add an entry to CSV file
		if ( is_resource( $this->csv ) ) {
			fputcsv( $this->csv, [
				$user->getId(),
				$userName,
				$user->getName(),
				$user->getEmail(),
				$isValidEmail ? 'Y' : 'N',
				$isMerged ? 'Y' : 'N',
				$user->getEditCount(),
				$uncycloEditsSince,
				$globalEdits ?: 0,
				$action
			] );
		}

		$this->output( "\n" );
	}

	/**
	 * Script entry point
	 */
	public function execute() {
		$this->isDryRun = $this->hasOption( 'dry-run' );

		if ( $this->hasOption( 'csv' ) ) {
			$this->csv = fopen( $this->getOption( 'csv' ), 'w' );

			fputcsv( $this->csv, [
				'User ID',
				'User Name',
				'New user name',
				'Email',
				'Valid email',
				'Merge?',
				'Uncyclo edits',
				'Uncyclo edits after Jan 2014',
				'Global edits',
				'Action'
			] );
		}

		// get all uncyclopedia accounts
		$res = $this->getUncycloDB()->select(
			self::USER_TABLE,
			'*',
			[],
			__METHOD__
		);

		$this->output( sprintf( "Migrating %d accounts...\n", $res->numRows() ) );

		// close the current transaction (if any)
		$dbw = $this->getUncycloDB( DB_MASTER );
		$dbw->commit();

		while( $row = $res->fetchObject() ) {
			$user = User::newFromRow((object)$row);

			try {
				$dbw->begin();
				$this->migrateUser( $user );
				$dbw->commit();
			}
			catch ( Exception $e ) {
				$dbw->rollback();

				$this->error( __METHOD__ , [
					'exception' => $e,
					'user_id' => $user->getId(),
					'user_name' => $user->getName(),
				] );
			}
		}

		// print the stats
		$this->output( "\n\nDone!\n\n" );

		$this->output( sprintf( "Accounts processed:            %d\n", $res->numRows() ) );
		$this->output( sprintf( "Created Wikia accounts:        %d\n", $this->createdAccounts ) );
		$this->output( sprintf( "Merged accounts:               %d\n", $this->mergedAccounts ) );
		$this->output( sprintf( "Renamed Uncyclo accounts:      %d\n", $this->renamedUnclycloAccounts ) );
		$this->output( sprintf( "Renamed Wikia accounts:        %d\n", $this->renamedWikiaAccounts ) );
		$this->output( sprintf( "Accounts with no email:        %d\n", $this->accountsWithNoEmail ) );
		$this->output( sprintf( "  (but active after Jan 2014): %d\n", $this->accountsWithNoEmailWithEdits ) );

		if ( is_resource( $this->csv ) ) {
			fclose( $this->csv );
		}
	}
}

$maintClass = "UncycloUserMigrator";
require_once( RUN_MAINTENANCE_IF_MAIN );
