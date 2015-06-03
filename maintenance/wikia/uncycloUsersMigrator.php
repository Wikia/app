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

class UncycloUsersMigratorException extends Exception {}

/**
 * Maintenance script class
 */
class UncycloUserMigrator extends Maintenance {

	const USER_TABLE = '`user`'; # backticks prevent any magical prefixes appends
	const SHARED_DB = 'wikicities';

	const PREFIX_RENAME_UNCYCLO = 'Un-';
	const PREFIX_RENAME_GLOBAL = 'W-';

	const UNCYCLO_EDITS_AFTER = '20140101000000' ; // Jan 2014

	const RENAME_REASON = 'Uncyclopedia users migration';

	private $createdAccounts         = 0;
	private $mergedAccounts          = 0;
	private $renamedUnclycloAccounts = 0;
	private $renamedWikiaAccounts    = 0;
	private $accountsWithNoEmail     = 0;
	private $accountsWithNoEmailWithEdits = 0;

	/* @var resource $csv */
	private $csv;
	private $isDryRun = true;
	private $onlyRenameGlobalUsers = true;

	/**
	 * Stores the predefined tasks to do for every local wiki database.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * Borrowed from /extensions/wikia/UserRenameTool/RenameUserProcess.class.php
	 */
	static private $mTableRenameRules = [
		# Core MW tables
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'image', 'userid_column' => 'img_user', 'username_column' => 'img_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_by', 'username_column' => 'ipb_by_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[ 'table' => 'oldimage', 'userid_column' => 'oi_user', 'username_column' => 'oi_user_text' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ],
		[ 'table' => 'text', 'userid_column' => 'old_user', 'username_column' => 'old_user_text' ],
		[ 'table' => 'user_newtalk', 'userid_column' => null, 'username_column' => 'user_ip' ],
		# Core 1.16 tables
		[ 'table' => 'logging', 'userid_column' => 'log_user', 'username_column' => 'log_user_text' ],

		# macbre: wikia-specific tables
		[ 'table' => 'cu_log', 'userid_column' => 'cul_user', 'username_column' => 'cul_user_text' ],
		[ 'table' => 'cu_changes', 'userid_column' => 'cuc_user', 'username_column' => 'cuc_user_text' ],

		# macbre: user ID only tables
		[ 'table' => 'user_groups', 'userid_column' => 'ug_user', 'username_column' => null ],
		[ 'table' => 'user_former_groups', 'userid_column' => 'ufg_user', 'username_column' => null ],
		[ 'table' => 'user_newtalk', 'userid_column' => 'user_id', 'username_column' => null ],
		[ 'table' => 'user_properties', 'userid_column' => 'up_user', 'username_column' => null ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_deleted_user', 'username_column' => null ],
		[ 'table' => 'uploadstash', 'userid_column' => 'us_id', 'username_column' => null ],
		[ 'table' => 'watchlist', 'userid_column' => 'wl_user', 'username_column' => null ],
		[ 'table' => 'page_restrictions', 'userid_column' => 'pr_user', 'username_column' => null ],
		[ 'table' => 'protected_titles', 'userid_column' => 'pt_user', 'username_column' => null ],

		# macbre: user ID only, wikia-specific tables
		[ 'table' => 'wikia_user_properties', 'userid_column' => 'wup_user', 'username_column' => null ],
		[ 'table' => 'video_info', 'userid_column' => 'added_by', 'username_column' => null ],
		[ 'table' => 'wall_history', 'userid_column' => 'post_user_id', 'username_column' => null ],
		[ 'table' => 'page_vote', 'userid_column' => 'user_id', 'username_column' => null ],

		# Template entry
//		[ 'table' => '...', 'userid_column' => '...', 'username_column' => '...' ],
	];

	const UPDATE_TABLE_USER_ID = 'userid_column';
	const UPDATE_TABLE_USER_NAME = 'username_column';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'csv', 'Generate a report in CSV file' );
		$this->addOption( 'dry-run', 'Don\'t perform any operations [default]' );
		$this->addOption( 'force', 'Apply the changes made by the script' );
		$this->addOption( 'only-rename-global-users', 'Perform global users rename ONLY' );
		$this->addOption( 'do-not-touch-global-users', 'Do not touch shared users database (no renames nor creation)' );
		$this->addOption( 'cluster', 'Use the provided cluster instead of $wgDBcluster' ); // e.g. --cluster=c5

		$this->addOption( 'from', 'Uncyclo user ID to start the migration from' );
		$this->addOption( 'to', 'Uncyclo user ID to finish the migration at' );

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
	protected function err( $msg, Array $context = [] ) {
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
		return wfGetDB( $flag, [], self::SHARED_DB );
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
	 * Updates given column (userid_column or username_column) with a new value
	 *
	 * @param string $fieldType
	 * @param string|int $oldValue
	 * @param string|int $newValue
	 */
	protected function updateTables( $fieldType, $oldValue, $newValue ) {
		$dbw = $this->getUncycloDB(DB_MASTER);
		$rows = 0;

		foreach( self::$mTableRenameRules as $entry ) {
			// a single entry:
			// array( 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ),
			if ( is_null( $entry[ $fieldType ] ) ) {
				continue;
			}

			$columnName = $entry[ $fieldType ];
			$tableName = $entry[ 'table' ];

			// perform table update in batches of 500 rows
			// UPDATE /* method */ `foo` SET foo_id = "new" WHERE foo_id = "old" LIMIT 500
			do {
				// Database::update method does not support passing LIMIT option
				$sql = sprintf(
					'UPDATE `%s` SET %s = %s WHERE %s = %s LIMIT 500',
					$entry['table'],
					$columnName,
					$dbw->addQuotes( $newValue ),
					$columnName,
					$dbw->addQuotes( $oldValue )
				);
				$dbw->query( $sql, __METHOD__ );
				$rows += $dbw->affectedRows();
			} while ($dbw->affectedRows() > 0);
		}

		$this->info( __METHOD__, [
			'rows' => $rows,
			'field_type' => $fieldType,
			'old' => $oldValue,
			'new' => $newValue
		] );
	}

	/**
	 * Change uncyclo user ID
	 *
	 * Updates fields with user ID only!
	 *
	 * @param User $user uncyclo account to migrate
	 * @param $newUserId new user ID
	 * @throws Exception
	 */
	protected function doChangeUncycloUserId( User $user, $newUserId ) {
		// "OptiPest" and "MrFlashlight" accounts have the same ID on uncyclo and shared DB
		if ( $newUserId == $user->getId() ) {
			return;
		}

		// don't touch uncyclo users in "global users only" mode
		if ( $this->onlyRenameGlobalUsers ) {
			return;
		}

		// check if there's the uncyclo user with the ID from shared DB
		$whoIs = User::whoIs( $newUserId );

		if ( $whoIs !== false ) {
			$this->output( sprintf( "\nCan't change the ID of %s - clashes with %s!\n", $user->getName(), $whoIs ) );

			if (!$this->isDryRun) {
				throw new UncycloUsersMigratorException(sprintf('IDs clash for %s (new ID taken from shared DB would be #%d)', $user->getName(), $newUserId));
			}
		}

		if ( $this->isDryRun ) {
			return;
		}

		// update user_id in the local user database
		$dbw = $this->getUncycloDB( DB_MASTER );
		$dbw->update( self::USER_TABLE,  [ 'user_id' => $newUserId ], [ 'user_id' => $user->getId() ], __METHOD__ );

		// update user_id in the rest of MW & Wikia-specific tables
		$this->updateTables( self::UPDATE_TABLE_USER_ID, $user->getId(), $newUserId );
	}

	/**
	 * Returns the new name for a given user and prefix provided
	 *
	 * @param User $user
	 * @param $prefix
	 * @throws UncycloUsersMigratorException if a new name can't be generated
	 * @return string
	 */
	protected function getNewUserName( User $user, $prefix ) {
		$newName = $prefix . $user->getName();

		// check user name conflicts
		// if there is one: try using suffixes -1, -2 and so on
		$suffix = 1;
		while ( $this->getGlobalUserByName( $newName ) instanceof User ) {
			$newName = $prefix . $user->getName() . '-' . $suffix++;

			if ($suffix > 5) {
				throw new UncycloUsersMigratorException( "Can't find a new name for {$user->getName()} (using '{$prefix}' prefix)" );
			}
		}

		return $newName;
	}

	/**
	 * Rename uncyclopedia user
	 *
	 * Updates fields with user name only!
	 *
	 * @param User $uncycloUser
	 * @return User user object with a changed name
	 */
	protected function doRenameUncycloUser( User $uncycloUser ) {
		// don't touch uncyclo users in "global users only" mode
		if ( $this->onlyRenameGlobalUsers ) {
			return $uncycloUser;
		}

		$user = clone $uncycloUser;

		$newName = $this->getNewUserName( $user, self::PREFIX_RENAME_UNCYCLO );
		$this->output( sprintf('> renaming uncyclo user to "%s"...', $newName) );

		$this->renamedUnclycloAccounts++;

		if ( !$this->isDryRun ) {
			// update user_name in MW tables
			$this->updateTables(self::UPDATE_TABLE_USER_NAME, $user->getName(), $newName);

			// move user page
			// TODO: include subpages as well
			$oldUserPage = Title::newFromText($user->getName(), NS_USER);
			$newUserPage = Title::newFromText($newName, NS_USER);
			$oldUserPage->moveTo($newUserPage, false /* do not check permissions to move */, 'Migrating Uncyclopedia accounts');
		}

		// return the updated user object
		$user->setName( $newName );
		return $user;
	}

	/**
	 * Rename global user
	 *
	 * @param User $user global user
	 */
	protected function doRenameGlobalUser( User $user ) {
		$newName = $this->getNewUserName( $user, self::PREFIX_RENAME_GLOBAL );
		$this->output( sprintf( '> renaming global user to "%s" (#%d)...', $newName, $user->getId() ) );

		$this->renamedWikiaAccounts++;

		if ( $this->isDryRun ) {
			return;
		}

		// do not touch shared users database
		if ( $this->hasOption( 'do-not-touch-global-users' ) ) {
			return;
		}

		$cmd = sprintf( 'php %s/renameUser.php --old-username=%s --new-username=%s --reason=%s',
			__DIR__,
			escapeshellarg( $user->getName() ),
			escapeshellarg( $newName ),
			escapeshellarg( self::RENAME_REASON )
		);

		$retVal = 0;
		$output = wfShellExec( $cmd, $retVal );

		if ( $retVal > 0 ) {
			$this->err( __METHOD__, [
				'cmd' => $cmd,
				'exception' => new Exception( $output, $retVal )
			]);

			throw new UncycloUsersMigratorException( "#{$retVal}: {$output}", $retVal );
		}

		$this->info( __METHOD__, [ 'user' => $user->getName() ] );
		$this->output( sprintf( "\n%s: %s\n", __METHOD__, trim( $output ) ) );
	}

	/**
	 * Create a shared DB account using given Uncyclo account
	 *
	 * @param User $user
	 * @return User|false created global account (with a new ID and migrated user settings)
	 */
	protected function doCreateGlobalUser( User $user ) {
		// don't touch uncyclo users in "global users only" mode
		if ( $this->onlyRenameGlobalUsers ) {
			return;
		}

		$this->output( sprintf( "\n\tcreating a shared account for %s...", $user->getName() ) );

		if ( $this->isDryRun ) {
			return false;
		}

		/* @var User $extUser */
		$extUser = clone $user;
		$extUser->setToken();

		// this code was borrowed from ExternalUser_Wikia::addToDatabase
		$fname = __METHOD__;
		$dbw = $this->getSharedDB( DB_MASTER );
		$dbw->begin( $fname );

		try {
			/**
			 * Now create a shared DB user and update the local user (and his settings) to have the matching ID
			 */
			if ( !$this->hasOption( 'do-not-touch-global-users' ) ) {
				$dbw->insert(
					self::USER_TABLE,
					[
						'user_id' => null,
						'user_name' => $user->getName(),
						'user_real_name' => $user->getRealName(),
						'user_password' => $user->mPassword,
						'user_newpassword' => '',
						'user_email' => $user->mEmail, // getEmail() would make a DB query
						'user_touched' => '',
						'user_token' => '',
						'user_options' => '',
						'user_registration' => $dbw->timestamp($user->mRegistration),
						'user_editcount' => $user->getEditCount(), // use uncyclo counter
						'user_birthdate' => $user->mBirthDate
					],
					$fname
				);

				$extUser->mId = $dbw->insertId();

				// move user settings to the shared DB
				$res = $this->getUncycloDB()->select(
					'user_properties',
					[ 'up_property', 'up_value' ],
					array( 'up_user' => $user->getId() ),
					$fname
				);

				foreach ( $res as $row ) {
					$dbw->insert(
						'user_properties',
						[
							'up_user'     => $extUser->mId,
							'up_property' => $row->up_property,
							'up_value'    => $row->up_value,
						],
						$fname
					);
				}

				// mark migrated accounts
				$dbw->insert(
					'user_properties',
					[
						'up_user'     => $extUser->mId,
						'up_property' => 'uncyclo_user',
						'up_value'    => $user->getId(),
					],
					$fname
				);
			}
			else {
				// fake the new user ID to perform the users ID remap procedure
				$extUser->mId = $user->getId() + 500000; // move user IDs by 500k (see --do-not-touch-global-users option)
				wfDebug( __METHOD__ . " - faking new user ID - #{$extUser->mId}\n" );
			}

			// we have a new ID for a global account
			// update user ID in uncyclo database
			$this->doChangeUncycloUserId( $user, $extUser->mId );

			// invalidate user cache
			global $wgMemc;
			$wgMemc->delete( wfMemcKey( 'user', 'id', $user->getId() ) );
			$wgMemc->delete( wfMemcKey( 'user', 'id', $extUser->mId ) );

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
		$this->output( sprintf( "%d: %s <%s>", $user->getId(), $user->getName(), $user->mEmail ?: 'MISSING_EMAIL' ) );

		$then = microtime( true );

		// keep data that will be saved to CSV file
		$action = false;
		$userName = $user->getName();
		$isMerged = false;

		// check if the uncyclo account has a valid email set
		$isValidEmail = Sanitizer::validateEmail( $user->mEmail );
		$uncycloEdits = (int) $user->getEditCount();
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
		$globalEdits = null;

		if ( $globalUser instanceof User ) {
			// HACK: calling getEmail() on global user will trigger a SQL query on uncyclo database
			$this->output( sprintf( ' - conflicts with the global user #%d <%s>', $globalUser->getId(), $globalUser->mEmail ?: 'MISSING_EMAIL' ) );

			$globalEdits  = (int) $globalUser->getEditCount();

			// global and shared DB accounts match
			if ( $isValidEmail && strtolower( $globalUser->mEmail ) === strtolower( $user->mEmail ) ) {
				$this->output( ' - emails match' );
				$this->output( "\n\tmerging accounts..." );

				$this->mergedAccounts++;

				$isMerged = true;
				$action = 'merge accounts';

				$this->doChangeUncycloUserId( $user, $globalUser->getId() );
			}
			else {
				// resolve conflicts
				$this->output( "\n\tresolving account conflicts..." );
				$this->output( sprintf(" uncyclo edits: %d / global edits: %d\n\t", $uncycloEdits, $globalEdits ) );

				/**
				Sannse says:
				No edits on either wikia = rename Uncyclopedia account
				No edits on Wikia/edits on Uncyclopedia = rename Wikia account
				< 1000 edits on Uncyclopedia = rename Uncyclopedia account
				> 1000 edits on Uncyclopedia = rename account with least edits
				 **/
				if ( $uncycloEdits === 0 && $globalEdits === 0 ) {
					$user = $this->doRenameUncycloUser( $user );
					$action = 'rename uncyclo account [no edits on either wikia]';
				}
				elseif ( $uncycloEdits > 0 && $globalEdits === 0 ) {
					$this->doRenameGlobalUser( $globalUser );
					$action = 'rename wikia account [uncyclo edits, no global edits]';
				}
				elseif ( $uncycloEdits < 1000 ) {
					$user = $this->doRenameUncycloUser( $user );
					$action = 'rename uncyclo account [uncyclo edits < 1k]';
				}
				else {
					// rename the one with the least edits
					if ( $uncycloEdits > $globalEdits ) {
						$this->doRenameGlobalUser( $globalUser );
						$action = 'rename wikia account [more uncyclo edits than global ones]';
					}
					else {
						$user = $this->doRenameUncycloUser( $user );
						$action = 'rename uncyclo account [less uncyclo edits than global ones]';
					}
				}

				// now create a shared account using the "local" uncyclo user object
				$this->doCreateGlobalUser( $user );
			}
		}
		else {
			// there's no accounts conflict - create a shared account and update the uncyclopedia user_id entries
			$this->createdAccounts++;

			$action = 'create a global account';

			// now create a shared account using the "local" uncyclo user object
			$this->doCreateGlobalUser( $user );
		}

		// add an entry to CSV file
		if ( is_resource( $this->csv ) ) {
			fputcsv( $this->csv, [
				$user->getId(),
				$userName,
				$user->getName(),
				$user->mEmail,
				$isValidEmail ? 'Y' : 'N',
				$globalUser ? $globalUser->mEmail : 'none',
				$isMerged ? 'Y' : 'N',
				$uncycloEdits,
				$uncycloEditsSince,
				is_int( $globalEdits ) ? $globalEdits : 'none',
				$action
			] );
		}

		$this->info( __METHOD__, [
			'took'      => microtime( true ) - $then,
			'user_id'   => $user->getId(),
			'user_name' => $userName,
			'action'    => $action
		] );

		$this->output( "\n" );
	}

	/**
	 * Set database to read-only mode when running in dry-run mode
	 */
	protected function dryRunMode() {
		global $wgReadOnly, $wgDBReadOnly;
		$this->output("Running in dry-run mode, forcing read-only mode\n");

		$wgReadOnly = $this->getName() . ' executed in dry-run mode';
		$wgDBReadOnly = true;

		wfDebug( $wgReadOnly . "\n" );
	}

	/**
	 * Script entry point
	 */
	public function execute() {
		global $wgUser;
		$wgUser = $this->getGlobalUserByName( 'WikiaBot' );

		// do not use ulimit4 when calling wfShellExec()
		global $wgMaxShellTime;
		$wgMaxShellTime = 0;

		// read options
		$this->isDryRun = $this->hasOption( 'dry-run' ) || !$this->hasOption( 'force' );
		$this->onlyRenameGlobalUsers = $this->hasOption( 'only-rename-global-users' );

		if ( $this->isDryRun ) {
			$this->dryRunMode();
		}
		else {
			// disable read-only mode for this script to work
			// even if disabled via WikiFactory
			global $wgReadOnly, $wgDBReadOnly;
			$wgReadOnly = null;
			$wgDBReadOnly = false;
		}

		// allow cluster to be forced via --cluster option
		if ( $forceCluster = $this->getOption( 'cluster' ) ) {
			global $wgDBcluster;
			$wgDBcluster = $forceCluster;
		}

		// setup the CSV header
		if ( $this->hasOption( 'csv' ) ) {
			$this->csv = fopen( $this->getOption( 'csv' ), 'w' );

			fputcsv( $this->csv, [
				'User ID',
				'User Name',
				'New user name',
				'Email',
				'Valid email',
				'Shared email',
				'Merge?',
				'Uncyclo edits',
				'Uncyclo edits after Jan 2014',
				'Global edits',
				'Action'
			] );

			$this->output( sprintf( "Will generate CSV file - <%s>...\n", $this->getOption( 'csv' ) ) );
		}

		global $wgDBname, $wgDBcluster;
		$this->output( "Working on {$wgDBname} database (cluster {$wgDBcluster}, master {$this->getUncycloDB(DB_MASTER)->getServer()}, slave {$this->getUncycloDB(DB_SLAVE)->getServer()})\n" );

		// get all uncyclopedia accounts
		$conds = [];

		$from_id = intval( $this->getOption( 'from' ) );
		$to_id   = intval( $this->getOption( 'to' ) );

		if ( $from_id ) $conds[] = 'user_id >= ' . $from_id;
		if ( $to_id )   $conds[] = 'user_id <= ' . $to_id;

		$this->output( "Preparing the list of accounts to migrate... conds = " . json_encode( $conds ) );
		$res = $this->getUncycloDB()->select(
			self::USER_TABLE,
			'*',
			$conds,
			__METHOD__
		);

		$this->output( sprintf( "\nMigrating %d accounts...\n", $res->numRows() ) );
		$this->output( "Will start in 5 seconds...\n" );
		sleep(5);

		// close the current transaction (if any)
		$dbw = $this->getUncycloDB( DB_MASTER );
		$dbw->commit( __METHOD__ );

		$i = 0;

		while( $row = $res->fetchObject() ) {
			$i++;
			$user = User::newFromRow((object)$row);

			try {
				$dbw->begin( __METHOD__ );
				$this->migrateUser( $user );
				$dbw->commit( __METHOD__ );
			}
			catch ( Exception $e ) {
				$dbw->rollback( __METHOD__ );

				$this->output( sprintf( "\n%s: %s\n", get_class( $e ), $e->getMessage() ) );
				$this->output( $e->getTraceAsString() );
				$this->err( __METHOD__ , [
					'exception' => $e,
					'user_id' => $user->getId(),
					'user_name' => $user->getName(),
				] );
			}

			if ( !$this->isDryRun ) {
				if ( $i % 25 === 0 ) {
					wfWaitForSlaves();
				}
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
