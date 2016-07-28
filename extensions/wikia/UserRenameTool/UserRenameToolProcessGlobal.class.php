<?php

class UserRenameToolProcessGlobal extends UserRenameToolProcess {

	const MAX_EXECUTION_TIME = 3600; // 1h

	/**
	 * Runs the whole rename process, schedules background jobs/tasks if needed.
	 *
	 * @return bool True if the process succeded
	 */
	public function run() {
		if ( !$this->setup() ) {
			return false;
		}

		// Execute the worker
		$status = false;

		try {
			$status = $this->renameUser();
		} catch ( Exception $e ) {
			$this->logInfo( "%s in %s at line %d", $e->getMessage(), $e->getFile(), $e->getLine() );
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
	 * Checks if the request provided to the constructor is valid.
	 *
	 * @return bool True if all prerequisites are met
	 */
	protected function setup() {
		$this->setExecutionLimits();

		$oldUserName = $this->getOldUserName();
		$newUserName = $this->getNewUserName();

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

		if ( $uid == 0 ) {
			$this->addUserDoesNotExistError();
			return false;
		};

		if ( !$this->checkOldUserPermissions( $oldUser ) ) {
			return false;
		}

		$this->setNamesAndIds( $uid, $newUser, $oldUser );

		// If there are only warnings and user confirmed that, do not show them again on the success page ;-)
		if ( $this->mActionConfirmed ) {
			$this->mWarnings = [];
		} elseif ( count( $this->mWarnings ) ) {
			// In case the action is not confirmed and there are warnings, display them and wait
			// for confirmation before running the process
			return false;
		}

		return empty( $this->mErrors );
	}

	/**
	 * Make sure the process will not be stopped in the middle of renaming the user
	 */
	private function setExecutionLimits() {
		set_time_limit( self::MAX_EXECUTION_TIME );
		ignore_user_abort( true );
		ini_set( "max_execution_time", self::MAX_EXECUTION_TIME );
	}

	/**
	 * Get the old username, sanitizing the username input
	 *
	 * @return String
	 */
	private function getOldUserName() {
		// Sanitize input data
		$oldTitle = Title::makeTitle( NS_USER, trim( str_replace( '_', ' ', $this->mRequestData->oldUsername ) ) );
		$oldUserName = is_object( $oldTitle ) ? $oldTitle->getText() : '';
		$this->phalanxTest( $oldUserName );

		return $oldUserName;
	}

	/**
	 * Get the new username, sanitizing the username input
	 *
	 * @return String
	 */
	private function getNewUserName() {
		global $wgContLang;

		// Force uppercase of new username, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );
		$newUserName = is_object( $newTitle ) ? $newTitle->getText() : '';
		$this->antiSpoofTest( $newUserName );
		$this->phalanxTest( $newUserName );

		return $newUserName;
	}

	private function areUserNamesValid( $oldUserName, $newUserName ) {
		if ( empty( $oldUserName ) ) {
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

		if ( $this->areUserNamesIdentical( $oldUserName, $newUserName ) ) {
			return false;
		}

		return true;
	}

	private function setNamesAndIds( $uid, User $newUser, User $oldUser ) {
		$fakeUid = 0;

		// If new user name does exist (we have a special case - repeating rename process)
		if ( $this->newUserExists( $newUser ) ) {
			$oldTitle = Title::makeTitleSafe( NS_USER, $oldUser->getName() );
			$newUserNameAlreadyExistsOut = $this->handleIfNewUserNameAlreadyExists(
				$uid,
				$newUser,
				$oldUser,
				$oldTitle
			);

			if ( !empty( $newUserNameAlreadyExistsOut ) ) {
				list( $oldUser, $uid, $fakeUid ) = $newUserNameAlreadyExistsOut;
			}
		}

		$this->mOldUsername = $oldUser->getName();
		$this->mNewUsername = $newUser->getName();
		$this->mUserId = (int) $uid;
		$this->mFakeUserId = $fakeUid;
	}

	protected function newUserExists( User $newUser ) {
		$dbr = wfGetDB( DB_SLAVE, [], F::app()->wg->ExternalSharedDB );

		$table = UserRenameToolHelper::getCentralUserTable();
		$id = $dbr->selectField(
			$table,
			'user_id',
			[ 'user_name' => $newUser->getName() ],
			__METHOD__
		);

		return !empty( $id );
	}

	/**
	 * Do the whole dirty job of renaming user
	 *
	 * @return bool True if the process succeded
	 */
	private function renameUser() {
		$this->logRenameStart();

		// Delete the record from all the secondary clusters
		if ( class_exists( 'ExternalUser_Wikia' ) ) {
			ExternalUser_Wikia::removeFromSecondaryClusters( $this->mUserId );
		}

		// rename the user on the shared cluster
		if ( !$this->renameAccount() ) {
			$this->logInfo( "Failed to rename the user on the primary cluster. Report the problem to the engineers." );
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-account' )->inContentLanguage()->text() );

			return false;
		}

		$this->invalidateUserCache( $this->mNewUsername );
		$this->invalidateUserCache( $this->mOldUsername );

		// Create a dummy account under the old username
		$this->initializeFakeUser();

		$this->updateGlobalTables();

		$this->queueMultiWikiRenameTask();

		return true;
	}

	private function logRenameStart() {
		$this->logInfo( "User rename global task start." );
		if ( !empty( $this->mFakeUserId ) ) {
			$this->logInfo(' Process is being repeated.');
		};
		$this->logInfo( "Renaming user %s (ID %d) to %s",
			$this->mOldUsername, $this->mUserId, $this->mNewUsername
		);
	}

	private function renameAccount() {
		global $wgExternalSharedDB;

		$dbw = wfGetDB( DB_MASTER, [ ], $wgExternalSharedDB );

		$this->logInfo(
			"Changing user %s to %s in %s",
			$this->mOldUsername, $this->mNewUsername, $wgExternalSharedDB
		);

		$table = UserRenameToolHelper::getCentralUserTable();
		if ( $dbw->tableExists( $table ) ) {;
			$dbw->update(
				$table,
				[ 'user_name' => $this->mNewUsername ],
				[ 'user_id' => $this->mUserId ],
				__METHOD__
			);

			$affectedRows = $dbw->affectedRows();
			$this->logInfo(
				'Running query: %s resulted in %s row(s) being affected.',
				$dbw->lastQuery(), $affectedRows
			);

			// Consider this a success if some rows were updated or if we repeating a rename,
			// in which case we probably already did this update.
			if ( $affectedRows || $this->mRepeatRename ) {
				$dbw->commit();
				$this->logInfo(
					"Changed user %s to %s in %s",
					$this->mOldUsername, $this->mNewUsername, $wgExternalSharedDB
				);

				User::clearUserCache( $this->mUserId );

				return true;
			} else {
				$this->logInfo(
					"No changes in %s for user %s",
					$wgExternalSharedDB, $this->mOldUsername
				);
			}
		} else {
			$this->logInfo( 'Table "%s" not found in %s', $table, $wgExternalSharedDB );
		}

		return false;
	}

	/**
	 * Create the fake user if it doesn't already exist.
	 *
	 * @return bool
	 * @throws PasswordError
	 */
	private function initializeFakeUser() {
		$this->logInfo( "Creating fake user account" );

		if ( !empty( $this->mFakeUserId ) ) {
			$this->logInfo( "Fake user account already exists: %d", $this->mFakeUserId );
			return true;
		}

		$fakeUser = $this->createFakeUser();
		if ( empty( $fakeUser ) ) {
			return false;
		}

		$this->mFakeUserId = $fakeUser->getId();

		$this->logInfo(
			"Created fake user account for %s with ID %s and renameData '%s'",
			$fakeUser->getName(),
			$this->mFakeUserId,
			json_encode( $this->getRenameData( $fakeUser ) )
		);

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
	private function createFakeUser() {
		$fakeUser = User::newFromName( $this->mOldUsername, 'creatable' );

		if ( !is_object( $fakeUser ) ) {
			$this->logInfo( "Cannot create fake user: %s", $this->mOldUsername );
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

		$this->setRenameData( $fakeUser, [
			self::RENAME_TAG => $this->mNewUsername,
			self::PROCESS_TAG => 1,
		] );

		$fakeUser->setGlobalFlag( 'disabled', 1 );
		$fakeUser->saveSettings();

		return $fakeUser;
	}

	/**
	 * Processes shared database (wikicities) and makes all needed changes
	 */
	private function updateGlobalTables() {
		// wikicities
		$this->logInfo( "Updating global shared database: wikicities." );
		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->begin();
		$tasks = [ ];

		$hookName = 'UserRename::Global';
		$this->logInfo( "Broadcasting hook: %s", $hookName );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks ] );

		foreach ( $tasks as $task ) {
			$this->logInfo( "Updating %s.%s", $task['table'], $task['username_column'] );
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
		$this->logInfo( "Finished updating shared database: wikicities." );
	}

	/**
	 * Starts a task that runs a shell script for each wiki ID given in $wikiIds.  This script
	 * performs the re-attribution tasks (among others) needed to rename the user everywhere.
	 */
	protected function queueMultiWikiRenameTask(  ) {
		// enumerate IDs for wikis the user has been active in
		$wikiIds = $this->lookupRegisteredUserActivity( $this->mUserId );

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
		$task = ( new UserRenameTool\Tasks\MultiWikiRename() )->setPriority( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->call( 'run', $wikiIds, $callParams );
		$this->mUserRenameTaskId = $task->queue();
	}

	private function antiSpoofTest( $newUserName ) {
		if ( class_exists( 'SpoofUser' ) ) {
			$oNewSpoofUser = new SpoofUser( $newUserName );
			if ( !$oNewSpoofUser->isLegal() ) {
				$this->addError( wfMessage( 'userrenametool-error-antispoof-conflict', $newUserName ) );
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

	/**
	 * Make sure we aren't trying to rename to the same name
	 *
	 * @param string $oldUserName
	 * @param string $newUserName
	 * @return bool
	 */
	private function areUserNamesIdentical( $oldUserName, $newUserName ) {
		if ( $oldUserName !== $newUserName ) {
			return false;
		}

		$this->addError( wfMessage( 'userrenametool-error-same-user' )->inContentLanguage()->text() );
		return true;
	}

	private function areUserObjectsValid( $oldUser, $newUser ) {
		if ( !is_object( $oldUser ) ) {
			$this->addError(
				wfMessage( 'userrenametool-errorinvalid',  $this->mRequestData->oldUsername )
					->inContentLanguage()
					->text()
			);
			return false;
		}

		if ( !is_object( $newUser ) ) {
			$this->addError(
				wfMessage( 'userrenametool-errorinvalidnew',  $this->mRequestData->newUsername )
					->inContentLanguage()
					->text()
			);
			return false;
		}

		return true;
	}

	private function addUserDoesNotExistError() {
		$this->addError(
			wfMessage( 'userrenametool-errordoesnotexist', $this->mRequestData->oldUsername )
				->inContentLanguage()
				->text()
		);
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
	 * Find the correct user ID for the old user.  This looks for users who may not have the first letter of their
	 * user name capitalized.  This became a standard some time ago but users prior to this may exist.
	 *
	 * @param string $oldUserName
	 * @param User $oldUser
	 *
	 * @return int
	 */
	private function getOldUserId( $oldUserName, $oldUser ) {
		global $wgContLang, $wgCapitalLinks;

		// Check for the existence of lowercase old username in database.
		// Until r19631 it was possible to rename a user to a name with first character as lowercase
		if ( $oldUserName == $wgContLang->ucfirst( $oldUserName ) ) {
			// old username was entered as uppercase -> standard procedure
			return $oldUser->idForName();
		}

		// old username was entered as lowercase -> check for existence in table 'user'
		$uid = $this->lookupUserIdFromName( $oldUserName );

		// We found a lowercase username.  Return that user ID
		if ( $uid !== false ) {
			return $uid;
		}

		if ( $wgCapitalLinks ) {
			// We are on a standard uppercase wiki, use normal
			return $oldUser->idForName();
		}

		// We are on a lowercase wiki, but lowercase username does not exists
		return 0;
	}

	private function lookupUserIdFromName( $name ) {
		$dbr = WikiFactory::db( DB_SLAVE );
		$uid = $dbr->selectField(
			'`user`',
			'user_id',
			[ 'user_name' => $name ],
			__METHOD__
		);

		$this->logInfo(
			"Running query: %s resulted in %s row(s) being affected.",
			$dbr->lastQuery(), $dbr->affectedRows()
		);

		return $uid;
	}

	/**
	 * @param int $uid
	 * @param User $newUser
	 * @param User $oldUser
	 * @param Title $oldTitle
	 *
	 * @return bool
	 */
	private function handleIfNewUserNameAlreadyExists( $uid, $newUser, $oldUser, $oldTitle ) {
		// Invalidate properties cache and reload to get updated data
		// needed here, if the cache is wrong bad things happen
		$oldUser->invalidateCache();
		$oldUser = User::newFromName( $oldTitle->getText(), false );

		// The information we want is attached to the old user name
		$renameData = $this->getRenameData( $oldUser );

		$this->logInfo(
			"Scanning user '%s' for renameData for process data: %s",
			$oldUser->getName(), json_encode( $renameData )
		);
		if ( !empty( $renameData->{self::RENAME_TAG} ) ) {
			$this->mRepeatRename = $renameData->{self::RENAME_TAG} == $newUser->getName();
		}

		if ( !empty( $renameData->{self::PHALANX_BLOCK_TAG} ) ) {
			$this->mPhalanxBlockId = (int) $renameData->{self::PHALANX_BLOCK_TAG};
		}

		if ( $this->mRepeatRename ) {
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
}