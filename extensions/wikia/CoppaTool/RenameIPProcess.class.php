<?php

class RenameIPProcess {

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_STANDARD = 'standard';
	const LOG_BATCH_TASK = 'task';
	const LOG_OUTPUT = 'output';

	const RENAMEIP_LOOP_PAUSE = 5;

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

	private $mOldIPAddress = '';
	private $mNewIPAddress = '';
	private $mUserId = 0;
	private $mPhalanxBlockId = 0;
	private $mRequestorId = 0;
	private $mRequestorName = '';
	private $mReason = null;
	private $mNotifyUser;

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
	public function __construct( $oldIPAddress, $newIPAddress, $confirmed = false, $reason = null ) {
		global $wgUser;

		// Save original request data
		$this->mRequestData = new stdClass();
		$this->mRequestData->oldIPAddress = $oldIPAddress;
		$this->mRequestData->newIPAddress = $newIPAddress;

		$this->mActionConfirmed = $confirmed;
		$this->mReason = $reason;
		$this->mRequestorId = $wgUser ? $wgUser->getId() : 0;
		$this->mRequestorName = $wgUser ? $wgUser->getName() : '';
		$this->mNotifyUser = false;

		$this->addInternalLog( "construct: old={$oldIPAddress} new={$newIPAddress}" );
	}

	public function getOldIPAddress() {
		return $this->mOldIPAddress;
	}

	public function getNewIPAddress() {
		return $this->mNewIPAddress;
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

	/**
	 * Processes specific local wiki database and makes all needed changes for an IP address
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocalIP() {
		global $wgCityId, $wgUser;

		if ( !IP::isIPAddress( $this->mOldIPAddress ) || !IP::isIPAddress( $this->mNewIPAddress ) ) {
			$this->addError( wfMessage( 'coppatool-error-invalid-ip' )->escaped() );
			return;
		}

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( Wikia::USER );

		$cityDb = WikiFactory::IDtoDB( $wgCityId );
		$this->addLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$tasks = self::$mLocalIpDefaults;

		$hookName = 'RenameIP::LocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		Hooks::run( $hookName, [ $dbw, $this->mOldIPAddress, $this->mNewIPAddress, $this, $wgCityId, &$tasks ] );

		foreach ( $tasks as $task ) {
			$this->addLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable( $dbw, $task['table'], $this->mOldIPAddress, $this->mNewIPAddress, $task );
		}

		$hookName = 'RenameIP::AfterLocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		Hooks::run( $hookName, [ $dbw, $this->mOldIPAddress, $this->mNewIPAddress, $this, $wgCityId, &$tasks ] );

		$dbw->commit();

		$this->addLog( "Finished updating wiki database: {$cityDb}" );

		$this->addMainLog( "log", RenameIPLogFormatter::wiki( $this->mRequestorName, $this->mOldIPAddress, $this->mNewIPAddress, $wgCityId, $this->mReason,
			!empty( $this->warnings ) || !empty( $this->errors ) ) );

		$wgUser = $wgOldUser;
	}

	/**
	 * @author: Władysław Bodzek
	 * Really performs a rename task specified in arguments
	 *
	 * @param DatabaseBase $dbw Database to operate on
	 * @param string $table Table name
	 * @param string $oldIP Old IP
	 * @param string $newIP New IP
	 * @param array $extra Extra options (currently: userid_column, username_column, conds)
	 *
	 * @return bool
	 */
	public function renameInTable( DatabaseBase $dbw, $table, $oldIP, $newIP, $extra ) {
		$dbName = $dbw->getDBname();
		$this->addLog( "Processing {$dbName}.{$table}.{$extra['username_column']}." );

		try {
			if ( !$dbw->tableExists( $table ) ) {
				$this->addLog( "Table \"$table\" does not exist in database {$dbName}" );
				$this->addWarning( wfMessage( 'coppatool-warn-table-missing', $dbName, $table )->inContentLanguage()->text() );

				return false;
			}

			$values = array(
				$extra['username_column'] => $newIP,
			);

			$conds = array(
				$extra['username_column'] => $oldIP,
			);

			if ( !empty( $extra['conds'] ) ) {
				$conds = array_merge( $extra['conds'], $conds );
			}

			$opts = array(
				'LIMIT' => self::MAX_ROWS_PER_QUERY,
			);

			$affectedRows = 1;

			while ( $affectedRows > 0 ) {
				$dbw->update( $table, $values, $conds, __METHOD__, $opts );
				$affectedRows = $dbw->affectedRows();
				$this->addLog( "SQL: " . $dbw->lastQuery() );
				$dbw->commit();
				$this->addLog( "In {$dbName}.{$table}.{$extra['username_column']} {$affectedRows} row(s) was(were) updated." );
				wfWaitForSlaves( $dbw->getDBname() );
			}
		} catch ( Exception $e ) {
			$this->addLog( "Exception in renameInTable(): " . $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine() );
		}

		$this->addLog( "Finished processing {$dbName}.{$table}.{$extra['username_column']}." );

		return true;
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
	 * Logs the message to main user-visible log
	 *
	 * @param string $action
	 * @param $text string Log message
	 */
	public function addMainLog( $action, $text ) {
		StaffLogger::log(
			'coppatool',
			$action,
			$this->mRequestorId,
			$this->mRequestorName,
			$this->mUserId,
			$this->mNewIPAddress,
			$text
		);
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

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 * Performs action for cleaning up temporary data at the very end of a process
	 */
	public function cleanup() {
		$hookName = 'UserRename::Cleanup';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		Hooks::run( $hookName, array( $this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mOldIPAddress, $this->mNewIPAddress ) );
		$tasks = [];
		if ( isset( $this->mLogTask ) ) {
			$tasks[] = $this->mLogTask->getID();
		}
	}

	private function addInternalLog( $text ) {
		$this->mInternalLog .= $text . "\n";
	}

	static public function newFromData( $data ) {
		$o = new RenameIPProcess( $data['old_ip'], $data['new_ip'], '', true );

		$mapping = array(
			'mOldIPAddress' => 'old_ip',
			'mNewIPAddress' => 'new_ip',
			'mRequestorId' => 'requestor_id',
			'mRequestorName' => 'requestor_name',
			'mPhalanxBlockId' => 'phalanx_block_id',
			'mReason' => 'reason',
			'mLogTask' => 'local_task',
			'mRenameIP' => 'rename_ip',
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


	/* Static utility functions */

	/**
	 * Sanitizes entered old username
	 *
	 * @param $username string
	 * @return string
	 */
	static public function createOldUserTitle( $username ) {
		return Title::makeTitle( NS_USER, trim( str_replace( '_', ' ', $username ) ) );
	}

	/**
	 * Sanitizes entered new username
	 *
	 * @param $username string
	 * @return string
	 */
	static public function createNewUserTitle( $username ) {
		global $wgContLang;
		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		return Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $username ) );
	}
}
