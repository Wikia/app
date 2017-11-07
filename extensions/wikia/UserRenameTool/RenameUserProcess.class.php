<?php

class RenameUserProcess {
	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_STANDARD = 'standard';
	const LOG_BATCH_TASK = 'task';
	const LOG_OUTPUT = 'output';

	/**
	 * Stores the predefined tasks to do for every local wiki database.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * @var $mLocalDefaults array
	 */
	static private $mLocalDefaults = array(
		# Core MW tables
		array( 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ),
		array( 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ),
		array( 'table' => 'image', 'userid_column' => 'img_user', 'username_column' => 'img_user_text' ),
		array( 'table' => 'ipblocks', 'userid_column' => 'ipb_by', 'username_column' => 'ipb_by_text' ),
		array( 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ),
		array( 'table' => 'logging', 'userid_column' => null, 'username_column' => 'log_title',
			'conds' => array(
				'log_namespace' => NS_USER,
			) ),
		array( 'table' => 'oldimage', 'userid_column' => 'oi_user', 'username_column' => 'oi_user_text' ),
		array( 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ),
		array( 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ),
		# disable in 1.19 array( 'table' => 'text', 'userid_column' => 'old_user', 'username_column' => 'old_user_text' ),
		array( 'table' => 'user_newtalk', 'userid_column' => null, 'username_column' => 'user_ip' ),
		# Core 1.16 tables
		array( 'table' => 'logging', 'userid_column' => 'log_user', 'username_column' => 'log_user_text' ),

		# Template entry
//		array( 'table' => '...', 'userid_column' => '...', 'username_column' => '...' ),
	);

	/**
	 * Stores the predefined tasks to do for every local wiki database for IP addresses.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * @var $mLocalIpDefaults array
	 */
	static private $mLocalIpDefaults = [
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ],
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

	private $mErrors = array();
	private $mWarnings = array();

	private $mInternalLog = '';

	private $mLogDestinations = array(
		array( self::LOG_STANDARD, null ),
	);
	/**
	 *
	 * @var BatchTask
	 */
	private $mLogTask = null;

	/**
	 * @var string
	 */
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

		$this->addInternalLog( "construct: old={$oldUsername} new={$newUsername}" );
	}

	public function getRequestData() {
		return $this->mRequestData;
	}

	public function getOldUsername() {
		return $this->mOldUsername;
	}

	public function getNewUsername() {
		return $this->mNewUsername;
	}

	public function getReason() {
		return $this->mReason;
	}

	public function getOldUid() {
		return $this->mUserId;
	}

	public function getErrors() {
		return $this->mErrors;
	}

	public function getWarnings() {
		return $this->mWarnings;
	}

	public function getPhalanxBlockID() {
		return $this->mPhalanxBlockId;
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
		$this->mLogDestinations = array();
		$this->addLogDestination( $destination, $task );
	}

	/**
	 * Adds another log destination
	 *
	 * @param $destination string/enum One of RenameUserProcess::LOG_* constant
	 * @param $task BatchTask (Optional) BatchTask to send logs to
	 */
	public function addLogDestination( $destination, $task = null ) {
		$this->mLogDestinations[] = array( $destination, $task );
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
	 * @param <type> $msg
	 */
	public function addWarning( $msg ) {
		$this->mWarnings[] = $msg;
	}

	protected function getUserTableName( $database ) {
		return "`{$database}`.`user`";
	}

	protected function renameAccount() {
		global $wgExternalSharedDB;

		$dbw = wfGetDb( DB_MASTER, array(), $wgExternalSharedDB );

		$table = '`user`';
		$this->addLog( "Changing user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

		if ( $dbw->tableExists( $table ) ) {
			$dbw->update( $table,
				array( 'user_name' => $this->mNewUsername ),
				array( 'user_id' => $this->mUserId ),
				__METHOD__
			);

			$affectedRows = $dbw->affectedRows();
			$this->addLog( 'Running query: ' . $dbw->lastQuery() . " resulted in {$affectedRows} row(s) being affected." );

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

	/**
	 * Checks if the request provided to the constructor is valid.
	 *
	 * @return bool True if all prerequisites are met
	 */
	protected function setup() {
		global $wgContLang, $wgCapitalLinks;

		// Sanitize input data
		$oldNamePar = trim( str_replace( '_', ' ', $this->mRequestData->oldUsername ) );
		$oldTitle = Title::makeTitle( NS_USER, $oldNamePar );

		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );

		$oun = is_object( $oldTitle ) ? $oldTitle->getText() : '';
		$nun = is_object( $newTitle ) ? $newTitle->getText() : '';

		$this->addInternalLog( "title: old={$oun} new={$nun}" );

		// AntiSpoof test

		if ( class_exists( 'SpoofUser' ) ) {
			$oNewSpoofUser = new SpoofUser( $nun );
			$conflicts = $oNewSpoofUser->getConflicts();
			if ( !empty( $conflicts ) ) {
				$this->addWarning( wfMessage( 'userrenametool-error-antispoof-conflict', $nun ) );
			}
		} else {
			$this->addError( wfMessage( 'userrenametool-error-antispoof-notinstalled' ) );
		}

		// Phalanx test

		$warning = RenameUserHelper::testBlock( $oun );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}

		$warning = RenameUserHelper::testBlock( $nun );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}

		// Invalid old user name entered
		if ( !$oun ) {
			$this->addError( wfMessage( 'userrenametool-errorinvalid', $this->mRequestData->oldUsername )->inContentLanguage()->text() );
			return false;
		}

		// Invalid new user name entered
		if ( !$nun ) {
			$this->addError( wfMessage( 'userrenametool-errorinvalidnew', $this->mRequestData->newUsername )->inContentLanguage()->text() );
			return false;
		}

		// Old username is the same as new username
		if ( $oldTitle->getText() === $newTitle->getText() ) {
			$this->addError( wfMessage( 'userrenametool-error-same-user' )->inContentLanguage()->text() );
			return false;
		}

		// validate new username and disable validation for old username
		$oldUser = User::newFromName( $oldTitle->getText(), false );
		$newUser = User::newFromName( $newTitle->getText(), 'creatable' );

		// It won't be an object if for instance "|" is supplied as a value
		if ( !is_object( $oldUser ) ) {
			$this->addError( wfMessage( 'userrenametool-errorinvalid', $this->mRequestData->oldUsername )->inContentLanguage()->text() );
			return false;
		}

		if ( !is_object( $newUser ) || !User::isCreatableName( $newUser->getName() ) ) {
			$this->addError( wfMessage( 'userrenametool-errorinvalid', $this->mRequestData->newUsername )->inContentLanguage()->text() );
			return false;
		}

		$this->addInternalLog( "user: old={$oldUser->getName()}:{$oldUser->getId()} new={$newUser->getName()}:{$newUser->getId()}" );

		// Check for the existence of lowercase oldusername in database.
		// Until r19631 it was possible to rename a user to a name with first character as lowercase
		if ( $oldTitle->getText() !== $wgContLang->ucfirst( $oldTitle->getText() ) ) {
			// oldusername was entered as lowercase -> check for existence in table 'user'
			$dbr = WikiFactory::db( DB_SLAVE );
			$uid = $dbr->selectField( '`user`', 'user_id',
				array( 'user_name' => $oldTitle->getText() ),
				__METHOD__ );

			$this->addLog( 'Running query: ' . $dbr->lastQuery() . " resulted in " . $dbr->affectedRows() . " row(s) being affected." );

			if ( $uid === false ) {
				if ( !$wgCapitalLinks ) {
					$uid = 0; // We are on a lowercase wiki but lowercase username does not exists
				} else {
					// We are on a standard uppercase wiki, use normal
					$uid = $oldUser->idForName();
					$oldTitle = Title::makeTitleSafe( NS_USER, $oldUser->getName() );
				}
			}
		} else {
			// oldusername was entered as upperase -> standard procedure
			$uid = $oldUser->idForName();
		}

		$this->addInternalLog( "id: uid={$uid} old={$oldUser->getName()}:{$oldUser->getId()} new={$newUser->getName()}:{$newUser->getId()}" );


		// If old user name does not exist:
		if ( $uid == 0 ) {
			$this->addError( wfMessage( 'userrenametool-errordoesnotexist', $this->mRequestData->oldUsername )->inContentLanguage()->text() );
			return false;
		} elseif ( $oldUser->isLocked() ) {
			$this->addError( wfMessage( 'userrenametool-errorlocked', $this->mRequestData->oldUsername )->inContentLanguage()->text() );
			return false;
		} elseif ( $oldUser->isAllowed( 'bot' ) ) {
			$this->addError( wfMessage( 'userrenametool-errorbot', $this->mRequestData->oldUsername )->inContentLanguage()->text() );
			return false;
		}

		$fakeUid = 0;

		// If new user name does exist (we have a special case - repeating rename process)
		if ( $newUser->idForName() != 0 ) {
			$repeating = false;

			// invalidate properties cache and reload to get updated data
			// needed here, if the cache is wrong bad things happen
			$this->addInternalLog( "pre-invalidate: titletext={$oldTitle->getText()} old={$oldUser->getName()}" );

			$oldUser->invalidateCache();
			$oldUser = User::newFromName( $oldTitle->getText(), false );

			$renameData = $oldUser->getGlobalAttribute( 'renameData', '' );

			$this->addInternalLog( "post-invalidate: titletext={$oldTitle->getText()} old={$oldUser->getName()}:{$oldUser->getId()}" );

			$this->addLog( "Scanning user option renameData for process data: {$renameData}" );

			if ( stripos( $renameData, self::RENAME_TAG ) !== false ) {
				$tokens = explode( ';', $renameData, 3 );

					if ( !empty( $tokens[0] ) ) {
						$nameTokens = explode( '=', $tokens[0], 2 );

						$repeating = (
							count( $nameTokens ) == 2 &&
							$nameTokens[0] === self::RENAME_TAG &&
							$nameTokens[1] === $newUser->getName()
						);
					}

					if ( !empty( $tokens[2] ) ) {
						$blockTokens = explode( '=', $tokens[2], 2 );

						if (
							count( $blockTokens ) == 2 &&
							$blockTokens[0] === self::PHALANX_BLOCK_TAG &&
							is_numeric( $blockTokens[1] )
						) {
							$this->mPhalanxBlockId = (int)$blockTokens[1];
						}
					}
			}

			if ( $repeating ) {
				$this->addWarning( wfMessage( 'userrenametool-warn-repeat', $this->mRequestData->oldUsername, $this->mRequestData->newUsername )->inContentLanguage()->text() );
				// Swap the uids because the real user ID is the new user ID in this special case
				$fakeUid = $uid;
				$uid = $newUser->idForName();
			} else {
				// In the case other than repeating the process drop an error
				$this->addError( wfMessage( 'userrenametool-errorexists', $newUser->getName() )->inContentLanguage()->text() );
				return false;
			}
		}

		// Execute Warning hook (arguments the same as in the original Renameuser extension)
		if ( !$this->mActionConfirmed ) {
			Hooks::run( 'UserRename::Warning', array( $this->mRequestData->oldUsername, $this->mRequestData->newUsername, &$this->mWarnings ) );
		}

		$this->mOldUsername = $oldUser->getName();
		$this->mNewUsername = $newUser->getName();
		$this->mUserId = (int)$uid;
		$this->mFakeUserId = $fakeUid;

		$this->addInternalLog( "setup: uid={$this->mUserId} fakeuid={$this->mFakeUserId} old={$this->mOldUsername} new={$this->mNewUsername}" );

		// If there are only warnings and user confirmed that, do not show them again
		// on success page ;-)
		if ( $this->mActionConfirmed ) {
			$this->mWarnings = array();
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
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-unexpected' )->inContentLanguage()->text() );
		}

		// Analyze status
		if ( !$status ) {
			$this->staffLog(
				'fail',
				[
					'requestor_name' => $this->mRequestorName,
					'rename_old_name' => $this->mOldUsername,
					'rename_new_name' => $this->mNewUsername,
					'reason' => $this->mReason
				],
				RenameUserLogFormatter::fail(
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
		$this->addLog( "User rename global task start." . ( ( !empty( $this->mFakeUserId ) ) ? ' Process is being repeated.' : null ) );
		$this->addLog( "Renaming user {$this->mOldUsername} (ID {$this->mUserId}) to {$this->mNewUsername}" );

		$hookName = 'RenameUser::Abort';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		// Give other affected extensions a chance to validate or abort
		if ( !Hooks::run( $hookName, array( $this->mUserId, $this->mOldUsername, $this->mNewUsername, &$this->mErrors ) ) ) {
			$this->addLog( "Aborting procedure as requested by hook." );
			$this->addError( wfMessage( 'userrenametool-error-extension-abort' )->inContentLanguage()->text() );
			return false;
		}

		// enumerate IDs for wikis the user has been active in
		$this->addLog( "Searching for user activity on wikis." );
		$wikiIDs = RenameUserHelper::lookupRegisteredUserActivity( $this->mUserId );
		$this->addLog( "Found " . count( $wikiIDs ) . " wikis: " . implode( ', ', $wikiIDs ) );

		$hookName = 'UserRename::BeforeAccountRename';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		Hooks::run( $hookName, array( $this->mUserId, $this->mOldUsername, $this->mNewUsername ) );

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

			$fakeUser->setEmail( null );
			$fakeUser->setRealName( '' );
			$fakeUser->setName( $this->mOldUsername );

			if ( $wgExternalAuthType ) {
				ExternalUser_Wikia::addUser( $fakeUser, '', '', '' );
			} else {
				$fakeUser->addToDatabase();
			}

			$fakeUser->setGlobalAttribute( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername . ';' . self::PROCESS_TAG . '=' . '1' );
			$fakeUser->setGlobalFlag( 'disabled', 1 );

			try {
				$fakeUser->setPassword( null );
			} catch ( PasswordError $e ) {
				// We don't really care if the password wasn't set at all for a fake user
				// now that we go through Helios
			}

			$fakeUser->saveSettings();
			$this->mFakeUserId = $fakeUser->getId();
			$this->addLog( "Created fake user account for {$fakeUser->getName()} with ID {$this->mFakeUserId} and renameData '{$fakeUser->getGlobalAttribute( 'renameData', '')}'" );
		} else {
			$this->addLog( "Fake user account already exists: {$this->mFakeUserId}" );
		}

		$this->invalidateUser( $this->mOldUsername );

		$callParams = array(
			'requestor_id' => $this->mRequestorId,
			'requestor_name' => $this->mRequestorName,
			'rename_user_id' => $this->mUserId,
			'rename_old_name' => $this->mOldUsername,
			'rename_new_name' => $this->mNewUsername,
			'rename_fake_user_id' => $this->mFakeUserId,
			'phalanx_block_id' => $this->mPhalanxBlockId,
			'reason' => $this->mReason
		);

		return $this->renameUser($callParams);
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
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

		// TODO: Add a hook
		$hookName = 'UserRename::Cleanup';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		Hooks::run( $hookName, array( $this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mOldUsername, $this->mNewUsername ) );

		$tasks = [];
		if ( isset( $this->mLogTask ) ) {
			$tasks[] = $this->mLogTask->getID();
		}
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
//				case self::LOG_STANDARD:
				default:
					wfDebugLog( __CLASS__, $text );
			}
		}
	}

	/**
	 * Adds log message in Special:Log for the current wiki
	 *
	 * @param $text string Log message
	 */
	public function addLocalLog( $text ) {
		$log = new LogPage( 'renameuser' );
		$log->addEntry( 'renameuser', Title::newFromText( $this->mOldUsername, NS_USER ), $text, array(), User::newFromId( $this->mRequestorId ) );
	}

	public function setRequestorUser() {
		global $wgUser;
		$oldUser = $wgUser;

		$this->addLog( "Checking for need to overwrite requestor user (id={$this->mRequestorId} name={$this->mRequestorName})" );

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

	public function getInternalLog() {
		return $this->mInternalLog;
	}

	static public function newFromData( $data ) {
		$o = new RenameUserProcess( $data['rename_old_name'], $data['rename_new_name'], '', true );

		$mapping = array(
			'mUserId' => 'rename_user_id',
			'mOldUsername' => 'rename_old_name',
			'mNewUsername' => 'rename_new_name',
			'mFakeUserId' => 'rename_fake_user_id',
			'mRequestorId' => 'requestor_id',
			'mRequestorName' => 'requestor_name',
			'mPhalanxBlockId' => 'phalanx_block_id',
			'mReason' => 'reason',
			'mLogTask' => 'local_task',
		);

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


	/**
	 * Marshal & execute the RenameUserProcess functions to rename a user
	 *
	 * @param array $params
	 *		requestor_id => ID of the user requesting this rename action
	 *		requestor_name => Name of the user requesting this rename action
	 *		rename_user_id => ID of the user to rename
	 *		rename_old_name => Current username of the user to rename
	 *		rename_new_name => New username for the user to rename
	 *		reason => Reason for requesting username change
	 *		rename_fake_user_id => Repeated rename process special case (TODO: Don't know what this is)
	 *		phalanx_block_id => Phalanx login block ID
	 * @return bool
	 */
	public function renameUser( array $params ) {
		$process = RenameUserProcess::newFromData( $params );
		$process->setLogDestination( self::LOG_STANDARD );
		$process->setRequestorUser();

		$noErrors = true;

		// ComSup wants the StaffLogger to keep track of renames...
		$this->staffLog(
			'start',
			$params,
			\RenameUserLogFormatter::start(
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason']
			)
		);

		// clean up pre-process setup
		$process->cleanup();

		// mark user as renamed
		$renamedUser = \User::newFromId( $params['rename_user_id'] );

		if ( !User::newFromId( $params['requestor_id'] )->isAllowed('renameanotheruser') ) {
			\RenameUserHelper::blockUserRenaming( $renamedUser );
			$renamedUser->saveSettings();
		}

		// send e-mail to the user that rename process has finished
		$this->notifyUser( $renamedUser, $params['rename_old_name'], $params['rename_new_name'] );
		$this->staffLog(
			$noErrors ? 'finish' : 'fail',
			$params,
			\RenameUserLogFormatter::finish(
				$params['requestor_name'],
				$params['rename_old_name'],
				$params['rename_new_name'],
				$params['reason']
			)
		);

		return $noErrors;
	}

	/**
	 * Curry the StaffLogger function
	 *
	 * @param string $action Which action to log ('start', 'complete', 'fail', 'log')
	 * @param array $params The params given to `#renameUser`
	 * @param string $text The text to log
	 */
	protected function staffLog( $action, array $params, $text ) {
		\StaffLogger::log(
			'renameuser',
			$action,
			$params['requestor_id'],
			$params['requestor_name'],
			$params['rename_user_id'],
			$params['rename_new_name'],
			$text
		);
	}

	/**
	 * Send an email to a user notifying them that a rename action completed
	 *
	 * @param User $user
	 * @param string $oldUsername
	 * @param string $newUsername
	 */
	protected function notifyUser( $user, $oldUsername, $newUsername ) {
		if ( $user->getEmail() != null ) {
			F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', [
				'targetUser' => $user,
				'oldUserName' => $oldUsername,
				'newUserName' => $newUsername
			] );
			$this->addLog( "rename user with email notification ({$oldUsername} => {$newUsername}), email: {$user->getEmail()}");
		} else {
			$this->addWarning( "no email address set for user ({$oldUsername} => {$newUsername})");
		}
	}
}
