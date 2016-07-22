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

	protected $mRequestData = null;
	protected $mActionConfirmed = false;

	protected $mOldUsername = '';
	protected $mNewUsername = '';

	protected $mUserId = 0;
	protected $mFakeUserId = 0;
	protected $mRequestorId = 0;
	protected $mRequestorName = '';
	protected $mReason = null;
	protected $mNotifyUser;

	protected $mErrors = [ ];
	protected $mWarnings = [ ];

	private $mLogDestinations = [ [ self::LOG_STANDARD, null ] ];
	protected $mUserRenameTaskId = null;

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
	 * @param string $destination One of RenameUserProcess::LOG_* constant
	 * @param BatchTask $task (Optional) BatchTask to send logs to
	 */
	public function setLogDestination( $destination, $task = null ) {
		$this->mLogDestinations = [ ];
		$this->addLogDestination( $destination, $task );
	}

	/**
	 * Adds another log destination
	 *
	 * @param string $destination One of RenameUserProcess::LOG_* constant
	 * @param BatchTask $task (Optional) BatchTask to send logs to
	 */
	private function addLogDestination( $destination, $task = null ) {
		$this->mLogDestinations[] = [ $destination, $task ];
	}

	/**
	 * Saves passed error for future retrieval
	 *
	 * @param string $msg Error message
	 */
	protected function addError( $msg ) {
		$this->mErrors[] = $msg;
	}

	/**
	 * Saves passed warning for future retrieval
	 *
	 * @param string $msg Error message
	 */
	protected function addWarning( $msg ) {
		$this->mWarnings[] = $msg;
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

				// Make sure we don't sleep unnecessarily
				if ( $affectedRows >= self::MAX_ROWS_PER_QUERY ) {
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
	public function addInternalLog( $text, $arg1 = null ) {
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
				!empty( $this->mWarnings ) || !empty( $this->mErrors )
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
	private function addStaffLog( $action, $text ) {
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
	 * @param User|string $user
	 */
	protected function invalidateUser( $user ) {
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

	/**
	 * Finds on which wikis a REGISTERED user (see LookupContribs for anons) has been active
	 * using the events table stored in the stats DB instead of the blobs table in dataware,
	 * tests showed is faster and more accurate
	 *
	 * @param $userID int the registered user ID
	 * @return array A list of wikis' IDs related to user activity, false if the user is not an existing one or an anon
	 */
	protected function lookupRegisteredUserActivity( $userID ) {
		$wg = F::app()->wg;

		// check for invalid values
		if ( empty( $userID ) || !is_int( $userID ) ) {
			return false;
		}

		$this->addInternalLog( "Looking up registered user activity for user with ID $userID" );

		// Short circuit to some known wikis in DEV.  The rollup_edit_events table is not kept up to date in DEV
		if ( $wg->DevelEnvironment ) {
			return [
				165, // firefly
				831, // muppet
				$wg->CityId,
			];
		}

		if ( empty( $wgStatsDBEnabled ) ) {
			return [];
		}

		$wikiIds = $this->lookupWikiIdsInDb( $userID );

		$this->addInternalLog( "Found " . count( $wikiIds ) . " wikis: " . implode( ', ', $wikiIds ) );
		return $wikiIds;
	}

	/**
	 * Look for user edits in the rollup_edit_events table
	 *
	 * @param int $userId
	 *
	 * @return array
	 *
	 * @throws DBUnexpectedError
	 */
	private function lookupWikiIdsInDb( $userId ) {
		$wg = F::app()->wg;

		$dbr = wfGetDB( DB_SLAVE, array(), $wg->DWStatsDB );
		$res = $dbr->select(
			'rollup_edit_events',
			'wiki_id',
			[ 'user_id' => $userId ],
			__METHOD__,
			[ 'GROUP BY' => 'wiki_id' ]
		);

		$result = [];
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( WikiFactory::isPublic( $row->wiki_id ) ) {
				$result[] = ( int ) $row->wiki_id;
				$this->addInternalLog( "Registered user with ID $userId was active on wiki with ID {$row->wiki_id}" );
			} else {
				$this->addInternalLog( "Skipped wiki with ID {$row->wiki_id} (inactive wiki)" );
			}
		}

		$dbr->freeResult( $res );

		return $result;
	}
}
