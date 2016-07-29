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

	protected $requestData = null;
	protected $actionConfirmed = false;

	protected $oldUsername = '';
	protected $newUsername = '';

	protected $userId = 0;
	protected $fakeUserId = 0;
	protected $requestorId = 0;
	protected $requestorName = '';
	protected $reason = null;
	protected $notifyUser;

	protected $errors = [ ];
	protected $warnings = [ ];

	protected $currentTaskId = null;

	protected $repeatRename = false;
	protected $phalanxBlockId = 0;

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
		$this->requestData = new \stdClass();
		$this->requestData->oldUsername = $oldUsername;
		$this->requestData->newUsername = $newUsername;

		$this->actionConfirmed = $confirmed;
		$this->reason = $reason;
		$this->requestorId = $wgUser ? $wgUser->getId() : 0;
		$this->requestorName = $wgUser ? $wgUser->getName() : '';
		$this->notifyUser = $notifyUser;
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
			'userId' => 'rename_user_id',
			'oldUsername' => 'rename_old_name',
			'newUsername' => 'rename_new_name',
			'fakeUserId' => 'rename_fake_user_id',
			'requestorId' => 'requestor_id',
			'requestorName' => 'requestor_name',
			'phalanxBlockId' => 'phalanx_block_id',
			'reason' => 'reason',
			'renameIP' => 'rename_ip',
		];

		foreach ( $mapping as $property => $key ) {
			if ( array_key_exists( $key, $data ) ) {
				$o->$property = $data[$key];
			}
		}

		// Quick hack to recover requestor name from its id
		if ( !empty( $o->requestorId ) && empty( $o->requestorName ) ) {
			$requestor = \User::newFromId( $o->requestorId );
			$o->requestorName = $requestor->getName();
		}

		$o->logDebug( "Created new ProcessBase instance in newFromData()" );

		return $o;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getWarnings() {
		return $this->warnings;
	}

	public function getCurrentTaskId() {
		return $this->currentTaskId;
	}

	/**
	 * Saves passed error for future retrieval
	 *
	 * @param string $msg Error message
	 */
	protected function addError( $msg ) {
		$this->errors[] = $msg;
	}

	/**
	 * Saves passed warning for future retrieval
	 *
	 * @param string $msg Error message
	 */
	protected function addWarning( $msg ) {
		$this->warnings[] = $msg;
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
		$this->logInfo( sprintf( "Processing %s.%s.%s", $dbName, $table, $extra['username_column'] ) );

		try {
			if ( !$dbw->tableExists( $table ) ) {
				$this->logWarn( sprintf( 'Table "%s" does not exist in database "%s"', $table, $dbName ) );
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
				$this->logDebug( sprintf( "Update SQL: %s",  $dbw->lastQuery() ) );
				$dbw->commit();
				$this->logDebug( sprintf(
					"In %s.%s.%s %d row(s) was(were) updated.",
					$dbName, $table, $extra['username_column'], $affectedRows
				) );

				// Make sure we don't sleep unnecessarily
				if ( $affectedRows >= self::MAX_ROWS_PER_QUERY ) {
					sleep( self::DB_COOL_DOWN_SECONDS );
				}
			}
		} catch ( \Exception $e ) {
			$this->logWarn( sprintf(
				"Exception in renameInTable(): %s in %s at line %",
				$e->getMessage(), $e->getFile(), $e->getLine()
			) );
		}

		$this->logDebug( sprintf( "Finished processing %s.%s.%s.", $dbName, $table, $extra['username_column'] ) );

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
		if ( $this->fakeUserId ) {
			$this->logInfo( "Writing renameData for fake user" );

			$fakeUser = \User::newFromId( $this->fakeUserId );

			$this->setRenameData( $fakeUser, [ self::RENAME_TAG => $this->newUsername ] );
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
			$this->requestorName,
			$this->oldUsername,
			$this->newUsername,
			$this->reason,
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
			$this->requestorId,
			$this->requestorName,
			$this->userId,
			$this->newUsername,
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
			\Title::newFromText( $this->oldUsername, NS_USER ),
			$text,
			[ ],
			\User::newFromId( $this->requestorId )
		);
	}

	/**
	 * Log info to kibana
	 *
	 * @param $text string Log message
	 * @param array $context
	 */
	public function logInfo( $text, $context = null ) {
		$context = $this->addDefaultsToContext( $context );
		$this->info( $text, $context );
	}

	/**
	 * Log warning to kibana
	 *
	 * @param $text string Log message
	 * @param array $context
	 */
	public function logWarn( $text, $context = null ) {
		$context = $this->addDefaultsToContext( $context );
		$this->warning( $text, $context );
	}

	/**
	 * Log error to kibana
	 *
	 * @param $text string Log message
	 * @param array $context
	 */
	public function logError( $text, $context = null ) {
		$context = $this->addDefaultsToContext( $context );
		$this->error( $text, $context );
	}

	/**
	 * Log debug to kibana
	 *
	 * @param $text string Log message
	 * @param array $context
	 */
	public function logDebug( $text, $context = null ) {
		$context = $this->addDefaultsToContext( $context );
		$this->debug( $text, $context );
	}

	private function addDefaultsToContext( $context ) {
		return array_merge( $this->getDefaultLogContext(), $context );
	}

	private function getDefaultLogContext() {
		return [
			'wikiId' => \F::app()->wg->CityId,
			'userId' => $this->userId,
			'oldUsername' => $this->oldUsername,
			'newUsername' => $this->newUsername,
			'fakeUserId' => $this->fakeUserId,
			'requestorId' => $this->requestorId,
			'requestorName' => $this->requestorName,
			'phalanxBlockId' => $this->phalanxBlockId,
			'reason' => $this->reason,
			'currentTaskId' => $this->currentTaskId,
		];
	}

	public function setRequestorUser() {
		global $wgUser;

		$oldUser = $wgUser;
		$this->logDebug( sprintf(
			"Checking for need to overwrite requestor user (id=%d name=%s)",
			$this->requestorId, $this->requestorName
		) );

		$userId = $wgUser->getId();

		if ( empty( $userId ) && !empty( $this->requestorId ) ) {
			$this->logDebug( "Checking if requestor exists" );
			$newUser = \User::newFromId( $this->requestorId );

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
		if ( is_string( $user ) ) {
			$user = \User::newFromName( $user );
		}

		if ( is_object( $user ) ) {
			$userName = $user->getName();
			$this->logInfo( sprintf( "Invalidating user data on local Wiki for '%s'", $userName ) );
			$user->invalidateCache();
		} else {
			$this->logError( sprintf( __METHOD__ . " called with some strange argument type: %s", gettype( $user ) ) );
		}
	}

	/**
	 * Finds on which wikis a REGISTERED user (see LookupContribs for anons) has been active
	 * using the events table stored in the stats DB instead of the blobs table in dataware,
	 * tests showed is faster and more accurate
	 *
	 * @return array A list of wikis' IDs related to user activity, false if the user is not an existing one or an anon
	 */
	protected function lookupRegisteredUserActivity() {
		$wg = \F::app()->wg;

		// check for invalid values
		if ( empty( $this->userId ) || !is_int( $this->userId ) ) {
			return false;
		}

		$this->logInfo( "Looking up user activity" );

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

		$wikiIds = $this->lookupWikiIdsInDb();

		$this->logDebug( sprintf( "Found %d wiki IDs", count( $wikiIds ) ), [ 'wikiIds' => $wikiIds ] );
		return $wikiIds;
	}

	/**
	 * Look for user edits in the rollup_edit_events table
	 *
	 * @return array
	 *
	 * @throws \DBUnexpectedError
	 */
	private function lookupWikiIdsInDb() {
		$wg = \F::app()->wg;

		$dbr = wfGetDB( DB_SLAVE, array(), $wg->DWStatsDB );
		$res = $dbr->select(
			'rollup_edit_events',
			'wiki_id',
			[ 'user_id' => $this->userId ],
			__METHOD__,
			[ 'GROUP BY' => 'wiki_id' ]
		);

		$result = [];
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( \WikiFactory::isPublic( $row->wiki_id ) ) {
				$result[] = ( int ) $row->wiki_id;
				$this->logDebug( sprintf( "Registered user was active on wiki with ID %d", $row->wiki_id ) );
			} else {
				$this->logDebug( sprintf( "Skipped wiki with ID %d (inactive wiki)", $row->wiki_id ) );
			}
		}

		$dbr->freeResult( $res );

		return $result;
	}
}
