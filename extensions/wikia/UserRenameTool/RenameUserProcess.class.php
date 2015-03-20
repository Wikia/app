<?php

use Wikia\Tasks\AsyncTaskList;

class RenameUserProcess {

	const RENAME_TAG = 'renamed_to';
	const PROCESS_TAG = 'rename_in_progress';
	const PHALANX_BLOCK_TAG = 'phalanx_block_id';

	const MAX_ROWS_PER_QUERY = 500;

	const LOG_STANDARD = 'standard';
	const LOG_BATCH_TASK = 'task';
	const LOG_OUTPUT = 'output';

	//Define what needs changing in core MW tables
	/*
	 * Task definition format:
	 *	 'table' => (string) table name
	 *   'userid_column' => (string) column name with user ID (or null if none
	 *   'username_column' => (string) column name with user name
	 *   'conds' => (array) additional conditions for the query
	 */
	/**
	 * Stores the predefined tasks to do for global (wikicities) database.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * @var $mGlobalDefaults array
	 */
	static private $mGlobalDefaults = array(
		//user table is processed separately
//		array( 'table' => '...', 'userid_column' => '...', 'username_column' => '...' ),
	);

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
			)),
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
	private $mGlobalTask = null;
	private $mRequestorId = 0;
	private $mRequestorName = '';
	private $mReason = null;
	private $mRenameIP = false;

	private $mErrors = array();
	private $mWarnings = array();

	private $mInternalLog = '';

	private $mLogDestinations = array(
		array( self::LOG_STANDARD, null),
	);
	/**
	 *
	 * @var BatchTask
	 */
	private $mLogTask = null;

	/**
	 * Creates new rename user process
	 *
	 * @param $oldUsername string Old username
	 * @param $newUsername string New username
	 * @param $confirmed bool Has the user confirmed all the warnings he got?
	 */
	public function __construct( $oldUsername, $newUsername, $confirmed = false, $reason = null ) {
		global $wgContLang, $wgUser;

		// Save original request data
		$this->mRequestData = new stdClass();
		$this->mRequestData->oldUsername = $oldUsername;
		$this->mRequestData->newUsername = $newUsername;

		$this->mActionConfirmed = $confirmed;
		$this->mReason = $reason;
		$this->mRequestorId = $wgUser ? $wgUser->getId() : 0;
		$this->mRequestorName = $wgUser ? $wgUser->getName() : '';

		$this->addInternalLog("construct: old={$oldUsername} new={$newUsername}");
	}

	public function getRequestData(){
		return $this->mRequestData;
	}

	public function getOldUsername(){
		return $this->mOldUsername;
	}

	public function getNewUsername(){
		return $this->mNewUsername;
	}

	public function getReason(){
		return $this->mReason;
	}

	public function getOldUid(){
		return $this->mUserId;
	}

	public function getErrors(){
		return $this->mErrors;
	}

	public function getWarnings(){
		return $this->mWarnings;
	}

	public function getPhalanxBlockID(){
		return $this->mPhalanxBlockId;
	}

	/**
	 * Sets destination for all the logs
	 *
	 * @param $destination string/enum One of RenameUserProcess::LOG_* constant
	 * @param $task BatchTask (Optional) BatchTask to send logs to
	 */
	public function setLogDestination( $destination, $task = null ) {
		$this->mLogDestinations = array();
		$this->addLogDestination($destination, $task);
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
	public function addError($msg){
		$this->mErrors[] = $msg;
	}

	/**
	 * Saves passed warning for future retrieval
	 *
	 * @param <type> $msg
	 */
	public function addWarning($msg){
		$this->mWarnings[] = $msg;
	}

	protected function getUserTableName($database){
		return "`{$database}`.`user`";
	}

	protected function renameAccount() {
		global $wgExternalSharedDB;
		wfProfileIn(__METHOD__);
		$dbw = wfGetDb( DB_MASTER, array(), $wgExternalSharedDB );

		$table = '`user`';
		$this->addLog("Changing user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}");

		if($dbw->tableExists($table)){
			$dbw->update($table,
				array( 'user_name' => $this->mNewUsername ),
				array( 'user_id' => $this->mUserId ),
				__METHOD__
			);

			$affectedRows = $dbw->affectedRows();
			$this->addLog('Running query: ' . $dbw->lastQuery() . " resulted in {$affectedRows} row(s) being affected.");

			if($affectedRows) {
				$dbw->commit();
				$this->addLog("Changed user {$this->mOldUsername} to {$this->mNewUsername} in {$wgExternalSharedDB}");
				wfProfileOut(__METHOD__);
				return true;
			} else {
				$this->addLog("No changes in {$wgExternalSharedDB} for user {$this->mOldUsername}");
			}
		} else {
			$this->addLog("Table \"{$table}\" not found in {$wgExternalSharedDB}");
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * Checks if the request provided to the constructor is valid.
	 *
	 * @return bool True if all prerequisites are met
	 */
	protected function setup() {
		wfProfileIn(__METHOD__);

		global $wgContLang, $wgCapitalLinks;

		//Sanitize input data
		$oldnamePar = trim(str_replace('_', ' ', $this->mRequestData->oldUsername));
		$oldTitle = Title::makeTitle(NS_USER, $oldnamePar);

		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newTitle = Title::makeTitleSafe(NS_USER, $wgContLang->ucfirst($this->mRequestData->newUsername));

		$oun = is_object($oldTitle) ? $oldTitle->getText() : '';
		$nun = is_object($newTitle) ? $newTitle->getText() : '';

		$this->addInternalLog("title: old={$oun} new={$nun}");

		//AntiSpoof test

		if ( class_exists( 'SpoofUser' ) ) {
			$oNewSpoofUser = new SpoofUser( $nun );
			if ( !$oNewSpoofUser -> isLegal() ) {
				$this->addWarning( wfMessage( 'userrenametool-error-antispoof-conflict', $nun ) );
			}
		} else {
			$this->addError( wfMessage( 'userrenametool-error-antispoof-notinstalled' ) );
		}

		//Phalanx test

		$warning = RenameUserHelper::testBlock( $oun );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}

		$warning = RenameUserHelper::testBlock( $nun );
		if ( !empty( $warning ) ) {
			$this->addWarning( $warning );
		}

		//Invalid old user name entered
		if(!$oun){
			$this->addError( wfMessage('userrenametool-errorinvalid', $this->mRequestData->oldUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		//Invalid new user name entered
		if(!$nun){
			$this->addError( wfMessage('userrenametool-errorinvalidnew', $this->mRequestData->newUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		//Old username is the same as new username
		if($oldTitle->getText() === $newTitle->getText()){
			$this->addError( wfMessage('userrenametool-error-same-user')->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		//validate new username and disable validation for old username
		$olduser = User::newFromName($oldTitle->getText(), false);
		$newuser = User::newFromName($newTitle->getText(), 'creatable');

		// It won't be an object if for instance "|" is supplied as a value
		if( !is_object($olduser) ) {
			$this->addError( wfMessage('userrenametool-errorinvalid', $this->mRequestData->oldUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		if( !is_object($newuser) || !User::isCreatableName($newuser->getName()) ) {
			$this->addError( wfMessage('userrenametool-errorinvalid', $this->mRequestData->newUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		$this->addInternalLog("user: old={$olduser->getName()}:{$olduser->getId()} new={$newuser->getName()}:{$newuser->getId()}");

		// Check for the existence of lowercase oldusername in database.
		// Until r19631 it was possible to rename a user to a name with first character as lowercase
		if($oldTitle->getText() !== $wgContLang->ucfirst( $oldTitle->getText())){
			// oldusername was entered as lowercase -> check for existence in table 'user'
			$dbr = WikiFactory::db(DB_SLAVE);
			$uid = $dbr->selectField('`user`', 'user_id',
				array( 'user_name' => $oldTitle->getText() ),
				__METHOD__ );

			$this->addLog('Running query: ' . $dbr->lastQuery() . " resulted in " . $dbr->affectedRows() . " row(s) being affected.");

			if( $uid === false ) {
				if( !$wgCapitalLinks ) {
					$uid = 0; // We are on a lowercase wiki but lowercase username does not exists
				} else {
					// We are on a standard uppercase wiki, use normal
					$uid = $olduser->idForName();
					$oldTitle = Title::makeTitleSafe( NS_USER, $olduser->getName() );
				}
			}
		}
		else{
			// oldusername was entered as upperase -> standard procedure
			$uid = $olduser->idForName();
		}

		$this->addInternalLog("id: uid={$uid} old={$olduser->getName()}:{$olduser->getId()} new={$newuser->getName()}:{$newuser->getId()}");


		//If old user name does not exist:
		if($uid == 0){
			$this->addError( wfMessage( 'userrenametool-errordoesnotexist', $this->mRequestData->oldUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}
		elseif($olduser->isLocked()){
			$this->addError( wfMessage( 'userrenametool-errorlocked', $this->mRequestData->oldUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}
		elseif($olduser->isAllowed( 'bot' )){
			$this->addError( wfMessage( 'userrenametool-errorbot', $this->mRequestData->oldUsername)->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		$fakeuid = 0;

		//If new user name does exist (we have a special case - repeating rename process)
		if($newuser->idForName() != 0){
			$repeating = false;
			$processing = false;

			//invalidate properties cache and reload to get updated data
			//needed here, if the cache is wrong bad things happen
			$this->addInternalLog("pre-invalidate: titletext={$oldTitle->getText()} old={$olduser->getName()}");

			$olduser->invalidateCache();
			$olduser = User::newFromName($oldTitle->getText(), false);

			$renameData = $olduser->getOption( 'renameData', '' );

			$this->addInternalLog("post-invalidate: titletext={$oldTitle->getText()} old={$olduser->getName()}:{$olduser->getId()}");

			$this->addLog("Scanning user option renameData for process data: {$renameData}");

			if(stripos($renameData, self::RENAME_TAG) !== false){
				$tokens = explode(';', $renameData, 3);

					if(!empty($tokens[0])){
						$nameTokens = explode('=', $tokens[0], 2);

						$repeating = (
							count($nameTokens) == 2 &&
							$nameTokens[0] === self::RENAME_TAG &&
							$nameTokens[1] === $newuser->getName()
						);
					}

					if(!empty($tokens[1])){
						$statusTokens = explode('=', $tokens[1], 2);

						$processing = (
							count($statusTokens) == 2 &&
							$statusTokens[0] === self::PROCESS_TAG &&
							((int)$statusTokens[1]) === 1
						);
					}

					if(!empty($tokens[2])){
						$blockTokens = explode('=', $tokens[2], 2);

						if(
							count($blockTokens) == 2 &&
							$blockTokens[0] === self::PHALANX_BLOCK_TAG &&
							is_numeric($blockTokens[1])
						){
							$this->mPhalanxBlockId = (int)$blockTokens[1];
						}
					}
			}

			/**
			 * Not needed, process must be resumable even in case of fatal errors, if 2 processes are run nothing bad happens
			//if the process is already running throw an error
			if($processing){
				$this->addError( wfMessage( 'userrenametool-errorprocessing', $olduser->getName(), $newuser->getName())->inContentLanguage()->text() );
				wfProfileOut(__METHOD__);
				return false;
			}*/

			if($repeating){
				$this->addWarning(wfMessage('userrenametool-warn-repeat', $this->mRequestData->oldUsername, $this->mRequestData->newUsername)->inContentLanguage()->text() );
				//Swap the uids because the real user ID is the new user ID in this special case
				$fakeuid = $uid;
				$uid = $newuser->idForName();
			} else {
				//In the case other than repeating the process drop an error
				$this->addError( wfMessage( 'userrenametool-errorexists', $newuser->getName())->inContentLanguage()->text() );
				wfProfileOut(__METHOD__);
				return false;
			}
		}

		//Execute Warning hook (arguments the same as in the original Renameuser extension)
		if(!$this->mActionConfirmed){
			wfRunHooks('UserRename::Warning', array($this->mRequestData->oldUsername, $this->mRequestData->newUsername, &$this->mWarnings));
		}

		$this->mOldUsername = $olduser->getName();
		$this->mNewUsername = $newuser->getName();
		$this->mUserId = (int)$uid;
		$this->mFakeUserId = $fakeuid;

		$this->addInternalLog("setup: uid={$this->mUserId} fakeuid={$this->mFakeUserId} old={$this->mOldUsername} new={$this->mNewUsername}");

		//If there are only warnings and user confirmed that, do not show them again
		//on success page ;-)
		if($this->mActionConfirmed){
			$this->mWarnings = array();
		}
		elseif(count($this->mWarnings)){
			//in case action is not confirmed and there are warnings display them and wait for confirmation before running the process
			wfProfileOut(__METHOD__);
			return false;
		}

		wfProfileOut(__METHOD__);
		return empty($this->mErrors);
	}

	/**
	 * Runs the whole rename process, schedules background jobs/tasks if needed.
	 *
	 * @return bool True if the process succeded
	 */
	public function run() {
		// Make sure the process will not be stopped in the middle
		set_time_limit(3600); //1h
		ignore_user_abort(true);
		ini_set("max_execution_time",3600); //1h

		wfProfileIn(__METHOD__);

		if (!$this->setup()) {
			wfProfileOut(__METHOD__);
			return false;
		}

		// Execute the worker
		$status = false;

		try {
			$status = $this->doRun();
		} catch (Exception $e) {
			$this->addLog($e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine());
			$this->addError(wfMessage('userrenametool-error-cannot-rename-unexpected')->inContentLanguage()->text());
		}

		// Analyze status
		if (!$status) {

			$problems = array_merge($this->mErrors, $this->mWarnings);

			$this->addMainLog("fail", RenameUserLogFormatter::fail($this->mRequestorName, $this->mOldUsername, $this->mNewUsername, $this->mReason, $tasks));
		}

		wfProfileOut(__METHOD__);
		return $status;
	}

	/**
	 * Do the whole dirty job of renaming user
	 *
	 * @return bool True if the process succeded
	 */
	private function doRun() {
		global $wgMemc, $wgAuth;
		wfProfileIn(__METHOD__);

		$this->addLog("User rename global task start." . ((!empty($this->mFakeUserId)) ? ' Process is being repeated.' : null));
		$this->addLog("Renaming user {$this->mOldUsername} (ID {$this->mUserId}) to {$this->mNewUsername}");

		$hookName = 'RenameUser::Abort';
		$this->addLog("Broadcasting hook: {$hookName}");
		// Give other affected extensions a chance to validate or abort
		if( !wfRunHooks( $hookName, array( $this->mUserId, $this->mOldUsername, $this->mNewUsername, &$this->mErrors ) ) ) {
			$this->addLog("Aborting procedure as requested by hook.");
			$this->addError( wfMessage( 'userrenametool-error-extension-abort' )->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		//enumerate IDs for wikis the user has been active in
		$this->addLog("Searching for user activity on wikis.");
		$wikiIDs = RenameUserHelper::lookupRegisteredUserActivity($this->mUserId);
		$this->addLog("Found ".count($wikiIDs)." wikis: ".implode(', ',$wikiIDs));

		$hookName = 'UserRename::BeforeAccountRename';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($this->mUserId, $this->mOldUsername, $this->mNewUsername));

		// delete the record from all the secondary clusters
		if ( class_exists( 'ExternalUser_Wikia' ) ) {
			ExternalUser_Wikia::removeFromSecondaryClusters( $this->mUserId );
		}

		// rename the user on the shared cluster
		if ( !$this->renameAccount() ) {
			$this->addLog("Failed to rename the user on the primary cluster. Report the problem to the engineers.");
			$this->addError( wfMessage('userrenametool-error-cannot-rename-account')->inContentLanguage()->text() );
			wfProfileOut(__METHOD__);
			return false;
		}

		$this->invalidateUser($this->mNewUsername);

		/*if not repeating the process
		create a new account storing the old username and some extra information in the realname field
		this avoids creating new accounts with the old name and let's resume/repeat the process in case is needed*/
		$this->addLog("Creating fake user account");

		$fakeUser = null;

		if(empty($this->mFakeUserId)){

			global $wgAuth, $wgExternalAuthType;

			$fakeUser = User::newFromName( $this->mOldUsername, 'creatable' );

			if ( !is_object( $fakeUser ) ) {
				$this->addLog("Cannot create fake user: {$this->mOldUsername}");
				wfProfileOut(__METHOD__);
				return false;
			}

			$fakeUser->setPassword( null );
			$fakeUser->setEmail( null );
			$fakeUser->setRealName( '' );
			$fakeUser->setName( $this->mOldUsername );

			if ( $wgExternalAuthType ) {
				$fakeUser = ExternalUser_Wikia::addUser( $fakeUser, '', '', '' );
                /**
                 * @wladekb
                 * \Wikia\Helios\User::register()
                 * $u = \ExternalUser_Wikia::newFromName();
                 * $u->saveSettings()
                 */
			} else {
				$fakeUser->addToDatabase();
			}

			$fakeUser->setOption( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername . ';' . self::PROCESS_TAG . '=' . '1' );
			$fakeUser->setOption( 'disabled', 1 );
			$fakeUser->saveSettings();
			$this->mFakeUserId = $fakeUser->getId();
			$this->addLog("Created fake user account for {$fakeUser->getName()} with ID {$this->mFakeUserId} and renameData '{$fakeUser->getOption( 'renameData', '')}'");
		} else {
			$fakeUser = User::newFromId($this->mFakeUserId);
			$this->addLog("Fake user account already exists: {$this->mFakeUserId}");
		}

		$this->invalidateUser($this->mOldUsername);

		//Block the user from logging in before logging him out
		$this->addLog("Creating a Phalanx block for the user.");

		if(empty($this->mPhalanxBlockId)){
			$data = array(
				'id'          => $this->mPhalanxBlockId,
				'text'        => $this->mNewUsername,
				'exact'       => 1,
				'case'        => 1,
				'regex'       => 0,
				'timestamp'   => wfTimestampNow(),
				'expire'      => null,
				'author_id'   => $this->mRequestorId,
				'reason'      => 'User rename process requested',
				'lang'        => null,
				'type'        => Phalanx::TYPE_USER
			);

			wfRunHooks( "EditPhalanxBlock", array( &$data ) );
			$this->mPhalanxBlockId = $data['id'];
			if(!$this->mPhalanxBlockId) {
				$this->addLog("Creation of the block failed.");
				$this->addError( wfMessage('userrenametool-error-cannot-create-block')->inContentLanguage()->text() );
				wfProfileOut(__METHOD__);
				return false;
			} else {
				$fakeUser->setOption( 'renameData', $fakeUser->getOption( 'renameData', '') . ';' . self::PHALANX_BLOCK_TAG . '=' . $this->mPhalanxBlockId);
				$fakeUser->saveSettings();
				$this->addLog("Block created with ID {$this->mPhalanxBlockId}.");
			}
		}
		else{
			$this->addLog("Block with ID {$this->mPhalanxBlockId} already exists.");
		}

		$hookName = 'UserRename::AfterAccountRename';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($this->mUserId, $this->mOldUsername, $this->mNewUsername));

		//process global tables
		$this->addLog("Initializing update of global shared DB's.");
		$this->updateGlobal();

		$callParams = array(
			'requestor_id' => $this->mRequestorId,
			'requestor_name' => $this->mRequestorName,
			'rename_user_id' => $this->mUserId,
			'rename_old_name' => $this->mOldUsername,
			'rename_new_name' => $this->mNewUsername,
			'rename_fake_user_id' => $this->mFakeUserId,
			'phalanx_block_id' => $this->mPhalanxBlockId,
			'reason' => $this->mReason,
		);
		$task = ( new UserRenameTask() )
			->setPriority( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->call( 'renameUser', $wikiIDs, $callParams );
		$task->queue();

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Processes shared database (wikicities) and makes all needed changes
	 */
	public function updateGlobal(){
		wfProfileIn(__METHOD__);

		global $wgStatsDB, $wgStatsDBEnabled;

		// wikicities
		$this->addLog("Updating global shared database: wikicities.");
		$dbw = WikiFactory::db(DB_MASTER);
		$dbw->begin();
		$tasks = self::$mGlobalDefaults;

		$hookName = 'UserRename::Global';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks));

		foreach($tasks as $task){
			$this->addLog("Updating {$task['table']}.{$task['username_column']}.");
			$this->renameInTable($dbw, $task['table'], $this->mUserId, $this->mOldUsername, $this->mNewUsername, $task);
		}

		$hookName = 'UserRename::AfterGlobal';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, &$tasks));

		$dbw->commit();
		$this->addLog("Finished updating shared database: wikicities.");

		wfProfileOut(__METHOD__);
	}

	/**
	 * Processes specific local wiki database and makes all needed changes
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocal(){
		global $wgCityId, $wgUser;

		wfProfileIn(__METHOD__);

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( 'Wikia' );

		$cityDb = WikiFactory::IDtoDB($wgCityId);
		$this->addLog("Processing wiki database: {$cityDb}.");

		$dbw = wfGetDB(DB_MASTER);
		$dbw->begin();
		$tasks = self::$mLocalDefaults;

		$hookName = 'UserRename::Local';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks));

		/* Move user pages */
		$this->addLog("Moving user pages.");
		try {
			$oldTitle = Title::makeTitle(NS_USER, $this->mOldUsername);
			$newTitle = Title::makeTitle(NS_USER, $this->mNewUsername);

			// Determine all namespaces which need processing
			$allowedNamespaces = array( NS_USER, NS_USER_TALK );
			// Blogs extension
			if (defined('NS_BLOG_ARTICLE'))
				$allowedNamespaces = array_merge( $allowedNamespaces, array( NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ));
			// NY User profile
			if (defined('NS_USER_WIKI'))
				$allowedNamespaces = array_merge( $allowedNamespaces, array( NS_USER_WIKI, /*NS_USER_WIKI_TALK*/ 201, NS_USER_PROFILE ));

			if (defined('NS_USER_WALL'))
				$allowedNamespaces = array_merge( $allowedNamespaces, array( NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING ));

			$oldKey = $oldTitle->getDBkey();
			$like = $dbw->buildLike( sprintf( "%s/", $oldKey ), $dbw->anyString() );
			$pages = $dbw->select(
				'page',
				array( 'page_namespace', 'page_title' ),
				array(
					'page_namespace' => $allowedNamespaces,
//					'page_namespace IN (' . NS_USER . ',' . NS_USER_TALK . ')',
					'(page_title ' . $like . ' OR page_title = ' . $dbw->addQuotes($oldKey) . ')'
				),
				__METHOD__
			);
			$this->addLog("SQL: ".$dbw->lastQuery());

			while($row = $dbw->fetchObject($pages)){
				$oldPage = Title::makeTitleSafe($row->page_namespace, $row->page_title);
				$newPage = Title::makeTitleSafe($row->page_namespace, preg_replace('!^[^/]+!', $newTitle->getDBkey(), $row->page_title));

				//Do not autodelete or anything, title must not exist
				//Info: The other case is when renaming is repeated - no action should be taken
				if ($newPage->exists() && !$oldPage->isValidMoveTarget($newPage)){
					$this->addLog("Updating wiki \"{$cityDb}\": User page " . $newPage->getText() . " already exists, moving cancelled.");
					$this->addWarning( wfMessage('userrenametool-page-exists', $newPage->getText())->inContentLanguage()->text() );
				}
				else{
					$this->addLog("Moving page " . $oldPage->getText() . " in namespace {$row->page_namespace} to " . $newTitle->getText() );
					$success = $oldPage->moveTo($newPage, false,  wfMessage('userrenametool-move-log', $oldTitle->getText(), $newTitle->getText())->inContentLanguage()->text());

					if($success === true){
						$this->addLog("Updating wiki \"{$cityDb}\": User page " . $oldPage->getText() . " moved to " . $newPage->getText() . '.');
					} else {
						$this->addLog("Updating wiki \"{$cityDb}\": User page " . $oldPage->getText() . " could not be moved to " . $newPage->getText() . '.');
						$this->addWarning( wfMessage('userrenametool-page-unmoved', array($oldPage->getText(), $newPage->getText()))->inContentLanguage()->text() );
					}
				}
			}
			$dbw->freeResult($pages);
		} catch (Exception $e) {
			$this->addLog("Exception while moving pages: " . $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine());
		}
		/* End of move user pages */

		foreach($tasks as $task){
			$this->addLog("Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}");
			$this->renameInTable($dbw, $task['table'], $this->mUserId, $this->mOldUsername, $this->mNewUsername, $task);
		}

		/* Reset local editcount */
		$this->resetEditCountWiki();

		$hookName = 'UserRename::AfterLocal';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array( $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks));

		$dbw->commit();

		// Save entry in local Special:Log
		// Important: assuming that run inside the maintenance script
		$this->addLocalLog( wfMessage( 'userrenametool-success', $this->mOldUsername, $this->mNewUsername )->inContentLanguage()->text() );

		$this->addLog("Finished updating wiki database: {$cityDb}");

		$this->addMainLog("log",RenameUserLogFormatter::wiki($this->mRequestorName, $this->mOldUsername, $this->mNewUsername, $wgCityId, $this->mReason,
			!empty($this->warnings) || !empty($this->errors) ));

		$this->addLog("Invalidate user data on local Wiki ({$wgCityId}): {$this->mOldUsername}");
		$this->invalidateUser($this->mOldUsername);

		$this->addLog("Invalidate user data on local Wiki ({$wgCityId}): {$this->mNewUsername}");
		$this->invalidateUser($this->mNewUsername);

		$wgUser = $wgOldUser;

		wfProfileOut(__METHOD__);
	}

	/**
	 * Processes specific local wiki database and makes all needed changes for an IP address
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocalIP() {
		global $wgCityId, $wgUser;

		wfProfileIn( __METHOD__ );

		if ( $this->mUserId !== 0 || !IP::isIPAddress( $this->mOldUsername ) || !IP::isIPAddress( $this->mNewUsername ) ) {
			$this->addError( wfMessage( 'userrenametool-error-invalid-ip' )->escaped() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOldUser = $wgUser;
		$wgUser = User::newFromName( 'Wikia' );

		$cityDb = WikiFactory::IDtoDB( $wgCityId );
		$this->addLog( "Processing wiki database: {$cityDb}." );

		$dbw = wfGetDB(DB_MASTER);
		$dbw->begin();
		$tasks = self::$mLocalIpDefaults;

		$hookName = 'UserRename::LocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ] );

		foreach ( $tasks as $task ) {
			$this->addLog( "Updating wiki \"{$cityDb}\": {$task['table']}:{$task['username_column']}" );
			$this->renameInTable( $dbw, $task['table'], $this->mUserId, $this->mOldUsername, $this->mNewUsername, $task );
		}

		$hookName = 'UserRename::AfterLocalIP';
		$this->addLog( "Broadcasting hook: {$hookName}" );
		wfRunHooks( $hookName, [ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ] );

		$dbw->commit();

		$this->addLog( "Finished updating wiki database: {$cityDb}" );

		$this->addMainLog( "log", RenameUserLogFormatter::wiki( $this->mRequestorName, $this->mOldUsername, $this->mNewUsername, $wgCityId, $this->mReason,
			!empty( $this->warnings ) || !empty( $this->errors ) ) );

		$wgUser = $wgOldUser;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @author: Władysław Bodzek
	 * Really performs a rename task specified in arguments
	 *
	 * @param $dbw Database Database to operate on
	 * @param $table string Table name
	 * @param $uid int User ID
	 * @param $oldusername string Old username
	 * @param $newusername string New username
	 * @param $extra array Extra options (currently: userid_column, username_column, conds)
	 */
	public function renameInTable($dbw, $table, $uid, $oldusername, $newusername, $extra){
		wfProfileIn(__METHOD__);

		$dbName = $dbw->getDBname();
		$this->addLog("Processing {$dbName}.{$table}.{$extra['username_column']}.");

		try {
			if (!$dbw->tableExists($table)){
				$this->addLog("Table \"$table\" does not exist in database {$dbName}");
				$this->addWarning( wfMessage( 'userrenametool-warn-table-missing', $dbName, $table )->inContentLanguage()->text() );
				wfProfileOut(__METHOD__);
				return false;
			}

			$values = array(
				$extra['username_column'] => $newusername,
			);

			$conds = array(
				$extra['username_column'] => $oldusername,
			);

			if ( !empty($extra['userid_column']) ) $conds[$extra['userid_column']] = $uid;

			if ( !empty($extra['conds']) ) $conds = array_merge($extra['conds'],$conds);

			$opts = array(
				'LIMIT' => self::MAX_ROWS_PER_QUERY,
			);

			$affectedRows = 1;

			while($affectedRows > 0) {
				$dbw->update($table, $values, $conds, __CLASS__.'::'.__METHOD__, $opts);
				$affectedRows = $dbw->affectedRows();
				$this->addLog("SQL: ".$dbw->lastQuery());
				$dbw->commit();
				$this->addLog("In {$dbName}.{$table}.{$extra['username_column']} {$affectedRows} row(s) was(were) updated.");
				sleep(USERRENAME_LOOP_PAUSE);
			}
		} catch (Exception $e) {
			$this->addLog("Exception in renameInTable(): ".$e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine());
		}

		$this->addLog("Finished processing {$dbName}.{$table}.{$extra['username_column']}.");

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Reset local editcount for renamed user and fake user
	 * @author Kamil Koterba
	 * @since Feb 2014
	 */
	private function resetEditCountWiki() {
		// Renamed user
		$uss = new UserStatsService( $this->mUserId );
		$uss->resetEditCountWiki();

		// FakeUser
		if ( $this->mFakeUserId != 0 ) {
			$uss = new UserStatsService( $this->mFakeUserId );
			$uss->resetEditCountWiki();
		} else {
			// use OldUsername if FakeUser isn't set
			$oldUser = User::newFromName( $this->mOldUsername );
			$uss = new UserStatsService( $oldUser->getId() );
			$uss->resetEditCountWiki();
		}
	}

	/**
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 * Performs action for cleaning up temporary data at the very end of a process
	 */
	public function cleanup(){
		//remove phalanx user block

		if ( $this->mPhalanxBlockId ) {
			if ( !wfRunHooks( "DeletePhalanxBlock", array( $this->mPhalanxBlockId ) ) ) {
				$result = false;
			} else {
				$result = true;
			}

			if ( !$result ) {
				$this->addLog("Error removing Phalanx user block with ID {$this->mPhalanxBlockId}");
			} else {
				$this->addLog("Phalanx user block with ID {$this->mPhalanxBlockId} has been removed");
			}
		}

		if($this->mFakeUserId){
			$this->addLog("Cleaning up process data in user option renameData for ID {$this->mFakeUserId}");

			$fakeUser = User::newFromId($this->mFakeUserId);
			$fakeUser->setOption( 'renameData', self::RENAME_TAG . '=' . $this->mNewUsername);
			$fakeUser->saveSettings();
			$fakeUser->saveToCache();
		}

		//TODO: Add a hook
		$hookName = 'UserRename::Cleanup';
		$this->addLog("Broadcasting hook: {$hookName}");
		wfRunHooks($hookName, array($this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mOldUsername, $this->mNewUsername));

		$tasks = array();
		if ( isset($this->mGlobalTask) )
			$tasks[] = $this->mGlobalTask->getID();
		if ( isset($this->mLogTask) )
			$tasks[] = $this->mLogTask->getID();

		$this->addMainLog("finish", RenameUserLogFormatter::finish($this->mRequestorName, $this->mOldUsername, $this->mNewUsername, $this->mReason, $tasks));
	}

	/**
	 * Sends the internal log message to the specified destination
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function addLog( $text, $arg1 = null ) {
		if (func_num_args() > 1) {
			$args = func_get_args();
			$args = array_slice($args,1);
			$text = vsprintf($text,$args);
		}
		foreach ($this->mLogDestinations as $destinationEntry) {
			$logDestination = $destinationEntry[0];
			$logTask = $destinationEntry[1];
			switch ($logDestination) {
				case self::LOG_BATCH_TASK:
					$logTask->log($text);
					break;
				case self::LOG_OUTPUT:
					echo $text."\n";
					break;
//				case self::LOG_STANDARD:
				default:
					wfDebugLog(__CLASS__, $text);
			}
		}
	}

	/**
	 * Logs the message to main user-visible log
	 *
	 * @param $text string Log message
	 * @param $arg1 mixed Multiple format parameters
	 */
	public function addMainLog( $action, $text, $arg1 = null ) {
		/*
		 * BugId:1030
		 * Michał Roszka (Mix) <michal@wikia-inc.com>
		 *
		 * $text is HTML and may contain % which are not vsptintf's conversion specification marks,
		 * e.g. username f"oo"bar results with <a href="http://community.wikia.com/wiki/User:F%22oo%22baz">F&quot;oo&quot;baz</a>
		 * which breaks vsprintf.
		 *
		 * There are 4 calls of this method, none of them passing any vsprintf's conversion specification marks.
		 * vsprintf seems unnecessary, let's just pass $text to StaffLogger::log()

		if (func_num_args() > 1) {
			$args = func_get_args();
			$args = array_slice($args,1);
			$text = vsprintf($text,$args);
		}
		 */
		StaffLogger::log("renameuser", $action, $this->mRequestorId, $this->mRequestorName, $this->mUserId, $this->mNewUsername, $text);
	}

	/**
	 * Adds log message in Special:Log for the current wiki
	 *
	 * @param $text string Log message
	 */
	public function addLocalLog( $text ) {
		$log = new LogPage( 'renameuser' );
		$log->addEntry( 'renameuser', Title::newFromText($this->mOldUsername,NS_USER), $text, array(), User::newFromId($this->mRequestorId) );
	}

	public function setRequestorUser() {
		global $wgUser;
		$oldUser = $wgUser;

		$this->addLog("Checking for need to overwrite requestor user (id={$this->mRequestorId} name={$this->mRequestorName})");

		$userId = $wgUser->getId();
		if ( empty($userId) && !empty($this->mRequestorId) ) {
			$this->addLog("Checking if requestor exists");
			$newUser = User::newFromId($this->mRequestorId);
			if ( !empty($newUser) ) {
				$this->addLog("Overwriting requestor user");
				$wgUser = $newUser;
			}
		}

		return $oldUser;
	}

	public function invalidateUser( $user ) {
		if (is_string($user)) {
			$user = User::newFromName($user);
		} else if (!is_object($user)) {
			$this->addLog("invalidateUser() called with some strange argument type: ".gettype($user));
			return;
		}
		if (is_object($user)) {
			$user->invalidateCache();
		}
	}

	public function addInternalLog( $text ) {
		$this->mInternalLog .= $text . "\n";
	}

	public function getInternalLog() {
		return $this->mInternalLog;
	}

	/**
	* Checks self::$mLocalDefaults against the current database layout and lists fields, that no longer exist.
	*
	* @author Michał Roszka (Mix) <michal@wikia-inc.com>
	* @static
	* @access public
	* @return string
	*/
	static public function checkDatabaseLayout() {
		$oDB = wfGetDB( DB_SLAVE );
		$sOut = '';

		foreach ( self::$mLocalDefaults as $aEntry ) {
			// table.userid_column
			if ( !empty( $aEntry['userid_column'] ) && !$oDB->fieldInfo( $aEntry['table'], $aEntry['userid_column'] ) ) {
				$sOut .= sprintf( "The %s.%s column does not exist in the current database layout.\n", $aEntry['table'], $aEntry['userid_column'] );
			}
			// table.username_column
			if ( !empty( $aEntry['username_column'] ) && !$oDB->fieldInfo( $aEntry['table'], $aEntry['username_column'] ) ) {
				$sOut .= sprintf( "The %s.%s column does not exist in the current database layout.\n", $aEntry['table'], $aEntry['username_column'] );
			}
			// table.[columns in conditions]
			if ( isset( $aEntry['conds'] ) ) {
				foreach ( $aEntry['conds'] as $key => $value ) {
					if ( !$oDB->fieldInfo( $aEntry['table'], $key ) ) {
						$sOut .= sprintf( "The %s.%s column does not exist in the current database layout.\n", $aEntry['table'], $aEntry['username_column'] );
					}
				}
			}
		}

		if ( empty( $sOut ) ) {
			$sOut = 'There are no missing columns in the current database layout';
		}

		return trim( $sOut );
	}

	static public function newFromData( $data ) {
		wfProfileIn(__METHOD__);

		$o = new RenameUserProcess($data['rename_old_name'],$data['rename_new_name'],'',true);

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
			'mRenameIP' => 'rename_ip',
		);

		foreach ($mapping as $property => $key) {
			if (array_key_exists($key, $data)) {
				$o->$property = $data[$key];
			}
		}

		// Quick hack to recover requestor name from its id
		if (!empty($o->mRequestorId) && empty($o->mRequestorName)) {
			$requestor = User::newFromId($o->mRequestorId);
			$o->mRequestorName = $requestor->getName();
		}

		$o->addLog("newFromData(): Requestor id={$o->mRequestorId} name={$o->mRequestorName}");

		wfProfileOut(__METHOD__);
		return $o;
	}


	/* Static utility functions */

	/**
	 * Sanitizes entered old username
	 *
	 * @param $username string
	 * @return string
	 */
	static public function createOldUserTitle($username){
		return Title::makeTitle(NS_USER, trim(str_replace('_', ' ', $username)));
	}

	/**
	 * Sanitizes entered new username
	 *
	 * @param $username string
	 * @return string
	 */
	static public function createNewUserTitle($username){
		global $wgContLang;
		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		return Title::makeTitleSafe(NS_USER, $wgContLang->ucfirst($username));
	}
}
