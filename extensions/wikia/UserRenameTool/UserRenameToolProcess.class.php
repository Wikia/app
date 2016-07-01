<?php

class UserRenameToolProcess {

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_STANDARD = 'standard';
	const LOG_BATCH_TASK = 'task';
	const LOG_OUTPUT = 'output';

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

	private $mInternalLog = '';
	private $mLogDestinations = [ [ self::LOG_STANDARD, null ] ];
	private $mLogTask = null;

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

		$this->addInternalLog( "construct: old={$oldUsername} new={$newUsername}" );
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

		$dbw = wfGetDb( DB_MASTER, [ ], $wgExternalSharedDB );

		$table = '`user`';
		$this->addLog( "Changing user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

		if ( $dbw->tableExists( $table ) ) {
			$dbw->update(
				$table,
				[ 'user_name' => $this->mNewUsername ],
				[ 'user_id' => $this->mUserId ],
				__METHOD__
			);

			$affectedRows = $dbw->affectedRows();
			$this->addLog(
				'Running query: ' . $dbw->lastQuery() . " resulted in {$affectedRows} row(s) being affected."
			);

			if ( $affectedRows ) {
				$dbw->commit();
				$this->addLog( "Changed user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

				User::clearUserCache( $this->mUserId );

				return true;
			} else {
				$this->addLog( "No changes in {$wgExternalSharedDB} for user {$this->mOldUsername}" );
			}
		} else {
			$this->addLog( "Table \"{$table}\" not found in {$wgExternalSharedDB}" );
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
		$warning = RenameUserHelper::testBlock( $userName );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}
	}

	private function areUserNamesValid( $oldUserName, $newUsername ) {
		if ( !$this->isUserNameNotEmpty(
			$oldUserName,
			'userrenametool-errorinvalid',
			$this->mRequestData->oldUsername
		)
		) {
			return false;
		};

		if ( !$this->isUserNameNotEmpty(
			$newUsername,
			'userrenametool-errorinvalidnew',
			$this->mRequestData->newUsername
		)
		) {
			return false;
		};

		if ( $this->areUserNamesIdentical( $oldUserName, $newUsername ) ) {
			return false;
		}

		return true;
	}

	private function isUserNameNotEmpty( $userName, $errorMessageKey, $errorMessageValue ) {
		if ( !$userName ) {
			$this->addError( wfMessage( $errorMessageKey, $errorMessageValue )->inContentLanguage()->text() );

			return false;
		}

		return true;
	}

	private function areUserNamesIdentical( $oldUserName, $newUserName ) {
		if ( $oldUserName === $newUserName ) {
			$this->addError( wfMessage( 'userrenametool-error-same-user' )->inContentLanguage()->text() );

			return false;
		}
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
			$this->addError( wfMessage( $errorMessageKey, $errorMessageValue )->inContentLanguage()->text() );

			return false;
		}

		if ( $checkCreatability && !User::isCreatableName( $user->getName() ) ) {
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

			$this->addLog(
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
		$this->addInternalLog( "pre-invalidate: titletext={$oldTitle->getText()} old={$oldUser->getName()}" );

		$oldUser->invalidateCache();
		$oldUser = User::newFromName( $oldTitle->getText(), false );

		$renameData = $oldUser->getGlobalAttribute( 'renameData', '' );

		$this->addInternalLog(
			"post-invalidate: titletext={$oldTitle->getText()} old={$oldUser->getName()}:{$oldUser->getId()}"
		);

		$this->addLog( "Scanning user option renameData for process data: {$renameData}" );

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

		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );

		$oldUserName = is_object( $oldTitle ) ? $oldTitle->getText() : '';
		$newUserName = is_object( $newTitle ) ? $newTitle->getText() : '';

		$this->addInternalLog( "title: old={$oldUserName} new={$newUserName}" );

		$this->antiSpoofTest( $newUserName );
		$this->phalanxTest( $oldUserName );
		$this->phalanxTest( $newUserName );

		if ( !$this->areUserNamesValid( $oldUserName, $newUserName ) ) {
			return false;
		}

		// validate new username and disable validation for old username
		$oldUser = User::newFromName( $oldUserName, false );
		$newUser = User::newFromName( $newUserName, 'creatable' );

		if ( !$this->areUserObjectsValid( $oldUser, $newUser ) ) {
			return false;
		}

		$this->addInternalLog(
			"user: old={$oldUser->getName()}:{$oldUser->getId()} new={$newUser->getName()}:{$newUser->getId()}"
		);

		$uid = $this->getOldUserId( $oldUserName, $oldUser );
		$oldTitle = Title::makeTitleSafe( NS_USER, $oldUser->getName() );

		$this->addInternalLog(
			"id: uid={$uid} old={$oldUser->getName()}:{$oldUser->getId()} new={$newUser->getName()}:{$newUser->getId()}"
		);

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

		$this->addInternalLog(
			"setup: uid={$this->mUserId} fakeuid={$this->mFakeUserId} old={$this->mOldUsername} new={$this->mNewUsername}"
		);

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
			$status = $this->doRun();
		} catch ( Exception $e ) {
			$this->addLog( $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine() );
			$this->addError(
				wfMessage( 'userrenametool-error-cannot-rename-unexpected' )->inContentLanguage()->text()
			);
		}

		// Analyze status
		if ( !$status ) {
			$this->addMainLog(
				'fail',
				UserRenameToolHelper::getLog(
					'userrenametool-info-failed',
					$this->mRequestorName,
					$this->mOldUsername,
					$this->mNewUsername,
					$this->mReason
				)
			);
		}

		return $status;
	}

	/**
	 * Do the whole dirty job of renaming user
	 *
	 * @return bool True if the process succeded
	 */
	private function doRun() {
		$this->addLog(
			"User rename global task start." .
			( ( !empty( $this->mFakeUserId ) ) ? ' Process is being repeated.' : null )
		);
		$this->addLog( "Renaming user {$this->mOldUsername} (ID {$this->mUserId}) to {$this->mNewUsername}" );

		$hookName = 'RenameUser::Abort';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		// Give other affected extensions a chance to validate or abort
		if ( !wfRunHooks( $hookName, [ $this->mUserId, $this->mOldUsername, $this->mNewUsername, &$this->mErrors ] ) ) {
			$this->addLog( "Aborting procedure as requested by hook." );
			$this->addError( wfMessage( 'userrenametool-error-extension-abort' )->inContentLanguage()->text() );

			return false;
		}

		// enumerate IDs for wikis the user has been active in
		$this->addLog( "Searching for user activity on wikis." );
		$wikiIDs = UserRenameToolHelper::lookupRegisteredUserActivity( $this->mUserId );
		$this->addLog( "Found " . count( $wikiIDs ) . " wikis: " . implode( ', ', $wikiIDs ) );

		$hookName = 'UserRename::BeforeAccountRename';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $this->mUserId, $this->mOldUsername, $this->mNewUsername ] );

		// delete the record from all the secondary clusters
		if ( class_exists( 'ExternalUser_Wikia' ) ) {
			ExternalUser_Wikia::removeFromSecondaryClusters( $this->mUserId );
		}

		// rename the user on the shared cluster
		if ( !$this->renameAccount() ) {
			$this->addLog( "Failed to rename the user on the primary cluster. Report the problem to the engineers." );
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-account' )->inContentLanguage()->text() );

			return false;
		}

		$this->invalidateUser( $this->mNewUsername );

		/*if not repeating the process
		create a new account storing the old username and some extra information in the realname field
		this avoids creating new accounts with the old name and let's resume/repeat the process in case is needed*/
		$this->addLog( "Creating fake user account" );

		$fakeUser = null;

		if ( empty( $this->mFakeUserId ) ) {
			global $wgExternalAuthType;

			$fakeUser = User::newFromName( $this->mOldUsername, 'creatable' );

			if ( !is_object( $fakeUser ) ) {
				$this->addLog( "Cannot create fake user: {$this->mOldUsername}" );

				return false;
			}

			$fakeUser->setPassword( null );
			$fakeUser->setEmail( null );
			$fakeUser->setRealName( '' );
			$fakeUser->setName( $this->mOldUsername );

			if ( $wgExternalAuthType ) {
				ExternalUser_Wikia::addUser( $fakeUser, '', '', '' );
			} else {
				$fakeUser->addToDatabase();
			}

			$fakeUser->setGlobalAttribute(
				'renameData',
				self::RENAME_TAG . '=' . $this->mNewUsername . ';' . self::PROCESS_TAG . '=' . '1'
			);
			$fakeUser->setGlobalFlag( 'disabled', 1 );
			$fakeUser->saveSettings();
			$this->mFakeUserId = $fakeUser->getId();
			$this->addLog(
				"Created fake user account for {$fakeUser->getName()} with ID {$this->mFakeUserId} and renameData " .
				"'{$fakeUser->getGlobalAttribute( 'renameData', '')}'"
			);
		} else {
			$this->addLog( "Fake user account already exists: {$this->mFakeUserId}" );
		}

		$this->invalidateUser( $this->mOldUsername );

		// process global tables
		$this->addLog( "Initializing update of global shared DB's." );
		$this->updateGlobal();

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
		$task = ( new UserRenameTask() )->setPriority( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->call( 'renameUser', $wikiIDs, $callParams );
		$this->mUserRenameTaskId = $task->queue();

		return true;
	}

	/**
	 * Processes shared database (wikicities) and makes all needed changes
	 */
	public function updateGlobal() {
		// wikicities
		$this->addLog( "Updating global shared database: wikicities." );
		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->begin();
		$tasks = [ ];

		$hookName = 'UserRename::Global';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks ] );

		foreach ( $tasks as $task ) {
			$this->addLog( "Updating {$task['table']}.{$task['username_column']}." );
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
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks ] );

		$dbw->commit();
		$this->addLog( "Finished updating shared database: wikicities." );
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
		$this->addLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$tasks = self::$mLocalDefaults;

		$hookName = 'UserRename::Local';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		/* Move user pages */
		$this->addLog( "Moving user pages." );

		try {
			$oldTitle = Title::makeTitle( NS_USER, $this->mOldUsername );
			$newTitle = Title::makeTitle( NS_USER, $this->mNewUsername );

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
			$this->addLog( "SQL: " . $dbw->lastQuery() );

			while ( $row = $dbw->fetchObject( $pages ) ) {
				$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
				$newPage = Title::makeTitleSafe(
					$row->page_namespace,
					preg_replace( '!^[^/]+!', $newTitle->getDBkey(), $row->page_title )
				);

				// Do not autodelete or anything, title must not exist
				// Info: The other case is when renaming is repeated - no action should be taken
				if ( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) ) {
					$this->addLog(
						"Updating wiki \"{$cityDb}\": User page " .
						$newPage->getText() .
						" already exists, moving cancelled."
					);
					$this->addWarning(
						wfMessage( 'userrenametool-page-exists', $newPage->getText() )->inContentLanguage()->text()
					);
				} else {
					$this->addLog(
						"Moving page " .
						$oldPage->getText() .
						" in namespace {$row->page_namespace} to " .
						$newTitle->getText()
					);
					$success = $oldPage->moveTo(
						$newPage,
						false,
						wfMessage( 'userrenametool-move-log', $oldTitle->getText(), $newTitle->getText() )
							->inContentLanguage()
							->text()
					);

					if ( $success === true ) {
						$this->addLog(
							"Updating wiki \"{$cityDb}\": User page " .
							$oldPage->getText() .
							" moved to " .
							$newPage->getText() .
							'.'
						);
					} else {
						$this->addLog(
							"Updating wiki \"{$cityDb}\": User page " .
							$oldPage->getText() .
							" could not be moved to " .
							$newPage->getText() .
							'.'
						);
						$this->addWarning(
							wfMessage( 'userrenametool-page-unmoved', [ $oldPage->getText(), $newPage->getText() ] )
								->inContentLanguage()
								->text()
						);
					}
				}
			}
			$dbw->freeResult( $pages );
		} catch ( DBError $e ) {
			// re-throw DB related exceptions instead of silently ignoring them (@see PLATFORM-775)
			throw $e;
		} catch ( Exception $e ) {
			$this->addLog( "Exception while moving pages: " . $e->getMessage() .
				" in " . $e->getFile() . " at line " . $e->getLine() );
		}
		/* End of move user pages */

		foreach ( $tasks as $task ) {
			$this->addLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

		/* Reset local editcount */
		$this->resetEditCountWiki();

		$hookName = 'UserRename::AfterLocal';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		$dbw->commit();

		// Save entry in local Special:Log
		// Important: assuming that run inside the maintenance script
		$this->addLocalLog(
			wfMessage( 'userrenametool-success', $this->mOldUsername, $this->mNewUsername )->inContentLanguage()->text()
		);

		$this->addLog( "Finished updating wiki database: {$cityDb}" );

		$this->addMainLog(
			"log",
			UserRenameToolHelper::getLogForWiki(
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$wgCityId,
				$this->mReason, !empty( $this->warnings ) || !empty( $this->errors )
			)
		);

		$this->addLog( "Invalidate user data on local Wiki ({$wgCityId}): {$this->mOldUsername}" );
		$this->invalidateUser( $this->mOldUsername );

		$this->addLog( "Invalidate user data on local Wiki ({$wgCityId}): {$this->mNewUsername}" );
		$this->invalidateUser( $this->mNewUsername );

		$wgUser = $wgOldUser;
	}

	/**
	 * Processes specific local wiki database and makes all needed changes for an IP address
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocalIP() {
		global $wgCityId, $wgUser;

		if ( $this->mUserId !== 0 ||
			!IP::isIPAddress( $this->mOldUsername ) ||
			!IP::isIPAddress( $this->mNewUsername )
		) {
			$this->addError( wfMessage( 'userrenametool-error-invalid-ip' )->escaped() );

			return;
		}

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( 'Wikia' );

		$cityDb = WikiFactory::IDtoDB( $wgCityId );
		$this->addLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$tasks = self::$mLocalIpDefaults;

		$hookName = 'UserRename::LocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		foreach ( $tasks as $task ) {
			$this->addLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

		$hookName = 'UserRename::AfterLocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		$dbw->commit();

		$this->addLog( "Finished updating wiki database: {$cityDb}" );

		$this->addMainLog(
			"log",
			UserRenameToolHelper::getLogForWiki(
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$wgCityId,
				$this->mReason, !empty( $this->warnings ) || !empty( $this->errors )
			)
		);

		$wgUser = $wgOldUser;
	}

	/**
	 * Really performs a rename task specified in arguments
	 *
	 * @param DatabaseBase $dbw Database to operate on
	 * @param string $table Table name
	 * @param int $uid User ID
	 * @param string $oldusername Old username
	 * @param string $newusername New username
	 * @param array $extra Extra options (currently: userid_column, username_column, conds)
	 *
	 * @return bool
	 */
	public function renameInTable( $dbw, $table, $uid, $oldusername, $newusername, $extra ) {
		$dbName = $dbw->getDBname();
		$this->addLog( "Processing {$dbName}.{$table}.{$extra['username_column']}." );

		try {
			if ( !$dbw->tableExists( $table ) ) {
				$this->addLog( "Table \"$table\" does not exist in database {$dbName}" );
				$this->addWarning(
					wfMessage( 'userrenametool-warn-table-missing', $dbName, $table )->inContentLanguage()->text()
				);

				return false;
			}

			$values = [
				$extra['username_column'] => $newusername,
			];

			$conds = [
				$extra['username_column'] => $oldusername,
			];

			if ( !empty( $extra['userid_column'] ) ) {
				$conds[$extra['userid_column']] = $uid;
			}

			if ( !empty( $extra['conds'] ) ) {
				$conds = array_merge( $extra['conds'], $conds );
			}

			$opts = [
				'LIMIT' => self::MAX_ROWS_PER_QUERY,
			];

			$affectedRows = 1;

			while ( $affectedRows > 0 ) {
				$dbw->update( $table, $values, $conds, __CLASS__ . '::' . __METHOD__, $opts );
				$affectedRows = $dbw->affectedRows();
				$this->addLog( "SQL: " . $dbw->lastQuery() );
				$dbw->commit();
				$this->addLog(
					"In {$dbName}.{$table}.{$extra['username_column']} {$affectedRows} row(s) was(were) updated."
				);
				sleep( 5 );
			}
		} catch ( Exception $e ) {
			$this->addLog(
				"Exception in renameInTable(): " .
				$e->getMessage() .
				' in ' .
				$e->getFile() .
				' at line ' .
				$e->getLine()
			);
		}

		$this->addLog( "Finished processing {$dbName}.{$table}.{$extra['username_column']}." );

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
			$this->addLog( "Cleaning up process data in user option renameData for ID {$this->mFakeUserId}" );

			$fakeUser = User::newFromId( $this->mFakeUserId );
			$fakeUser->setGlobalAttribute( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername );
			$fakeUser->saveSettings();
			$fakeUser->saveToCache();
		}

		$hookName = 'UserRename::Cleanup';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks(
			$hookName,
			[ $this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mOldUsername, $this->mNewUsername ]
		);

		$tasks = [ ];
		if ( isset( $this->mLogTask ) ) {
			$tasks[] = $this->mLogTask->getID();
		}

		$this->addMainLog(
			"finish",
			UserRenameToolHelper::getLog(
				'userrenametool-info-finished',
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$this->mReason,
				$tasks
			)
		);
	}

	/**
	 * Sends the internal log message to the specified destination
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function addLog( $text, $arg1 = null ) {
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
	 * Logs the message to main user-visible log
	 *
	 * @param string $action
	 * @param $text string Log message
	 */
	public function addMainLog( $action, $text ) {
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
		$this->addLog(
			"Checking for need to overwrite requestor user (id={$this->mRequestorId} name={$this->mRequestorName})"
		);

		$userId = $wgUser->getId();

		if ( empty( $userId ) && !empty( $this->mRequestorId ) ) {
			$this->addLog( "Checking if requestor exists" );
			$newUser = User::newFromId( $this->mRequestorId );

			if ( !empty( $newUser ) ) {
				$this->addLog( "Overwriting requestor user" );
				$wgUser = $newUser;
			}
		}

		return $oldUser;
	}

	public function invalidateUser( $user ) {
		if ( is_string( $user ) ) {
			$user = User::newFromName( $user );
		} else if ( !is_object( $user ) ) {
			$this->addLog( "invalidateUser() called with some strange argument type: " . gettype( $user ) );

			return;
		}

		if ( is_object( $user ) ) {
			$user->invalidateCache();
		}
	}

	public function addInternalLog( $text ) {
		$this->mInternalLog .= $text . "\n";
	}

	// TODO: Let's start to use this method
	public function getInternalLog() {
		return $this->mInternalLog;
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
			'mLogTask' => 'local_task',
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

		$o->addLog( "newFromData(): Requestor id={$o->mRequestorId} name={$o->mRequestorName}" );

		return $o;
	}
}
