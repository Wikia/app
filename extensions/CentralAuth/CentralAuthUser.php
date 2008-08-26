<?php

/*

likely construction types...

- give me the global account for this local user id
- none? give me the global account for this name

- create me a global account for this name

*/

class CentralAuthUser {

	/**
	 * The username of the current user.
	 */
	/*private*/ var $mName;
	/*private*/ var $mStateDirty = false;
	/*private*/ var $mVersion = 1;
	/*private*/ var $mDelayInvalidation = 0;
	
	static $mCacheVars = array(
		'mGlobalId',
		'mSalt',
		'mPassword',
		'mAuthToken',
		'mLocked',
		'mHidden',
		'mRegistration',
		'mEmail',
		'mAuthenticationTimestamp',
		'mGroups',
		'mRights',

		# Store the string list instead of the array, to save memory, and 
		# avoid unserialize() overhead
		'mAttachedList',

		'mVersion',
	);

	function __construct( $username ) {
		$this->mName = $username;
		$this->resetState();
	}

	/**
	 * Create a CentralAuthUser object corresponding to the suppplied User, and
	 * cache it in the User object.
	 * @param User $user
	 */
	static function getInstance( $user ) {
		if ( !isset( $user->centralAuthObj ) ) {
			$user->centralAuthObj = new self( $user->getName() );
		}
		return $user->centralAuthObj;
	}

	public static function getCentralDB() {
		global $wgCentralAuthDatabase;
		return wfGetLB( $wgCentralAuthDatabase )->getConnection( DB_MASTER, array(), 
			$wgCentralAuthDatabase );
	}

	public static function getCentralSlaveDB() {
		global $wgCentralAuthDatabase;
		return wfGetLB( $wgCentralAuthDatabase )->getConnection( DB_SLAVE, 'centralauth', 
			$wgCentralAuthDatabase );
	}

	public static function getLocalDB( $wikiID ) {
		return wfGetLB( $wikiID )->getConnection( DB_MASTER, array(), $wikiID );
	}

	/**
	 * Create a CentralAuthUser object from a joined globaluser/localuser row
	 */
	public static function newFromRow( $row, $fromMaster = false ) {
		$caUser = new self( $row->gu_name );
		$caUser->loadFromRow( $row, $fromMaster );
		return $caUser;
	}

	/**
	 * Clear state information cache
	 * Does not clear $this->mName, so the state information can be reloaded with loadState()
	 */
	protected function resetState() {
		unset( $this->mGlobalId );
		unset( $this->mProperties );
		unset( $this->mGroups );
		unset( $this->mAttachedArray );
		unset( $this->mAttachedList );
	}
	
	/**
	 * Load up state information, but don't use the cache
	*/
	protected function loadStateNoCache() { 
		$this->loadState( true ); 
	}

	/**
	 * Lazy-load up the most commonly required state information
	 * @param boolean $recache Force a load from the database then save back to the cache
	 */
	protected function loadState( $recache = false ) {
		if ( $recache ) {
			$this->resetState();
		} elseif ( isset( $this->mGlobalId ) ) {
			// Already loaded
			return;
		}

		wfProfileIn( __METHOD__ );
		// Check the cache
		if ( !$recache && $this->loadFromCache() ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		
		wfDebugLog( 'CentralAuth', "Loading state for global user {$this->mName} from DB" );
		
		// Get the master. We want to make sure we've got up to date information
		// since we're caching it.
		$dbr = self::getCentralDB();
		$globaluser = $dbr->tableName( 'globaluser' );
		$localuser = $dbr->tableName( 'localuser' );

		$sql =
			"SELECT gu_id, lu_wiki, gu_salt, gu_password,gu_auth_token, " .
				"gu_locked,gu_hidden,gu_registration,gu_email,gu_email_authenticated " .
			"FROM $globaluser " .
			"LEFT OUTER JOIN $localuser ON gu_name=lu_name AND lu_wiki=? " .
			"WHERE gu_name=?";
		$result = $dbr->safeQuery( $sql, wfWikiID(), $this->mName );
		$row = $dbr->fetchObject( $result );
		$dbr->freeResult( $result );
		
		$this->loadFromRow( $row, true );
		$this->saveToCache();
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * Load user groups and rights from the database.
	 */
	protected function loadGroups() {
		if ( isset( $this->mGroups ) ) {
			// Already loaded
			return;
		}
		// We need the user id from the database, but this should be checked by the getId accessor.
		
		wfDebugLog( 'CentralAuth', "Loading groups for global user {$this->mName}" );
		
		$dbr = self::getCentralDB(); // We need the master.
		
		$res = $dbr->select( 
			array( 'global_group_permissions', 'global_user_groups' ),
			array( 'ggp_permission', 'ggp_group' ), 
			array( 'ggp_group=gug_group', 'gug_user' => $this->getId() ), 
			__METHOD__ );
		
		// Grab the user's rights/groups.
		$rights = array();
		$groups = array();
		
		while ($row = $dbr->fetchObject( $res ) ) {
			$rights[] = $row->ggp_permission;
			$groups[$row->ggp_group] = 1;
		}
		
		$this->mRights = $rights;
		$this->mGroups = array_keys($groups);
	}

	/**
	 * Load user state from a joined globaluser/localuser row
	 */
	protected function loadFromRow( $row, $fromMaster = false ) {
		if( $row ) {
			$this->mGlobalId = intval( $row->gu_id );
			$this->mIsAttached = ($row->lu_wiki !== null);
			$this->mSalt = $row->gu_salt;
			$this->mPassword = $row->gu_password;
			$this->mAuthToken = $row->gu_auth_token;
			$this->mLocked = $row->gu_locked;
			$this->mHidden = $row->gu_hidden;
			$this->mRegistration = wfTimestamp( TS_MW, $row->gu_registration );
			$this->mEmail = $row->gu_email;
			$this->mAuthenticationTimestamp =
				wfTimestampOrNull( TS_MW, $row->gu_email_authenticated );
			$this->mFromMaster = $fromMaster;
		} else {
			$this->mGlobalId = 0;
			$this->mIsAttached = false;
			$this->mFromMaster = $fromMaster;
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
			$fromMaster = true;
		}
		
		if (!is_array($cache) || $cache['mVersion'] < $this->mVersion ) {
			// Out of date cache.
			wfDebugLog( 'CentralAuth', "Global User: cache miss for {$this->mName}, " . 
				"version {$cache['mVersion']}, expected {$this->mVersion}" );
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
		wfDebugLog( 'CentralAuth', "Loading CentralAuthUser for user {$this->mName} from cache object" );
		foreach( self::$mCacheVars as $var ) {
			$this->$var = $object[$var];
		}
		
		$this->loadAttached();
		
		$this->mIsAttached = $this->exists() && in_array( wfWikiID(), $this->mAttachedArray );
		$this->mFromMaster = $fromMaster;
	}
	
	/**
	 * Get the object data as an array ready for caching
	 * @return Object to cache.
	 */
	protected function getCacheObject() {
		$this->loadState();
		$this->loadAttached();
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
	 	wfDebugLog( 'CentralAuth', "Saving user {$this->mName} to cache." );
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
		return "centralauth-user-".md5($this->mName);
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
		return $this->mIsAttached;
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
		
		if (!isset( $this->mAuthToken ) || !$this->mAuthToken) {
			$this->resetAuthToken();
		}
		return $this->mAuthToken;
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
	 * @return bool	
	 */
	public function isHidden() {
		$this->loadState();
		return (bool)$this->mHidden;
	}

	/**
	 * @return string timestamp
	 */
	public function getRegistration() {
		$this->loadState();
		return wfTimestamp( TS_MW, $this->mRegistration );
	}

	/**
	 * Register a new, not previously existing, central user account
	 * Remaining fields are expected to be filled out shortly...
	 * eeeyuck
	 */
	function register( $password, $email, $realname ) {
		$dbw = self::getCentralDB();
		list( $salt, $hash ) = $this->saltedPassword( $password );
		$ok = $dbw->insert(
			'globaluser',
			array(
				'gu_name'  => $this->mName,

				'gu_email' => $email,
				'gu_email_authenticated' => null,

				'gu_salt'     => $salt,
				'gu_password' => $hash,

				'gu_locked' => 0,
				'gu_hidden' => 0,

				'gu_registration' => $dbw->timestamp(),
			),
			__METHOD__ );

		if( $ok ) {
			wfDebugLog( 'CentralAuth',
				"registered global account '$this->mName'" );
		} else {
			wfDebugLog( 'CentralAuth',
				"registration failed for global account '$this->mName'" );
		}
		
		// Kill any cache entries saying we don't exist
		$this->invalidateCache();
		return $ok;
	}

	/**
	 * For use in migration pass zero.
	 * Store local user data into the auth server's migration table.
	 * @param string $wiki Source wiki ID
	 * @param array $users Associative array of ids => names
	 */
	static function storeMigrationData( $wiki, $users ) {
		if( $users ) {
			$dbw = self::getCentralDB();
			$globalTuples = array();
			$tuples = array();
			foreach( $users as $name ) {
				$globalTuples[] = array( 'gn_name' => $name );
				$tuples[] = array(
					'ln_wiki' => $wiki,
					'ln_name' => $name
				);
			}
			$dbw->insert(
				'globalnames',
				$globalTuples,
				__METHOD__,
				array( 'IGNORE' ) );
			$dbw->insert(
				'localnames',
				$tuples,
				__METHOD__,
				array( 'IGNORE' ) );
		}
	}

	/**
	 * Store global user data in the auth server's main table.
	 * @return bool Whether we were successful or not.
	 */
	protected function storeGlobalData( $salt, $hash, $email, $emailAuth ) {
		$dbw = self::getCentralDB();
		$dbw->insert( 'globaluser',
			array(
				'gu_name' => $this->mName,
				'gu_salt' => $salt,
				'gu_password' => $hash,
				'gu_email' => $email,
				'gu_email_authenticated' => $dbw->timestampOrNull( $emailAuth ),
				'gu_registration' => $dbw->timestamp(), // hmmmm
			),
			__METHOD__,
			array( 'IGNORE' ) );

		$this->resetState();
		return $dbw->affectedRows() != 0;
	}

	public function storeAndMigrate( $passwords=array() ) {
		$dbw = self::getCentralDB();
		$dbw->begin();

		$ret = $this->attemptAutoMigration( $passwords );

		$dbw->commit();
		return $ret;
	}

	/**
	 * Out of the given set of local account data, pick which will be the
	 * initially-assigned home wiki.
	 *
	 * This will be the account with the highest edit count, either out of
	 * all privileged accounts or all accounts if none are privileged.
	 *
	 * @param array $migrationSet
	 * @return string
	 */
	function chooseHomeWiki( $migrationSet ) {
		if( empty( $migrationSet ) ) {
			throw new MWException( 'Logic error -- empty migration set in chooseHomeWiki' );
		}

		// Sysops get priority
		$priorityGroups = array( 'sysop', 'bureaucrat', 'steward' );
		$workingSet = array();
		foreach( $migrationSet as $wiki => $local ) {
			if( array_intersect( $priorityGroups, $local['groups'] ) ) {
				if( $local['editCount'] ) {
					// Ignore unused sysop accounts
					$workingSet[$wiki] = $local;
				}
			}
		}

		if( !$workingSet ) {
			// No privileged accounts; look among the plebes...
			$workingSet = $migrationSet;
		}

		$maxEdits = -1;
		$homeWiki = null;
		foreach( $workingSet as $wiki => $local ) {
			if( $local['editCount'] > $maxEdits ) {
				$homeWiki = $wiki;
				$maxEdits = $local['editCount'];
			}
		}

		if( !isset( $homeWiki ) ) {
			throw new MWException( "Logic error in migration: " .
				"Unable to determine primary account for $this->mName" );
		}

		return $homeWiki;
	}

	/**
	 * Go through a list of migration data looking for those which
	 * can be automatically migrated based on the available criteria.
	 * @param array $migrationSet
	 * @param string $passwords Optional, pre-authenticated passwords.
	 *                          Should match an account which is known
	 *                          to be attached.
	 */
	function prepareMigration( $migrationSet, $passwords=array() ) {
		// If the primary account has an e-mail address set,
		// we can use it to match other accounts. If it doesn't,
		// we can't be sure that the other accounts with no mail
		// are the same person, so err on the side of caution.
		//
		// For additional safety, we'll only let the mail check
		// propagate from a confirmed account
		$passingMail = array();
		if( $this->mEmail != '' && $this->mEmailAuthenticated ) {
			$passingMail[$this->mEmail] = true;
		}

		// If we've got an authenticated password to work with, we can
		// also assume their e-mails are useful for this purpose...
		if( $passwords ) {
			foreach( $migrationSet as $wiki => $local ) {
				if( $local['email'] != ''
					&& $local['emailAuthenticated']
					&& $this->matchHashes( $passwords, $local['id'], $local['password'] ) ) {
					$passingMail[$local['email']] = true;
				}
			}
		}

		$attach = array();
		foreach( $migrationSet as $wiki => $local ) {
			$localName = "$this->mName@$wiki";
			if( $wiki == $this->mHomeWiki ) {
				// Primary account holder... duh
				$method = 'primary';
			} elseif( $this->matchHashes( $passwords, $local['id'], $local['password'] ) ) {
				// Matches the pre-authenticated password, yay!
				$method = 'password';
			} elseif( $local['emailAuthenticated'] && isset( $passingMail[$local['email']] ) ) {
				// Same e-mail as primary means we know they could
				// reset their password, so we give them the account.
				// Authenticated email addresses only to prevent merges with malicious users
				$method = 'mail';
			} else {
				// Can't automatically resolve this account.
				//
				// If the password matches, it will be automigrated
				// at next login. If no match, user will have to input
				// the conflicting password or deal with the conflict.
				wfDebugLog( 'CentralAuth', "unresolvable $localName" );
				continue;
			}
			wfDebugLog( 'CentralAuth', "$method $localName" );
			$attach[$wiki] = $method;
		}

		return $attach;
	}

	/**
	 * Do a dry run -- pick a winning master account and try to auto-merge
	 * as many as possible, but don't perform any actions yet.
	 *
	 * @param array $passwords
	 * @param string &$home set to false if no permission to do checks
	 * @param array &$attached on success, list of wikis which will be auto-attached
	 * @param array &$unattached on success, list of wikis which won't be auto-attached
	 * @param array &$methods on success, associative array of each wiki's attachment method
	 * @param array &$blocked true if the home wiki is blocked
	 * 
	 * @return Status object
	 */
	function migrationDryRun( $passwords, &$home, &$attached, &$unattached, &$methods ) {
		$home = false;
		$attached = array();
		$unattached = array();

		// First, make sure we were given the current wiki's password.
		$self = $this->localUserData( wfWikiID() );
		if( !$this->matchHashes( $passwords, $self['id'], $self['password'] ) ) {
			wfDebugLog( 'CentralAuth', "dry run: failed self-password check" );
			return Status::newFatal( 'wrongpassword' );
		}

		$migrationSet = $this->queryUnattached();
		if( empty( $migrationSet ) ) {
			wfDebugLog( 'CentralAuth', 'dry run: no accounts to merge, failed migration' );
			return Status::newFatal( 'centralauth-merge-no-accounts' );
		}
		$home = $this->chooseHomeWiki( $migrationSet );
		$local = $migrationSet[$home];

		// If home account is blocked...
		if( $local['blocked'] ) {
			wfDebugLog( 'CentralAuth', "dry run: $home blocked, forbid migration" );
			return Status::newFatal( 'centralauth-blocked-text' );
		}

		// And we need to match the home wiki before proceeding...
		if( $this->matchHashes( $passwords, $local['id'], $local['password'] ) ) {
			wfDebugLog( 'CentralAuth', "dry run: passed password match to home $home" );
		} else {
			wfDebugLog( 'CentralAuth', "dry run: failed password match to home $home" );
			return Status::newFatal( 'centralauth-merge-home-password' );
		}

		$this->mHomeWiki = $home;
		$this->mEmail = $local['email'];
		$this->mEmailAuthenticated = $local['emailAuthenticated'];
		$attach = $this->prepareMigration( $migrationSet, $passwords );

		$all = array_keys( $migrationSet );
		$attached = array_keys( $attach );
		$unattached = array_diff( $all, $attached );
		$methods = $attach;

		sort( $attached );
		sort( $unattached );
		ksort( $methods );

		return Status::newGood();
	}

	/**
	 * Pick a winning master account and try to auto-merge as many as possible.
	 * @fixme add some locking or something
	 * @return bool Whether full automatic migration completed successfully.
	 */
	protected function attemptAutoMigration( $passwords=array() ) {
		$migrationSet = $this->queryUnattached();
		if( empty( $migrationSet ) ) {
			wfDebugLog( 'CentralAuth', 'no accounts to merge, failed migration' );
			return false;
		}


		$this->mHomeWiki = $this->chooseHomeWiki( $migrationSet );
		$home = $migrationSet[$this->mHomeWiki];
		$this->mEmail = $home['email'];
		$this->mEmailAuthenticated = $home['emailAuthenticated'];

		if ( $home['blocked'] ) {
			wfDebugLog( 'CentralAuth', $this->mHomeWiki . ' blocked, forbid migration' );
			return false;
		}

		$attach = $this->prepareMigration( $migrationSet, $passwords );

		$ok = $this->storeGlobalData(
				$home['id'],
				$home['password'],
				$home['email'],
				$home['emailAuthenticated'] );

		if( !$ok ) {
			wfDebugLog( 'CentralAuth',
				"attemptedAutoMigration for existing entry '$this->mName'" );
			return false;
		}

		if( count( $attach ) < count( $migrationSet ) ) {
			wfDebugLog( 'CentralAuth',
				"Incomplete migration for '$this->mName'" );
		} else {
			if( count( $migrationSet ) == 1 ) {
				wfDebugLog( 'CentralAuth',
					"Singleton migration for '$this->mName' on " . $this->mHomeWiki );
			} else {
				wfDebugLog( 'CentralAuth',
					"Full automatic migration for '$this->mName'" );
			}
		}
		
		// Don't purge the cache 50 times.
		$this->startTransaction();

		foreach( $attach as $wiki => $method ) {
			$this->attach( $wiki, $method );
		}
		
		$this->endTransaction();

		return count( $attach ) == count( $migrationSet );
	}

	/**
	 * Attempt to migrate any remaining unattached accounts by virtue of
	 * the password check.
	 *
	 * @param string $password plaintext password to try matching
	 * @param $migrated out array of wiki IDs for records which were
	 *                  successfully migrated by this operation
	 * @param $remaining out array of wiki IDs for records which are still
	 *                   unattached after the operation
	 * @return bool true if all accounts are migrated at the end
	 */
	public function attemptPasswordMigration( $password, &$migrated=null, &$remaining=null ) {
		$rows = $this->queryUnattached();

		if( count( $rows ) == 0 ) {
			wfDebugLog( 'CentralAuth',
				"Already fully migrated user '$this->mName'" );
			return true;
		}

		$migrated = array();
		$remaining = array();

		// Don't invalidate the cache 50 times
		$this->startTransaction();

		// Look for accounts we can match by password
		foreach( $rows as $row ) {
			$wiki = $row['wiki'];
			if( $this->matchHash( $password, $row['id'], $row['password'] ) ) {
				wfDebugLog( 'CentralAuth',
					"Attaching '$this->mName' on $wiki by password" );
				$this->attach( $wiki, 'password' );
				$migrated[] = $wiki;
			} else {
				wfDebugLog( 'CentralAuth',
					"No password match for '$this->mName' on $wiki" );
				$remaining[] = $wiki;
			}
		}
		
		$this->endTransaction();

		if( count( $remaining ) == 0 ) {
			wfDebugLog( 'CentralAuth',
				"Successfull auto migration for '$this->mName'" );
			return true;
		}

		wfDebugLog( 'CentralAuth',
			"Incomplete migration for '$this->mName'" );
		return false;
	}

	protected static function validateList( $list ) {
		$unique = array_unique( $list );
		$valid = array_intersect( $unique, self::getWikiList() );

		if( count( $valid ) != count( $list ) ) {
			// fixme: handle this gracefully
			throw new MWException( "Invalid input" );
		}

		return $valid;
	}

	public static function getWikiList() {
		global $wgLocalDatabases;
		static $wikiList;
		if ( is_null( $wikiList ) ) {
			wfRunHooks( 'CentralAuthWikiList', array( &$wikiList ) );
			if ( is_null( $wikiList ) ) {
				$wikiList = $wgLocalDatabases;
			}
		}
		return $wikiList;
	}

	/**
	 * Unattach a list of local accounts from the global account
	 * @param array $list List of wiki names
	 * @return Status
	 */
	public function adminUnattach( $list ) {
		global $wgMemc;
		if ( !count( $list ) ) {
			return Status::newFatal( 'centralauth-admin-none-selected' );
		}
		$status = new Status;
		$valid = $this->validateList( $list );
		$invalid = array_diff( $list, $valid );
		foreach ( $invalid as $wikiName ) {
			$status->error( 'centralauth-invalid-wiki', $wikiName );
			$status->failCount++;
		}
		
		$invalidCount = count( $list ) - count( $valid );
		$missingCount = 0;
		$dbcw = self::getCentralDB();
		$password = $this->getPassword();

		foreach ( $valid as $wikiName ) {
			# Delete the user from the central localuser table
			$dbcw->delete( 'localuser',
				array(
					'lu_name'   => $this->mName,
					'lu_wiki' => $wikiName ),
				__METHOD__ );
			if ( !$dbcw->affectedRows() ) {
				$wiki = WikiMap::getWiki( $wikiName );
				$status->error( 'centralauth-admin-already-unmerged', $wiki->getDisplayName() );
				$status->failCount++;
				continue;
			}

			# Touch the local user row, update the password
			$lb = wfGetLB( $wikiName );
			$dblw = $lb->getConnection( DB_MASTER, array(), $wikiName );
			$dblw->update( 'user', 
				array( 
					'user_touched' => wfTimestampNow(), 
					'user_password' => $password
				), array( 'user_name' => $this->mName ), __METHOD__ 
			);
			$id = $dblw->selectField( 'user', 'user_id', array( 'user_name' => $this->mName ), __METHOD__ );
			$wgMemc->delete( "$wikiName:user:id:$id" );

			$lb->reuseConnection( $dblw );

			$status->successCount++;
		}

		if( in_array( wfWikiID(), $valid ) ) {
			$this->resetState();
		}
		
		$this->invalidateCache();

		return $status;
	}

	/**
	 * Delete a global account
	 */
	function adminDelete() {
		global $wgMemc;
		wfDebugLog( 'CentralAuth', "Deleting global account for user {$this->mName}" );
		$centralDB = self::getCentralDB();

		# Synchronise passwords
		$password = $this->getPassword();
		$localUserRes = $centralDB->select( 'localuser', '*', 
			array( 'lu_name' => $this->mName ), __METHOD__ );
		$name = $this->getName();
		foreach ( $localUserRes as $localUserRow ) {
			$wiki = $localUserRow->lu_wiki;
			wfDebug( __METHOD__.": Fixing password on $wiki\n" );
			$lb = wfGetLB( $wiki );
			$localDB = $lb->getConnection( DB_MASTER, array(), $wiki );
			$localDB->update( 'user', 
				array( 'user_password' => $password ),
				array( 'user_name' => $name ),
				__METHOD__
			);
			$id = $localDB->selectField( 'user', 'user_id', array( 'user_name' => $this->mName ), __METHOD__ );
			$wgMemc->delete( "$wiki:user:id:$id" );
			$lb->reuseConnection( $localDB );
		}

		$centralDB->begin();
		# Delete and lock the globaluser row
		$centralDB->delete( 'globaluser', array( 'gu_name' => $this->mName ), __METHOD__ );
		if ( !$centralDB->affectedRows() ) {
			$centralDB->commit();
			return Status::newFatal( 'centralauth-admin-delete-nonexistent', $this->mName );
		}
		# Delete the localuser rows
		$centralDB->delete( 'localuser', array( 'lu_name' => $this->mName ), __METHOD__ );
		$centralDB->commit();
		
		$this->invalidateCache();
		
		return Status::newGood();
	}

	/**
	 * Lock a global account
	 */
	function adminLock() {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$dbw->update( 'globaluser', array( 'gu_locked' => 1 ),
			array( 'gu_name' => $this->mName ), __METHOD__ );
		if ( !$dbw->affectedRows() ) {
			$dbw->commit();
			return Status::newFatal( 'centralauth-admin-lock-nonexistent', $this->mName );
		}
		$dbw->commit();
	
		$this->invalidateCache();
		
		return Status::newGood();
	}

	/**
	 * Unlock a global account
	 */
	function adminUnlock() {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$dbw->update( 'globaluser', array( 'gu_locked' => 0 ),
			array( 'gu_name' => $this->mName ), __METHOD__ );
		if ( !$dbw->affectedRows() ) {
			$dbw->commit();
			return Status::newFatal( 'centralauth-admin-unlock-nonexistent', $this->mName );
		}
		$dbw->commit();
		
		$this->invalidateCache();
		
		return Status::newGood();
	}

	/**
	 * Hide a global account
	 */
	function adminHide() {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$dbw->update( 'globaluser', array( 'gu_hidden' => 1 ),
			array( 'gu_name' => $this->mName ), __METHOD__ );
		if ( !$dbw->affectedRows() ) {
			$dbw->commit();
			return Status::newFatal( 'centralauth-admin-hide-nonexistent', $this->mName );
		}
		$dbw->commit();
		
		$this->invalidateCache();
		
		return Status::newGood();
	}

	/**
	 * Unhide a global account
	 */
	function adminUnhide() {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$dbw->update( 'globaluser', array( 'gu_hidden' => 0 ),
			array( 'gu_name' => $this->mName ), __METHOD__ );
		if ( !$dbw->affectedRows() ) {
			$dbw->commit();
			return Status::newFatal( 'centralauth-admin-unhide-nonexistent', $this->mName );
		}
		$dbw->commit();
		
		$this->invalidateCache();
		
		return Status::newGood();
	}

	/**
	 * Add a local account record for the given wiki to the central database.
	 * @param string $wikiID
	 * @param int $localid
	 *
	 * Prerequisites:
	 * - completed migration state
	 */
	public function attach( $wikiID, $method='new' ) {
		$dbw = self::getCentralDB();
		$dbw->insert( 'localuser',
			array(
				'lu_wiki'             => $wikiID,
				'lu_name'               => $this->mName ,
				'lu_attached_timestamp' => $dbw->timestamp(),
				'lu_attached_method'    => $method ),
			__METHOD__,
			array( 'IGNORE' ) );

		if( $dbw->affectedRows() == 0 ) {
			wfDebugLog( 'CentralAuth',
				"Race condition? Already attached $this->mName@$wikiID, just tried by '$method'" );
			return;
		}
		wfDebugLog( 'CentralAuth',
			"Attaching local user $this->mName@$wikiID by '$method'" );

		if( $wikiID == wfWikiID() ) {
			$this->resetState();
		}
		
		$this->invalidateCache();
	}
	
	/**
	 * If the user provides the correct password, would we let them log in?
	 * This encompasses checks on missing and locked accounts, at present.
	 * @return mixed: true if login available, or string status, one of: "no user", "locked"
	 */
	public function canAuthenticate() {
		if( !$this->getId() ) {
			wfDebugLog( 'CentralAuth',
				"authentication for '$this->mName' failed due to missing account" );
			return "no user";
		}

		list($salt,$crypt) = $this->getPasswordHash();
		$locked = $this->isLocked();

		if( $locked ) {
			wfDebugLog( 'CentralAuth',
				"authentication for '$this->mName' failed due to lock" );
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
			return $ret;
		}
		
		list( $salt, $crypt ) = $this->getPasswordHash();
		
		if( $this->matchHash( $password, $salt, $crypt ) ) {
			wfDebugLog( 'CentralAuth',
				"authentication for '$this->mName' succeeded" );
			return "ok";
		} else {
			wfDebugLog( 'CentralAuth',
				"authentication for '$this->mName' failed, bad pass" );
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

	/**
	 * Fetch a list of databases where this account name is registered,
	 * but not yet attached to the global account. It would be used for
	 * an alert or management system to show which accounts have still
	 * to be dealt with.
	 *
	 * @return array of database name strings
	 */
	public function listUnattached() {
		$unattached = $this->doListUnattached();
		if( empty( $unattached ) ) {
			if( $this->lazyImportLocalNames() ) {
				$unattached = $this->doListUnattached();
			}
		}
		return $unattached;
	}

	function doListUnattached() {
		$dbw = self::getCentralDB();

		$sql = "
		SELECT ln_wiki
		FROM localnames
		LEFT OUTER JOIN localuser
			ON ln_wiki=lu_wiki AND ln_name=lu_name
		WHERE ln_name=? AND lu_name IS NULL
		";
		$result = $dbw->safeQuery( $sql, $this->mName );

		$dbs = array();
		while( $row = $dbw->fetchObject( $result ) ) {
			$dbs[] = $row->ln_wiki;
		}
		$dbw->freeResult( $result );

		return $dbs;
	}

	function addLocalName( $wikiID ) {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$this->lazyImportLocalNames();
		$dbw->insert( 'localnames',
			array(
				'ln_wiki' => $wikiID,
				'ln_name' => $this->mName ),
			__METHOD__,
			array( 'IGNORE' ) );
		$dbw->commit();
	}

	function removeLocalName( $wikiID ) {
		$dbw = self::getCentralDB();
		$dbw->begin();
		$this->lazyImportLocalNames();
		$dbw->delete( 'localnames',
			array(
				'ln_wiki' => $wikiID,
				'ln_name' => $this->mName ),
			__METHOD__ );
		$dbw->commit();
	}

	function lazyImportLocalNames() {
		$dbw = self::getCentralDB();

		$result = $dbw->select( 'globalnames',
			array( '1' ),
			array( 'gn_name' => $this->mName ),
			__METHOD__,
			array( 'LIMIT' => 1 ) );
		$known = $result->numRows();
		$result->free();

		if( $known ) {
			// No need...
			// Hmm.. what about wikis added after localnames was populated? -werdna
			return false;
		}

		return $this->importLocalNames();
	}

	/**
	 * Troll through the full set of local databases and list those
	 * which exist into the 'localnames' table.
	 */
	function importLocalNames() {
		$rows = array();
		foreach( self::getWikiList() as $wikiID ) {
			$lb = wfGetLB( $wikiID );
			$dbr = $lb->getConnection( DB_MASTER, array(), $wikiID );
			$id = $dbr->selectField(
				"`$wikiID`.`user`",
				'user_id',
				array( 'user_name' => $this->mName ),
				__METHOD__ );
			if( $id ) {
				$rows[] = array(
					'ln_wiki' => $wikiID,
					'ln_name' => $this->mName );
			}
			$lb->reuseConnection( $dbr );
		}

		$dbw = self::getCentralDB();
		$dbw->begin();
		$dbw->insert( 'globalnames',
			array( 'gn_name' => $this->mName ),
			__METHOD__,
			array( 'IGNORE' ) );
		if( $rows ) {
			$dbw->insert( 'localnames',
				$rows,
				__METHOD__,
				array( 'IGNORE' ) );
		}
		$dbw->commit();

		return !empty( $rows );
	}
	
	/**
	 * Load the list of databases where this account has been successfully
	 * attached
	 */
	public function loadAttached() {
		if ( isset( $this->mAttachedArray ) ) {
			// Already loaded
			return;
		}
		
		wfDebugLog( 'CentralAuth', "Loading attached wiki list for global user {$this->mName}." );
		
		if ( isset( $this->mAttachedList ) ) {
			wfDebugLog( 'CentralAuth', "-Found in cache." );
			// We have a list already, probably from the cache.
			$this->mAttachedArray = explode( "\n", $this->mAttachedList );
			
			return;
		}
		
		wfDebugLog( 'CentralAuth', "-Loading from DB" );
		
		$dbw = self::getCentralDB();

		$result = $dbw->select( 'localuser',
			array( 'lu_wiki' ),
			array( 'lu_name' => $this->mName ),
			__METHOD__ );

		$wikis = array();
		while( $row = $result->fetchObject() ) {
			$wikis[] = $row->lu_wiki;
		}
		$dbw->freeResult( $result );
		
		$this->mAttachedArray = $wikis;
		$this->mAttachedList = implode( "\n", $wikis );
	}

	/**
	 * Fetch a list of databases where this account has been successfully
	 * attached.
	 *
	 * @return array database name strings
	 */
	public function listAttached() {
		$this->loadAttached();
		
		return $this->mAttachedArray;
	}

	/**
	 * Get information about each local user attached to this account
	 *
	 * @return Map of database name to property table with members:
	 *    wiki                  The wiki ID (database name)
	 *    attachedTimestamp     The MW timestamp when the account was attached
	 *    attachedMethod        Attach method: password, mail or primary
	 */
	public function queryAttached() {
		$dbw = self::getCentralDB();

		$result = $dbw->select(
			'localuser',
			array(
				'lu_wiki',
				'lu_attached_timestamp',
				'lu_attached_method' ),
			array(
				'lu_name' => $this->mName ),
			__METHOD__ );

		$wikis = array();
		while( $row = $dbw->fetchObject( $result ) ) {
			$wikis[$row->lu_wiki] = array(
				'wiki' => $row->lu_wiki,
				'attachedTimestamp' => wfTimestampOrNull( TS_MW,
					 $row->lu_attached_timestamp ),
				'attachedMethod' => $row->lu_attached_method,
			);
		}
		$dbw->freeResult( $result );

		return $wikis;
	}

	/**
	 * Find any remaining migration records for this username
	 * which haven't gotten attached to some global account.
	 *
	 * Formatted as associative array with some data.
	 */
	public function queryUnattached() {
		$wikiIDs = $this->listUnattached();

		$items = array();
		foreach( $wikiIDs as $wikiID ) {
			$data = $this->localUserData( $wikiID );
			if( empty( $data ) ) {
				throw new MWException(
					"Bad user row looking up local user $this->mName@$wikiID" );
			}
			$items[$wikiID] = $data;
		}

		return $items;
	}

	/**
	 * Fetch a row of user data needed for migration.
	 */
	protected function localUserData( $wikiID ) {
		$lb = wfGetLB( $wikiID );
		$db = $lb->getConnection( DB_SLAVE, array(), $wikiID );
		$fields = array(
				'user_id',
				'user_email',
				'user_email_authenticated',
				'user_password',
				'user_editcount' );
		$conds = array( 'user_name' => $this->mName );
		$row = $db->selectRow( 'user', $fields, $conds, __METHOD__ );
		if ( !$row ) {
			# Row missing from slave, try the master instead
			$lb->reuseConnection( $db );
			$db = $lb->getConnection( DB_MASTER, array(), $wikiID );
			$row = $db->selectRow( 'user', $fields, $conds, __METHOD__ );
		}
		if ( !$row ) {
			$lb->reuseConnection( $db );
			return false;
		}

		$data = array(
			'wiki' => $wikiID,
			'id' => $row->user_id,
			'email' => $row->user_email,
			'emailAuthenticated' =>
				wfTimestampOrNull( TS_MW, $row->user_email_authenticated ),
			'password' => $row->user_password,
			'editCount' => $row->user_editcount,
			'groups' => array(),
			'blocked' => false );

		// Edit count field may not be initialized...
		if( is_null( $row->user_editcount ) ) {
			$data['editCount'] = $db->selectField(
				'revision',
				'COUNT(*)',
				array( 'rev_user' => $data['id'] ),
				__METHOD__ );
		}

		// And we have to fetch groups separately, sigh...
		$groups = array();
		$result = $db->select( 'user_groups',
			array( 'ug_group' ),
			array( 'ug_user' => $data['id'] ),
			__METHOD__ );
		foreach( $result as $row ) {
			$data['groups'][] = $row->ug_group;
		}
		$result->free();

		// And while we're in here, look for user blocks :D
		$blocks = array();
		$result = $db->select( 'ipblocks',
			array( 'ipb_expiry' ),
			array( 'ipb_user' => $data['id'] ),
			__METHOD__ );
		foreach( $result as $row ) {
			if( Block::decodeExpiry( $row->ipb_expiry ) > wfTimestampNow() ) {
				$data['blocked'] = true;
			}
		}
		$result->free();
		$lb->reuseConnection( $db );

		return $data;
	}

	function getEmail() {
		$this->loadState();
		return $this->mEmail;
	}

	function getEmailAuthenticationTimestamp() {
		$this->loadState();
		return $this->mAuthenticationTimestamp;
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
		if ( $this->mAuthenticationTimestamp !== $ts ) {
			$this->mAuthenticationTimestamp = $ts;
			$this->mStateDirty = true;
		}
	}

	/**
	 * Salt and hash a new plaintext password.
	 * @param string $password plaintext
	 * @return array of strings, salt and hash
	 */
	protected function saltedPassword( $password ) {
		return array( '', User::crypt( $password ) );
	}

	/**
	 * Set the account's password
	 * @param string $password plaintext
	 */
	function setPassword( $password ) {
		list( $salt, $hash ) = $this->saltedPassword( $password );

		$this->mPassword = $hash;
		$this->mSalt = $salt;

		$dbw = self::getCentralDB();
		$dbw->update( 'globaluser',
			array(
				'gu_salt'     => $salt,
				'gu_password' => $hash,
			),
			array(
				'gu_id' => $this->getId(),
			),
			__METHOD__ );

		wfDebugLog( 'CentralAuth',
			"Set global password for '$this->mName'" );
		
		// Reset the auth token.
		$this->resetAuthToken();
		$this->invalidateCache();
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
	
	static function setCookie( $name, $value, $exp=-1 ) {
		global $wgCentralAuthCookiePrefix, $wgCentralAuthCookieDomain, $wgCookieSecure,
			$wgCookieExpiration, $wgCookieHttpOnly;
		
		if ($exp == -1) {
			$exp = time() + $wgCookieExpiration;
		} elseif ( $exp == 0 ) {
			// Don't treat as a relative expiry.
			//  They want a session cookie.
		} elseif ( $exp < 3.16e7 ) {
			// Relative expiry
			$exp += time();
		}
		$httpOnlySafe = version_compare("5.2", PHP_VERSION, "<");
		
		if( $httpOnlySafe && isset( $wgCookieHttpOnly ) ) {
			setcookie( $wgCentralAuthCookiePrefix . $name,
				$value,
				$exp,
				'/',
				$wgCentralAuthCookieDomain,
				$wgCookieSecure,
				$wgCookieHttpOnly );
		} else {
			// setcookie() fails on PHP 5.1 if you give it future-compat paramters.
			// stab stab!
			setcookie( $wgCentralAuthCookiePrefix . $name,
				$value,
				$exp,
				'/',
				$wgCentralAuthCookieDomain,
				$wgCookieSecure );
		}
	}
	
	protected function clearCookie( $name ) {
		global $wgCentralAuthCookiePrefix;
		self::setCookie( $name, '', -86400 );
	}

	/**
	 * Set a global cookie that auto-authenticates the user on other wikis
	 * Called on login.
	 * @return Session ID
	 */
	function setGlobalCookies($remember = false) {
		if (is_object($remember)) {
			// Older code passed a user object here. Be kind and do what they meant to do.
			$remember = $remember->getOption('rememberpassword');
		}
		
		$session = array();
		$exp = time() + 86400;
		
		$session['user'] = $this->mName;
		self::setCookie( 'User', $this->mName );
		$session['token'] = $this->getAuthToken();
		$session['expiry'] = $exp;
		$session['auto-create-blacklist'] = array();
		
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
		global $wgCentralAuthCookiePrefix;
		
		$this->clearCookie( 'User' );
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
	function resetAuthToken() {
		// Generate a random token.
		$this->mAuthToken = wfGenerateToken( $this->getId() );
		$this->mStateDirty = true;
		
		// Save it.
		$this->saveSettings();
	}

	function saveSettings() {
		if ( !$this->mStateDirty ) return;
		$this->mStateDirty = false;

		if ( wfReadOnly() ) return;

		$this->loadState();
		if ( !$this->mGlobalId ) return;

		$dbw = self::getCentralDB();
		$dbw->update( 'globaluser', 
			array( # SET
				'gu_password' => $this->mPassword,
				'gu_salt' => $this->mSalt,
				'gu_auth_token' => $this->mAuthToken,
				'gu_locked' => $this->mLocked,
				'gu_hidden' => $this->mHidden,
				'gu_email' => $this->mEmail,
				'gu_email_authenticated' => $dbw->timestampOrNull( $this->mAuthenticationTimestamp )
			),
			array( # WHERE
				'gu_id' => $this->mGlobalId 
			), 
			__METHOD__
		);
		
		$this->invalidateCache();
	}
	
	function getGlobalGroups() {
		$this->loadGroups();
		
		return $this->mGroups;
	}
	
	function getGlobalRights() {
		$this->loadGroups();
		
		return $this->mRights;
	}
	
	function removeFromGlobalGroups( $groups ) {
		$dbw = self::getCentralDB();
		
		# Delete from the DB
		$dbw->delete( 'global_user_groups', 
			array( 'gug_user' => $this->getId(), 'gug_group' => $groups ), 
			__METHOD__ );
		
		$this->invalidateCache();
	}
	
	function addToGlobalGroups( $groups ) {
		$dbw = self::getCentralDB();
		
		if (!is_array($groups)) {
			$groups = array($groups);
		}
		
		$insert_rows = array();
		foreach( $groups as $group ) {
			$insert_rows[] = array( 'gug_user' => $this->getId(), 'gug_group' => $group );
		}
		
		# Replace into the DB
		$dbw->replace( 'global_user_groups', 
			array( 'gug_user', 'gug_group' ), 
			$insert_rows, __METHOD__ );
		
		$this->invalidateCache();
	}
	
	static function availableGlobalGroups() {
		$dbr = self::getCentralSlaveDB();
		
		$res = $dbr->select( 'global_group_permissions', 'distinct ggp_group', array(), __METHOD__ );
		
		$groups = array();
		
		while ($row = $dbr->fetchObject( $res ) )
			$groups[] = $row->ggp_group;
			
		return $groups;
	}
	
	static function globalGroupPermissions( $group ) {
		$dbr = self::getCentralSlaveDB();
		
		$res = $dbr->select( array( 'global_group_permissions' ),
			array( 'ggp_permission' ), array( 'ggp_group' => $group), __METHOD__ );
		
		$rights = array();
		
		while ($row = $dbr->fetchObject( $res ) ) {
			$rights[] = $row->ggp_permission;
		}
		
		return $rights;
	}
	
	function hasGlobalPermission( $perm ) {
		$perms = $this->getGlobalRights();
		
		return in_array( $perm, $perms );
	}
	
	static function getUsedRights() {
		$dbr = self::getCentralSlaveDB();
		
		$res = $dbr->select( 'global_group_permissions', 'distinct ggp_permission', 
			array(), __METHOD__ );
		
		$rights = array();
		
		while ($row = $dbr->fetchObject( $res ) )
			$rights[] = $row->ggp_permission;
			
		return $rights;
	}
	
	public function invalidateCache() {
		if (!$this->mDelayInvalidation) {
			wfDebugLog( 'CentralAuth', "Updating cache for global user {$this->mName}" );
			
			// Reload the state
			$this->loadStateNoCache();
			
			// Overwrite the cache.
			$this->saveToCache();
		} else {
			wfDebugLog( 'CentralAuth', "Deferring cache invalidation because we're in a transaction" );
		}
	}
	
	/**
	 * For when speed is of the essence (e.g. when batch-purging users after rights changes)
	 */
	public function quickInvalidateCache() {
		global $wgMemc;
		
		wfDebugLog( 'CentralAuth', "Quick cache invalidation for global user {$this->mName}" );
		
		$wgMemc->delete( $this->getCacheKey() );
	}
	
	/**
	 * End a "transaction".
	 * A transaction delays cache invalidation until after
	 * some operation which would otherwise repeatedly do so.
	 * Intended to be used for things like migration.
	 */
	public function endTransaction() {
		wfDebugLog( 'CentralAuth', "Finishing CentralAuthUser cache-invalidating transaction" );
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
		wfDebugLog( 'CentralAuth', "Beginning CentralAuthUser cache-invalidating transaction" );
		// Delay cache invalidation
		$this->mDelayInvalidation = 1;
	}

	static function memcKey( /*...*/ ) {
		global $wgCentralAuthDatabase;
		$args = func_get_args();
		return $wgCentralAuthDatabase . ':' . implode( ':', $args );
	}

	/**
	 * Get the central session data
	 */
	static function getSession() {
		global $wgCentralAuthCookies, $wgCentralAuthCookiePrefix;
		global $wgMemc;
		if ( !$wgCentralAuthCookies ) {
			return array();
		}
		if ( !isset( $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'] ) ) {
			return array();
		}
		$id =  $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'];
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
		global $wgCentralAuthCookies, $wgCentralAuthCookiePrefix;
		global $wgMemc;
		if ( !$wgCentralAuthCookies ) {
			return;
		}
		if ( !isset( $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'] ) ) {
			$id = wfGenerateToken();
			self::setCookie( 'Session', $id, 0 );
		} else {
			$id =  $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'];
		}
		$key = self::memcKey( 'session', $id );
		$wgMemc->set( $key, $data, 86400 );
		return $id;
	}

	/**
	 * Delete the central session data
	 */
	static function deleteSession() {
		global $wgCentralAuthCookies, $wgCentralAuthCookiePrefix;
		global $wgMemc;
		if ( !$wgCentralAuthCookies ) {
			return;
		}
		if ( !isset( $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'] ) ) {
			return;
		}
		$id =  $_COOKIE[$wgCentralAuthCookiePrefix . 'Session'];
		wfDebug( __METHOD__.": Deleting session $id\n" );
		$key = self::memcKey( 'session', $id );
		$wgMemc->delete( $key );
	}
	
	/**
	 * Check if the user is attached on a given wiki id.
	 */
	public function attachedOn( $wiki ) {
		return $this->exists() && in_array( $wiki, $this->mAttachedArray );
	}
}
