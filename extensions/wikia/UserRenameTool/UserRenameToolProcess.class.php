<?php

class UserRenameToolProcess {

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_STANDARD = 'standard';
	const LOG_BATCH_TASK = 'task';
	const LOG_OUTPUT = 'output';

	const ACTION_FAIL = 'fail';
	const ACTION_LOG = 'log';
	const ACTION_FINISH = 'finish';

	const DB_COOL_DOWN_SECONDS = 1;

	// Define what needs changing in core MW tables
	/**
	 * Stores the predefined tasks to do for every local wiki database.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * Task definition format:
	 *   'table' => (string) table name
	 *   'userid_column' => (string) column name with user ID or null if none
	 *   'username_column' => (string) column name with user name
	 *   'conds' => (array) additional conditions for the query
	 */
	static private $mLocalDefaults = [
		# Core MW tables
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'image', 'userid_column' => 'img_user', 'username_column' => 'img_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_by', 'username_column' => 'ipb_by_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[
			'table' => 'logging',
			'userid_column' => null,
			'username_column' => 'log_title',
			'conds' => [ 'log_namespace' => NS_USER ]
		],
		[ 'table' => 'oldimage', 'userid_column' => 'oi_user', 'username_column' => 'oi_user_text' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ],
		[ 'table' => 'user_newtalk', 'userid_column' => null, 'username_column' => 'user_ip' ],

		# Core 1.16 tables
		[ 'table' => 'logging', 'userid_column' => 'log_user', 'username_column' => 'log_user_text' ],
	];

	/**
	 * Stores the predefined tasks to do for every local wiki database for IP addresses.
	 * Here should be mentioned all core tables not connected to any extension.
	 */
	static private $mLocalIpDefaults = [
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ]
	];

	private $mRequestData = null;
	private $mActionConfirmed = false;

	private $mOldUsername = '';
	private $mNewUsername = '';
	private $mUserId = 0;
	private $mFakeUserId = 0;
	private $mPhalanxBlockId = 0;
	private $mRequestorId = 0;
	private $mRequestorName = '';
	private $mReason = null;
	private $mNotifyUser;

	private $mErrors = [ ];
	private $mWarnings = [ ];

	private $mLogDestinations = [ [ self::LOG_STANDARD, null ] ];

	private $mUserRenameTaskId = null;

	/**
	 * Creates new rename user process
	 *
	 * @param string $oldUsername Old username
	 * @param string $newUsername New username
	 * @param bool $confirmed Has the user confirmed all the warnings he got?
	 * @param string $reason
	 * @param bool $notifyUser Whether to notify the renamed user
	 */
	public function __construct( $oldUsername, $newUsername, $confirmed = false, $reason = null, $notifyUser = true ) {
		global $wgUser;

		// Save original request data
		$this->mRequestData = new stdClass();
		$this->mRequestData->oldUsername = $oldUsername;
		$this->mRequestData->newUsername = $newUsername;

		$this->mActionConfirmed = $confirmed;
		$this->mReason = $reason;
		$this->mRequestorId = $wgUser ? $wgUser->getId() : 0;
		$this->mRequestorName = $wgUser ? $wgUser->getName() : '';
		$this->mNotifyUser = $notifyUser;
	}

	public function getErrors() {
		return $this->mErrors;
	}

	public function getWarnings() {
		return $this->mWarnings;
	}

	public function getUserRenameTaskId() {
		return $this->mUserRenameTaskId;
	}

	/**
	 * Sets destination for all the logs
	 *
	 * @param $destination string/enum One of RenameUserProcess::LOG_* constant
	 * @param $task BatchTask (Optional) BatchTask to send logs to
	 */
	public function setLogDestination( $destination, $task = null ) {
		$this->mLogDestinations = [ ];
		$this->addLogDestination( $destination, $task );
	}

	/**
	 * Adds another log destination
	 *
	 * @param $destination string/enum One of RenameUserProcess::LOG_* constant
	 * @param $task BatchTask (Optional) BatchTask to send logs to
	 */
	public function addLogDestination( $destination, $task = null ) {
		$this->mLogDestinations[] = [ $destination, $task ];
	}

	/**
	 * Saves passed error for future retrieval
	 *
	 * @param $msg string Error message
	 */
	public function addError( $msg ) {
		$this->mErrors[] = $msg;
	}

	/**
	 * Saves passed warning for future retrieval
	 *
	 * @param $msg string Error message
	 */
	public function addWarning( $msg ) {
		$this->mWarnings[] = $msg;
	}

	protected function renameAccount() {
		global $wgExternalSharedDB;

		$dbw = wfGetDB( DB_MASTER, [ ], $wgExternalSharedDB );

		$table = '`user`';
		$this->addInternalLog( "Changing user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

		if ( $dbw->tableExists( $table ) ) {
			$dbw->update(
				$table,
				[ 'user_name' => $this->mNewUsername ],
				[ 'user_id' => $this->mUserId ],
				__METHOD__
			);

			$affectedRows = $dbw->affectedRows();
			$this->addInternalLog(
				'Running query: ' . $dbw->lastQuery() . " resulted in {$affectedRows} row(s) being affected."
			);

			if ( $affectedRows ) {
				$dbw->commit();
				$this->addInternalLog( "Changed user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

				User::clearUserCache( $this->mUserId );

				return true;
			} else {
				$this->addInternalLog( "No changes in {$wgExternalSharedDB} for user {$this->mOldUsername}" );
			}
		} else {
			$this->addInternalLog( "Table \"{$table}\" not found in {$wgExternalSharedDB}" );
		}

		return false;
	}

	private function antiSpoofTest( $newUserName ) {
		if ( class_exists( 'SpoofUser' ) ) {
			$oNewSpoofUser = new SpoofUser( $newUserName );
			if ( !$oNewSpoofUser->isLegal() ) {
				$this->addWarning( wfMessage( 'userrenametool-error-antispoof-conflict', $newUserName ) );
			}
		} else {
			$this->addError( wfMessage( 'userrenametool-error-antispoof-notinstalled' ) );
		}
	}

	private function phalanxTest( $userName ) {
		$warning = UserRenameToolHelper::testBlock( $userName );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}
	}

	private function areUserNamesValid( $oldUserName, $newUserName ) {
gmark("oldUserName: ".$oldUserName);
		if ( empty( $oldUserName ) ) {
gmark();
			$this->addError(
				wfMessage( 'userrenametool-errorinvalid', $this->mRequestData->oldUsername )
					->inContentLanguage()
					->text()
			);
			return false;
		}

		if ( empty( $newUserName ) ) {
			$this->addError(
				wfMessage( 'userrenametool-errorinvalidnew', $this->mRequestData->newUsername )
					->inContentLanguage()
					->text()
			);
			return false;
		}

gmark();
		if ( $this->areUserNamesIdentical( $oldUserName, $newUserName ) ) {
			return false;
		}

		return true;
	}

	private function areUserNamesIdentical( $oldUserName, $newUserName ) {
		if ( $oldUserName === $newUserName ) {
			$this->addError( wfMessage( 'userrenametool-error-same-user' )->inContentLanguage()->text() );

			return true;
		}

		return false;
	}

	private function areUserObjectsValid( $oldUser, $newUser ) {
		if ( !$this->isUserObjectValid( $oldUser, 'userrenametool-errorinvalid', $this->mRequestData->oldUsername ) ) {
			return false;
		}

		if ( !$this->isUserObjectValid(
			$newUser,
			'userrenametool-errorinvalidnew',
			$this->mRequestData->newUsername,
			true
		)
		) {
			return false;
		}

		return true;
	}

	/**
	 * It won't be an object if for instance "|" is supplied as a value
	 *
	 * @param User $user
	 * @param string $errorMessageKey
	 * @param string $errorMessageValue
	 * @param bool $checkCreatability
	 *
	 * @return bool
	 */
	private function isUserObjectValid( $user, $errorMessageKey, $errorMessageValue, $checkCreatability = false ) {
		if ( !is_object( $user ) ) {
gmark();
			$this->addError( wfMessage( $errorMessageKey, $errorMessageValue )->inContentLanguage()->text() );

			return false;
		}

		if ( $checkCreatability && !User::isCreatableName( $user->getName() ) ) {
gmark();
			return false;
		}

		return true;
	}

	private function oldUserNameExists( $uid ) {
		if ( $uid == 0 ) {
			$this->addError(
				wfMessage( 'userrenametool-errordoesnotexist', $this->mRequestData->oldUsername )
					->inContentLanguage()
					->text()
			);

			return false;
		}

		return true;
	}

	/**
	 * @param user $oldUser
	 *
	 * @return bool
	 */
	private function checkOldUserPermissions( $oldUser ) {
		if ( $oldUser->isLocked() ) {
			$this->addError(
				wfMessage( 'userrenametool-errorlocked', $this->mRequestData->oldUsername )->inContentLanguage()->text()
			);

			return false;
		}

		if ( $oldUser->isAllowed( 'bot' ) ) {
			$this->addError(
				wfMessage( 'userrenametool-errorbot', $this->mRequestData->oldUsername )->inContentLanguage()->text()
			);

			return false;
		}

		return true;
	}

	/**
	 * @param string $oldUserName
	 * @param User $oldUser
	 *
	 * @return int
	 */
	private function getOldUserId( $oldUserName, $oldUser ) {
		global $wgContLang, $wgCapitalLinks;

		// Check for the existence of lowercase oldusername in database.
		// Until r19631 it was possible to rename a user to a name with first character as lowercase
		if ( $oldUserName !== $wgContLang->ucfirst( $oldUserName ) ) {
			// oldusername was entered as lowercase -> check for existence in table 'user'
			$dbr = WikiFactory::db( DB_SLAVE );
			$uid = $dbr->selectField(
				'`user`',
				'user_id',
				[ 'user_name' => $oldUserName ],
				__METHOD__
			);

			$this->addInternalLog(
				"Running query: " .
				$dbr->lastQuery() .
				" resulted in " .
				$dbr->affectedRows() .
				" row(s) being affected."
			);

			if ( $uid === false ) {
				if ( !$wgCapitalLinks ) {
					// We are on a lowercase wiki, but lowercase username does not exists
					return 0;
				} else {
					// We are on a standard uppercase wiki, use normal
					return $oldUser->idForName();
				}
			}

			return $uid;
		}

		// oldusername was entered as upperase -> standard procedure
		return $oldUser->idForName();
	}

	/**
	 * @param int $uid
	 * @param User $newUser
	 * @param User $oldUser
	 * @param Title $oldTitle
	 *
	 * @return bool
	 */
	private function doStuffIfNewUserNameAlreadyExists( $uid, $newUser, $oldUser, $oldTitle ) {
		$repeating = false;

		// invalidate properties cache and reload to get updated data
		// needed here, if the cache is wrong bad things happen
		$oldUser->invalidateCache();
		$oldUser = User::newFromName( $oldTitle->getText(), false );

		$renameData = $oldUser->getGlobalAttribute( 'renameData', '' );

		$this->addInternalLog( "Scanning user option renameData for process data: {$renameData}" );

		if ( stripos( $renameData, self::RENAME_TAG ) !== false ) {
			$tokens = explode( ';', $renameData, 3 );

			if ( !empty( $tokens[0] ) ) {
				$nameTokens = explode( '=', $tokens[0], 2 );

				$repeating = ( count( $nameTokens ) == 2 &&
					$nameTokens[0] === self::RENAME_TAG &&
					$nameTokens[1] === $newUser->getName() );
			}

			if ( !empty( $tokens[2] ) ) {
				$blockTokens = explode( '=', $tokens[2], 2 );

				if ( count( $blockTokens ) == 2 &&
					$blockTokens[0] === self::PHALANX_BLOCK_TAG &&
					is_numeric( $blockTokens[1] )
				) {
					$this->mPhalanxBlockId = (int) $blockTokens[1];
				}
			}
		}

		if ( $repeating ) {
			$this->addWarning(
				wfMessage(
					'userrenametool-warn-repeat',
					$this->mRequestData->oldUsername,
					$this->mRequestData->newUsername
				)->inContentLanguage()->text()
			);
			// Swap the uids because the real user ID is the new user ID in this special case
			$fakeUid = $uid;
			$uid = $newUser->idForName();
		} else {
			// In the case other than repeating the process drop an error
			$this->addError(
				wfMessage( 'userrenametool-errorexists', $newUser->getName() )->inContentLanguage()->text()
			);

			return false;
		}

		return [ $oldUser, $uid, $fakeUid ];
	}

	/**
	 * Checks if the request provided to the constructor is valid.
	 *
	 * @return bool True if all prerequisites are met
	 */
	protected function setup() {
		global $wgContLang;

		// Sanitize input data
		$oldTitle = Title::makeTitle( NS_USER, trim( str_replace( '_', ' ', $this->mRequestData->oldUsername ) ) );
gbug("OLD TITLE: ".$oldTitle->getText());
		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );

		$oldUserName = is_object( $oldTitle ) ? $oldTitle->getText() : '';
		$newUserName = is_object( $newTitle ) ? $newTitle->getText() : '';
gmark("oldUserName: ".$oldUserName);
		$this->antiSpoofTest( $newUserName );
		$this->phalanxTest( $oldUserName );
		$this->phalanxTest( $newUserName );
gmark("oldUserName: ".$oldUserName);
		if ( !$this->areUserNamesValid( $oldUserName, $newUserName ) ) {
			return false;
		}

		// validate new username and disable validation for old username
		$oldUser = User::newFromName( $oldUserName, false );
		$newUser = User::newFromName( $newUserName, 'creatable' );

		if ( !$this->areUserObjectsValid( $oldUser, $newUser ) ) {
			return false;
		}

		$uid = $this->getOldUserId( $oldUserName, $oldUser );
		$oldTitle = Title::makeTitleSafe( NS_USER, $oldUser->getName() );

		if ( !$this->oldUserNameExists( $uid ) ) {
			return false;
		};

		if ( !$this->checkOldUserPermissions( $oldUser ) ) {
			return false;
		}

		$fakeUid = 0;

		// If new user name does exist (we have a special case - repeating rename process)
		if ( $newUser->idForName() != 0 ) {
			$newUserNameAlreadyExistsOut = $this->doStuffIfNewUserNameAlreadyExists(
				$uid,
				$newUser,
				$oldUser,
				$oldTitle
			);

			if ( !empty( $newUserNameAlreadyExistsOut ) ) {
				list( $oldUser, $uid, $fakeUid ) = $newUserNameAlreadyExistsOut;
			}
		}

		// Execute Warning hook (arguments the same as in the original Renameuser extension)
		if ( !$this->mActionConfirmed ) {
			wfRunHooks(
				'UserRename::Warning',
				[ $this->mRequestData->oldUsername, $this->mRequestData->newUsername, &$this->mWarnings ]
			);
		}

		$this->mOldUsername = $oldUser->getName();
		$this->mNewUsername = $newUser->getName();
		$this->mUserId = (int) $uid;
		$this->mFakeUserId = $fakeUid;

		// If there are only warnings and user confirmed that, do not show them again
		// on success page ;-)
		if ( $this->mActionConfirmed ) {
			$this->mWarnings = [ ];
		} elseif ( count( $this->mWarnings ) ) {
			// in case action is not confirmed and there are warnings display them and wait for confirmation before running the process
			return false;
		}

		return empty( $this->mErrors );
	}

	/**
	 * Runs the whole rename process, schedules background jobs/tasks if needed.
	 *
	 * @return bool True if the process succeded
	 */
	public function run() {
		// Make sure the process will not be stopped in the middle
		set_time_limit( 3600 ); // 1h
		ignore_user_abort( true );
		ini_set( "max_execution_time", 3600 ); // 1h

		if ( !$this->setup() ) {
			return false;
		}

		// Execute the worker
		$status = false;

		try {
			$status = $this->renameUser();
		} catch ( Exception $e ) {
			$this->addInternalLog( $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine() );
			$this->addError(
				wfMessage( 'userrenametool-error-cannot-rename-unexpected' )->inContentLanguage()->text()
			);
		}

		if ( !$status ) {
			$this->logFailToStaff();
		}

		return $status;
	}

	/**
	 * Do the whole dirty job of renaming user
	 *
	 * @return bool True if the process succeded
	 */
	private function renameUser() {
		$this->addInternalLog( "User rename global task start." );
		if ( !empty( $this->mFakeUserId ) ) {
			$this->addInternalLog(' Process is being repeated.');
		};
		$this->addInternalLog( "Renaming user {$this->mOldUsername} (ID {$this->mUserId}) to {$this->mNewUsername}" );

		// enumerate IDs for wikis the user has been active in
		$this->addInternalLog( "Searching for user activity on wikis." );
		$wikiIDs = UserRenameToolHelper::lookupRegisteredUserActivity( $this->mUserId );
		$this->addInternalLog( "Found " . count( $wikiIDs ) . " wikis: " . implode( ', ', $wikiIDs ) );

		// delete the record from all the secondary clusters
		if ( class_exists( 'ExternalUser_Wikia' ) ) {
			ExternalUser_Wikia::removeFromSecondaryClusters( $this->mUserId );
		}

		// rename the user on the shared cluster
		if ( !$this->renameAccount() ) {
			$this->addInternalLog( "Failed to rename the user on the primary cluster. Report the problem to the engineers." );
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-account' )->inContentLanguage()->text() );

			return false;
		}

		$this->invalidateUser( $this->mNewUsername );

		// Create a dummy account under the old username
		$this->initializeFakeUser();

		$this->invalidateUser( $this->mOldUsername );

		$this->updateGlobalTables();

		$this->runLocalRenameTask( $wikiIDs );

		return true;
	}

	/**
	 * Starts a task that runs a shell script for each wiki ID given in $wikiIds.  This script
	 * performs the re-attribution tasks (among others) needed to rename the user everywhere.
	 *
	 * @param $wikiIds
	 */
	protected function runLocalRenameTask( $wikiIds ) {
		$callParams = [
			'requestor_id' => $this->mRequestorId,
			'requestor_name' => $this->mRequestorName,
			'rename_user_id' => $this->mUserId,
			'rename_old_name' => $this->mOldUsername,
			'rename_new_name' => $this->mNewUsername,
			'rename_fake_user_id' => $this->mFakeUserId,
			'phalanx_block_id' => $this->mPhalanxBlockId,
			'reason' => $this->mReason,
			'notify_renamed' => $this->mNotifyUser,
		];
		$task = ( new UserRenameToolTask() )->setPriority( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->execute( 'renameUser', [ $wikiIds, $callParams ] );
//		$task->call( 'renameUser', $wikiIds, $callParams );
//		$this->mUserRenameTaskId = $task->queue();
	}

	/**
	 * Create the fake user if it doesn't already exist.
	 *
	 * @return bool
	 * @throws PasswordError
	 */
	protected function initializeFakeUser() {
		$this->addInternalLog( "Creating fake user account" );

		if ( !empty( $this->mFakeUserId ) ) {
			$this->addInternalLog( "Fake user account already exists: {$this->mFakeUserId}" );
			return true;
		}

		$fakeUser = $this->createFakeUser();
		if ( empty( $fakeUser ) ) {
			return false;
		}

		$this->mFakeUserId = $fakeUser->getId();

		$this->addInternalLog( sprintf(
			"Created fake user account for %s with ID %s and renameData '%s'",
			$fakeUser->getName(),
			$this->mFakeUserId,
			$fakeUser->getGlobalAttribute( 'renameData', '')
		) );

		return true;
	}

	/**
	 * Creates a fake user with the old username.  This prevents anyone from registering with this
	 * username during the rename process.
	 *
	 * We keep this fake user around after as a record of this rename. Also, we keep it for the
	 * chance that the rename process dies and we need to restart it.  In all cases we want to
	 * keep history clean and not let a new user start using the old username.
	 *
	 * @return null|User
	 * @throws PasswordError
	 */
	protected function createFakeUser() {
		$fakeUser = User::newFromName( $this->mOldUsername, 'creatable' );

		if ( !is_object( $fakeUser ) ) {
			$this->addInternalLog( "Cannot create fake user: {$this->mOldUsername}" );
			return null;
		}

		$fakeUser->setPassword( null );
		$fakeUser->setEmail( null );
		$fakeUser->setRealName( '' );
		$fakeUser->setName( $this->mOldUsername );

		if ( F::app()->wg->ExternalAuthType ) {
			ExternalUser_Wikia::addUser( $fakeUser, '', '', '' );
		} else {
			$fakeUser->addToDatabase();
		}

		$data = self::RENAME_TAG . '=' . $this->mNewUsername . ';' . self::PROCESS_TAG . '=' . '1';
		$fakeUser->setGlobalAttribute( 'renameData', $data );
		$fakeUser->setGlobalFlag( 'disabled', 1 );
		$fakeUser->saveSettings();

		return $fakeUser;
	}

	/**
	 * Processes shared database (wikicities) and makes all needed changes
	 */
	public function updateGlobalTables() {
		// wikicities
		$this->addInternalLog( "Updating global shared database: wikicities." );
		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->begin();
		$tasks = [ ];

		$hookName = 'UserRename::Global';
		$this->addInternalLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks ] );

		foreach ( $tasks as $task ) {
			$this->addInternalLog( "Updating {$task['table']}.{$task['username_column']}." );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

		$hookName = 'UserRename::AfterGlobal';
		$this->addInternalLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks ] );

		$dbw->commit();
		$this->addInternalLog( "Finished updating shared database: wikicities." );
	}

	/**
	 * Processes specific local wiki database and makes all needed changes
	 *
	 * Important: should only be run within maintenance script (bound to specified wiki)
	 *
	 * @throws DBError
	 */
	public function updateLocal() {
		global $wgCityId, $wgUser;

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( 'Wikia' );

		$cityDb = WikiFactory::IDtoDB( $wgCityId );
		$this->addInternalLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		$tasks = self::$mLocalDefaults;

		$hookName = 'UserRename::Local';
		$this->addInternalLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		$this->moveUserPages( $dbw, $cityDb );
		$this->performTableUpdateTasks( $cityDb, $dbw );
		$this->resetEditCountWiki();

		$dbw->commit();

		// Save entry in local Special:Log
		$this->addLocalLog(
			wfMessage( 'userrenametool-success', $this->mOldUsername, $this->mNewUsername )
				->inContentLanguage()
				->text()
		);

		$this->addInternalLog( "Finished updating wiki database: {$cityDb}" );
		$this->logMessagesToStaff();

		$this->invalidateUser( $this->mOldUsername );
		$this->invalidateUser( $this->mNewUsername );

		$wgUser = $wgOldUser;
	}

	protected function moveUserPages( DatabaseBase $dbw, $cityDb ) {
		$this->addInternalLog( "Moving user pages." );

		try {
			$oldTitle = Title::makeTitle( NS_USER, $this->mOldUsername );
			$newTitle = Title::makeTitle( NS_USER, $this->mNewUsername );

			$pages = $this->getUserPages( $oldTitle, $dbw );

			while ( $row = $dbw->fetchObject( $pages ) ) {
				$this->moveUserPage( $row, $cityDb, $oldTitle, $newTitle );
			}
			$dbw->freeResult( $pages );
		} catch ( DBError $e ) {
			// re-throw DB related exceptions instead of silently ignoring them (@see PLATFORM-775)
			throw $e;
		} catch ( Exception $e ) {
			$this->addInternalLog( "Exception while moving pages: " . $e->getMessage() .
				" in " . $e->getFile() . " at line " . $e->getLine() );
		}
	}

	/**
	 * Updates a list of tables in the local wiki to have the new username
	 *
	 * @param int $cityDb
	 * @param DatabaseBase $dbw
	 */
	protected function performTableUpdateTasks( $cityDb, $dbw ) {
		$tasks = self::$mLocalDefaults;

		foreach ( $tasks as $task ) {
			$this->addInternalLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

	}

	/**
	 * Move the user page to the new username.
	 *
	 * @param Object $row
	 * @param int $cityDb
	 * @param Title $oldTitle
	 * @param Title $newTitle
	 */
	protected function moveUserPage( $row, $cityDb, Title $oldTitle, Title $newTitle ) {
		$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
		$updatedPageTitle = preg_replace( '!^[^/]+!', $newTitle->getDBkey(), $row->page_title );
		$newPage = Title::makeTitleSafe( $row->page_namespace, $updatedPageTitle );

		if ( !$this->canMoveUserPage( $cityDb, $newPage, $oldPage ) ) {
			return;
		}

		$this->addInternalLog( sprintf(
			"Moving page %s in namespace %s to %s",
			$oldPage->getText(),
			$row->page_namespace,
			$newTitle->getText()
		) );
		$success = $oldPage->moveTo(
			$newPage,
			false,
			wfMessage( 'userrenametool-move-log', $oldTitle->getText(), $newTitle->getText() )
				->inContentLanguage()
				->text()
		);

		if ( $success === true ) {
			$this->addInternalLog( sprintf(
				'Updating wiki "%s": User page %s moved to %s',
				$cityDb, $oldPage->getText(), $newPage->getText()
			) );
		} else {
			$this->addInternalLog( sprintf(
				'Updating wiki "%s": User page %s could not be moved to %s',
				$cityDb, $oldPage->getText(), $newPage->getText()
			) );
			$this->addWarning(
				wfMessage( 'userrenametool-page-unmoved', [ $oldPage->getText(), $newPage->getText() ] )
					->inContentLanguage()
					->text()
			);
		}
	}

	/**
	 * Test whether we can move the user page
	 *
	 * @param int $cityDb
	 * @param Title $newPage
	 * @param Title $oldPage
	 *
	 * @return bool
	 */
	protected function canMoveUserPage( $cityDb, Title $newPage, Title $oldPage ) {
		// Do not autodelete or anything, title must not exist
		// Info: The other case is when renaming is repeated - no action should be taken
		if ( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) ) {
			$this->addInternalLog( sprintf(
				'Updating wiki "%s": User page %s already exists, moving cancelled.',
				$cityDb, $newPage->getText()
			) );
			$this->addWarning(
				wfMessage( 'userrenametool-page-exists', $newPage->getText() )->inContentLanguage()->text()
			);
			return false;
		}

		return true;
	}

	/**
	 * Checks which namespaces where user content is found are enabled on the current wiki
	 *
	 * @return array
	 */
	protected function findAllowedUserNamespaces() {
		// Determine all namespaces which need processing
		$allowedNamespaces = [ NS_USER, NS_USER_TALK ];

		// Blogs extension
		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$allowedNamespaces = array_merge( $allowedNamespaces, [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ] );
		}

		// NY User profile
		if ( defined( 'NS_USER_WIKI' ) ) {
			$allowedNamespaces = array_merge(
				$allowedNamespaces,
				[
					NS_USER_WIKI,
					201 // NS_USER_WIKI_TALK
				]
			);
		}

		if ( defined( 'NS_USER_WALL' ) ) {
			$allowedNamespaces = array_merge(
				$allowedNamespaces,
				[ NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING ]
			);
		}

		return $allowedNamespaces;
	}

	/**
	 * Builds a query using the old user page title to get the user page plus all child pages.
	 * The query looks something like:
	 *
	 *   SELECT page_namespace, page_title
	 *   FROM page
	 *   WHERE page_namespace IN ('2','3','1200','1201','1202')
	 *     AND (page_title LIKE 'SomeUserName/%' OR page_title = 'SomeUserName')
	 *
	 * The namespaces used come from self::findAllowedUserNamespaces.
	 *
	 * @param Title $oldTitle
	 * @param DatabaseBase $dbw
	 * @return ResultWrapper
	 */
	protected function getUserPages( Title $oldTitle, DatabaseBase $dbw) {
		// Determine all namespaces which need processing
		$allowedNamespaces = $this->findAllowedUserNamespaces();

		$oldKey = $oldTitle->getDBkey();
		$like = $dbw->buildLike( sprintf( "%s/", $oldKey ), $dbw->anyString() );
		$pages = $dbw->select(
			'page',
			[ 'page_namespace', 'page_title' ],
			[
				'page_namespace' => $allowedNamespaces,
				'(page_title ' . $like . ' OR page_title = ' . $dbw->addQuotes( $oldKey ) . ')'
			],
			__METHOD__
		);
		$this->addInternalLog( "SQL: " . $dbw->lastQuery() );

		return $pages;
	}

	/**
	 * Processes specific local wiki database and makes all needed changes for an IP address
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocalIP() {
		global $wgCityId, $wgUser;

		if ( !$this->isValidIP() ) {
			$this->addError( wfMessage( 'userrenametool-error-invalid-ip' )->escaped() );
			return;
		}

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( 'Wikia' );

		$cityDb = WikiFactory::IDtoDB( $wgCityId );
		$this->addInternalLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$tasks = self::$mLocalIpDefaults;

		$hookName = 'UserRename::LocalIP';
		$this->addInternalLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		foreach ( $tasks as $task ) {
			$this->addInternalLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

		$dbw->commit();

		$this->addInternalLog( "Finished updating wiki database: {$cityDb}" );

		$this->logMessagesToStaff();

		$wgUser = $wgOldUser;
	}

	/**
	 * Test whether this is an anonymous user and that the IP addresses used
	 * for this anonymous user's username are valid.
	 *
	 * @return bool
	 */
	protected function isValidIP() {
		return (
			$this->mUserId == 0 &&
			IP::isIPAddress( $this->mOldUsername ) &&
			IP::isIPAddress( $this->mNewUsername )
		);
	}

	/**
	 * Rename the user in the table given.
	 *
	 * @param DatabaseBase $dbw Database to operate on
	 * @param string $table Table name
	 * @param int $uid User ID
	 * @param string $oldUserName Old username
	 * @param string $newUserName New username
	 * @param array $extra Extra options (currently: userid_column, username_column, conds)
	 *
	 * @return bool
	 */
	public function renameInTable( $dbw, $table, $uid, $oldUserName, $newUserName, $extra ) {
		$dbName = $dbw->getDBname();
		$this->addInternalLog( "Processing {$dbName}.{$table}.{$extra['username_column']}." );

		try {
			if ( !$dbw->tableExists( $table ) ) {
				$this->addInternalLog( "Table \"$table\" does not exist in database {$dbName}" );
				$this->addWarning(
					wfMessage( 'userrenametool-warn-table-missing', $dbName, $table )->inContentLanguage()->text()
				);

				return false;
			}

			$values = [ $extra['username_column'] => $newUserName ];
			$conds = [ $extra['username_column'] => $oldUserName ];

			if ( !empty( $extra['userid_column'] ) ) {
				$conds[$extra['userid_column']] = $uid;
			}

			if ( !empty( $extra['conds'] ) ) {
				$conds = array_merge( $extra['conds'], $conds );
			}

			$opts = [ 'LIMIT' => self::MAX_ROWS_PER_QUERY ];

			$affectedRows = 1;

			while ( $affectedRows > 0 ) {
				$dbw->update( $table, $values, $conds, __METHOD__, $opts );
				$affectedRows = $dbw->affectedRows();
				$this->addInternalLog( "SQL: " . $dbw->lastQuery() );
				$dbw->commit();
				$this->addInternalLog(
					"In {$dbName}.{$table}.{$extra['username_column']} {$affectedRows} row(s) was(were) updated."
				);

				// Check this even though the loop condition does the same thing so that
				// we don't sleep unnecessarily
				if ( $affectedRows > 0 ) {
					sleep( self::DB_COOL_DOWN_SECONDS );
				}
			}
		} catch ( Exception $e ) {
			$this->addInternalLog( sprintf(
				"Exception in renameInTable(): %s in %s at line %",
				$e->getMessage(), $e->getFile(), $e->getLine()
			) );
		}

		$this->addInternalLog( "Finished processing {$dbName}.{$table}.{$extra['username_column']}." );

		return true;
	}

	/**
	 * Reset local editcount for renamed user and fake user
	 */
	private function resetEditCountWiki() {
		// Renamed user
		$uss = new UserStatsService( $this->mUserId );
		$uss->calculateEditCountWiki();

		// FakeUser
		if ( $this->mFakeUserId != 0 ) {
			$uss = new UserStatsService( $this->mFakeUserId );
			$uss->calculateEditCountWiki();
		} else {
			// use OldUsername if FakeUser isn't set
			$oldUser = User::newFromName( $this->mOldUsername );
			$uss = new UserStatsService( $oldUser->getId() );
			$uss->calculateEditCountWiki();
		}
	}

	/**
	 * Performs action for cleaning up temporary data at the very end of a process
	 */
	public function cleanup() {
		if ( $this->mFakeUserId ) {
			$this->addInternalLog( "Cleaning up process data in user option renameData for ID {$this->mFakeUserId}" );

			$fakeUser = User::newFromId( $this->mFakeUserId );
			$fakeUser->setGlobalAttribute( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername );
			$fakeUser->saveSettings();
			$fakeUser->saveToCache();
		}

		$hookName = 'UserRename::Cleanup';
		$this->addInternalLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mOldUsername, $this->mNewUsername ]
		);

		$this->logFinishToStaff();
	}

	/**
	 * Sends the internal log message to the specified destination
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function addInternalLog($text, $arg1 = null ) {
gmark($text);
		if ( func_num_args() > 1 ) {
			$args = func_get_args();
			$args = array_slice( $args, 1 );
			$text = vsprintf( $text, $args );
		}
		foreach ( $this->mLogDestinations as $destinationEntry ) {
			$logDestination = $destinationEntry[0];

			/** @var BatchTask $logTask */
			$logTask = $destinationEntry[1];

			switch ( $logDestination ) {
				case self::LOG_BATCH_TASK:
					$logTask->log( $text );
					break;
				case self::LOG_OUTPUT:
					echo $text . "\n";
					break;
				default:
					wfDebugLog( __CLASS__, $text );
			}
		}
	}

	/**
	 * Log any warnings or errors to the staff log
	 */
	public function logMessagesToStaff() {
		global $wgCityId;

		$this->addStaffLog(
			self::ACTION_LOG,
			UserRenameToolHelper::getLogForWiki(
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$wgCityId,
				$this->mReason,
				!empty( $this->warnings ) || !empty( $this->errors )
			)
		);
	}

	/**
	 * Log when the rename operation has failed to the staff log
	 */
	public function logFailToStaff() {
		$this->addStaffLog(
			self::ACTION_FAIL,
			UserRenameToolHelper::getLog(
				'userrenametool-info-failed',
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$this->mReason
			)
		);
	}

	/**
	 * Log when the rename operation has completed to the staff log
	 */
	public function logFinishToStaff() {
		$this->addStaffLog(
			self::ACTION_FINISH,
			UserRenameToolHelper::getLog(
				'userrenametool-info-finished',
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$this->mReason
			)
		);
	}

	/**
	 * Logs the message to main user-visible log
	 *
	 * @param string $action
	 * @param $text string Log message
	 */
	public function addStaffLog( $action, $text ) {
gmark("$action: $text");
		StaffLogger::log(
			'renameuser',
			$action,
			$this->mRequestorId,
			$this->mRequestorName,
			$this->mUserId,
			$this->mNewUsername,
			$text
		);
	}

	/**
	 * Adds log message in Special:Log for the current wiki
	 *
	 * @param $text string Log message
	 */
	public function addLocalLog( $text ) {
gmark($text);
		$log = new LogPage( 'renameuser' );
		$log->addEntry(
			'renameuser',
			Title::newFromText( $this->mOldUsername, NS_USER ),
			$text,
			[ ],
			User::newFromId( $this->mRequestorId )
		);
	}

	public function setRequestorUser() {
		global $wgUser;

		$oldUser = $wgUser;
		$this->addInternalLog(
			"Checking for need to overwrite requestor user (id={$this->mRequestorId} name={$this->mRequestorName})"
		);

		$userId = $wgUser->getId();

		if ( empty( $userId ) && !empty( $this->mRequestorId ) ) {
			$this->addInternalLog( "Checking if requestor exists" );
			$newUser = User::newFromId( $this->mRequestorId );

			if ( !empty( $newUser ) ) {
				$this->addInternalLog( "Overwriting requestor user" );
				$wgUser = $newUser;
			}
		}

		return $oldUser;
	}

	/**
	 * Clear user cache, forcing a reload from DB the next time a user object for this name is requested.
	 *
	 * @param User $user
	 */
	public function invalidateUser( $user ) {
		global $wgCityId;

		if ( is_string( $user ) ) {
			$user = User::newFromName( $user );
		}

		if ( is_object( $user ) ) {
			$userName = $user->getName();
			$this->addInternalLog( "Invalidate user data on local Wiki ($wgCityId): $userName" );
			$user->invalidateCache();
		} else {
			$this->addInternalLog( "invalidateUser() called with some strange argument type: " . gettype( $user ) );
		}
	}

	static public function newFromData( $data ) {
		$o = new UserRenameToolProcess( $data['rename_old_name'], $data['rename_new_name'], '', true );

		$mapping = [
			'mUserId' => 'rename_user_id',
			'mOldUsername' => 'rename_old_name',
			'mNewUsername' => 'rename_new_name',
			'mFakeUserId' => 'rename_fake_user_id',
			'mRequestorId' => 'requestor_id',
			'mRequestorName' => 'requestor_name',
			'mPhalanxBlockId' => 'phalanx_block_id',
			'mReason' => 'reason',
			'mRenameIP' => 'rename_ip',
		];

		foreach ( $mapping as $property => $key ) {
			if ( array_key_exists( $key, $data ) ) {
				$o->$property = $data[$key];
			}
		}

		// Quick hack to recover requestor name from its id
		if ( !empty( $o->mRequestorId ) && empty( $o->mRequestorName ) ) {
			$requestor = User::newFromId( $o->mRequestorId );
			$o->mRequestorName = $requestor->getName();
		}

		$o->addInternalLog( "newFromData(): Requestor id={$o->mRequestorId} name={$o->mRequestorName}" );

		return $o;
	}
}
