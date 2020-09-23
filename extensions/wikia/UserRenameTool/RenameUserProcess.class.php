<?php

use Wikia\Tasks\Tasks\RenameUserPagesTask;
use Wikia\Logger\Loggable;

class RenameUserProcess {
	use Loggable;

	const EMAIL_CONTROLLER = \Email\Controller\UserNameChangeController::class;

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const USER_ALREADY_RENAMED_FLAG = 'wasRenamed';

	private $mRequestData = null;
	private $mActionConfirmed = false;
	private $mNotifyUser = true;

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

				$this->addLog( "Adding a row in replication queue" );
				$dbw->insert(
					'user_replicate_queue',
					[ 'user_id' => $this->mUserId ],
					__METHOD__,
					[ 'IGNORE' ]
				);

				$dbw->commit( __METHOD__ );
				wfWaitForSlaves( $dbw->getDBname() );

				$this->addLog( "Changed user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}" );

				$user = User::newFromId( $this->mUserId );
				$user->deleteCache();
				Hooks::run( 'UserRenamed', [ $user, $this->mOldUsername, $this->mNewUsername ] );

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
	 * Makes spoof and phalanx tests.
	 *
	 * @return mixed false if all prerequisites are met else list of errors
	 */
	public function testSpoof( $stringErrors = false) {
		global $wgContLang;
		$errors = [];

		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );

		$nun = is_object( $newTitle ) ? $newTitle->getText() : '';

		// AntiSpoof test

		if ( class_exists( 'SpoofUser' ) ) {
			$oNewSpoofUser = new SpoofUser( $nun );
			$conflicts = $oNewSpoofUser->getConflicts();
			if ( !empty( $conflicts ) ) {
				$errors[] = wfMessage( 'userrenametool-error-antispoof-conflict', $nun )->parse();
			}

			// SUS-4301 | check for emojis in user name
			if ( $oNewSpoofUser->isLegal() === false ) {
				$errors[] = wfMessage( 'userrenametool-error-antispoof-conflict', $nun )->parse();
			}
		} else {
			$errors[] = wfMessage( 'userrenametool-error-antispoof-notinstalled' )->parse();
		}

		if ( count( $errors ) > 0 && $stringErrors ) {
			$stringErr = [];
			foreach ( $errors as $err ) {
				$stringErr[] = $err;
			}
			return $stringErr;
		}
		return count( $errors ) > 0 ? $errors : false;
	}

	/**
	 * Checks if the request provided to the constructor is valid.
	 *
	 * @return bool True if all prerequisites are met
	 */
	public function setup( $selfRename = true ) {
		global $wgContLang, $wgCapitalLinks;

		// Sanitize input data
		$oldNamePar = trim( str_replace( '_', ' ', $this->mRequestData->oldUsername ) );
		$oldTitle = Title::makeTitle( NS_USER, $oldNamePar );

		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->mRequestData->newUsername ) );

		$oun = is_object( $oldTitle ) ? $oldTitle->getText() : '';
		$nun = is_object( $newTitle ) ? $newTitle->getText() : '';

		$this->addInternalLog( "title: old={$oun} new={$nun}" );

		if ( $selfRename ) {
			$errors = $this->testSpoof();
			if ( $errors ) {
				foreach ( $errors as $err ) {
					$this->addError( $err );
				}

				return false;
			}
		}

		// Phalanx test

		$err = self::testBlock( $oun );
		if ( !empty( $err ) ) {
			$this->addError( $err );
			return false;
		}

		$err = self::testBlock( $nun );
		if ( !empty( $err ) ) {
			$this->addError( $err );
			return false;
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
			$uid = (int) $dbr->selectField( '`user`', 'user_id',
				array( 'user_name' => $oldTitle->getText() ),
				__METHOD__ );

			$this->addLog( 'Running query: ' . $dbr->lastQuery() . " resulted in " . $dbr->affectedRows() . " row(s) being affected." );

			if ( empty( $uid ) && $wgCapitalLinks ) {
				// We are on a standard uppercase wiki, use normal
				$uid = User::idFromName( $oldTitle->getText() );
				$oldTitle = Title::makeTitleSafe( NS_USER, $oldUser->getName() );
			}

		} else {
			// oldusername was entered as upperase -> standard procedure
			$uid = User::idFromName( $oldTitle->getText() );
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
		if ( User::idFromName( $newTitle->getText() ) ) {
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
				$uid = User::idFromName( $newTitle->getText() );
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
	public function run( $selfRename = true ) {
		if ( !$this->setup( $selfRename ) ) {
			return false;
		}

		// ComSup wants the StaffLogger to keep track of renames...
		$this->addMainLog(
			'start',
			\RenameUserLogFormatter::start(
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername
			)
		);

		try {
			$noErrors = $this->doRun();
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( "Rename process failed", [
				'exception' => $e
			] );
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-unexpected' )->inContentLanguage()->text() );
			$noErrors = false;
		}

		if ( $noErrors && $this->mNotifyUser === true ) {
			$this->notifyUser( \User::newFromId( $this->mUserId ), $this->mOldUsername, $this->mNewUsername );

			if ( $this->mRequestorId !== $this->mUserId ) {
				$this->notifyUser( \User::newFromId( $this->mRequestorId ), $this->mOldUsername, $this->mNewUsername );
			}
		}
		// send e-mail to the user that rename process has finished

		$finalMessage = $noErrors ? 'finish' : 'fail';

		$this->info( 'User rename process completed: ' . $finalMessage );

		$this->addMainLog(
			$finalMessage,
			\RenameUserLogFormatter::$finalMessage(
				$this->mRequestorName,
				$this->mOldUsername,
				$this->mNewUsername,
				$this->mReason
			)
		);

		return $noErrors;
	}

	/**
	 * Do the whole dirty job of renaming user
	 *
	 * @return bool True if the process was successful
	 */
	private function doRun() {
		$this->addLog( "User rename global task start." . ( ( !empty( $this->mFakeUserId ) ) ? ' Process is being repeated.' : null ) );
		$this->addLog( "Renaming user {$this->mOldUsername} (ID {$this->mUserId}) to {$this->mNewUsername}" );

		// rename the user on the shared cluster
		if ( !$this->renameAccount() ) {
			$this->addLog( "Failed to rename the user on the primary cluster. Report the problem to the engineers." );
			$this->addError( wfMessage( 'userrenametool-error-cannot-rename-account' )->inContentLanguage()->text() );
			return false;
		}

		// SUS-3523: invalidate the destination user (by both name and ID, user name to ID
		// mapping is cached as well)
		$this->invalidateUser( User::newFromId( $this->mUserId ) );
		$this->invalidateUser( $this->mNewUsername );

		/*if not repeating the process
		create a new account storing the old username and some extra information in the realname field
		this avoids creating new accounts with the old name and let's resume/repeat the process in case is needed*/
		$this->addLog( "Creating fake user account" );

		$fakeUser = null;

		if ( empty( $this->mFakeUserId ) ) {
			$fakeUser = User::newFromName( $this->mOldUsername, 'creatable' );

			if ( !is_object( $fakeUser ) ) {
				$this->addLog( "Cannot create fake user: {$this->mOldUsername}" );
				return false;
			}

			$fakeUser->setEmail( '' );
			$fakeUser->setRealName( '' );
			$fakeUser->setName( $this->mOldUsername );
			$fakeUser->addToDatabase();

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

		// SUS-3523: invalidate the old user (by both name and ID, user name to ID
		// mapping is cached as well)
		$this->invalidateUser( User::newFromId( $this->mFakeUserId ) );
		$this->invalidateUser( $this->mOldUsername );

		if ( $this->mFakeUserId ) {
			$this->addLog( "Cleaning up process data in user option renameData for ID {$this->mFakeUserId}" );

			$fakeUser = User::newFromId( $this->mFakeUserId );
			$fakeUser->setGlobalAttribute( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername );
			$fakeUser->saveSettings();
			$fakeUser->saveToCache();
		}

		// mark user as renamed (even if a rename is performed by staff member)
		$renamedUser = User::newFromId( $this->mUserId );
		self::blockUserRenaming( $renamedUser );
		$renamedUser->saveSettings();

		// SUS-3120 Schedule background task to rename local user pages, blogs, Walls...
		$task = new RenameUserPagesTask();
		$task->call( 'renameLocalPages', $this->mOldUsername, $this->mNewUsername );

		$targetCommunityIds = RenameUserPagesTask::getTargetCommunities( $this->mOldUsername );

		if ( empty( $targetCommunityIds ) ) {
			$this->info( 'RenameUserPagesTask::getTargetCommunities - no wikis were returned' );
		}

		foreach ( $targetCommunityIds as $wikiId ) {
			$this->info( 'RenameUserPagesTask queued for wiki #' . $wikiId );

			$task->wikiId( $wikiId )->queue();
		}

		return empty( $this->getErrors() );
	}

	protected function getLoggerContext() {
		return [
			'user_rename_from' => $this->getOldUsername(),
			'user_rename_to' => $this->getNewUsername(),
		];
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

		wfDebugLog( __CLASS__, $text );

		$this->info( $text );
	}

	/**
	 * @param User|string $user
	 */
	private function invalidateUser( $user ) {
		if ( is_string( $user ) ) {
			$user = User::newFromName( $user );
		} elseif ( !is_object( $user ) ) {
			$this->addLog( "invalidateUser() called with some strange argument type: " . gettype( $user ) );
			return;
		}

		if ( is_object( $user ) ) {
			$user->invalidateCache();
		}
	}

	private function addInternalLog( $text ) {
		$this->mInternalLog .= $text . "\n";
	}

	/**
	 * Logs the message to main user-visible log
	 *
	 * @param string $action
	 * @param $text string Log message
	 */
	private function addMainLog( $action, $text ) {
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

	/**
	 * testBlock
	 *
	 * performs a test of all available phalanx filters and returns warning message if there are any
	 * @author Kamil Koterba <kamil@wikia-inc.com>
	 *
	 * @param $text String to match
	 * @return String with HTML to display via AJAX
	 */
	private static function testBlock( $text ) {
		wfProfileIn( __METHOD__ );

		if ( !class_exists( 'PhalanxServiceFactory' ) ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		$phalanxMatchParams = PhalanxMatchParams::withGlobalDefaults()->content( $text );
		$phalanxService = PhalanxServiceFactory::getServiceInstance();

		$blockFound = false;

		foreach ( Phalanx::getSupportedTypeNames() as $blockType ) {
			$phalanxMatchParams->type( $blockType );
			$res = $phalanxService->doMatch( $phalanxMatchParams );

			if ( !empty( $res ) ) {
				$blockFound = true;
				break;
			}

		}

		$warning = '';
		if ( $blockFound ) {
			$phalanxTestTitle = SpecialPage::getTitleFor( 'Phalanx', 'test' );
			$linkToTest = Linker::link( $phalanxTestTitle, wfMessage( 'userrenametool-see-list-of-blocks' )->escaped(), [], [ 'wpBlockText' => $text ] );
			$warning = wfMessage( 'userrenametool-warning-phalanx-block', $text )->rawParams( $linkToTest )->escaped();
		}

		wfProfileOut( __METHOD__ );
		return $warning;
	}

	public static function canUserChangeUsername( User $user ): bool {
		return !$user->getGlobalFlag( self::USER_ALREADY_RENAMED_FLAG, false ) || $user->isAllowed( 'renameanotheruser' );
	}

	/**
	 * Mark a user as renamed. This will prevent any further attempts to rename it.
	 *
	 * @param User $user
	 */
	private static function blockUserRenaming( User $user ) {
		$user->setGlobalFlag( self::USER_ALREADY_RENAMED_FLAG, true );
	}
}
