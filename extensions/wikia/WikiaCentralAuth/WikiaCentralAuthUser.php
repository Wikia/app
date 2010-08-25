<?php

/*

likely construction types...

- give me the global account for this local user id
- none? give me the global account for this name

- create me a global account for this name

*/

class WikiaCentralAuthUser extends AuthPluginUser {

	/**
	 * The username of the current user.
	 */
	/*private*/ var $mName;
	/*private*/ var $mStateDirty = false;
	/*private*/ var $mVersion = 2;
	/*private*/ var $mDelayInvalidation = 0;

	static $mCacheVars = array(
		'mGlobalId',
		'mIsAttached',
		'mSalt',
		'mPassword',
		'mNewpassword',
		'mNewpassTime',
		'mToken',
		'mRealName',
		'mLocked',
		'mRegistration',
		'mEmail',
		'mEmailToken',
		'mEmailTokenExpires',
		'mEmailAuthenticated',
		'mTouched',
		'mBirthDate',
		'mEditCount',
		'mVersion',
		'mOptions',
		'mGroups',
	);

	function __construct( $username ) {
		$this->mName = $username;
		$this->resetState();
	}

	function WikiaCentralAuthUser( $oUser ) {
		$this->mName = $oUser->getName();
		$this->resetState();
	}

	/**
	 * Create a WikiaCentralAuthUser object corresponding to the suppplied User, and
	 * cache it in the User object.
	 * @param User $user
	 */
	static function getInstance( $user ) {
		if ( !isset( $user->centralAuth ) ) {
			$user->centralAuth = new self( $user->getName() );
		}
		return $user->centralAuth;
	}

	public static function getCentralDB() {
		global $wgWikiaCentralAuthDatabase;
		return wfGetDB(DB_MASTER, array(), $wgWikiaCentralAuthDatabase);
	}

	public static function getCentralSlaveDB() {
		global $wgWikiaCentralAuthDatabase;
		return wfGetDB(DB_SLAVE, array(), $wgWikiaCentralAuthDatabase);
	}

	public static function getLocalDB( ) {
		global $wgDBName;
		$db = wfGetDB(DB_MASTER);
		$db->selectDB($wgDBName);
		return $db;
	}

	public static function getLocalSlaveDB( ) {
		global $wgDBName;
		$db = wfGetDB(DB_SLAVE);
		$db->selectDB($wgDBName);
		return $db;
	}

	/**
	 * Create a WikiaCentralAuthUser object from a joined globaluser row
	 */
	public static function newFromRow( $row, $fromMaster = false ) {
		if ( !is_object( $row ) ) {
			$caUser = null;
		} else {
			$caUser = new self( $row->user_name );
			$caUser->loadFromRow( $row, $fromMaster );
		}
		return $caUser;
	}

	/**
	 * Clear state information cache
	 * Does not clear $this->mName, so the state information can be reloaded with loadState()
	 */
	protected function resetState() {
		unset( $this->mGlobalId );
		unset( $this->mGroups );
	}

	/**
	 * Load up state information, but don't use the cache
	*/
	protected function loadStateNoCache() {
		$this->loadState( true );
	}

	/*
	 * load row by name
	 */
	static function loadFromDatabaseByName($userName) {
		$dbr = self::getCentralDB();
		$oRow = $dbr->selectRow( array( '`user`' ), array( '*' ), array( 'user_name' => $userName ), __METHOD__ );
		return $oRow;
	}

	/*
	 * load row by id
	 */
	static function loadFromDatabaseById($userId) {
		$dbr = self::getCentralDB();
		$oRow = $dbr->selectRow( array( '`user`' ), array( '*' ), array( 'user_id' => $userId ), __METHOD__ );
		return $oRow;
	}

	/**
	 * Lazy-load up the most commonly required state information
	 * @param boolean $recache Force a load from the database then save back to the cache
	 */
	protected function loadState( $recache = false ) {
		if ( $recache ) {
			wfDebug( __METHOD__ . ": Reset state so take data from DB \n" );
			$this->resetState();
		} elseif ( isset( $this->mGlobalId ) ) {
			// Already loaded
			return;
		}

		wfProfileIn( __METHOD__ );

		if ( !$recache && $this->loadFromCache() ) {
			wfDebug( __METHOD__ . ": Central User data taken from cache \n" );
			wfProfileOut( __METHOD__ );
			return;
		}

		wfDebug( __METHOD__ . ": Loading state for global user {$this->mName} from DB \n" );

		// Get the master. We want to make sure we've got up to date information
		// since we're caching it.
		//---
		$oRow = self::loadFromDatabaseByName($this->mName);
		$this->loadFromRow( $oRow, true );
		$this->saveToCache();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Load user groups from the database.
	 */
	protected function loadGroups() {
		global $wgWikiaCentralUseGlobalGroups;
		if ( !$wgWikiaCentralUseGlobalGroups) {
			wfDebug( __METHOD__ . ": Don't use central user groups \n" );
			return;
		}
		
		if ( isset( $this->mGroups ) ) {
			wfDebug( __METHOD__ . ": Groups are loaded \n" );
			return;
		}
		$id = $this->getId();
		if ($id == 0) {
			wfDebug( __METHOD__ . ": Anon or invalid user \n" );
			return;
		}
		// We need the user id from the database, but this should be checked by the getId accessor.
		wfDebug( __METHOD__ . ": Loading groups for global user {$this->mName} \n" );

		$dbr = self::getCentralDB(); // We need the master.
		$oRes = $dbr->select( array( 'user_groups' ), array( 'ug_user', 'ug_group' ), array( 'ug_user' => $this->getId() ), __METHOD__ );

		// Grab the user's groups.
		$groups = array();
		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			$groups[$oRow->ug_group] = 1;
		}
		$this->mGroups = array_keys($groups);
	}

	/*
	 * check user exists in central DB
	 */
	public static function idFromUser( User $oUser ) {
		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__ . ": check User ({$oUser->getName()}) exists in central DB \n" );

		$id = 0;
		$dbr =& self::getCentralDB(); // We need the master.
		$oRow = $dbr->selectRow( '`user`', 'user_id', array( 'user_name' => $oUser->getName() ), __METHOD__ );
		if ($oRow === false) {
			$id = 0;
		} else {
			$id = $oRow->user_id;
		}

		wfProfileOut( __METHOD__ );
		return $id;
	}

	/**
	 * Load user state from a joined globaluser row
	 */
	protected function loadFromRow( $row, $fromMaster = false ) {
		global $wgCityId;
		if( $row ) {
			$this->mGlobalId = intval( $row->user_id );
			$this->mSalt = intval( $row->user_id );
			$this->mPassword = $row->user_password;
			$this->mNewpassword = $row->user_newpassword;
			$this->mNewpassTime = wfTimestampOrNull( TS_MW, $row->user_newpass_time );
			$this->mRealName = $row->user_real_name;
			$this->mToken = $row->user_token;
			$this->mLocked = false;
			$this->mRegistration = $row->user_registration;
			$this->mEmail = $row->user_email;
			$this->mEmailAuthenticated = wfTimestampOrNull( TS_MW, $row->user_email_authenticated );
			$this->mFromMaster = $fromMaster;
			$this->mTouched = $row->user_touched;
			$this->mBirthDate = $row->user_birthdate;
			$this->mEditCount = $row->user_editcount;
			$this->mEmailToken = $row->user_email_token;
			$this->mEmailTokenExpires = $row->user_email_token_expires;
			$this->mIsAttached = 1;
			$this->decodeOptions($row->user_options);
		} else {
			$this->mGlobalId = 0;
			$this->mFromMaster = $fromMaster;
			$this->mLocked = false;
			$this->mTouched = false;
			$this->mIsAttached = 0;
			$this->mEmail = '';
		}
	}

	/**
	 * Load data from memcached
	 */
	protected function loadFromCache( $cache = null, $fromMaster = false ) {
		wfProfileIn( __METHOD__ );
		if ($cache == null) {
			global $wgMemc;
			$cache = $wgMemc->get( $this->getCacheKey() );
			wfDebug( __METHOD__ . ": Load user data from cache \n" );
			$fromMaster = true;
		}

		if ( !is_array($cache) || ( isset($cache['mVersion']) && ($cache['mVersion'] < $this->mVersion) ) ) {
			// Out of date cache.
			wfDebug( __METHOD__ . ": Global User: cache miss for {$this->mName}, " .
				"version {$cache['mVersion']}, expected {$this->mVersion} \n" );
			wfProfileOut( __METHOD__ );
			return false;
		}
		$this->loadFromCacheObject( $cache, $fromMaster );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Load user state from a cached array.
	 */
	protected function loadFromCacheObject( $object, $fromMaster = false ) {
		wfDebug( __METHOD__ . ": Loading WikiaCentralAuthUser for user {$this->mName} from cache object \n" );
		foreach( self::$mCacheVars as $var ) {
			$this->$var = $object[$var];
		}
		$this->mIsAttached = $this->exists() && $this->isAttached();
		$this->mFromMaster = $fromMaster;
	}

	/**
	 * Get the object data as an array ready for caching
	 * @return Object to cache.
	 */
	protected function getCacheObject() {
		$this->loadState();
		$this->loadGroups();

		$obj = array();
		foreach( self::$mCacheVars as $var ) {
			if( isset( $this->$var ) ) {
				$obj[$var] = $this->$var;
			} else {
				$obj[$var] = null;
			}
		}

		return $obj;
	}

	/**
	 * Save cachable data to memcached.
	 */
	protected function saveToCache() {
		global $wgMemc;

		// Make sure the data is fresh
		if ( isset( $this->mGlobalId ) && !$this->mFromMaster ) {
			$this->resetState();
		}

	 	$obj = $this->getCacheObject();
	 	wfDebug( __METHOD__ . ": Saving user {$this->mName} to cache. \n" );
	 	$wgMemc->set( $this->getCacheKey(), $obj, 86400 );
	}

	/**
	 * Return the global account ID number for this account, if it exists.
	 */
	public function getId() {
		$this->loadState();
		return $this->mGlobalId;
	}

	/**
	 * Generate a valid memcached key for caching the object's data.
	 */
	protected function getCacheKey() {
		global $wgWikiaCentralAuthMemcPrefix;
		if ( isset($this->mGlobalId) ) {
			$memcKey = wfMemcKey( 'user', 'id', $this->mGlobalId );
		} else {
			$memcKey = $wgWikiaCentralAuthMemcPrefix . md5($this->mName . rand());
		}
		return $memcKey;
	}

	/**
	 * Return the global account's name, whether it exists or not.
	 */
	public function getName() {
		return $this->mName;
	}

	/**
	 * @return bool True if the account is attached on the local wiki
	 */
	public function isAttached() {
		$this->loadState();
		if ( empty($this->mIsAttached) ) {
			wfDebug ( __METHOD__ . ": User is not attached - check local db \n");
			$oUser = User::newFromName($this->mName);
			if ( isset($oUser) && ( 0 != $oUser->getId() )  ) {
				$this->mIsAttached = 1;
			}
		}
		return ( !empty($this->mIsAttached) ) ? true : false;
	}

	/**
	 * @return bool if user settings was changed.
	 */
	public function isDirty() {
		return (bool)$this->mStateDirty;
	}

	/**
	 * Return the password salt and hash.
	 * @return array( salt, hash )
	 */
	public function getPasswordHash() {
		$this->loadState();
		return array( $this->mSalt, $this->mPassword );
	}

	/**
	 * Return the global-login token for this account.
	 */
	public function getAuthToken() {
		$this->loadState();

		if (!isset( $this->mToken ) || !$this->mToken) {
			$this->resetAuthToken();
		}
		return $this->mToken;
	}

	/**
	 * Check whether a global user account for this name exists yet.
	 * If migration state is set for pass 1, this may trigger lazy
	 * evaluation of automatic migration for the account.
	 *
	 * @return bool
	 */
	public function exists() {
		$id = $this->getId();
		return $id != 0;
	}

	/**
	 * @return bool
	 */
	public function isLocked() {
		$this->loadState();
		return (bool)$this->mLocked;
	}

	/**
	 * @return string timestamp
	 */
	public function getRegistration() {
		$this->loadState();
		return wfTimestamp( TS_MW, $this->mRegistration );
	}

	/**
	 * Set this user's options from an encoded string
	 * @param $str \string Encoded options to import
	 * @private
	 */
	function decodeOptions( $str ) {
		$this->mOptions = array();
		$a = explode( "\n", $str );
		foreach ( $a as $s ) {
			$m = array();
			if ( preg_match( "/^(.[^=]*)=(.*)$/", $s, $m ) ) {
				$this->mOptions[$m[1]] = $m[2];
			}
		}
	}

	/*
	 * @return string user's options
	 */
	private function encodeOptions($options) {
		if ( is_null( $options ) ) {
			$options = User::getDefaultOptions();
		}
		$a = array();
		if (is_array($options) ) {
			foreach ( $options as $oname => $oval ) {
				array_push( $a, $oname.'='.$oval );
			}
		}
		$s = implode( "\n", $a );
		return $s;
	}

	/**
	 * Register a new, not previously existing, central user account
	 * Remaining fields are expected to be filled out shortly...
	 * eeeyuck
	 */
	function addUser( $password, $email, $realname, $options = null ) {
		#---
        if ( wfReadOnly() ) {
            return false;
        }
		#---
		$dbw = self::getCentralDB();
		#---
		list( $salt, $password ) = $this->saltedPassword( $password, $this->mGlobalId );
		#---
		$user_options = $this->encodeOptions($options);
		#---
		$seqVal = $dbw->nextSequenceValue( 'user_user_id_seq' );
		#---
		$fields = array(
			'user_id' => $seqVal,
			'user_name' => $this->mName,
			'user_password' => $password,
			'user_newpassword' => '',
			'user_email' => $email,
			'user_real_name' => $realname,
			'user_options' => $user_options,
			'user_token' => $this->getAuthToken(),
			'user_registration' => $dbw->timestamp(),
			'user_editcount' => 0,
		);

		$ok = $dbw->insert ( '`user`', $fields, __METHOD__, array('IGNORE') );

		if( $ok ) {
			wfDebug( __METHOD__ . ": registered global account '$this->mName' \n" );
		} else {
			wfDebug( __METHOD__ . ": registration failed for global account '$this->mName' \n" );
		}

		// Kill any cache entries saying we don't exist
		$this->invalidateCache();
		return $ok;
	}

	/**
	 * Add a local account record for the given wiki to the central database.
	 * @param string $wikiID
	 * @param int $localid
	 *
	 * Prerequisites:
	 * - completed migration state
	 */
	public function addToLocalDB() {
		global $wgCityId;

		$dbw = self::getLocalDB();
		$fields = array(
			'user_id' => $this->mGlobalId,
			'user_name' => $this->mName,
			'user_real_name' => $this->mRealName,
			'user_password' => $this->mPassword,
			'user_newpassword' => $this->mNewpassword,
			'user_email' => $this->mEmail,
			'user_options' => $this->encodeOptions($this->mOptions),
			'user_token' => $this->mToken,
			'user_email_authenticated' => $dbw->timestampOrNull( $this->mEmailAuthenticated ),
			'user_email_token' => $this->mEmailToken,
			'user_email_token_expires' => $this->mEmailTokenExpires,
			'user_registration' => $this->mRegistration,
			'user_newpass_time' => $dbw->timestampOrNull( $this->mNewpassTime ),
			'user_editcount' => $this->mEditCount,
			'user_birthdate' => $this->mBirthDate,
		);
		wfDebug ( __METHOD__ . ": Replace local copy of User by central data: {$fields['user_name']} \n" );

		$dbw->replace( 'user',  'user_name', $fields, __METHOD__ );

		wfDebug( __METHOD__ . ": Attaching local user {$this->mName} on {$wgCityId} \n" );
		$this->mIsAttached = 1;

		global $wgWikiaCentralAuthUDPAddress, $wgWikiaCentralAuthNew2UDPPrefix;
		if( $wgWikiaCentralAuthUDPAddress ) {
			$userpage = Title::makeTitleSafe( NS_USER, $this->mName );
			RecentChange::sendToUDP( self::getIRCLine( $userpage, $wikiID ),
				$wgWikiaCentralAuthUDPAddress, $wgWikiaCentralAuthNew2UDPPrefix );
		}
	}

	/**
	 * Generate an IRC line corresponding to user unification/creation
	 * @param Title $userpage
	 * @param string $wikiID
	 * @return string
	 */
	protected static function getIRCLine( $userpage, $wikiID ) {
		$title = RecentChange::cleanupForIRC( $userpage->getPrefixedText() );
		$wikiID = RecentChange::cleanupForIRC( $wikiID );
		// FIXME: *HACK* should be getFullURL(), hacked for SSL madness
		$url = $userpage->getInternalURL();
		$user = RecentChange::cleanupForIRC( $userpage->getText() );
		# see http://www.irssi.org/documentation/formats for some colour codes. prefix is \003,
		# no colour (\003) switches back to the term default
		$fullString = "\00314[[\00307$title\00314]]\0034@$wikiID\00310 " .
			"\00302$url\003 \0035*\003 \00303$user\003 \0035*\003\n";
		return $fullString;
	}

	/**
	 * If the user provides the correct password, would we let them log in?
	 * This encompasses checks on missing and locked accounts, at present.
	 * @return mixed: true if login available, or string status, one of: "no user", "locked"
	 */
	public function canAuthenticate() {
		if( !$this->getId() ) {
			wfDebug( __METHOD__ . ": authentication for '{$this->mName}' failed due to missing account \n" );
			return "no user";
		}

		list( $salt, $crypt ) = $this->getPasswordHash();
		$locked = $this->isLocked();

		if( $locked ) {
			wfDebug( __METHOD__ . ": authentication for '{$this->mName}' failed due to lock \n" );
			return "locked";
		}

		return true;
	}

	/**
	 * Attempt to authenticate the global user account with the given password
	 * @param string $password
	 * @return string status, one of: "ok", "no user", "locked", or "bad password".
	 * @todo Currently only the "ok" result is used (i.e. either use, or return a bool).
	 */
	public function authenticate( $password ) {
		if (($ret = $this->canAuthenticate()) !== true) {
			wfDebug ( __METHOD__ . ": Cannot authenticate user: {$this->mName} \n" );
			return $ret;
		}

		list( $salt, $crypt ) = $this->getPasswordHash();

		if( $this->matchHash( $password, $salt, $crypt ) ) {
			wfDebug( __METHOD__ . ": Authentication for '{$this->mName}' succeeded \n" );
			return "ok";
		} else {
			wfDebug( __METHOD__ . ": Authentication for '{$this->mName}' failed, bad pass \n" );
			return "bad password";
		}
	}

	/**
	 * Attempt to authenticate the global user account with the given global authtoken
	 * @param string $token
	 * @return string status, one of: "ok", "no user", "locked", or "bad token"
	 */
	public function authenticateWithToken( $token ) {
		if (($ret = $this->canAuthenticate()) !== true) {
			return $ret;
		}

		if ($this->validateAuthToken( $token ) ) {
			return "ok";
		} else {
			return "bad token";
		}
	}

	/**
	 * @param $plaintext  User-provided password plaintext.
	 * @param $salt       The hash "salt", eg a local id for migrated passwords.
	 * @param $encrypted  Fully salted and hashed database crypto text from db.
	 * @return bool true on match.
	 */
	protected function matchHash( $plaintext, $salt, $encrypted ) {
		if( User::comparePasswords( $encrypted, $plaintext, $salt ) ) {
			wfDebug( __METHOD__ . ": User::comparePasswords success \n" );
			return true;
		} elseif( function_exists( 'iconv' ) ) {
			// Some wikis were converted from ISO 8859-1 to UTF-8;
			// retained hashes may contain non-latin chars.
			$latin1 = iconv( 'UTF-8', 'WINDOWS-1252//TRANSLIT', $plaintext );
			if( User::comparePasswords( $encrypted, $latin1, $salt ) ) {
				return true;
			}
		}
		return false;
	}

	protected function matchHashes( $passwords, $salt, $encrypted ) {
		foreach( $passwords as $plaintext ) {
			if( $this->matchHash( $plaintext, $salt, $encrypted ) ) {
				return true;
			}
		}
		return false;
	}

	function setGroups( $groups = array()) {
		global $wgWikiaCentralGroups, $wgWikiaCentralUseGlobalGroups;
		if (!$wgWikiaCentralUseGlobalGroups) {
			return $groups;
		}
		$glGroups = $this->getGlobalGroups();
		if (empty($glGroups)) {
			$glGroups = array();
		}
		wfDebug( __METHOD__ . ": set local user groups (merge local (".implode(",", $groups).") and central groups (".implode(",", $glGroups).") ) \n" );
		$mergedGroups = array();
		foreach ($groups as $id => $group) {
			if (isset($wgWikiaCentralGroups) && !in_array($group, $wgWikiaCentralGroups)) {
				$mergedGroups[] = $group;
			}
		}
		$mergedGroups = array_unique(array_merge($mergedGroups, $glGroups));
		return $mergedGroups;
	}

	function getToken() {
		$this->loadState();
		return $this->mToken;
	}

	function getRealName() {
		$this->loadState();
		return $this->mRealName;
	}

	function getOptions( $useString = true ) {
		$this->loadState();
		return ($useString === true) ? $this->encodeOptions($this->mOptions) : $this->mOptions;
	}

	function getEmail() {
		$this->loadState();
		return $this->mEmail;
	}

	function getEmailAuthenticationTimestamp() {
		$this->loadState();
		return $this->mEmailAuthenticated;
	}

	function setEmail( $email ) {
		$this->loadState();
		if ( $this->mEmail !== $email ) {
			$this->mEmail = $email;
			$this->mStateDirty = true;
		}
	}

	function setEmailAuthenticationTimestamp( $ts ) {
		$this->loadState();
		if ( $this->mEmailAuthenticated !== $ts ) {
			$this->mEmailAuthenticated = $ts;
			$this->mStateDirty = true;
		}
	}

	function setOptions($str) {
		$this->loadState();
		if ( (!$this->mOptions) || $this->encodeOptions($this->mOptions) !== $str ) {
			$this->decodeOptions($str);
			$this->mStateDirty = true;
		}
	}

	function setToken($str) {
		$this->loadState();
		if ( $this->mToken !== $str ) {
			$this->mToken = $str;
			$this->mStateDirty = true;
		}
	}

	function setEmailToken($str) {
		$this->loadState();
		if ( $this->mEmailToken !== $str ) {
			$this->mEmailToken = $str;
			$this->mStateDirty = true;
		}
	}

	function setEmailTokenExpires($str) {
		$this->loadState();
		if ( $this->mEmailTokenExpires !== $str ) {
			$this->mEmailTokenExpires = $str;
			$this->mStateDirty = true;
		}
	}

	/**
	 * Salt and hash a new plaintext password.
	 * @param string $password plaintext
	 * @return array of strings, salt and hash
	 */
	protected function saltedPassword( $password, $user_id ) {
		global $wgWikiaCentralNewCryptPassword;
		$newPassword = ($wgWikiaCentralNewCryptPassword) ? User::crypt( $password ) : User::oldCrypt( $password, $user_id );
		return array( '',  $newPassword);
	}

	/**
	 * Set the account's password
	 * @param string $password plaintext
	 */
	function setPassword( $password ) {
		wfProfileIn( __METHOD__ );
        if ( wfReadOnly() ) {
            return true;
        }
		if ( is_null($password) ) {
			return true;
		}
		$user_id = $this->getId();
		list( $salt, $hash ) = $this->saltedPassword( $password, $user_id );
		$this->mPassword = $hash;
		$this->mSalt = $salt;

		$dbw = self::getCentralDB();
		$dbw->update( '`user`',
			array( 'user_password' => $this->mPassword ),
			array( 'user_id' => $user_id ),
			__METHOD__
		);

		wfDebug( __METHOD__ . ": Set global password for '$this->mName' \n" );

		// Reset the auth token.
		$this->resetAuthToken();
		$this->invalidateCache();
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get the password hash.
	 * Automatically converts to a new-style hash
	 */
	function getPassword() {
		$this->loadState();
		if ( substr( $this->mPassword, 0, 1 ) != ':' ) {
			$this->mPassword = ':B:' . $this->mSalt . ':' . $this->mPassword;
		}
		return $this->mPassword;
	}

	/**
	 * Set cookie
	 */
	static function setCookie( $name, $value, $exp=-1 ) {
		global $wgWikiaCentralAuthCookiePrefix, $wgCookieExpiration;
		global $wgRequest;

		if ($exp == -1) {
			$exp = time() + $wgCookieExpiration;
		} elseif ( $exp == 0 ) {
			// Don't treat as a relative expiry.
			//  They want a session cookie.
		} elseif ( $exp < 3.16e7 ) {
			// Relative expiry
			$exp += time();
		}
		$wgRequest->response()->setcookie( $wgWikiaCentralAuthCookiePrefix . $name, $value, $exp );
	}

	/**
	 * Clear cookie
	 */
	protected function clearCookie( $name ) {
		self::setCookie( $name, '', -86400 );
	}

	/**
	 * Set a global cookie that auto-authenticates the user on other wikis
	 * Called on login.
	 * @return Session ID
	 */
	function setGlobalCookies(&$session, $remember = false) {
		if (is_object($remember)) {
			// Older code passed a user object here. Be kind and do what they meant to do.
			$remember = $remember->getOption('rememberpassword');
		}

		if ( empty($session) ) {
			$session = array();
		}
		$exp = time() + 86400;

		$session['wsAuthUser'] = $this->mName;
		self::setCookie( 'UserName', $this->mName );
		self::setCookie( 'UserID', $this->mGlobalId );
		$session['wsAuthToken'] = $this->getAuthToken();
		$session['wsAuthExpiry'] = $exp;

		if ($remember) {
			self::setCookie( 'Token', $this->getAuthToken() );
		} else {
			$this->clearCookie( 'Token' );
		}
		return self::setSession( $session );
	}

	/**
	 * Delete global cookies which auto-authenticate the user on other wikis.
	 * Called on logout.
	 */
	function deleteGlobalCookies() {
		global $wgWikiaCentralAuthCookiePrefix;

		$this->clearCookie( 'UserID' );
		$this->clearCookie( 'UserName' );
		$this->clearCookie( 'Token' );
		$this->clearCookie( 'Session' );

		// Logged-out cookie -to fix caching.
		self::setCookie( 'LoggedOut', wfTimestampNow() );

		self::deleteSession();
	}

	/**
	 * Check a global auth token against the one we know of in the database.
	 */
	function validateAuthToken( $token ) {
		return ($token == $this->getAuthToken());
	}

	/**
	 * Generate a new random auth token, and store it in the database.
	 * Should be called as often as possible, to the extent that it will
	 * not randomly log users out (so on logout, as is done currently, is a good time).
	 */
	function resetAuthToken( $token = false) {
		// Generate a random token.
		if ( !$token ) {
			$this->mToken = wfGenerateToken( $this->getId() );
		} else {
			$this->mToken = $token;
		}
		$this->mStateDirty = true;

		// Save it.
		$this->saveSettings();
	}

	function saveSettings() {
		wfDebug( __METHOD__ . ": Save Central User settings \n" );
		if ( !$this->mStateDirty ) {
			return;
		}
		$this->mStateDirty = false;

		if ( wfReadOnly() ) {
			return;
		}

		$this->loadState();
		if ( !$this->mGlobalId ) {
			return;
		}

		$this->mTouched = User::newTouchedTimestamp();
		wfDebug( __METHOD__ . ": Update User settings in database \n" );
		$dbw = self::getCentralDB();
		$dbw->update( '`user`',
			array( # SET
				'user_name' => $this->mName,
				'user_password' => $this->mPassword,
				'user_newpassword' => $this->mNewpassword,
				'user_newpass_time' => $dbw->timestampOrNull( $this->mNewpassTime ),
				'user_real_name' => $this->mRealName,
		 		'user_email' => $this->mEmail,
		 		'user_email_authenticated' => $dbw->timestampOrNull( $this->mEmailAuthenticated ),
				'user_options' => $this->encodeOptions($this->mOptions),
				'user_touched' => $dbw->timestamp($this->mTouched),
				'user_token' => $this->mToken,
				'user_email_token' => $this->mEmailToken,
				'user_email_token_expires' => $dbw->timestampOrNull( $this->mEmailTokenExpires ),
			),
			array( # WHERE
				'user_id' => $this->mGlobalId
			),
			__METHOD__
		);

		if( isset( $_GET['action'] ) && $_GET['action'] == 'ajax' ) {
                        $dbw->commit();
                }

		$this->invalidateCache();
	}

	function getGlobalGroups() {
		$this->loadGroups();

		return $this->mGroups;
	}

	function removeFromGlobalGroups( $groups ) {
		global $wgWikiaCentralUseGlobalGroups;
		if ( !$wgWikiaCentralUseGlobalGroups ) {
			wfDebug( __METHOD__ . ": Don't use central user groups \n" );
			return;
		}
		if ( !empty($groups) ) {
			$dbw = self::getCentralDB();
			$dbw->delete(
				'user_groups',
				array(
					'ug_user' => $this->getId(),
					'ug_group' => $groups
				),
				__METHOD__
			);
			$this->invalidateCache();
		}
	}

	function addToGlobalGroups( $groups ) {
		global $wgWikiaCentralUseGlobalGroups;

        if ( wfReadOnly() ) {
            return;
        }
		
		if ( !$wgWikiaCentralUseGlobalGroups ) {
			wfDebug( __METHOD__ . ": Don't use central user groups \n" );
			return;
		}

		$dbw = self::getCentralDB();

		if ( !is_array($groups) ) {
			$groups = array($groups);
		}

		$insert_rows = array();
		foreach( $groups as $group ) {
			$insert_rows[] = array( 'ug_user' => $this->getId(), 'ug_group' => $group );
		}

		# Replace into the DB
		$dbw->replace( 'user_groups', array( 'ug_user', 'ug_group' ), $insert_rows, __METHOD__ );

		$this->invalidateCache();
	}

	public function invalidateCache() {
		if (!$this->mDelayInvalidation) {
			wfDebug( __METHOD__ . ": Updating cache for global user {$this->mName} \n" );

			// Reload the state
			$this->loadStateNoCache();

			// Overwrite the cache.
			$this->saveToCache();
		} else {
			wfDebug( __METHOD__ . ": Deferring cache invalidation because we're in a transaction \n" );
		}
	}

	/**
	 * For when speed is of the essence (e.g. when batch-purging users after rights changes)
	 */
	public function quickInvalidateCache() {
		global $wgMemc;
		wfDebug( __METHOD__ . ": Quick cache invalidation for global user {$this->mName} \n" );
		$wgMemc->delete( $this->getCacheKey() );
	}

	/**
	 * End a "transaction".
	 * A transaction delays cache invalidation until after
	 * some operation which would otherwise repeatedly do so.
	 * Intended to be used for things like migration.
	 */
	public function endTransaction() {
		wfDebug( __METHOD__ . ": Finishing WikiaCentralAuthUser cache-invalidating transaction \n" );
		$this->mDelayInvalidation = false;
		$this->invalidateCache();
	}

	/**
	 * Start a "transaction".
	 * A transaction delays cache invalidation until after
	 * some operation which would otherwise repeatedly do so.
	 * Intended to be used for things like migration.
	 */
	public function startTransaction() {
		wfDebug( __METHOD__ . ": Beginning WikiaCentralAuthUser cache-invalidating transaction \n" );
		// Delay cache invalidation
		$this->mDelayInvalidation = true;
	}

	static function memcKey( /*...*/ ) {
		global $wgWikiaCentralAuthDatabase;
		$args = func_get_args();
		return $wgWikiaCentralAuthDatabase . ':' . implode( ':', $args );
	}

	/**
	 * Get the central session data
	 */
	static function getSession() {
		global $wgWikiaCentralAuthCookies, $wgWikiaCentralAuthCookiePrefix;
		global $wgMemc;
		if ( !$wgWikiaCentralAuthCookies ) {
			return array();
		}
		if ( !isset( $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'] ) ) {
			return array();
		}
		$id =  $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'];
		$key = self::memcKey( 'session', $id );
		$data = $wgMemc->get( $key );
		if ( $data === false || $data === null ) {
			return array();
		} else {
			return $data;
		}
	}

	/**
	 * Set the central session data
	 * @return ID
	 */
	static function setSession( $data ) {
		global $wgWikiaCentralAuthCookies, $wgWikiaCentralAuthCookiePrefix;
		global $wgMemc;
		if ( !$wgWikiaCentralAuthCookies ) {
			return;
		}
		if ( !isset( $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'] ) ) {
			$id = wfGenerateToken();
			self::setCookie( 'Session', $id, 0 );
		} else {
			$id =  $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'];
		}
		$key = self::memcKey( 'session', $id );
		$wgMemc->set( $key, $data, 86400 );
		return $id;
	}

	/**
	 * Delete the central session data
	 */
	static function deleteSession() {
		global $wgWikiaCentralAuthCookies, $wgWikiaCentralAuthCookiePrefix;
		global $wgMemc;

		if (isset($_SESSION['wsUserID']) ) {
			$_SESSION['wsUserID'] = 0;
			unset($_SESSION['wsUserID']);
		}

		if (isset($_SESSION['wsUserName']) ) {
			unset($_SESSION['wsUserName']);
		}

		if ( !$wgWikiaCentralAuthCookies ) {
			return;
		}
		if ( !isset( $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'] ) ) {
			return;
		}
		$id =  $_COOKIE[$wgWikiaCentralAuthCookiePrefix . 'Session'];
		wfDebug( __METHOD__ . ": Deleting session $id \n" );
		$key = self::memcKey( 'session', $id );
		$wgMemc->delete( $key );
	}

	/**
	 * Copy Central User values of variables to the wgUser object
	 */
	function invalidateLocalUser( User &$oUser, $useId = false ) {
		wfDebug( __METHOD__ . ": Update wgUser values with Central User: {$this->mName} data \n" );
		#--- load data from local cache

		foreach( self::$mCacheVars as $var ) {
			if ( !in_array($var, array('mOptions','mGroups') ) ) {
				$oUser->$var = $this->$var;
			}
		}
		#--- don't load data from local cache
		$oUser->mDataLoaded = true;
		$oUser->mId = $this->getId();
		$oUser->setName($this->mName);
		$oUser->decodeOptions($this->getOptions());
		$oUser->mGroups = $this->setGroups($oUser->mGroups);
		$oUser->mDataLoaded = true;
	}

	/**
	 * Copy wgUser values of variables to the Central User object
	 */
	function invalidateCentralUser( User &$oUser ) {
		wfDebug( __METHOD__ . ": Update Central User data with wgUser values ({$oUser->getName()}) \n" );
		foreach( self::$mCacheVars as $var ) {
			if ( !in_array($var, array('mOptions','mGroups') ) ) {
				if ( isset($oUser->$var) ) {
					$this->$var = $oUser->$var;
					$this->mStateDirty = true;
				}
			}
		}
		$this->mName = $oUser->getName();
		$this->setOptions( $oUser->encodeOptions() );
	}

	/*
	 * check local user token
	 */
	function authenticateLocalUserToken ($token, &$from) {
		global $wgCookiePrefix;

		$passwordCorrect = false;
		if ( isset( $_SESSION['wsToken'] ) ) {
			$passwordCorrect = $_SESSION['wsToken'] == $token;
			$from = 'session';
		} else if ( isset( $_COOKIE["{$wgCookiePrefix}Token"] ) ) {
			$passwordCorrect = $token == $_COOKIE["{$wgCookiePrefix}Token"];
			$from = 'cookie';
		} else {
			$from = '';
		}
		return $passwordCorrect;
	}

	/*
	 * check local user name from DB_MASTER 
	 */
	function idFromName() {
		$dbr = self::getLocalDB();
		$s = $dbr->selectRow( 'user', $what, $where, __METHOD__ );
		if ( $s === false ) {
			$id = 0;
		} else {
			$id = $s->user_id;
		}	
		return $id;
	}

}
