<?php

namespace UserRenameTool\Process;

use Wikia\Logger\Loggable;

class ProcessBase {
	use Loggable;

	const FLAG_RENAME_DATA = 'renameData';
	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_WIKIA_LOGGER = 'wikia_logger';
	const LOG_OUTPUT = 'output';

	const ACTION_START = 'start';
	const ACTION_LOG = 'log';
	const ACTION_FAIL = 'fail';
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

	protected $mUserRenameTaskId = null;

	protected $mRepeatRename = false;
	protected $mPhalanxBlockId = 0;

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
		$this->mRequestData = new \stdClass();
		$this->mRequestData->oldUsername = $oldUsername;
		$this->mRequestData->newUsername = $newUsername;

		$this->mActionConfirmed = $confirmed;
		$this->mReason = $reason;
		$this->mRequestorId = $wgUser ? $wgUser->getId() : 0;
		$this->mRequestorName = $wgUser ? $wgUser->getName() : '';
		$this->mNotifyUser = $notifyUser;
	}

	/**
	 * Create a new UserRenameToolProcessLocal object from select context data.
	 *
	 * @param array $data
	 * @return ProcessBase
	 */
	public static function newFromData( $data ) {
		$o = new static( $data['rename_old_name'], $data['rename_new_name'], '', true );

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
			$requestor = \User::newFromId( $o->mRequestorId );
			$o->mRequestorName = $requestor->getName();
		}

		$o->logInfo( "newFromData(): Requestor id=%d name=%s", $o->mRequestorId, $o->mRequestorName );

		return $o;
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
	 * @param \DatabaseBase $dbw Database to operate on
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
		$this->logInfo( "Processing %s.%s.%s", $dbName, $table, $extra['username_column'] );

		try {
			if ( !$dbw->tableExists( $table ) ) {
				$this->logInfo( 'Table "%s" does not exist in database "%s"', $table, $dbName );
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
				$this->logInfo( "SQL: %s",  $dbw->lastQuery() );
				$dbw->commit();
				$this->logInfo(
					"In %s.%s.%s %d row(s) was(were) updated.",
					$dbName, $table, $extra['username_column'], $affectedRows
				);

				// Make sure we don't sleep unnecessarily
				if ( $affectedRows >= self::MAX_ROWS_PER_QUERY ) {
					sleep( self::DB_COOL_DOWN_SECONDS );
				}
			}
		} catch ( \Exception $e ) {
			$this->logInfo(
				"Exception in renameInTable(): %s in %s at line %",
				$e->getMessage(), $e->getFile(), $e->getLine()
			);
		}

		$this->logInfo( "Finished processing %s.%s.%s.", $dbName, $table, $extra['username_column'] );

		return true;
	}

	/**
	 * Retrieve the state information stored about this move in the rename data flag
	 *
	 * @param \User $user
	 *
	 * @return array|mixed
	 */
	public function getRenameData( \User $user ) {
		$renameDataJson = $user->getGlobalFlag( self::FLAG_RENAME_DATA );

		if ( empty( $renameDataJson ) ) {
			return [];
		} else {
			return json_decode( $renameDataJson );
		}
	}

	/**
	 * Overwrite the state information stored about this move in the rename data flag.  If you want to add
	 * rather than replace the state information use addRenameData
	 *
	 * @param \User $user
	 * @param array $params
	 *
	 * @return array|mixed
	 */
	public function setRenameData( \User $user, $params ) {
		if ( empty( $params ) ) {
			$renameData = json_encode( [] );
		} else {
			$renameData = json_encode( $params );
		}
		$user->setGlobalAttribute( self::FLAG_RENAME_DATA, $renameData );
	}

	/**
	 * Add or update values in the state information stored for this move in the rename data flag.
	 *
	 * @param \User $user
	 * @param $params
	 */
	public function addRenameData( \User $user, $params ) {
		if ( empty( $params ) ) {
			return;
		}

		$renameData = $this->getRenameData( $user );
		$renameData = array_merge( $renameData, $params );
		$this->setRenameData( $user, $renameData );
	}

	/**
	 * Performs action for cleaning up temporary data at the very end of a process
	 */
	public function cleanupFakeUser() {
		if ( $this->mFakeUserId ) {
			$this->logInfo( "Cleaning up process data in user option renameData for ID %s", $this->mFakeUserId );

			$fakeUser = \User::newFromId( $this->mFakeUserId );

			$this->setRenameData( $fakeUser, [ self::RENAME_TAG => $this->mNewUsername ] );
			$fakeUser->saveSettings();
			$fakeUser->saveToCache();
		}
	}

	/**
	 * Log when the rename operation starts to the staff log
	 *
	 * @param string $taskId
	 */
	public function logStartToStaff( $taskId = null ) {
		$logLink = $taskId ? \UserRenameToolHelper::buildTaskLogLink( $taskId ) : '-';
		$this->addStaffLogAction( self::ACTION_START, 'userrenametool-info-started', $logLink );
	}

	/**
	 * Log when the rename operation has failed to the staff log
	 *
	 * @param string $taskId
	 */
	public function logFailToStaff( $taskId = null ) {
		$logLink = $taskId ? \UserRenameToolHelper::buildTaskLogLink( $taskId ) : '-';
		$this->addStaffLogAction( self::ACTION_FAIL, 'userrenametool-info-failed', $logLink );
	}

	/**
	 * Log when the rename operation has completed to the staff log
	 *
	 * @param string $taskId
	 */
	public function logFinishToStaff( $taskId = null ) {
		$logLink = $taskId ? \UserRenameToolHelper::buildTaskLogLink( $taskId ) : '-';
		$this->addStaffLogAction( self::ACTION_FINISH, 'userrenametool-info-finished', $logLink );
	}

	/**
	 * Log a successful rename for a single wiki
	 *
	 * @param int $wikiId The wiki ID for this single rename.  If not given the current value of wgCityId is used.
	 */
	public function logFinishWikiToStaff( $wikiId = null ) {
		$wikiId = $wikiId ? $wikiId : \F::app()->wg->CityId;
		$this->addStaffLogAction( self::ACTION_LOG, 'userrenametool-info-wiki-finished', $wikiId );
	}

	/**
	 * Log a rename fail for a single wiki
	 *
	 * @param int $wikiId The wiki ID for this single rename.  If not given the current value of wgCityId is used.
	 */
	public function logFailWikiToStaff( $wikiId = null ) {
		$wikiId = $wikiId ? $wikiId : \F::app()->wg->CityId;
		$this->addStaffLogAction( self::ACTION_LOG, 'userrenametool-info-wiki-finished-problems', $wikiId );
	}

	public function addStaffLogAction( $action, $key, $info = null ) {
		$formattedLogLine = \UserRenameToolHelper::generateLogLine(
			$key,
			$this->mRequestorName,
			$this->mOldUsername,
			$this->mNewUsername,
			$this->mReason,
			$info
		);

		$this->addStaffLog( $action, $formattedLogLine );
	}

	/**
	 * Logs the message to main user-visible log
	 *
	 * @param string $action
	 * @param $text string Log message
	 */
	public function addStaffLog( $action, $text ) {
		\StaffLogger::log(
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
		$log = new \LogPage( 'renameuser' );
		$log->addEntry(
			'renameuser',
			\Title::newFromText( $this->mOldUsername, NS_USER ),
			$text,
			[ ],
			\User::newFromId( $this->mRequestorId )
		);
	}

	/**
	 * Sends the internal log message to the specified destination
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function logInfo( $text, $arg1 = null ) {
		if ( func_num_args() > 1 ) {
			$args = func_get_args();
			$args = array_slice( $args, 1 );
			$text = vsprintf( $text, $args );
		}

		$this->info( $text );
	}

	/**
	 * Sends the internal log message to the specified destination
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function logDebug( $text, $arg1 = null ) {
		if ( func_num_args() > 1 ) {
			$args = func_get_args();
			$args = array_slice( $args, 1 );
			$text = vsprintf( $text, $args );
		}

		$this->debug( $text );
	}

	public function setRequestorUser() {
		global $wgUser;

		$oldUser = $wgUser;
		$this->logInfo(
			"Checking for need to overwrite requestor user (id=%d name=%s)",
			$this->mRequestorId, $this->mRequestorName
		);

		$userId = $wgUser->getId();

		if ( empty( $userId ) && !empty( $this->mRequestorId ) ) {
			$this->logInfo( "Checking if requestor exists" );
			$newUser = \User::newFromId( $this->mRequestorId );

			if ( !empty( $newUser ) ) {
				$this->logInfo( "Overwriting requestor user" );
				$wgUser = $newUser;
			}
		}

		return $oldUser;
	}

	/**
	 * Clear user cache, forcing a reload from DB the next time a user object for this name is requested.
	 *
	 * @param \User|string $user
	 */
	protected function invalidateUserCache( $user ) {
		global $wgCityId;

		if ( is_string( $user ) ) {
			$user = \User::newFromName( $user );
		}

		if ( is_object( $user ) ) {
			$userName = $user->getName();
			$this->logInfo( "Invalidate user data on local Wiki (%s): %s", $wgCityId, $userName );
			$user->invalidateCache();
		} else {
			$this->logInfo( "invalidateUser() called with some strange argument type: %s", gettype( $user ) );
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
		$wg = \F::app()->wg;

		// check for invalid values
		if ( empty( $userID ) || !is_int( $userID ) ) {
			return false;
		}

		$this->logInfo( "Looking up registered user activity for user with ID %s", $userID );

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

		$this->logInfo( "Found %s wikis: %s", count( $wikiIds ), implode( ', ', $wikiIds ) );
		return $wikiIds;
	}

	/**
	 * Look for user edits in the rollup_edit_events table
	 *
	 * @param int $userId
	 *
	 * @return array
	 *
	 * @throws \DBUnexpectedError
	 */
	private function lookupWikiIdsInDb( $userId ) {
		$wg = \F::app()->wg;

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
			if ( \WikiFactory::isPublic( $row->wiki_id ) ) {
				$result[] = ( int ) $row->wiki_id;
				$this->logInfo(
					"Registered user with ID %d was active on wiki with ID %d",
					$userId, $row->wiki_id
				);
			} else {
				$this->logInfo( "Skipped wiki with ID %d (inactive wiki)", $row->wiki_id );
			}
		}

		$dbr->freeResult( $res );

		return $result;
	}
}
