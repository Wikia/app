<?php
/**
 * Implements the User class for the %MediaWiki software.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

use Email\Controller\EmailConfirmationController;
use Wikia\Domain\User\Attribute;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\Loggable;
use Wikia\Logger\WikiaLogger;
use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\User\Attributes\UserAttributes;
use Wikia\Service\User\Auth\AuthResult;
use Wikia\Service\User\Auth\AuthServiceAccessor;
use Wikia\Service\User\Auth\CookieHelper;
use Wikia\Service\User\Permissions\PermissionsService;
use Wikia\Service\User\Preferences\PreferenceService;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Int Number of characters in user_token field.
 * @ingroup Constants
 */
define( 'USER_TOKEN_LENGTH', 32 );

/**
 * Int Serialized record version.
 * @ingroup Constants
 */
define( 'MW_USER_VERSION', 17 );

/**
 * String Some punctuation to prevent editing from broken text-mangling proxies.
 * @ingroup Constants
 */
define( 'EDIT_TOKEN_SUFFIX', '+\\' );

/**
 * Thrown by User::setPassword() on error.
 * @ingroup Exception
 */
class PasswordError extends MWException {
	// NOP
}

/**
 * The User object encapsulates all of the user-specific settings (user_id,
 * name, rights, password, email address, options, last login time). Client
 * classes use the getXXX() functions to access these fields. These functions
 * do all the work of determining whether the user is logged in,
 * whether the requested option can be satisfied from cookies or
 * whether a database query is needed. Most of the settings needed
 * for rendering normal pages are set in the cookie to minimize use
 * of the database.
 */
class User implements JsonSerializable {

	# WIKIA CHANGE BEGIN
	# adamk@wikia-inc.com
	/**
	 * Traits extending the class
	 */
	use AuthServiceAccessor;
	# WIKIA CHANGE END

	use Loggable;

	/**
	 * Global constants made accessible as class constants so that autoloader
	 * magic can be used.
	 */
	const USER_TOKEN_LENGTH = USER_TOKEN_LENGTH;
	const MW_USER_VERSION = MW_USER_VERSION;
	const EDIT_TOKEN_SUFFIX = EDIT_TOKEN_SUFFIX;
	const CACHE_ATTRIBUTES_KEY = "attributes";
	const GET_SET_OPTION_SAMPLE_RATE = 0.1;

	const INVALIDATE_CACHE_THROTTLE_SESSION_KEY = 'invalidate-cache-throttle';
	const INVALIDATE_CACHE_THROTTLE = 60; /* seconds */

	private static $PROPERTY_UPSERT_SET_BLOCK = [ "up_user = VALUES(up_user)", "up_property = VALUES(up_property)", "up_value = VALUES(up_value)" ];

	/**
	 * Array of Strings List of member variables which are saved to the
	 * shared cache (memcached). Any operation which changes the
	 * corresponding database fields must call a cache-clearing function.
	 * @showinitializer
	 */
	static $mCacheVars = array(
		// user table
		'mId',
		'mName',
		'mRealName',
		'mEmail',
		'mTouched',
		'mToken',
		'mEmailAuthenticated',
		'mEmailToken',
		'mEmailTokenExpires',
		'mRegistration',
		'mBirthDate', // Wikia. Added to reflect our user table layout.
		// user_groups table
		'mGroups',
		// user_properties table
		'mOptionOverrides',
	);

	/** @name Cache variables */
	//@{
	var $mId, $mName, $mRealName,
		$mEmail, $mToken, $mEmailAuthenticated,
		$mEmailToken, $mEmailTokenExpires, $mRegistration, $mGroups, $mOptionOverrides,
		$mCookiePassword, $mAllowUsertalk;
	var $mBirthDate; // Wikia. Added to reflect our user table layout.
	//@}

	/** @var string TS_MW timestamp from the DB */
	public $mTouched;

	/** @var string TS_MW timestamp from cache */
	protected $mQuickTouched;

	/**
	 * Bool Whether the cache variables have been loaded.
	 */
	//@{
	var $mOptionsLoaded;

	/**
	 * Array with already loaded items or true if all items have been loaded.
	 */
	private $mLoadedItems = array();
	//@}

	/**
	 * String Initialization data source if mLoadedItems!==true. May be one of:
	 *  - 'defaults'   anonymous user initialised from class defaults
	 *  - 'name'       initialise from mName
	 *  - 'id'         initialise from mId
	 *  - 'session'    log in from cookies or session if possible
	 *
	 * Use the User::newFrom*() family of functions to set this.
	 */
	var $mFrom;

	/**
	 * Lazy-initialized variables, invalidated with clearInstanceCache
	 */
	var $mNewtalk, $mDatePreference, $mBlockedby, $mHash,
		$mBlockreason, $mBlockedGlobally,
		$mLocked, $mHideName, $mOptions;

	/**
	 * @var WebRequest
	 */
	private $mRequest;

	/**
	 * @var Block
	 */
	var $mBlock;

	/**
	 * @var Block
	 */
	private $mBlockedFromCreateAccount = false;

	static $idCacheByName = array();

	/**
	 * @var string the service auth token (currently helios); should NEVER be cached
	 */
	private $globalAuthToken = null;

	/**
	 * @var PermissionsService
	 */
	private static $permissionsService;

	/**
	 * Lightweight constructor for an anonymous user.
	 * Use the User::newFrom* factory functions for other kinds of users.
	 *
	 * @see newFromName()
	 * @see newFromId()
	 * @see newFromConfirmationCode()
	 * @see newFromSession()
	 * @see newFromRow()
	 */
	function __construct() {
		$this->clearInstanceCache( 'defaults' );
	}

	/**
	 * @param String $name
	 * @return string
	 */
	private static function getUserIdCacheKey( string $name ): string {
		$cacheKey = new UserNameCacheKeys( $name );
		$key = $cacheKey->forUserId();
		return $key;
	}

	/**
	 * @return String
	 */
	function __toString(){
		return $this->getName();
	}

	private static function heliosClient(): HeliosClient {
		return ServiceFactory::instance()->heliosFactory()->heliosClient();
	}

	private static function authCookieHelper(): CookieHelper {
		return ServiceFactory::instance()->heliosFactory()->cookieHelper();
	}

	private function userPreferences(): PreferenceService {
		return ServiceFactory::instance()->preferencesFactory()->preferenceService();
	}

	/**
	 * @return bool
	 */
	public function arePreferencesReadOnly() {
		return $this->userPreferences()->getPreferences( $this->getId() )->isReadOnly();
	}

	private function userAttributes(): UserAttributes {
		return ServiceFactory::instance()->attributesFactory()->userAttributes();
	}

	private static function permissionsService(): PermissionsService {
		return ServiceFactory::instance()->permissionsFactory()->permissionsService();
	}

	/**
	 * @return BernoulliTrial
	 */
	private function getOrSetOptionSampler() {
		static $sampler = null;

		if ($sampler === null) {
			$sampler = new BernoulliTrial(self::GET_SET_OPTION_SAMPLE_RATE);
		}

		return $sampler;
	}

	/**
	 * Load the user table data for this object from the source given by mFrom.
	 */
	public function load() {
		if ( $this->mLoadedItems === true ) {
			return;
		}
		wfProfileIn( __METHOD__ );

		# Set it now to avoid infinite recursion in accessors
		$this->mLoadedItems = true;

		switch ( $this->mFrom ) {
			case 'defaults':
				$this->loadDefaults();
				break;
			case 'name':
				$this->mId = self::idFromName( $this->mName );
				if ( !$this->mId ) {
					# Nonexistent user placeholder object
					$this->loadDefaults( $this->mName );
				} else {
					$this->loadFromId();
				}
				break;
			case 'id':
				$this->loadFromId();
				break;
			default:
				throw new MWException( "Unrecognised value for User->mFrom: \"{$this->mFrom}\"" );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Load user table data, given mId has already been set.
	 * @return Bool false if the ID does not exist, true otherwise
	 */
	public function loadFromId() {
		global $wgMemc;
		if ( $this->mId == 0 ) {
			$this->loadDefaults();
			return false;
		}

		# Try cache
		$key = $this->getCacheKey();
		$data = $wgMemc->get( $key );
		if ( !is_array( $data ) || $data['mVersion'] < MW_USER_VERSION ) {
			# Object is expired, load from DB
			$data = false;
		}

		# Wikia
		/*
		 * This code is responsible for re-invalidate user object data from database
		 * instead of memcache if user preferences had been changed on another wiki
		 */
		$isExpired = true;
		if(!empty($data)) {
			$_key = $this->getUserTouchedKey();
			$_touched = $wgMemc->get( $_key );
			if( empty( $_touched ) ) {
				$wgMemc->set( $_key, $data['mTouched'] );
				wfDebug( "Shared user: miss on shared user_touched\n" );
			} else if( $_touched <= $data['mTouched'] ) {
				$isExpired = false;
			}
			else {
				wfDebug( "Shared user: invalidating local user cache due to shared user_touched\n" );
			}
		}
		# /Wikia

		if ( !$data || $isExpired ) { # Wikia
			wfDebug( "User: cache miss for user {$this->mId}\n" );
			# Load from DB
			if ( !$this->loadFromDatabase() ) {
				# Can't load from ID, user is anonymous
				return false;
			}
			$this->saveToCache();
		} else {
			wfDebug( "User: got user {$this->mId} from cache\n" );
			# Restore from cache
			foreach ( self::$mCacheVars as $name ) {
				if( isset( $data[$name] ) ) {
					$this->$name = $data[$name];
				}
			}
		}
		return true;
	}

	/**
	 * Save user data to the shared cache
	 */
	public function saveToCache() {
		$this->load();
		$this->loadOptions();
		if ( $this->isAnon() ) {
			// Anonymous users are uncached
			return;
		}

		// prepare mOptionOverrides for caching
		$this->mOptionOverrides = [];
		foreach ( $this->mOptions as $optionKey => $optionValue ) {
			if ( $this->shouldOptionBeStored( $optionKey, $optionValue ) ) {
				$this->mOptionOverrides[$optionKey] = $optionValue;
			}
		}

		$data = array();
		foreach ( self::$mCacheVars as $name ) {
			$data[$name] = $this->$name;
		}
		$data['mVersion'] = MW_USER_VERSION;

		global $wgMemc;
		$wgMemc->set( $this->getCacheKey(), $data, WikiaResponse::CACHE_LONG );
		// SUS-2945
		$key = new UserNameCacheKeys( $this->getName() );
		$wgMemc->set( $key->forUserId(), (int) $this->getId(), WikiaResponse::CACHE_LONG );

		wfDebug( "User: user {$this->mId} stored in cache\n" );
	}

	private function getCacheKey(): string {
		$cacheKey = new UserIdCacheKeys($this->getId());
		return $cacheKey->forUser();
	}

	/** @name newFrom*() static factory methods */
	//@{

	/**
	 * Static factory method for creation from username.
	 *
	 * This is slightly less efficient than newFromId(), so use newFromId() if
	 * you have both an ID and a name handy.
	 *
	 * @param $name String Username, validated by Title::newFromText()
	 * @param $validate String|Bool Validate username. Takes the same parameters as
	 *    User::getCanonicalName(), except that true is accepted as an alias
	 *    for 'valid', for BC.
	 *
	 * @return User object, or false if the username is invalid
	 *    (e.g. if it contains illegal characters or is an IP address). If the
	 *    username is not present in the database, the result will be a user object
	 *    with a name, zero user ID and default settings.
	 */
	public static function newFromName( $name, $validate = 'valid' ) {
		if ( $validate === true ) {
			$validate = 'valid';
		}
		$name = self::getCanonicalName( $name, $validate );
		if ( $name === false ) {
			return false;
		}
		# Create unloaded user object
		$u = new User;
		$u->mName = $name;
		$u->mFrom = 'name';
		$u->setItemLoaded( 'name' );
		return $u;
	}

	/**
	 * Static factory method for creation from a given user ID.
	 *
	 * @param $id Int Valid user ID
	 * @return User The corresponding User object
	 */
	public static function newFromId( $id ) {
		$u = new User;
		$u->mId = $id;
		$u->mFrom = 'id';
		$u->setItemLoaded( 'id' );
		return $u;
	}

	/**
	 * Factory method to fetch whichever user has a given email confirmation code.
	 * This code is generated when an account is created or its e-mail address
	 * has changed.
	 *
	 * If the code is invalid or has expired, returns NULL.
	 *
	 * @param $code String Confirmation code
	 * @return User object, or null
	 */
	public static function newFromConfirmationCode( $code ) {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$id = $dbr->selectField( "`user`", 'user_id', array(
			'user_email_token' => md5( $code ),
			'user_email_token_expires > ' . $dbr->addQuotes( $dbr->timestamp() ),
		) );
		if( $id !== false ) {
			return User::newFromId( $id );
		} else {
			return null;
		}
	}

	/**
	 * Creates a MediaWiki User object based on the token given in the HTTP request.
	 *
	 * @param  WebRequest $request The HTTP request data as an object
	 *
	 * @return User                A logged in User object on successful authentication,
	 *                             or an anonymous User object on failure
	 */
	public static function newFromToken( \WebRequest $request ) {
		global $wgMemc;

		$cookieHelper = self::authCookieHelper();
		$token = $cookieHelper->getAccessToken( $request );

		if ( !$token ) {
			return new User;
		}

		try {
			$tokenInfo = self::heliosClient()->info( $token, $request );
			if ( empty( $tokenInfo->user_id ) ) {
				return new User;
			}

			$user = self::newFromId( $tokenInfo->user_id );
			$user->setGlobalAuthToken( $token );

			// Don't return the user object if it's disabled
			// @see SERVICES-459
			if ( (bool)$user->getGlobalFlag( 'disabled' ) ) {
				$cookieHelper->clearAuthenticationCookie( $request->response() );
				$user->loadDefaults();
				return $user;
			}

			// start the session if there's none so far
			// the code is borrowed from SpecialUserlogin
			// @see PLATFORM-1261
			if ( session_id() == '' ) {
				$sessionId = substr( hash( 'sha256', $token ), 0, 32 );
				wfSetupSession( $sessionId );
				WikiaLogger::instance()->debug( __METHOD__ . '::startSession' );

				// Update mTouched on user when he starts new MW session, but not too often
				// @see SOC-1326 and SUS-546
				$throttleKey = wfSharedMemcKey( self::INVALIDATE_CACHE_THROTTLE_SESSION_KEY, $tokenInfo->user_id );
				$invalidateCacheThrottleTime = $wgMemc->get( $throttleKey );
				if ( $invalidateCacheThrottleTime === null || $invalidateCacheThrottleTime < time() ) {
					$wgMemc->set( $throttleKey, time() + self::INVALIDATE_CACHE_THROTTLE, self::INVALIDATE_CACHE_THROTTLE );
					$user->invalidateCache();
				}
			}

			return $user;
		} catch ( ClientException $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
		}

		return new User;
	}

	/**
	 * Create a new user object from a user row.
	 * The row should have the following fields from the user table in it:
	 * - either user_name or user_id to load further data if needed (or both)
	 * - user_real_name
	 * - all other fields (email, password, etc.)
	 * It is useless to provide the remaining fields if either user_id,
	 * user_name and user_real_name are not provided because the whole row
	 * will be loaded once more from the database when accessing them.
	 *
	 * @param $row Array A row from the user table
	 * @return User
	 */
	public static function newFromRow( $row ) {
		$user = new User;
		$user->loadFromRow( $row );
		return $user;
	}

	//@}

	/**
	 * Get the username corresponding to a given user ID
	 * @param $id Int User ID
	 * @return String|false The corresponding username
	 */
	public static function whoIs( $id ) {
		// Wikia change - @see SUS-1015
		return self::newFromId( $id )->getName();
	}

	/**
	 * Return user ID to user name mapping
	 *
	 * Please note that this method is NOT cached!
	 *
	 * @param array $ids User IDs
	 * @param int $source DB_SLAVE / DB_MASTER
	 * @return array User ID to User name mapping
	 */
	public static function whoAre( Array $ids, $source = DB_SLAVE ): array {
		global $wgExternalSharedDB;

		if ( $ids == [] ) {
			return [];
		}

		$ids = array_unique( $ids, SORT_NUMERIC );

		if ( count( $ids ) === 1 ) {
			// SUS-3219 - fall back to well-cached User::whoIs when we want to resolve a single user ID
			$userId = $ids[0];

			return [
				// Add the name used to indicate anonymous users.
				0 => wfMessage( 'oasis-anon-user' )->escaped(),
				$userId => self::whoIs( $userId )
			];
		}

		$sdb = wfGetDB( $source, [], $wgExternalSharedDB );
		$res = $sdb->select(
			'`user`',
			[ 'user_id', 'user_name' ],
			[ 'user_id' => $ids ],
			__METHOD__
		);

		// Pre-fill the returned array with empty strings
		// so that missing users are not skipped.
		// It makes further iterating over the array
		// and handling anons and missing users a little
		// bit easier.
		$users = array_fill_keys( $ids, '' );

		// Add the name used to indicate anonymous users.
		$users[0] = wfMessage( 'oasis-anon-user' )->escaped();

		foreach ( $res as $row ) {
			$users[ $row->user_id ] = (string) $row->user_name;
		}

		return $users;
	}

	/**
	 * Get the real name of a user given their user ID
	 *
	 * @param $id Int User ID
	 * @return String|false The corresponding user's real name
	 */
	public static function whoIsReal( $id ) {
		// Wikia change - @see SUS-1015
		return self::newFromId( $id )->getRealName();
	}

	/**
	 * Get database id given a user name
	 * @param $name String Username
	 * @return Int|Null The corresponding user's ID, or null if user is nonexistent
	 */
	public static function idFromName( $name ) {
		$nt = Title::makeTitleSafe( NS_USER, $name );
		if( is_null( $nt ) ) {
			# Illegal name
			return null;
		}

		// SUS-2980: This is an anon, they won't have a DB entry - stop here.
		if ( IP::isIPAddress( $name ) ) {
			return null;
		}

		if ( isset( self::$idCacheByName[$name] ) ) {
			// SUS-2981 - return NULL when a user is not found
			return ( (int) self::$idCacheByName[$name] ) ?: null;
		}

		// SUS-2945 | this method makes ~32mm queries every day
		// worth caching given the fact that (user ID, user name) pairs do not change very often
		global $wgMemc;

		$key = self::getUserIdCacheKey( $name );
		$cachedId = $wgMemc->get( $key );

		if ( is_numeric( $cachedId ) ) {
			// SUS-2981 - return NULL when a user is not found
			return ( (int) self::$idCacheByName[$name] = $cachedId ) ?: null;
		}

		// not in cache, query the database
		global $wgExternalSharedDB; // SUS-2945 - let's use wikicities.user instead of per-cluster copy
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$s = $dbr->selectRow( '`user`', array( 'user_id' ), array( 'user_name' => $nt->getText() ), __METHOD__ );
		if ( $s === false ) {
			$user_name = $nt->getText();
			Hooks::run( 'UserNameLoadFromId', array( $user_name, &$s ) );
		}

		if ( $s === false ) {
			// SUS-2981 - set cached value to zero when a user is not found, setting a memcache entry to NULL makes no sense
			$result = 0;
		} else {
			$result = (int)$s->user_id;
		}

		// SUS-2981 - cache even when a given user is not found (set cache entry to 0)
		$wgMemc->set( $key, $result, WikiaResponse::CACHE_LONG );

		self::$idCacheByName[$name] = $result;

		if ( count( self::$idCacheByName ) > 1000 ) {
			self::$idCacheByName = array();
		}

		return $result ?: null;
	}

	/**
	 * Reset the cache used in idFromName(). For use in tests.
	 */
	public static function resetIdByNameCache() {
		self::$idCacheByName = array();
	}

	/**
	 * Does the string match an anonymous IPv4 address?
	 *
	 * This function exists for username validation, in order to reject
	 * usernames which are similar in form to IP addresses. Strings such
	 * as 300.300.300.300 will return true because it looks like an IP
	 * address, despite not being strictly valid.
	 *
	 * We match \d{1,3}\.\d{1,3}\.\d{1,3}\.xxx as an anonymous IP
	 * address because the usemod software would "cloak" anonymous IP
	 * addresses like this, if we allowed accounts like this to be created
	 * new users could get the old edits of these anonymous users.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isIP( $name ) {
		return preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:xxx|\d{1,3})$/',$name) || IP::isIPv6($name);
	}

	/**
	 * Is the input a valid username?
	 *
	 * Checks if the input is a valid username, we don't want an empty string,
	 * an IP address, anything that containins slashes (would mess up subpages),
	 * is longer than the maximum allowed username size or doesn't begin with
	 * a capital letter.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isValidUserName( $name ) {
		global $wgContLang, $wgMaxNameChars;

		if ( $name == ''
			|| User::isIP( $name )
			|| strpos( $name, '/' ) !== false
			|| strlen( $name ) > $wgMaxNameChars
			|| $name != $wgContLang->ucfirst( $name ) ) {
			wfDebugLog( 'username', __METHOD__ .
				": '$name' invalid due to empty, IP, slash, colon, length, or lowercase" );
			return false;
		}


		// Ensure that the name can't be misresolved as a different title,
		// such as with extra namespace keys at the start.
		$parsed = Title::newFromText( $name );
		if( is_null( $parsed )
			|| $parsed->getNamespace()
			|| strcmp( $name, $parsed->getPrefixedText() ) ) {
			wfDebugLog( 'username', __METHOD__ .
				": '$name' invalid due to ambiguous prefixes" );
			return false;
		}

		// Check an additional blacklist of troublemaker characters.
		// Should these be merged into the title char list?
		$unicodeBlacklist = '/[' .
			'\x{0080}-\x{009f}' . # iso-8859-1 control chars
			'\x{00a0}' .          # non-breaking space
			'\x{2000}-\x{200f}' . # various whitespace
			'\x{2028}-\x{202f}' . # breaks and control chars
			'\x{3000}' .          # ideographic space
			'\x{e000}-\x{f8ff}' . # private use
			']/u';
		if( preg_match( $unicodeBlacklist, $name ) ) {
			wfDebugLog( 'username', __METHOD__ .
				": '$name' invalid due to blacklisted characters" );
			return false;
		}

		return true;
	}

	/**
	 * Usernames which fail to pass this function will be blocked
	 * from user login and new account registrations, but may be used
	 * internally by batch processes.
	 *
	 * If an account already exists in this form, login will be blocked
	 * by a failure to pass this function.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isUsableName( $name ) {
		global $wgReservedUsernames;
		// Must be a valid username, obviously ;)
		if ( !self::isValidUserName( $name ) ) {
			return false;
		}

		static $reservedUsernames = false;
		if ( !$reservedUsernames ) {
			$reservedUsernames = $wgReservedUsernames;
			Hooks::run( 'UserGetReservedNames', array( &$reservedUsernames ) );
		}

		// Certain names may be reserved for batch processes.
		foreach ( $reservedUsernames as $reserved ) {
			if ( substr( $reserved, 0, 4 ) == 'msg:' ) {
				$reserved = wfMsgForContent( substr( $reserved, 4 ) );
			}
			if ( $reserved == $name ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Usernames which fail to pass this function will be blocked
	 * from new account registrations, but may be used internally
	 * either by batch processes or by user accounts which have
	 * already been created.
	 *
	 * Additional blacklisting may be added here rather than in
	 * isValidUserName() to avoid disrupting existing accounts.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isCreatableName( $name ) {
		global $wgInvalidUsernameCharacters;
		// Ensure that the username isn't longer than 235 bytes, so that
		// (at least for the builtin skins) user javascript and css files
		// will work. (bug 23080)
		if( strlen( $name ) > 235 ) {
			wfDebugLog( 'username', __METHOD__ .
				": '$name' invalid due to length" );
			return false;
		}

		// Preg yells if you try to give it an empty string
		if( $wgInvalidUsernameCharacters !== '' ) {
			if( preg_match( '/[' . preg_quote( $wgInvalidUsernameCharacters, '/' ) . ']/', $name ) ) {
				wfDebugLog( 'username', __METHOD__ .
					": '$name' invalid due to wgInvalidUsernameCharacters" );
				return false;
			}
		}

		return self::isUsableName( $name );
	}

	/**
	 * Check for max name length
	 * * @param $name \string String to match
	 * @return \bool True or false
	 */

	static function isNotMaxNameChars($name) {
		global $wgWikiaMaxNameChars;

		if( empty($wgWikiaMaxNameChars) ) {
			//emergency fallback
			global $wgMaxNameChars;
			$wgWikiaMaxNameChars = $wgMaxNameChars;
		}

		return !( mb_strlen($name) > $wgWikiaMaxNameChars );
	}

	/**
	 * Is the input a valid password for this user?
	 *
	 * @param $password String Desired password
	 * @return Bool
	 */
	public function isValidPassword( $password ) {
		//simple boolean wrapper for getPasswordValidity
		return $this->getPasswordValidity( $password ) === true;
	}

	/**
	 * Given unvalidated password input, return error message on failure.
	 *
	 * @param $password String Desired password
	 * @return mixed: true on success, string or array of error message on failure
	 */
	public function getPasswordValidity( $password ) {
		$result = self::heliosClient()->validatePassword( $password, $this->getName(), $this->getEmail() );

		if ( !empty( $result->success ) && $result->success ) {
			return true;
		}

		if ( empty( $result->errors ) ) {
			return 'unknown-error';
		}

		if ( count( $result->errors ) === 1 ) {
			return $result->errors[0]->description;
		}

		$return = [];
		foreach ( $result->errors as $errors ) {
			$return[] = $errors->description;
		}

		return $return;
	}

	/**
	 * Does a string look like an e-mail address?
	 *
	 * This validates an email address using an HTML5 specification found at:
	 * http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#valid-e-mail-address
	 * Which as of 2011-01-24 says:
	 *
	 *     A valid e-mail address is a string that matches the ABNF production
	 *   1*( atext / "." ) "@" ldh-str *( "." ldh-str ) where atext is defined
	 *   in RFC 5322 section 3.2.3, and ldh-str is defined in RFC 1034 section
	 *   3.5.
	 *
	 * This function is an implementation of the specification as requested in
	 * bug 22449.
	 *
	 * Client-side forms will use the same standard validation rules via JS or
	 * HTML 5 validation; additional restrictions can be enforced server-side
	 * by extensions via the 'isValidEmailAddr' hook.
	 *
	 * Note that this validation doesn't 100% match RFC 2822, but is believed
	 * to be liberal enough for wide use. Some invalid addresses will still
	 * pass validation here.
	 *
	 * @param $addr String E-mail address
	 * @return Bool
	 * @deprecated since 1.18 call Sanitizer::isValidEmail() directly
	 */
	public static function isValidEmailAddr( $addr ) {
		wfDeprecated( __METHOD__, '1.18' );
		return Sanitizer::validateEmail( $addr );
	}

	/**
	 * Given unvalidated user input, return a canonical username, or false if
	 * the username is invalid.
	 * @param $name String User input
	 * @param $validate String|Bool type of validation to use:
	 *                - false        No validation
	 *                - 'valid'      Valid for batch processes
	 *                - 'usable'     Valid for batch processes and login
	 *                - 'creatable'  Valid for batch processes, login and account creation
	 *
	 * @return bool|string
	 */
	public static function getCanonicalName( $name, $validate = 'valid' ) {
		# Force usernames to capital
		global $wgContLang;
		$name = $wgContLang->ucfirst( $name );

		# Reject names containing '#'; these will be cleaned up
		# with title normalisation, but then it's too late to
		# check elsewhere
		if( strpos( $name, '#' ) !== false )
			return false;

		# Clean up name according to title rules
		$t = ( $validate === 'valid' ) ?
			Title::newFromText( $name ) : Title::makeTitle( NS_USER, $name );
		# Check for invalid titles
		if( is_null( $t ) ) {
			return false;
		}

		# Reject various classes of invalid names
		global $wgAuth;
		$name = $wgAuth->getCanonicalName( $t->getText() );

		switch ( $validate ) {
			case false:
				break;
			case 'valid':
				if ( !User::isValidUserName( $name ) ) {
					$name = false;
				}
				break;
			case 'usable':
				if ( !User::isUsableName( $name ) ) {
					$name = false;
				}
				break;
			case 'creatable':
				if ( !User::isCreatableName( $name ) ) {
					$name = false;
				}
				break;
			default:
				throw new MWException( 'Invalid parameter value for $validate in ' . __METHOD__ );
		}
		return $name;
	}

	/**
	 * Return a random password.
	 *
	 * @return String new random password
	 */
	public static function randomPassword() {
		global $wgMinimalPasswordLength;
		// Decide the final password length based on our min password length, stopping at a minimum of 20 chars
		$length = max( 20, $wgMinimalPasswordLength );
		// Multiply by 1.25 to get the number of hex characters we need
		// Generate random hex chars
		$hex = MWCryptRand::generateHex( ceil( $length * 1.25 ) );
		// Convert from base 16 to base 32 to get a proper password like string
		return substr( wfBaseConvert( $hex, 16, 32, $length ), -$length );
	}

	/**
	 * Set cached properties to default.
	 *
	 * @note This no longer clears uncached lazy-initialised properties;
	 *       the constructor does that instead.
	 *
	 * @param $name string
	 */
	public function loadDefaults( $name = false ) {
		wfProfileIn( __METHOD__ );

		$this->mId = 0;
		$this->mName = $name;
		$this->mRealName = '';
		$this->mEmail = '';
		$this->mOptionOverrides = null;
		$this->mOptionsLoaded = false;

		$loggedOut = $this->getRequest()->getCookie( 'LoggedOut' );
		if( $loggedOut !== null ) {
			$this->mTouched = wfTimestamp( TS_MW, $loggedOut );
		} else {
			$this->mTouched = '0'; # Allow any pages to be cached
		}

		$this->mToken = null; // Don't run cryptographic functions till we need a token
		$this->mEmailAuthenticated = null;
		$this->mEmailToken = '';
		$this->mEmailTokenExpires = null;
		$this->mRegistration = wfTimestamp( TS_MW );
		$this->mGroups = array();

		$this->mBirthDate = null; // Wikia. Added to reflect our user table layout.

		Hooks::run( 'UserLoadDefaults', array( $this, $name ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return whether an item has been loaded.
	 *
	 * @param $item String: item to check. Current possibilities:
	 *              - id
	 *              - name
	 *              - realname
	 * @param $all String: 'all' to check if the whole object has been loaded
	 *        or any other string to check if only the item is available (e.g.
	 *        for optimisation)
	 * @return Boolean
	 */
	public function isItemLoaded( $item, $all = 'all' ) {
		return ( $this->mLoadedItems === true && $all === 'all' ) ||
			( isset( $this->mLoadedItems[$item] ) && $this->mLoadedItems[$item] === true );
	}

	/**
	 * Set that an item has been loaded
	 *
	 * @param $item String
	 */
	private function setItemLoaded( $item ) {
		if ( is_array( $this->mLoadedItems ) ) {
			$this->mLoadedItems[$item] = true;
		}
	}

	/**
	 * A comparison of two strings, not vulnerable to timing attacks
	 * @param string $answer the secret string that you are comparing against.
	 * @param string $test compare this string to the $answer.
	 * @return bool True if the strings are the same, false otherwise
	 */
	protected function compareSecrets( $answer, $test ) {
		if ( strlen( $answer ) !== strlen( $test ) ) {
			$passwordCorrect = false;
		} else {
			$result = 0;
			for ( $i = 0; $i < strlen( $answer ); $i++ ) {
				$result |= ord( $answer{$i} ) ^ ord( $test{$i} );
			}
			$passwordCorrect = ( $result == 0 );
		}
		return $passwordCorrect;
	}

	/**
	 * Load user and user_group data from the database.
	 * $this->mId must be set, this is how the user is identified.
	 *
	 * @return Bool True if the user exists, false if the user is anonymous
	 */
	public function loadFromDatabase() {
		# Paranoia
		$this->mId = intval( $this->mId );

		/** Anonymous user */
		if( !$this->mId ) {
			$this->loadDefaults();
			return false;
		}

		// SUS-2339 - query wikicities.user table instead of per-cluster copy
		// `user` - backticks prevent adding `wikicities_cX` prefix to the table name
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_MASTER, [],  $wgExternalSharedDB );
		if ( !is_object( $dbr ) ) {
			$this->loadDefaults();
			return false;
		}

		$s = $dbr->selectRow( '`user`', '*', array( 'user_id' => $this->mId ), __METHOD__ );
		Hooks::run( 'UserLoadFromDatabase', array( $this, &$s ) );

		if ( $s !== false ) {
			# Initialise user table data
			$this->loadFromRow( $s );
			$this->mGroups = null; // deferred
			return true;
		} else {
			# Invalid user_id
			$this->mId = 0;
			$this->loadDefaults();
			return false;
		}
	}

	/**
	 * Initialize this object from a row from the user table.
	 *
	 * @param $row Array Row from the user table to load.
	 */
	public function loadFromRow( $row ) {
		$all = true;

		$this->mGroups = null; // deferred

		if ( isset( $row->user_name ) ) {
			$this->mName = $row->user_name;
			$this->mFrom = 'name';
			$this->setItemLoaded( 'name' );
		} else {
			$all = false;
		}

		if ( isset( $row->user_real_name ) ) {
			$this->mRealName = $row->user_real_name;
			$this->setItemLoaded( 'realname' );
		} else {
			$all = false;
		}

		if ( isset( $row->user_id ) ) {
			$this->mId = intval( $row->user_id );
			$this->mFrom = 'id';
			$this->setItemLoaded( 'id' );
		} else {
			$all = false;
		}

		if ( isset( $row->user_email ) ) {
			$this->mEmail = $row->user_email;
			if ( isset( $row->user_options ) ) {
				$this->decodeOptions( $row->user_options );
			}
			$this->mTouched = wfTimestamp( TS_MW, $row->user_touched );
			$this->mToken = $row->user_token;
			if ( $this->mToken == '' ) {
				$this->mToken = null;
			}
			$this->mEmailAuthenticated = wfTimestampOrNull( TS_MW, $row->user_email_authenticated );
			$this->mEmailToken = $row->user_email_token;
			$this->mEmailTokenExpires = wfTimestampOrNull( TS_MW, $row->user_email_token_expires );
			$this->mRegistration = wfTimestampOrNull( TS_MW, $row->user_registration );
		} else {
			$all = false;
		}

		// Wikia. The following if/else statement has been added to reflect our user table layout.
		if ( isset( $row->user_birthdate ) && $row->user_birthdate !== '0000-00-00' ) {
			$this->mBirthDate = $row->user_birthdate;
		} else {
			$all = false;
		}

		if ( $all ) {
			$this->mLoadedItems = true;
		}
	}

	/**
	 * Load the data for this user object from another user object.
	 *
	 * @param $user User
	 */
	protected function loadFromUserObject( $user ) {
		$user->load();
		$user->loadOptions();
		foreach ( self::$mCacheVars as $var ) {
			$this->$var = $user->$var;
		}
	}

	/**
	 * Clear various cached data stored in this object.
	 * @param $reloadFrom bool|String Reload user and user_groups table data from a
	 *   given source. May be "name", "id", "defaults", "session", or false for
	 *   no reload.
	 */
	public function clearInstanceCache( $reloadFrom = false ) {
		$this->mNewtalk = -1;
		$this->mDatePreference = null;
		$this->mBlockedby = -1; # Unset
		$this->mHash = false;
		$this->mOptions = null;
		$this->mOptionOverrides = null;
		$this->mOptionsLoaded = false;

		if ( $reloadFrom ) {
			$this->mLoadedItems = array();
			$this->mFrom = $reloadFrom;
		}
	}

	/**
	 * Combine the language default options with any site-specific options
	 * and add the default language variants.
	 *
	 * @return Array of String options
	 */
	public static function getDefaultOptions() {
		global $wgNamespacesToBeSearchedDefault, $wgDefaultUserOptions, $wgContLang, $wgDefaultSkin;

		static $defOpt = null;
		if ( !defined( 'MW_PHPUNIT_TEST' ) && $defOpt !== null ) {
			// Disabling this for the unit tests, as they rely on being able to change $wgContLang
			// mid-request and see that change reflected in the return value of this function.
			// Which is insane and would never happen during normal MW operation
			// Owen backported this from MW 1.25
			return $defOpt;
		}
		$defOpt = $wgDefaultUserOptions;
		# default language setting
		$variant = $wgContLang->getDefaultVariant();
		$defOpt['variant'] = $variant;
		$defOpt['language'] = $variant;
		foreach( SearchEngine::searchableNamespaces() as $nsnum => $nsname ) {
			$defOpt['searchNs'.$nsnum] = !empty( $wgNamespacesToBeSearchedDefault[$nsnum] );
		}
		$defOpt['skin'] = $wgDefaultSkin;

		// Owen fixed this (see above)
		// FIXME: Ideally we'd cache the results of this function so the hook is only run once,
		// but that breaks the parser tests because they rely on being able to change $wgContLang
		// mid-request and see that change reflected in the return value of this function.
		// Which is insane and would never happen during normal MW operation, but is also not
		// likely to get fixed unless and until we context-ify everything.
		// See also https://www.mediawiki.org/wiki/Special:Code/MediaWiki/101488#c25275
		Hooks::run( 'UserGetDefaultOptions', array( &$defOpt ) );

		return $defOpt;
	}

	/**
	 * Get a given default option value.
	 *
	 * @param $opt String Name of option to retrieve
	 * @return String Default option value
	 */
	public static function getDefaultOption( $opt ) {
		$defOpts = self::getDefaultOptions();
		if( isset( $defOpts[$opt] ) ) {
			return $defOpts[$opt];
		} else {
			return null;
		}
	}


	/* Wikia change begin - SUS-92 */
	/**
	 * Get blocking information
	 * @param $bFromSlave Bool Whether to check the slave database first. To
	 *                    improve performance, non-critical checks are done
	 *                    against slaves. Check when actually saving should be
	 *                    done against master.
	 * @param $shouldLogBlockInStats Bool flag that decides whether to log or not in PhalanxStats
	 */
	private function getBlockedStatus( $bFromSlave = true, $shouldLogBlockInStats = true, $global = true ) {
		/* Wikia change end */
		global $wgProxyWhitelist, $wgUser;

		if ( -1 != $this->mBlockedby ) {
			return;
		}

		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__.": checking...\n" );

		// Initialize data...
		// Otherwise something ends up stomping on $this->mBlockedby when
		// things get lazy-loaded later, causing false positive block hits
		// due to -1 !== 0. Probably session-related... Nothing should be
		// overwriting mBlockedby, surely?
		$this->load();

		# We only need to worry about passing the IP address to the Block generator if the
		# user is not immune to autoblocks/hardblocks, and they are the current user so we
		# know which IP address they're actually coming from
		if ( !$this->isAllowed( 'ipblock-exempt' ) && $this->equals( $wgUser ) ) {
			$ip = $this->getRequest()->getIP();
		} else {
			$ip = null;
		}

		# User/IP blocking
		$block = Block::newFromTarget( $this, $ip, !$bFromSlave );

		# Proxy blocking
		if ( !$block instanceof Block && $ip !== null && !$this->isAllowed( 'proxyunbannable' )
			&& !in_array( $ip, $wgProxyWhitelist ) )
		{
			# Local list
			if ( self::isLocallyBlockedProxy( $ip ) ) {
				$block = new Block;
				$block->setBlocker( wfMsg( 'proxyblocker' ) );
				$block->mReason = wfMsg( 'proxyblockreason' );
				$block->setTarget( $ip );
			} elseif ( $this->isAnon() && $this->isDnsBlacklisted( $ip ) ) {
				$block = new Block;
				$block->setBlocker( wfMsg( 'sorbs' ) );
				$block->mReason = wfMsg( 'sorbsreason' );
				$block->setTarget( $ip );
			}
		}

		if ( $block instanceof Block ) {
			wfDebug( __METHOD__ . ": Found block.\n" );
			$this->mBlock = $block;
			$this->mBlockedby = $block->getByName();
			$this->mBlockreason = $block->mReason;
			$this->mHideName = $block->mHideName;
			$this->mAllowUsertalk = !$block->prevents( 'editownusertalk' );
		} else {
			$this->mBlockedby = '';
			$this->mHideName = 0;
			$this->mAllowUsertalk = false;
		}

		# Extensions
		/* Wikia change begin - SUS-92 */
		Hooks::run( 'GetBlockedStatus', [ $this, $shouldLogBlockInStats, $global ] );
		/* Wikia change end */

		if ( !empty($this->mBlockedby) ) {
			$this->mBlock->mBy = $this->mBlockedby;
			$this->mBlock->mReason = $this->mBlockreason;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Wikia change - SUS-1649: Clear all block-related info from this instance of User class
	 * This allows us to re-run block check functions with different parameters (e.g. checking for only local blocks)
	 * @see User::getBlockedStatus()
	 */
	public function clearBlockInfo() {
		$this->mBlock = null;
		$this->mBlockedby = -1;
		$this->mBlockreason = '';
		$this->mHideName = 0;
		$this->mAllowUsertalk = false;
	}

	/**
	 * Whether the given IP is in a DNS blacklist.
	 *
	 * @param $ip String IP to check
	 * @param $checkWhitelist Bool: whether to check the whitelist first
	 * @return Bool True if blacklisted.
	 */
	public function isDnsBlacklisted( $ip, $checkWhitelist = false ) {
		global $wgEnableSorbs, $wgEnableDnsBlacklist,
			$wgSorbsUrl, $wgDnsBlacklistUrls, $wgProxyWhitelist;

		if ( !$wgEnableDnsBlacklist && !$wgEnableSorbs )
			return false;

		if ( $checkWhitelist && in_array( $ip, $wgProxyWhitelist ) )
			return false;

		$urls = array_merge( $wgDnsBlacklistUrls, (array)$wgSorbsUrl );
		return $this->inDnsBlacklist( $ip, $urls );
	}

	/**
	 * Whether the given IP is in a given DNS blacklist.
	 *
	 * @param $ip String IP to check
	 * @param $bases String|Array of Strings: URL of the DNS blacklist
	 * @return Bool True if blacklisted.
	 */
	public function inDnsBlacklist( $ip, $bases ) {
		wfProfileIn( __METHOD__ );

		$found = false;
		// @todo FIXME: IPv6 ???  (http://bugs.php.net/bug.php?id=33170)
		if( IP::isIPv4( $ip ) ) {
			# Reverse IP, bug 21255
			$ipReversed = implode( '.', array_reverse( explode( '.', $ip ) ) );

			foreach( (array)$bases as $base ) {
				# Make hostname
				# If we have an access key, use that too (ProjectHoneypot, etc.)
				if( is_array( $base ) ) {
					if( count( $base ) >= 2 ) {
						# Access key is 1, base URL is 0
						$host = "{$base[1]}.$ipReversed.{$base[0]}";
					} else {
						$host = "$ipReversed.{$base[0]}";
					}
				} else {
					$host = "$ipReversed.$base";
				}

				# Send query
				$ipList = gethostbynamel( $host );

				if( $ipList ) {
					wfDebug( "Hostname $host is {$ipList[0]}, it's a proxy says $base!\n" );
					$found = true;
					break;
				} else {
					wfDebug( "Requested $host, not found in $base.\n" );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $found;
	}

	/**
	 * Check if an IP address is in the local proxy list
	 *
	 * @param $ip string
	 *
	 * @return bool
	 */
	public static function isLocallyBlockedProxy( $ip ) {
		global $wgProxyList;

		if ( !$wgProxyList ) {
			return false;
		}
		wfProfileIn( __METHOD__ );

		if ( !is_array( $wgProxyList ) ) {
			# Load from the specified file
			$wgProxyList = array_map( 'trim', file( $wgProxyList ) );
		}

		if ( !is_array( $wgProxyList ) ) {
			$ret = false;
		} elseif ( array_search( $ip, $wgProxyList ) !== false ) {
			$ret = true;
		} elseif ( array_key_exists( $ip, $wgProxyList ) ) {
			# Old-style flipped proxy list
			$ret = true;
		} else {
			$ret = false;
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Is this user subject to rate limiting?
	 *
	 * @return Bool True if rate limited
	 */
	public function isPingLimitable() {
		global $wgRateLimitsExcludedIPs;
		if( in_array( $this->getRequest()->getIP(), $wgRateLimitsExcludedIPs ) ) {
			// No other good way currently to disable rate limits
			// for specific IPs. :P
			// But this is a crappy hack and should die.
			return false;
		}
		return !$this->isAllowed('noratelimit');
	}

	/**
	 * Primitive rate limits: enforce maximum actions per time period
	 * to put a brake on flooding.
	 *
	 * @note When using a shared cache like memcached, IP-address
	 * last-hit counters will be shared across wikis.
	 *
	 * @param $action String Action to enforce; 'edit' if unspecified
	 * @return Bool True if a rate limiter was tripped
	 * @throws MWException
	 */
	public function pingLimiter( $action = 'edit' ) {
		# Call the 'PingLimiter' hook
		$result = false;
		if ( !Hooks::run( 'PingLimiter', [ $this, $action, $result ] ) ) {
			return $result;
		}

		global $wgRateLimits;
		if( !isset( $wgRateLimits[$action] ) ) {
			return false;
		}

		# Some groups shouldn't trigger the ping limiter, ever
		if( !$this->isPingLimitable() )
			return false;

		global $wgMemc, $wgRateLimitLog;
		wfProfileIn( __METHOD__ );

		$limits = $wgRateLimits[$action];
		$keys = array();
		$id = $this->getId();
		$ip = $this->getRequest()->getIP();
		$userLimit = false;
		$isNewbie = $this->isNewbie();

		if( isset( $limits['anon'] ) && $id == 0 ) {
			$keys[wfMemcKey( 'limiter', $action, 'anon' )] = $limits['anon'];
		}

		if( isset( $limits['user'] ) && $id != 0 ) {
			$userLimit = $limits['user'];
		}

		// limits for anons and for newbie logged-in users
		if ( $isNewbie ) {
			// ip-based limits
			if( isset( $limits['ip'] ) ) {
				$keys["mediawiki:limiter:$action:ip:$ip"] = $limits['ip'];
			}
			// subnet-based limits
			$matches = array();
			if( isset( $limits['subnet'] ) && preg_match( '/^(\d+\.\d+\.\d+)\.\d+$/', $ip, $matches ) ) {
				$subnet = $matches[1];
				$keys["mediawiki:limiter:$action:subnet:$subnet"] = $limits['subnet'];
			}
		}
		// Check for group-specific permissions
		// If more than one group applies, use the group with the highest limit
		foreach ( $this->getGroups() as $group ) {
			if ( isset( $limits[$group] ) ) {
				if ( $userLimit === false || $limits[$group] > $userLimit ) {
					$userLimit = $limits[$group];
				}
			}
		}

		// limits for newbie logged-in users (override all the normal user limits)
		if ( $id !== 0 && $isNewbie && isset( $limits['newbie'] ) ) {
			$userLimit = $limits['newbie'];
		}

		// Set the user limit key
		if ( $userLimit !== false ) {
			$keys[ wfMemcKey( 'limiter', $action, 'user', $id ) ] = $userLimit;
		}

		$triggered = false;
		foreach( $keys as $key => $limit ) {
			[ $max, $period ] = $limit;
			$summary = "(limit $max in {$period}s)";
			$count = $wgMemc->get( $key );
			// Already pinged?
			if( $count ) {
				if( $count > $max ) {
					wfDebug( __METHOD__ . ": tripped! $key at $count $summary\n" );
					if( $wgRateLimitLog ) {
						wfSuppressWarnings();
						file_put_contents( $wgRateLimitLog, wfTimestamp( TS_MW ) . ' ' . wfWikiID() . ': ' . $this->getName() . " tripped $key at $count $summary\n", FILE_APPEND );
						wfRestoreWarnings();
					}
					$triggered = true;
				} else {
					wfDebug( __METHOD__ . ": ok. $key at $count $summary\n" );
				}
			} else {
				wfDebug( __METHOD__ . ": adding record for $key $summary\n" );
				$wgMemc->add( $key, 0, intval( $period ) ); // first ping
			}
			$wgMemc->incr( $key );
		}

		wfProfileOut( __METHOD__ );
		return $triggered;
	}

	/* Wikia change begin - SUS-92 */
	/**
	 * Check if user is blocked
	 *
	 * @param $bFromSlave Bool Whether to check the slave database instead of the master
	 * @param $shouldLogBlockInStats Bool flag that decides whether to log or not in PhalanxStats
	 *
	 * @return Bool True if blocked, false otherwise
	 */
	public function isBlocked( $bFromSlave = true, $shouldLogBlockInStats = true, $global = true ) { // hacked from false due to horrible probs on site
		$block = $this->getBlock( $bFromSlave, $shouldLogBlockInStats, $global );
		return $block instanceof Block && $block->prevents( 'edit' );
	}

	/**
	 * Get the block affecting the user, or null if the user is not blocked
	 *
	 * @param $bFromSlave Bool Whether to check the slave database instead of the master
	 * @param $shouldLogBlockInStats Bool flag that decides whether to log or not in PhalanxStats
	 *
	 * @return Block|null
	 */
	public function getBlock( $bFromSlave = true, $shouldLogBlockInStats = true, $global = true ){
		$this->getBlockedStatus( $bFromSlave, $shouldLogBlockInStats, $global );
		return $this->mBlock instanceof Block ? $this->mBlock : null;
	}
	/* Wikia change end */

	/**
	 * Check if user is blocked from editing a particular article
	 *
	 * @param $title Title to check
	 * @param $bFromSlave Bool whether to check the slave database instead of the master
	 * @return Bool
	 */
	function isBlockedFrom( $title, $bFromSlave = false ) {
		global $wgBlockAllowsUTEdit;
		wfProfileIn( __METHOD__ );

		$blocked = $this->isBlocked( $bFromSlave );
		$allowUsertalk = ( $wgBlockAllowsUTEdit ? $this->mAllowUsertalk : false );
		# If a user's name is suppressed, they cannot make edits anywhere
		if ( !$this->mHideName && $allowUsertalk && $title->getText() === $this->getName() &&
			$title->getNamespace() == NS_USER_TALK ) {
			$blocked = false;
			wfDebug( __METHOD__ . ": self-talk page, ignoring any blocks\n" );
		}

		Hooks::run( 'UserIsBlockedFrom', array( $this, $title, &$blocked, &$allowUsertalk ) );

		wfProfileOut( __METHOD__ );
		return $blocked;
	}

	/**
	 * If user is blocked, return the name of the user who placed the block
	 * @return String name of blocker
	 */
	public function blockedBy() {
		$this->getBlockedStatus();
		return $this->mBlockedby;
	}

	/**
	 * If user is blocked, return the specified reason for the block
	 * @return String Blocking reason
	 */
	public function blockedFor() {
		$this->getBlockedStatus();
		return $this->mBlockreason;
	}

	/**
	 * If user is blocked, return the ID for the block
	 * @return Int Block ID
	 */
	public function getBlockId() {
		$this->getBlockedStatus();
		return ( $this->mBlock ? $this->mBlock->getId() : false );
	}

	/**
	 * Check if user is blocked on all wikis.
	 * Do not use for actual edit permission checks!
	 * This is intented for quick UI checks.
	 *
	 * @param $ip String IP address, uses current client if none given
	 * @return Bool True if blocked, false otherwise
	 */
	public function isBlockedGlobally( $ip = '' ) {
		if( $this->mBlockedGlobally !== null ) {
			return $this->mBlockedGlobally;
		}
		// User is already an IP?
		if( IP::isIPAddress( $this->getName() ) ) {
			$ip = $this->getName();
		} elseif( !$ip ) {
			$ip = $this->getRequest()->getIP();
		}
		$blocked = false;
		Hooks::run( 'UserIsBlockedGlobally', [ $this, $ip, &$blocked ] );
		$this->mBlockedGlobally = (bool)$blocked;
		return $this->mBlockedGlobally;
	}

	/**
	 * Check if user account is locked
	 *
	 * @return Bool True if locked, false otherwise
	 */
	public function isLocked() {
		if( $this->mLocked !== null ) {
			return $this->mLocked;
		}
		global $wgAuth;
		$authUser = $wgAuth->getUserInstance( $this );
		$this->mLocked = (bool)$authUser->isLocked();
		return $this->mLocked;
	}

	/**
	 * Check if user account is hidden
	 *
	 * @return Bool True if hidden, false otherwise
	 */
	public function isHidden() {
		if( $this->mHideName !== null ) {
			return $this->mHideName;
		}
		$this->getBlockedStatus();
		if( !$this->mHideName ) {
			global $wgAuth;
			$authUser = $wgAuth->getUserInstance( $this );
			$this->mHideName = (bool)$authUser->isHidden();
		}
		return $this->mHideName;
	}

	/**
	 * Get the user's ID.
	 * @return Int The user's ID; 0 if the user is anonymous or nonexistent
	 */
	public function getId() {
		if( $this->mId === null && $this->mName !== null
			&& User::isIP( $this->mName ) ) {
			// Special case, we know the user is anonymous
			return 0;
		} elseif( !$this->isItemLoaded( 'id' ) ) {
			// Don't load if this was initialized from an ID
			$this->load();
		}
		return $this->mId;
	}

	/**
	 * Set the user and reload all fields according to a given ID
	 * @param $v Int User ID to reload
	 */
	public function setId( $v ) {
		$this->mId = $v;
		$this->clearInstanceCache( 'id' );
	}

	/**
	 * SUS-3250: Just set the user ID, without any side-effects
	 * @see User::setId() for bad design
	 * @param $userId
	 */
	public function setUserId( $userId ) {
		$this->mId = $userId;

		// make sure user will be loaded from user id
		$this->mFrom = 'id';
		$this->setItemLoaded( 'id' );
	}

	/**
	 * Get the user name, or the IP of an anonymous user
	 * @return String User's name or IP address
	 */
	public function getName() {
		if ( $this->isItemLoaded( 'name', 'only' ) ) {
			# Special case optimisation
			return $this->mName;
		} else {
			$this->load();
			if ( $this->mName === false ) {
				# Clean up IPs
				$this->mName = IP::sanitizeIP( $this->getRequest()->getIP() );
			}
			return $this->mName;
		}
	}

	/**
	 * Set the user name.
	 *
	 * This does not reload fields from the database according to the given
	 * name. Rather, it is used to create a temporary "nonexistent user" for
	 * later addition to the database. It can also be used to set the IP
	 * address for an anonymous user to something other than the current
	 * remote IP.
	 *
	 * @note User::newFromName() has rougly the same function, when the named user
	 * does not exist.
	 * @param $str String New user name to set
	 */
	public function setName( $str ) {
		$this->load();
		$this->mName = $str;
	}

	/**
	 * Get the user's name escaped by underscores.
	 * @return String Username escaped by underscores.
	 */
	public function getTitleKey() {
		return str_replace( ' ', '_', $this->getName() );
	}

	/**
	 * Check if the user has new messages.
	 * @return Bool True if the user has new messages
	 */
	public function getNewtalk() {
		# Wikia change - begin
		# leave early, don't check it for our varnish ip addresses
		global $wgSquidServers, $wgSquidServersNoPurge;
		if( in_array( $this->getName(), $wgSquidServers ) ||
			in_array( $this->getName(), $wgSquidServersNoPurge )
		) {
			return false;
		}
		# Wikia change - end

		$this->load();

		# Load the newtalk status if it is unloaded (mNewtalk=-1)
		if( $this->mNewtalk === -1 ) {
			$this->mNewtalk = (bool) WikiaDataAccess::cache(
				$this->getNewTalkMemcKey(),
				WikiaResponse::CACHE_LONG,
				function() : int {
					// WikiaDataAccess::cache assumes that there's a cache miss
					// when we get either null or false from the caching layer - cast the result to an integer

					// Check memcached separately for anons, who have no
					// entire User object stored in there.
					if ( !$this->mId ) {
						global $wgDisableAnonTalk;
						if ( $wgDisableAnonTalk ) {
							// Anon newtalk disabled by configuration.
							$result = false;
						} else {
							$result = $this->checkNewtalk( 'user_ip', $this->getName() );
						}
					} else {
						$result = $this->checkNewtalk( 'user_id', $this->mId );
					}

					return (int) $result;
				}
			);
		}

		return (bool)$this->mNewtalk;
	}

	/**
	 * Wikia change
	 * @see SUS-2571
	 *
	 * @return string
	 */
	private function getNewTalkMemcKey() : string {
		if ( $this->isAnon() ) {
			return wfMemcKey( 'newtalk', 'ip', $this->getName() );
		}
		else {
			return wfMemcKey( 'newtalk', 'user', $this->getId() );
		}
	}

	/**
	 * Return the talk page(s) this user has new messages on.
	 * @return string[] page URLs
	 */
	public function getNewMessageLinks() {
		$talks = [];
		Hooks::run( 'UserRetrieveNewTalks', [ $this, &$talks ] );

		/* Wikia change begin */
		if ( $this->getNewtalk() ) {
			global $wgCityId, $wgSitename;
			$up = $this->getUserPage();
			$utp = $up->getTalkPage();
			unset( $talks[$wgCityId] );
			$talks[0] = [ "wiki" => $wgSitename, "link" => $utp->getFullURL() ];

			return $talks;
		}

		return array_values( $talks );
		/* Wikia change end */
	}

	/**
	 * Internal uncached check for new messages
	 *
	 * @see getNewtalk()
	 * @param $field String 'user_ip' for anonymous users, 'user_id' otherwise
	 * @param $id String|Int User's IP address for anonymous users, User ID otherwise
	 * @return Bool True if the user has new messages
	 */
	protected function checkNewtalk( $field, $id ) {
		$db = wfGetDB( DB_SLAVE );

		$ok = $db->selectField( 'user_newtalk', $field,
			array( $field => $id ), __METHOD__ );
		return $ok !== false;
	}

	/**
	 * Add or update the new messages flag
	 * @param $field String 'user_ip' for anonymous users, 'user_id' otherwise
	 * @param $id String|Int User's IP address for anonymous users, User ID otherwise
	 * @return Bool True if successful, false otherwise
	 */
	protected function updateNewtalk( $field, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'user_newtalk',
			array( $field => $id ),
			__METHOD__,
			'IGNORE' );
		if ( $dbw->affectedRows() ) {
			wfDebug( __METHOD__ . ": set on ($field, $id)\n" );
			return true;
		} else {
			wfDebug( __METHOD__ . " already set ($field, $id)\n" );
			return false;
		}
	}

	/**
	 * Clear the new messages flag for the given user
	 * @param $field String 'user_ip' for anonymous users, 'user_id' otherwise
	 * @param $id String|Int User's IP address for anonymous users, User ID otherwise
	 * @return Bool True if successful, false otherwise
	 */
	protected function deleteNewtalk( $field, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_newtalk',
			array( $field => $id ),
			__METHOD__ );
		if ( $dbw->affectedRows() ) {
			wfDebug( __METHOD__ . ": killed on ($field, $id)\n" );
			return true;
		} else {
			wfDebug( __METHOD__ . ": already gone ($field, $id)\n" );
			return false;
		}
	}

	/**
	 * Update the 'You have new messages!' status.
	 * @param $val Bool Whether the user has new messages
	 */
	public function setNewtalk( $val ) {
		if( wfReadOnly() ) {
			return;
		}

		$this->load();
		$this->mNewtalk = $val;

		if( $this->isAnon() ) {
			$field = 'user_ip';
			$id = $this->getName();
		} else {
			$field = 'user_id';
			$id = $this->getId();
		}

		if( $val ) {
			$changed = $this->updateNewtalk( $field, $id );
		} else {
			$changed = $this->deleteNewtalk( $field, $id );
		}

		// Wikia change - start
		// SUS-2571 - store the updated new talk state to avoid database queries
		// cast the value to an integer to avoid false cache misses in WikiaDataAccess::cache
		global $wgMemc;
		$wgMemc->set( $this->getNewTalkMemcKey(), (int) $val, WikiaResponse::CACHE_LONG );
		// Wikia change - end

		if ( $changed ) {
			// Bust article ETags for this user, to ensure they receive the message notification
			// SRE-109: Use touch() to avoid needless DB queries; it's sufficient as per r59993
			$this->touch();
		}
	}

	/**
	 * Generate a current or new-future timestamp to be stored in the
	 * user_touched field when we update things.
	 * @return String Timestamp in TS_MW format
	 */
	public static function newTouchedTimestamp() {
		global $wgClockSkewFudge;
		return wfTimestamp( TS_MW, time() + $wgClockSkewFudge );
	}

	/**
	 * Clear user data from memcached.
	 * Use after applying fun updates to the database; caller's
	 * responsibility to update user_touched if appropriate.
	 *
	 * Called implicitly from invalidateCache() and saveSettings().
	 */
	private function clearSharedCache() {
		$this->load();
		if( $this->mId ) {
			global $wgMemc;
			$this->deleteCache();

			// Wikia: and save updated user data in the cache to avoid memcache miss and DB query
			$this->saveToCache();

			$wgMemc->set( $this->getUserTouchedKey(), $this->mTouched );
			wfDebug( "Shared user: updating shared user_touched\n" );
		}
	}

	/**
	 * Immediately touch the user data cache for this account.
	 *
	 * Calls touch() and removes account data from memcached
	 *
	 * @see SUS-1620
	 */
	public function invalidateCache() {
		$this->touch();
		$this->clearSharedCache();

		// Wikia change
		self::permissionsService()->invalidateCache( $this );
	}

	/**
	 * This method should be used to clear all cache for the user, not just account data, but also Masthead,
	 * contributions and others. This should be used when user is renamed, anonymized and so on.
	 */
	public function deleteCache() {
		global $wgMemc, $wgCityId;

		$this->load();

		$userCache = new UserIdCacheKeys( $this->getId() );
		foreach ( $userCache->getAllKeys() as $key) {
			$wgMemc->delete( $key);
		}
		$usernameCache = new UserNameCacheKeys( $this->getName() );
		foreach ( $usernameCache->getAllKeys( $wgCityId ) as $key) {
			$wgMemc->delete($key);
		}
	}

	/**
	 * Update the "touched" timestamp for the user
	 *
	 * This is useful on various login/logout events when making sure that
	 * a browser or proxy that has multiple tenants does not suffer cache
	 * pollution where the new user sees the old users content. The value
	 * of getTouched() is checked when determining 304 vs 200 responses.
	 * Unlike invalidateCache(), this preserves the User object cache and
	 * avoids database writes.
	 *
	 * @@see SUS-1620
	 * @since 1.25
	 */
	public function touch() {
		global $wgMemc;

		$this->load();

		if ( $this->mId ) {
			$key = wfSharedMemcKey( 'user-quicktouched', 'id', $this->mId );
			$timestamp = self::newTouchedTimestamp();
			$wgMemc->set( $key, $timestamp );
			$this->mQuickTouched = $timestamp;
		}
	}

	/**
	 * Validate the cache for this account.
	 * @param $timestamp String A timestamp in TS_MW format
	 *
	 * @return bool
	 */
	public function validateCache( $timestamp ) {
		$this->load();
		return ( $timestamp >= $this->mTouched );
	}

	/**
	 * Get the user touched timestamp
	 * @return string TS_MW Timestamp
	 */
	public function getTouched() {
		global $wgMemc;

		$this->load();

		if ( $this->mId ) {
			if ( $this->mQuickTouched === null ) {
				$key = wfSharedMemcKey( 'user-quicktouched', 'id', $this->mId );
				$timestamp = $wgMemc->get( $key );
				if ( !$timestamp ) {
					# Set the timestamp to get HTTP 304 cache hits
					$this->touch();
				}
			}

			return max( $this->mTouched, $this->mQuickTouched );
		}

		return $this->mTouched;
	}

	/**
	 * Set the password and reset the random token.
	 * Calls through to authentication plugin if necessary;
	 * will have no effect if the auth plugin refuses to
	 * pass the change through or if the legal password
	 * checks fail.
	 *
	 * As a special case, setting the password to null
	 * wipes it, so the account cannot be logged in until
	 * a new password is set, for instance via e-mail.
	 *
	 * @param string $password New password to set
	 * @param bool   $forceLogout
	 *
	 * @return bool on failure
	 *
	 * @throws Exception
	 * @throws PasswordError on failure
	 */
	public function setPassword( $password, $forceLogout = true ) {
		if ( is_null( $password ) ) {
			$this->heliosDeletePassword();
		} else {
			$this->heliosSetNewPassword( $password );
		}

		$this->setToken();

		if ( $forceLogout ) {
			self::heliosClient()->forceLogout( $this->getId() );
		}

		return true;
	}

	private function heliosSetNewPassword( $password ) {
		$heliosPasswordChange = null;

		$heliosPasswordChange = self::heliosClient()->setPassword( $this->getId(), $password );

		if ( empty( $heliosPasswordChange ) ) {
			$this->error( 'Helios password set communication failed', [
				'userId' => $this->getId(),
			] );
			throw new PasswordError( wfMessage( 'externaldberror' )->text() );
		}

		if ( !empty( $heliosPasswordChange->errors ) ) {
			$this->error( 'Helios password set failed', [
				'userId' => $this->getId(),
				'err'    => $heliosPasswordChange,
			] );
			throw new PasswordError( wfMessage( $heliosPasswordChange->errors[0]->description )->text() );
		}
	}

	private function heliosDeletePassword() {
		$result = self::heliosClient()->deletePassword( $this->getId() );

		if ( empty( $result ) ) {
			$this->error( 'Helios password deletion communication failed', [
				'userId' => $this->getId(),
			] );
			throw new PasswordError( wfMessage( 'externaldberror' )->text() );
		}

		if ( !empty( $result->errors ) ) {
			$this->error( 'Helios password deletion failed', [
				'userId' => $this->getId(),
				'err'    => $result,
			] );
			throw new PasswordError( wfMessage( $result->errors[0]->description )->text() );
		}
	}

	/**
	 * Get the user's current token.
	 * @param boolean $forceCreation Force the generation of a new token if the user doesn't have one (default=true for backwards compatibility)
	 * @return String Token
	 */
	public function getToken( $forceCreation = true ) {
		$this->load();
		if ( !$this->mToken && $forceCreation ) {
			$this->setToken();
		}
		return $this->mToken;
	}

	/**
	 * Set the random token (used for persistent authentication)
	 * Called from loadDefaults() among other places.
	 *
	 * @param $token String|bool If specified, set the token to this value
	 */
	public function setToken( $token = false ) {
		$this->load();
		if ( !$token ) {
			$this->mToken = MWCryptRand::generateHex( USER_TOKEN_LENGTH );
		} else {
			$this->mToken = $token;
		}
	}

	/**
	 * Get the user's e-mail address
	 * @return String User's email address
	 */
	public function getEmail() {
		$this->load();
		Hooks::run( 'UserGetEmail', array( $this, &$this->mEmail ) );
		return $this->mEmail;
	}

	/**
	 * Return the new email address that is waiting for confirmation
	 *
	 * @return string
	 */
	public function getNewEmail() {
		return $this->getGlobalAttribute( 'new_email' );
	}

	/**
	 * Sets a new email address, to be confirmed
	 *
	 * @param $newEmail
	 */
	public function setNewEmail( $newEmail ) {
		$this->setGlobalAttribute( 'new_email', $newEmail );
	}

	/**
	 * Clear out the new email after its been confirmed
	 */
	public function clearNewEmail() {
		$this->setGlobalAttribute( 'new_email', null );
	}

	/**
	 * Get the timestamp of the user's e-mail authentication
	 * @return String TS_MW timestamp
	 */
	public function getEmailAuthenticationTimestamp() {
		$this->load();
		Hooks::run( 'UserGetEmailAuthenticationTimestamp', array( $this, &$this->mEmailAuthenticated ) );
		return $this->mEmailAuthenticated;
	}

	/**
	 * Set the user's e-mail address
	 * @param $str String New e-mail address
	 */
	public function setEmail( $str ) {
		$this->load();
		if( $str == $this->mEmail ) {
			return;
		}

		/* Wikia change */
		/* add a new hook that sends both before/after emails @param User, new_email, old_email */
		Hooks::run( 'BeforeUserSetEmail', array( $this, $str, $this->mEmail ) );

		$this->mEmail = $str;

		/* Wikia change begin - @author: Macbre */
		/* invalidate empty email - RT #44046 */
		if ($str == '') {
			$this->invalidateEmail();
		}
		/* Wikia change end */

		Hooks::run( 'UserSetEmail', array( $this, &$this->mEmail ) );
	}

	/**
	 * Get the user's real name
	 * @return String User's real name
	 */
	public function getRealName() {
		if ( !$this->isItemLoaded( 'realname' ) ) {
			$this->load();
		}

		return $this->mRealName;
	}

	/**
	 * Set the user's real name
	 * @param $str String New real name
	 */
	public function setRealName( $str ) {
		$this->load();
		$this->mRealName = $str;
	}

	/**
	 * @param $oname
	 * @param null $defaultOverride
	 * @param bool|false $ignoreHidden
	 * @return String
	 * @deprecated use get(Global|Local)Preference  get(Global|Local)Attribute or get(Global|Local)Flag
	 */
	public function getOption($oname, $defaultOverride = null, $ignoreHidden = false) {
		if ($this->getOrSetOptionSampler()->shouldSample()) {
			$this->warning("calling getOption", [
				"class" => "user",
				"type" => "getoption",
				"option" => $oname,
				"source" => wfBacktrace(true),
			]);
		}

		return $this->getOptionHelper($oname, $defaultOverride, $ignoreHidden);
	}

	/**
	 * Get the user's current setting for a given option.
	 *
	 * @param $oname String The option to check
	 * @param $defaultOverride String A default value returned if the option does not exist
	 * @param $ignoreHidden Bool = whether to ignore the effects of $wgHiddenPrefs
	 * @return String User's current value for the option
	 * @see getBoolOption()
	 * @see getIntOption()
	 */
	private function getOptionHelper( $oname, $defaultOverride = null, $ignoreHidden = false ) {
		global $wgHiddenPrefs;
		$this->loadOptions();

		if ( is_null( $this->mOptions ) ) {
			if($defaultOverride != '') {
				return $defaultOverride;
			}
			$this->mOptions = User::getDefaultOptions();
		}

		# We want 'disabled' preferences to always behave as the default value for
		# users, even if they have set the option explicitly in their settings (ie they
		# set it, and then it was disabled removing their ability to change it).  But
		# we don't want to erase the preferences in the database in case the preference
		# is re-enabled again.  So don't touch $mOptions, just override the returned value
		if( in_array( $oname, $wgHiddenPrefs ) && !$ignoreHidden ) {
			return self::getDefaultOption( $oname );
		}

		if ( array_key_exists( $oname, $this->mOptions ) ) {

			/* Wikia change begin - @author: Macbre */
			/* allow extensions to modify value returned by User::getOption() */
			/* make local copy of option value, so hook won't modify value read from DB and store in object */
			$value = $this->mOptions[$oname];

			Hooks::run( 'UserGetOption', array( $this->mOptions, $oname, &$value ) );

			return $value;
			/* Wikia change end */
		} else {
			return $defaultOverride;
		}
	}

	/**
	 * Get all user's options
	 *
	 * @return array
	 * @deprecated use get(Global|Local)Preference  get(Global|Local)Attribute or get(Global|Local)Flag
	 */
	public function getOptions() {
		global $wgHiddenPrefs;
		$this->loadOptions();
		$options = $this->mOptions;

		# We want 'disabled' preferences to always behave as the default value for
		# users, even if they have set the option explicitly in their settings (ie they
		# set it, and then it was disabled removing their ability to change it).  But
		# we don't want to erase the preferences in the database in case the preference
		# is re-enabled again.  So don't touch $mOptions, just override the returned value
		foreach( $wgHiddenPrefs as $pref ){
			$default = self::getDefaultOption( $pref );
			if( $default !== null ){
				$options[$pref] = $default;
			}
		}

		// Populate with attributes from attribute service
		foreach ( $this->userAttributes()->getAttributes( $this->getId() ) as $attrName => $attrValue ) {
			$options[$attrName] = $attrValue;
		}

		// Populate with user global preferences, and wiki local preferences
		$preferences = $this->userPreferences()->getPreferences( $this->getId() );

		foreach ( $preferences->getGlobalPreferences() as $globalPreference ) {
			$options[ $globalPreference->getName() ] = $globalPreference->getValue();
		}

		global $wgCityId;
		$localPreferences = $preferences->getLocalPreferencesForWiki( $wgCityId );

		foreach ( $localPreferences as $localPreference ) {
			$options[ $localPreference->getName() ] = $localPreference->getValue();
		}

		return $options;
	}

	/**
	 * Get the user's current setting for a given option, as a boolean value.
	 *
	 * @param $oname String The option to check
	 * @return Bool User's current value for the option
	 * @deprecated use get(Global|Local)Preference  get(Global|Local)Attribute or get(Global|Local)Flag
	 * @see getOption()
	 */
	public function getBoolOption( $oname ) {
		return (bool)$this->getOption( $oname );
	}

	/**
	 * Get the user's current setting for a given option, as a boolean value.
	 *
	 * @param $oname String The option to check
	 * @param $defaultOverride Int A default value returned if the option does not exist
	 * @return Int User's current value for the option
	 * @deprecated use get(Global|Local)Preference  get(Global|Local)Attribute or get(Global|Local)Flag
	 */
	public function getIntOption( $oname, $defaultOverride=0 ) {
		$val = $this->getOption( $oname );
		if( $val == '' ) {
			$val = $defaultOverride;
		}
		return intval( $val );
	}

	/**
	 * Get a preference local to this wikia.
	 *
	 * Refere to getGlobalPreference for more detailed documentation.
	 *
	 * @param string $preference the preference name
	 * @param int $cityId the city id
	 * @param string $sep the separator between the name and the city id
	 * @param mixed $default
	 * @param bool $ignoreHidden
	 * @return string
	 * @see getGlobalPreference
	 */
	public function getLocalPreference($preference, $cityId, $sep = "-", $default = null, $ignoreHidden = false) {
		global $wgPreferenceServiceRead;

		if ($wgPreferenceServiceRead) {
			$value = $this->userPreferences()->getLocalPreference($this->getId(), $cityId, $preference, $default, $ignoreHidden);
		} else {
			$preferenceGlobalName = self::localToGlobalPropertyName($preference, $cityId, $sep);
			$value = $this->getOptionHelper($preferenceGlobalName, $default, $ignoreHidden);
		}

		return $value;
	}

	/**
	 * Get a global user preference.
	 *
	 * Preferences are options that typically alter the users experience. Some
	 * examples include the skin, language, and whether or not marketing is
	 * allowed.
	 *
	 * @param string $preference
	 * @param mixed $default
	 * @param bool $ignoreHidden
	 * @return string
	 */
	public function getGlobalPreference($preference, $default = null, $ignoreHidden = false) {
		global $wgPreferenceServiceRead;

		if ($wgPreferenceServiceRead) {
			$preferences = [];
			$value = $this->userPreferences()->getGlobalPreference($this->getId(), $preference, $default, $ignoreHidden);
			foreach ($this->userPreferences()->getPreferences($this->getId())->getGlobalPreferences() as $globalPreference) {
				$preferences[$globalPreference->getName()] = $globalPreference->getValue();
			}

			Hooks::run(
				'UserGetPreference',
				[
					$preferences,
					$preference,
					&$value
				]
			);
		} else {
			$value = $this->getOptionHelper($preference, $default, $ignoreHidden);
		}

		return $value;
	}

	/**
	 * Set a preference local to a wikia. See createLocalOptionName for details regarding
	 * the format. Note that the $sep param is provided in the rare case where
	 * the option name is not normal. Should you have to use the separator, PLEASE MAKE
	 * A PLAN TO NORMALIZE IT TO "-".
	 *
	 * @param string $preference
	 * @param string $value
	 * @param int $cityId [optional, defaults to $wgCityId]
	 * @param string $sep [optional, defaults to '-']
	 * @see getGlobalPreference
	 */
	public function setLocalPreference($preference, $value, $cityId, $sep = '-') {
		global $wgPreferenceServiceWrite;

		if ( $wgPreferenceServiceWrite ) {
			$value = $this->replaceNewlineAndCRWithSpace( $value );
			$this->userPreferences()->setLocalPreference( $this->getId(), $cityId, $preference, $value );
		} else {
			$preferenceGlobalName = self::localToGlobalPropertyName($preference, $cityId, $sep);
			$this->setOptionHelper( $preferenceGlobalName, $value );
		}
	}

	/**
	 * Set a global user preference.
	 *
	 * @param string $preference
	 * @param string $value
	 * @see getGlobalPreference for documentation about preferences
	 */
	public function setGlobalPreference( $preference, $value ) {
		global $wgPreferenceServiceWrite;

		if ( $wgPreferenceServiceWrite ) {
			$value = $this->replaceNewlineAndCRWithSpace( $value );
			$this->userPreferences()->setGlobalPreference( $this->getId(), $preference, $value );
			if ( $preference == 'skin' ) {
				unset( $this->mSkin );
			}
		} else {
			$this->setOptionHelper( $preference, $value );
		}
	}

	/**
	 * @param String $preference set to default
	 * for now its support only old aproach to handle preferences (get/set Option)
	 * It will be handled with https://wikia-inc.atlassian.net/browse/SERVICES-483
	 */
	public function removeGlobalPreference($preference){
		unset( $this->mOptions[ $preference ] );
	}

	/**
	 * Get the default global preference.
	 *
	 * @param string $preference
	 * @return string
	 * @see getGlobalPreference for documentation about preferences
	 */
	public function getDefaultGlobalPreference( $preference ) {
		return $this->userPreferences()->getGlobalDefault( $preference );
	}

	/**
	 * Get a global user attribute.
	 *
	 * Attributes are facts about the user such as their avatar URL, their
	 * location, or their twitter username.
	 *
	 * @param string $attribute
	 * @param mixed $default
	 * @return string
	 */
	public function getGlobalAttribute( $attribute, $default = null ) {

		if ( $this->shouldGetAttributeFromService( $attribute ) ) {
			return $this->userAttributes()->getAttribute( $this->getId(), $attribute, $default );
		}

		return $this->getOptionHelper($attribute, $default);
	}

	/**
	 * @param $attributeName
	 * @return bool
	 */
	private function shouldGetAttributeFromService( $attributeName ) {
		return $this->isPublicAttribute( $attributeName );
	}

	private function isPublicAttribute( $attributeName ) {
		global $wgPublicUserAttributes;

		return in_array( $attributeName, $wgPublicUserAttributes );
	}

	/**
	 * Set a global user attribute. You also have to call `saveSettings` for the value to be saved in the DB.
	 *
	 * @param string $attribute
	 * @param string $value
	 * @see getGlobalAttribute for more documentation about attributes
	 */
	public function setGlobalAttribute( $attribute, $value ) {
		if ( $this->isPublicAttribute( $attribute ) ) {
			$value = $this->replaceNewlineAndCRWithSpace( $value );
			$this->userAttributes()->setAttribute( $this->getId(), new Attribute( $attribute, $value ) );
		} else {
			$this->setOptionHelper( $attribute, $value );
		}
	}

	/**
	 * Get a user flag local to a wikia.
	 *
	 * @param string $flag the flag name
	 * @param int $cityId the city id
	 * @param string $sep the separator between the name and the city id
	 * @return bool
	 * @see getGlobalFlag for more documentation about flags
	 */
	public function getLocalFlag( $flag, $cityId = null, $sep = '-' ) {
		$name = self::localToGlobalPropertyName( $flag, $cityId, $sep );
		return $this->getGlobalFlag( $name );
	}

	/**
	 * Set a user flag local to a wikia.
	 *
	 * @param string $flag the flag name
	 * @param bool $value The value of the flag
	 * @param int $cityId the city id
	 * @param string $sep the separator between the name and the city id
	 * @see getGlobalFlag for more documentation about flags
	 */
	public function setLocalFlag( $flag, $value, $cityId = null, $sep = '-' ) {
		$name = self::localToGlobalPropertyName( $flag, $cityId, $sep );
		$this->setGlobalFlag( $name, $value );
	}

	/**
	 * Get a global user flag.
	 *
	 * Flags are typically boolean settings that are used internally to signify
	 * something about the user.
	 *
	 * @param string $flag
	 * @param bool $default
	 * @return bool
	 */
	public function getGlobalFlag($flag, $default = null) {
		return $this->getOptionHelper($flag, $default);
	}

	/**
	 * Set a global user flag.
	 *
	 * @param string $flag
	 * @param        $value
	 *
	 * @return bool
	 * @see getGlobalFlag for more documentation about flags
	 */
	public function setGlobalFlag($flag, $value) {
		$this->setOptionHelper($flag, $value);
	}

	/**
	 * Create a local option name. All localized (wikia specific) options,
	 * preferences, attributes or flags should be of the form "{option}-{cityId}"
	 *
	 * IF YOU USE $sep, MAKE A PLAN TO NORMALIZE IT TO "-"!
	 *
	 * @param string $property
	 * @param int $cityId [optional]
	 * @param string $sep the separator between the option and the id.
	 * @return string
	 */
	public static function localToGlobalPropertyName($property, $cityId = null, $sep = '-') {
		global $wgCityId;
		if (!isset($cityId)) {
			$cityId = $wgCityId;
		}

		return sprintf("%s%s%s", $property, $sep, $cityId);
	}

	private function replaceNewlineAndCRWithSpace($value) {
		if ($value) {
			$value = str_replace("\r\n", "\n", $value);
			$value = str_replace("\r", "\n", $value);
			$value = str_replace("\n", " ", $value);
		}

		return $value;
	}

	/**
	 * @param $oname
	 * @param $val
	 * @deprecated use set(Global|Local)Preference  set(Global|Local)Attribute or set(Global|Local)Flag
	 */
	public function setOption( $oname, $val ) {
		if ($this->getOrSetOptionSampler()->shouldSample()) {
			$this->warning("calling setOption", [
				"class" => "user",
				"type" => "setoption",
				"source" => wfBacktrace(true),
			]);
		}

		$this->setOptionHelper($oname, $val);
	}

	/**
	 * Set the given option for a user.
	 *
	 * @param $oname String The option to set
	 * @param $val mixed New value to set
	 */
	private function setOptionHelper( $oname, $val ) {
		$this->load();
		$this->loadOptions();

		if ( $oname == 'skin' ) {
			# Clear cached skin, so the new one displays immediately in Special:Preferences
			unset( $this->mSkin );
		}
		// Filter out any newlines that may have passed through input validation.
		// Newlines are used to separate items in the options blob.
		$val = $this->replaceNewlineAndCRWithSpace($val);
		// Explicitly NULL values should refer to defaults
		global $wgDefaultUserOptions;
		if( is_null( $val ) && isset( $wgDefaultUserOptions[$oname] ) ) {
			$val = $wgDefaultUserOptions[$oname];
		}

		$this->mOptions[$oname] = $val;
	}

	/**
	 * Reset all options to the site defaults
	 */
	public function resetOptions() {
		$this->mOptions = self::getDefaultOptions();
	}

	/**
	 * Get the user's preferred date format.
	 * @return String User's preferred date format
	 */
	public function getDatePreference() {
		// Important migration for old data rows
		if ( is_null( $this->mDatePreference ) ) {
			global $wgLang;
			$value = $this->getGlobalPreference( 'date' );
			$map = $wgLang->getDatePreferenceMigrationMap();
			if ( isset( $map[$value] ) ) {
				$value = $map[$value];
			}
			$this->mDatePreference = $value;
		}
		return $this->mDatePreference;
	}

	/**
	 * Get the user preferred stub threshold
	 *
	 * @return int
	 */
	public function getStubThreshold() {
		global $wgMaxArticleSize; # Maximum article size, in Kb
		$threshold = intval( $this->getGlobalPreference( 'stubthreshold' ) );
		if ( $threshold > $wgMaxArticleSize * 1024 ) {
			# If they have set an impossible value, disable the preference
			# so we can use the parser cache again.
			$threshold = 0;
		}
		return $threshold;
	}

	/**
	 * Get the user's edit count.
	 * NOTE: UserStatsService:getEditCountWiki function retrieves User object inside
	 * due to this fact localized editcount shouldn't be a field of User class
	 * to avoid infinite loop
	 * @return Int
	 */
	public function getEditCount() {
		if ( $this->getId() ) {
			$userStatsService = new UserStatsService( $this->mId );
			return $userStatsService->getEditCountWiki();
		}

		return 0;
	}

	/**
	 * Get whether the user is logged in
	 * @return Bool
	 */
	public function isLoggedIn() {
		return $this->getId() != 0;
	}

	/**
	 * Get whether the user is anonymous
	 * @return Bool
	 */
	public function isAnon() {
		return !$this->isLoggedIn();
	}

	/**
	 * Checks if two user objects point to the same user.
	 *
	 * Ported from MW 1.25 by Michał Roszka
	 *
	 * @since 1.25
	 * @param User $user
	 * @return bool
	 */
	public function equals( User $user ) {
		return $this->getName() === $user->getName();
	}

	/**
	 * Check whether to enable recent changes patrol features for this user
	 * @return Boolean: True or false
	 */
	public function useRCPatrol() {
		global $wgUseRCPatrol;
		return $wgUseRCPatrol && $this->isAllowedAny( 'patrol', 'patrolmarks' );
	}

	/**
	 * Check whether to enable new pages patrol features for this user
	 * @return Bool True or false
	 */
	public function useNPPatrol() {
		global $wgUseRCPatrol, $wgUseNPPatrol;
		return( ( $wgUseRCPatrol || $wgUseNPPatrol ) && ( $this->isAllowedAny( 'patrol', 'patrolmarks' ) ) );
	}

	/**
	 * Get the WebRequest object to use with this object
	 *
	 * @return WebRequest
	 */
	public function getRequest() {
		if ( $this->mRequest ) {
			return $this->mRequest;
		}
		global $wgRequest;
		return $wgRequest;
	}

	/**
	 * Get the current skin, loading it if required
	 * @return Skin The current skin
	 * @todo FIXME: Need to check the old failback system [AV]
	 * @deprecated since 1.18 Use ->getSkin() in the most relevant outputting context you have
	 */
	public function getSkin() {
		wfDeprecated( __METHOD__, '1.18' );
		return RequestContext::getMain()->getSkin();
	}

	/**
	 * Check the watched status of an article.
	 * @param $title Title of the article to look at
	 * @return Bool
	 */
	public function isWatched( $title ) {
		$wl = WatchedItem::fromUserTitle( $this, $title );
		return $wl->isWatched();
	}

	/**
	 * Watch an article.
	 * @param $title Title of the article to look at
	 */
	public function addWatch( $title ) {
		$wl = WatchedItem::fromUserTitle( $this, $title );
		$wl->addWatch();

		// Bust article ETags for this user, to ensure that "watch" links change to "unwatch" links
		// SRE-109: Use touch() to avoid needless DB queries; it's sufficient as per r59993
		$this->touch();
	}

	/**
	 * Stop watching an article.
	 * @param $title Title of the article to look at
	 */
	public function removeWatch( $title ) {
		$wl = WatchedItem::fromUserTitle( $this, $title );
		$wl->removeWatch();

		// Bust article ETags for this user, to ensure that "unwatch" links change to "watch" links
		// SRE-109: Use touch() to avoid needless DB queries; it's sufficient as per r59993
		$this->touch();
	}

	/**
	 * Clear the user's notification timestamp for the given title.
	 * If e-notif e-mails are on, they will receive notification mails on
	 * the next change of the page if it's watched etc.
	 * @param $title Title of the article to look at
	 */
	public function clearNotification( Title $title ) {
		global $wgUseEnotif, $wgShowUpdatedMarker;

		# Do nothing if the database is locked to writes
		if( wfReadOnly() ) {
			return;
		}

		if ( $title->getNamespace() == NS_USER_TALK && $title->getText() == $this->getName() ) {
			if ( !Hooks::run( 'UserClearNewTalkNotification', [ $this ] ) ) {
				return;
			}

			// SUS-2161: Only schedule a notification update if there are new messages
			if ( $this->getNewtalk() ) {
				$task = \Wikia\Tasks\Tasks\WatchlistUpdateTask::newLocalTask();
				$task->title( $title );
				$task->call( 'clearMessageNotification', $this->getName() );
				$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
				$task->queue();
			}
		}

		if( !$wgUseEnotif && !$wgShowUpdatedMarker ) {
			return;
		}

		if( $this->isAnon() ) {
			// Nothing else to do...
			return;
		}

		// Only update the timestamp if the page is being watched.
		// The query to find out if it is watched is cached both in memcached and per-invocation,
		// and when it does have to be executed, it can be on a slave
		// If this is the user's newtalk page, we always update the timestamp
		if( $title->getNamespace() == NS_USER_TALK &&
			$title->getText() == $this->getName() )
		{
			$watched = true;
		} else {
			$watched = $this->isWatched( $title );
		}

		// If the page is watched by the user (or may be watched), update the timestamp on any
		// any matching rows
		if ( $watched ) {
			// SUS-2161: Use a background task for watchlist update
			$task = \Wikia\Tasks\Tasks\WatchlistUpdateTask::newLocalTask();
			$task->title( $title );
			$task->call( 'clearWatch', $this->getId() );
			$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
			$task->queue();
		}
	}

	/**
	 * Resets all of the given user's page-change notification timestamps.
	 * If e-notif e-mails are on, they will receive notification mails on
	 * the next change of any watched page.
	 */
	public function clearAllNotifications() {
		global $wgUseEnotif, $wgShowUpdatedMarker;
		if ( !$wgUseEnotif && !$wgShowUpdatedMarker ) {
			$this->setNewtalk( false );
			return;
		}
		$id = $this->getId();
		if( $id != 0 )  {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'watchlist',
				array( /* SET */
					'wl_notificationtimestamp' => null
				), array( /* WHERE */
					'wl_user' => $id
				), __METHOD__
			);

			Hooks::run( 'User::resetWatch', array ( $id ) );
			# 	We also need to clear here the "you have new message" notification for the own user_talk page
			#	This is cleared one page view later in Article::viewUpdates();
		}
	}

	/** Wikia Change - begin - bringing this function back (don't see any harm in it and it's used in a few places) **/
	/**
	 * Encode this user's options as a string
	 * @return \string Encoded options
	 * @private
	 */
	function encodeOptions() {
		$this->load();
		if ( is_null( $this->mOptions ) ) {
			$this->mOptions = User::getDefaultOptions();
		}
		$a = array();
		foreach ( $this->mOptions as $oname => $oval ) {
			array_push( $a, $oname.'='.$oval );
		}
		$s = implode( "\n", $a );
		return $s;
	}
	/** Wikia Change - end - bringing this function back (don't see any harm in it and it's used in a few places) **/

	/**
	 * Set this user's options from an encoded string
	 * @param $str String Encoded options to import
	 *
	 * @deprecated in 1.19 due to removal of user_options from the user table
	 */
	private function decodeOptions( $str ) {
		wfDeprecated( __METHOD__, '1.19' );
		if( !$str )
			return;

		$this->mOptionsLoaded = true;
		$this->mOptionOverrides = array();

		// If an option is not set in $str, use the default value
		$this->mOptions = self::getDefaultOptions();

		$a = explode( "\n", $str );
		foreach ( $a as $s ) {
			$m = array();
			if ( preg_match( "/^(.[^=]*)=(.*)$/", $s, $m ) ) {
				$this->mOptions[$m[1]] = $m[2];
				$this->mOptionOverrides[$m[1]] = $m[2];
			}
		}
	}

	/**
	 * Set a cookie on the user's client. Wrapper for
	 * WebResponse::setCookie
	 * @param $name String Name of the cookie to set
	 * @param $value String Value to set
	 * @param $exp Int Expiration time, as a UNIX time value;
	 *                   if 0 or not specified, use the default $wgCookieExpiration
	 */
	protected function setCookie( $name, $value, $exp = 0 ) {
		$this->getRequest()->response()->setcookie( $name, $value, $exp );
	}

	/**
	 * Clear a cookie on the user's client
	 * @param $name String Name of the cookie to clear
	 */
	protected function clearCookie( $name ) {
		$this->setCookie( $name, '', time() - 86400 );
	}

	/**
	 * Set the default cookies for this session on the user's client.
	 *
	 * @param $request WebRequest object to use; $wgRequest will be used if null
	 *        is passed.
	 */
	public function setCookies( $request = null ) {
		if ( $request === null ) {
			$request = $this->getRequest();
		}

		$this->load();
		if ( 0 == $this->mId ) return;
		if ( !$this->mToken ) {
			// When token is empty or NULL generate a new one and then save it to the database
			// This allows a wiki to re-secure itself after a leak of it's user table or $wgSecretKey
			// Simply by setting every cell in the user_token column to NULL and letting them be
			// regenerated as users log back into the wiki.
			$this->setToken();
			$this->saveSettings();
		}
		$session = array(
			'wsUserID' => $this->mId,
			'wsToken' => $this->mToken,
			'wsUserName' => $this->getName()
		);
		$cookies = array(
			'UserID' => $this->mId,
			'UserName' => $this->getName(),
		);
		if ( 1 == $this->getGlobalPreference( 'rememberpassword' ) ) {
			$cookies['Token'] = $this->mToken;
		} else {
			$cookies['Token'] = false;
		}

		Hooks::run( 'UserSetCookies', array( $this, &$session, &$cookies ) );

		foreach ( $session as $name => $value ) {
			$request->setSessionData( $name, $value );
		}
		foreach ( $cookies as $name => $value ) {
			if ( $value === false ) {
				$this->clearCookie( $name );
			} else {
				$this->setCookie( $name, $value );
			}
		}

		if ( !empty( $this->getGlobalAuthToken() ) ) {
			// Set Helios token
			self::authCookieHelper()->setAuthenticationCookieWithToken( $this->getGlobalAuthToken(), $request->response() );
		}
	}

	/**
	 * Log this user out.
	 */
	public function logout() {
		if ( Hooks::run( 'UserLogout', [ $this ] ) ) {
			$this->doLogout();
		}
	}

	/**
	 * Clear the user's cookies and session, and reset the instance cache.
	 * @see logout()
	 */
	public function doLogout() {
		$accessToken = self::authCookieHelper()->getAccessToken( $this->getRequest() );
		if ( !empty( $accessToken ) ) {
			self::heliosClient()->invalidateToken( $accessToken, $this->getId() );
		}
		self::authCookieHelper()->clearAuthenticationCookie( $this->getRequest()->response() );

		$this->clearInstanceCache( 'defaults' );

		$this->getRequest()->setSessionData( 'wsUserID', 0 );
		$this->getRequest()->setSessionData( 'wsEditToken', null );

		$this->clearCookie( 'UserID' );
		$this->clearCookie( 'Token' );

		// Wikia change - begin (@see PLATFORM-1028)
		// @author macbre
		// There's no need to keep the user name (in both session and cookie) when you log out
		$this->getRequest()->setSessionData( 'wsUserName', null );
		$this->clearCookie( 'UserName' );
		// Wikia change - end

		wfResetSessionID();

		# Remember when user logged out, to prevent seeing cached pages
		$this->setCookie( 'LoggedOut', wfTimestampNow(), time() + 86400 );
	}

	/**
	 * Save this user's settings into the database.
	 * @todo Only rarely do all these fields need to be set!
	 */
	public function saveSettings() {
		global $wgExternalSharedDB;
		$this->load();
		if ( wfReadOnly() ) {
			return;
		}
		if ( 0 == $this->mId ) {
			return;
		}

		$this->mTouched = self::newTouchedTimestamp();

		Hooks::run( 'BeforeUserSaveSettings', array( $this ) );

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		$dbw->update( '`user`',
			array( /* SET */
				'user_name' => $this->mName,
				'user_real_name' => $this->mRealName,
				'user_email' => $this->mEmail,
				'user_email_authenticated' => $dbw->timestampOrNull( $this->mEmailAuthenticated ),
				'user_touched' => $dbw->timestamp( $this->mTouched ),
				'user_token' => strval( $this->mToken ),
				'user_email_token' => $this->mEmailToken,
				'user_email_token_expires' => $dbw->timestampOrNull( $this->mEmailTokenExpires ),
			), array( /* WHERE */
				'user_id' => $this->mId
			), __METHOD__
		);

		$this->saveOptions();
		$this->savePreferences();
		$this->saveAttributes();

		Hooks::run( 'UserSaveSettings', array( $this ) );
		$this->clearSharedCache();

		# Wikia - bad style fix for #1531 - needs review if it is still needed
		global $wgRequest;
		$action = $wgRequest->getVal( 'action');
		$commit = ( isset($action) && $action == 'ajax' );
		if ( $commit === true ) {
			$dbw->commit();
		}

		$this->getUserPage()->invalidateCache();
	}

	/**
	 * Add a user to the database, return the user object
	 *
	 * @param $name String Username to add
	 * @param $params Array of Strings Non-default parameters to save to the database as user_* fields:
	 *   - password             The user's password hash. Password logins will be disabled if this is omitted.
	 *   - newpassword          Hash for a temporary password that has been mailed to the user
	 *   - email                The user's email address
	 *   - email_authenticated  The email authentication timestamp
	 *   - real_name            The user's real name
	 *   - options              An associative array of non-default options
	 *   - token                Random authentication token. Do not set.
	 *   - registration         Registration timestamp. Do not set.
	 *
	 * @return User object, or null if the username already exists
	 */
	public static function createNew( $name, $params = array() ) {
		$user = new User;
		$user->load();
		if ( isset( $params['options'] ) ) {
			$user->mOptions = $params['options'] + (array)$user->mOptions;
			unset( $params['options'] );
		}
		$dbw = wfGetDB( DB_MASTER );
		$seqVal = $dbw->nextSequenceValue( 'user_user_id_seq' );

		$fields = array(
			'user_id' => $seqVal,
			'user_name' => $name,
			'user_email' => $user->mEmail,
			'user_email_authenticated' => $dbw->timestampOrNull( $user->mEmailAuthenticated ),
			'user_real_name' => $user->mRealName,
			'user_token' => strval( $user->mToken ),
			'user_registration' => $dbw->timestamp( $user->mRegistration ),
			'user_birthdate' => $user->mBirthDate, // Wikia. Added to reflect our user table layout.
			'user_editcount' => 0,
		);
		foreach ( $params as $name => $value ) {
			$fields["user_$name"] = $value;
		}
		$dbw->insert( 'user', $fields, __METHOD__, array( 'IGNORE' ) );
		if ( $dbw->affectedRows() ) {
			$newUser = User::newFromId( $dbw->insertId() );
			/**
			 * wikia, increase number of registered users for wfIniStats
			 */
			global $wgMemc;
			$wgMemc->incr( wfSharedMemcKey( "registered-users-number" ) );

		} else {
			$newUser = null;
		}

		return $newUser;
	}

	/**
	 * Add this existing user object to the database
	 */
	public function addToDatabase() {
		$this->load();

		// wikia change
		global $wgExternalSharedDB;
		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$seqVal = $dbw->nextSequenceValue( 'user_user_id_seq' );
		$dbw->insert( 'user',
			array(
				'user_id' => $seqVal,
				'user_name' => $this->mName,
				'user_email' => $this->mEmail,
				'user_email_authenticated' => $dbw->timestampOrNull( $this->mEmailAuthenticated ),
				'user_real_name' => $this->mRealName,
				'user_token' => strval( $this->mToken ),
				'user_registration' => $dbw->timestamp( $this->mRegistration ),
				'user_birthdate' => $this->mBirthDate, // Wikia. Added to reflect our user table layout.
				'user_editcount' => 0,
				'user_options' => '', // Wikia. Field 'user_options' doesn't have a default value
			), __METHOD__
		);
		$this->mId = $dbw->insertId();

		// Clear instance cache other than user table data, which is already accurate
		$this->clearInstanceCache();

		$this->saveOptions();
		$this->savePreferences();
		$this->saveAttributes();
	}

	/**
	 * If this user is logged-in and blocked,
	 * block any IP address they've successfully logged in from.
	 * @return bool A block was spread
	 */
	public function spreadAnyEditBlock() {
		if ( $this->isLoggedIn() && $this->isBlocked() ) {
			return $this->spreadBlock();
		}
		return false;
	}

	/**
	 * If this (non-anonymous) user is blocked,
	 * block the IP address they've successfully logged in from.
	 * @return bool A block was spread
	 */
	protected function spreadBlock() {
		wfDebug( __METHOD__ . "()\n" );
		$this->load();
		if ( $this->mId == 0 ) {
			return false;
		}

		$userblock = Block::newFromTarget( $this->getName() );
		if ( !$userblock ) {
			return false;
		}

		return (bool)$userblock->doAutoblock( $this->getRequest()->getIP() );
	}

	/**
	 * Generate a string which will be different for any combination of
	 * user options which would produce different parser output.
	 * This will be used as part of the hash key for the parser cache,
	 * so users with the same options can share the same cached data
	 * safely.
	 *
	 * Extensions which require it should install 'PageRenderingHash' hook,
	 * which will give them a chance to modify this key based on their own
	 * settings.
	 *
	 * @deprecated since 1.17 use the ParserOptions object to get the relevant options
	 * @return String Page rendering hash
	 */
	public function getPageRenderingHash() {
		wfDeprecated( __METHOD__, '1.17' );

		global $wgUseDynamicDates, $wgRenderHashAppend, $wgLang, $wgContLang;
		if( $this->mHash ){
			return $this->mHash;
		}

		// stubthreshold is only included below for completeness,
		// since it disables the parser cache, its value will always
		// be 0 when this function is called by parsercache.

		$confstr =        $this->getGlobalPreference( 'math' );
		$confstr .= '!' . $this->getStubThreshold();
		if ( $wgUseDynamicDates ) { # This is wrong (bug 24714)
			$confstr .= '!' . $this->getDatePreference();
		}
		$confstr .= '!' . ( $this->getGlobalPreference( 'numberheadings' ) ? '1' : '' );
		$confstr .= '!' . $wgLang->getCode();
		$confstr .= '!' . $this->getGlobalPreference( 'thumbsize' );
		// add in language specific options, if any
		$extra = $wgContLang->getExtraHashOptions();
		$confstr .= $extra;

		// Since the skin could be overloading link(), it should be
		// included here but in practice, none of our skins do that.

		$confstr .= $wgRenderHashAppend;

		// Give a chance for extensions to modify the hash, if they have
		// extra options or other effects on the parser cache.
		Hooks::run( 'PageRenderingHash', array( &$confstr ) );

		// Make it a valid memcached key fragment
		$confstr = str_replace( ' ', '_', $confstr );
		$this->mHash = $confstr;
		return $confstr;
	}

	/**
	 * Get whether the user is explicitly blocked from account creation.
	 * @return Bool|Block
	 */
	public function isBlockedFromCreateAccount() {
		$this->getBlockedStatus();
		if( $this->mBlock && $this->mBlock->prevents( 'createaccount' ) ){
			return $this->mBlock;
		}

		# bug 13611: if the IP address the user is trying to create an account from is
		# blocked with createaccount disabled, prevent new account creation there even
		# when the user is logged in
		if( $this->mBlockedFromCreateAccount === false ){
			$this->mBlockedFromCreateAccount = Block::newFromTarget( null, $this->getRequest()->getIP() );
		}
		return $this->mBlockedFromCreateAccount instanceof Block && $this->mBlockedFromCreateAccount->prevents( 'createaccount' )
			? $this->mBlockedFromCreateAccount
			: false;
	}

	/**
	 * Get whether the user is blocked from using Special:Emailuser.
	 * @return Bool
	 */
	public function isBlockedFromEmailuser() {
		$this->getBlockedStatus();
		return $this->mBlock && $this->mBlock->prevents( 'sendemail' );
	}

	/**
	 * Get whether the user is allowed to create an account.
	 * @return Bool
	 */
	function isAllowedToCreateAccount() {
		return $this->isAllowed( 'createaccount' ) && !$this->isBlockedFromCreateAccount();
	}

	/**
	 * Get this user's personal page title.
	 *
	 * @return Title: User's personal page title
	 */
	public function getUserPage() {
		return Title::makeTitle( NS_USER, $this->getName() );
	}

	/**
	 * Get this user's talk page title.
	 *
	 * @return Title: User's talk page title
	 */
	public function getTalkPage() {
		$title = $this->getUserPage();
		return $title->getTalkPage();
	}

	/**
	 * Determine whether the user is a newbie. Newbies are either
	 * anonymous IPs, or the most recently created accounts.
	 * @return Bool
	 */
	public function isNewbie() {
		return !$this->isAllowed( 'autoconfirmed' );
	}

	/**
	 * Check to see if the given clear-text password is one of the accepted passwords
	 * @param $password String: user password.
	 * @return AuthResult
	 */
	public function checkPassword( $password, &$errorMessageKey = null ) {
		$this->load();

		// Even though we stop people from creating passwords that
		// are shorter than this, doesn't mean people wont be able
		// to. Certain authentication plugins do NOT want to save
		// domain passwords in a mysql database, so we should
		// check this (in case $wgAuth->strict() is false).
		if( !$this->isValidPassword( $password ) ) {
			return AuthResult::create( false )->build();
		}

		// Wikia change - begin
		// Helios integration
		$authResult = $this->authenticationService()->authenticate( $this->mName, $password );
		if ( $authResult->success() && !$authResult->isResetPasswordAuth() ) {
			$this->setGlobalAuthToken( $authResult->getAccessToken() );
		} elseif ( $authResult->checkStatus( WikiaResponse::RESPONSE_CODE_SERVICE_UNAVAILABLE ) ) {
			$errorMessageKey = 'login-abort-service-unavailable';
		}
		// Wikia change - end

		return $authResult;
	}

	/**
	 * Alias for getEditToken.
	 * @deprecated since 1.19, use getEditToken instead.
	 *
	 * @param $salt String|Array of Strings Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return String The new edit token
	 */
	public function editToken( $salt = '', $request = null ) {
		wfDeprecated( __METHOD__, '1.19' );
		return $this->getEditToken( $salt, $request );
	}

	/**
	 * Initialize (if necessary) and return a session token value
	 * which can be used in edit forms to show that the user's
	 * login credentials aren't being hijacked with a foreign form
	 * submission.
	 *
	 * @since 1.19
	 *
	 * @param $salt String|Array of Strings Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return String The new edit token
	 */
	public function getEditToken( $salt = '', $request = null ) {
		if ( $request == null ) {
			$request = $this->getRequest();
		}

		if ( $this->isAnon() && session_status() !== PHP_SESSION_ACTIVE /* Wikia change (SUS-20) */ ) {
			return EDIT_TOKEN_SUFFIX;
		} else {
			$token = $request->getSessionData( 'wsEditToken' );
			if ( $token === null ) {
				$token = MWCryptRand::generateHex( 32 );
				$request->setSessionData( 'wsEditToken', $token );
			}
			if( is_array( $salt ) ) {
				$salt = implode( '|', $salt );
			}
			return md5( $token . $salt ) . EDIT_TOKEN_SUFFIX;
		}
	}

	/**
	 * Check given value against the token value stored in the session.
	 * A match should confirm that the form was submitted from the
	 * user's own login session, not a form submission from a third-party
	 * site.
	 *
	 * @param $val String Input value to compare
	 * @param $salt String Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return Boolean: Whether the token matches
	 */
	public function matchEditToken( $val, $salt = '', $request = null ) {
		$sessionToken = $this->getEditToken( $salt, $request );
		$equals = !is_null( $val ) && hash_equals( $sessionToken, $val );
		if ( !$equals ) {
			wfDebug( "User::matchEditToken: broken session data\n" );

			// Wikia change - begin
			// @see MAIN-4660 log edit tokens mismatches
			if ($val != '') {
				WikiaLogger::instance()->error(
					__METHOD__ . '::tokenMismatch',
					[
						'client_val'  => $val,
						'session_val' => $sessionToken,
						'session_id'  => session_id(),
						'salt'        => $salt,
						'user_id'     => $this->getId(),
						'user_name'   => $this->getName(),
						'exception'   => new Exception(),
					]
				);
			}
			// Wikia change - end
		}

		Hooks::run( 'UserMatchEditToken' ); # Wikia change

		return $equals;
	}

	/**
	 * Check given value against the token value stored in the session,
	 * ignoring the suffix.
	 *
	 * @param $val String Input value to compare
	 * @param $salt String Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return Boolean: Whether the token matches
	 */
	public function matchEditTokenNoSuffix( $val, $salt = '', $request = null ) {
		$sessionToken = $this->getEditToken( $salt, $request );
		return !is_null( $val ) && hash_equals( substr( $sessionToken, 0, 32 ), substr( $val, 0, 32 ) );
	}

	/**
	 * Generate a new e-mail confirmation token and send a confirmation/invalidation
	 * mail to the user's given address.
	 *
	 * @param string $type
	 * @param string $mailtype
	 * @param string $mailmsg
	 * @param bool|true $ip_arg
	 * @param string $emailTextTemplate
	 * @param null $language
	 * @return Status
	 * @throws MWException
	 */
	public function sendConfirmationMail(
		$type = 'created',
		$mailtype = EmailConfirmationController::TYPE,
		$mailmsg = '',
		$ip_arg = true,
		$emailTextTemplate = '',
		$language = null ) {

		global $wgLang;
		$expiration = null; // gets passed-by-ref and defined in next line.
		$token = $this->confirmationToken( $expiration );
		$url = $this->confirmationTokenUrl( $token );
		$invalidateURL = $this->invalidationTokenUrl( $token );
		$this->saveSettings();

		if ( $type == 'created' || $type === false ) {
			$message = 'confirmemail_body';
		} elseif ( $type === true ) {
			$message = 'confirmemail_body_changed';
		} else {
			$message = 'confirmemail_body_' . $type;
		}

		/* Wikia change begin */
		$subject = 'confirmemail_subject';
		if ( !empty($mailmsg) ) {
			$message = $mailmsg.'_body';
			$subject = $mailmsg.'_subject';
		}

		$manualURL = SpecialPage::getTitleFor( 'ConfirmEmail/manual' )->getFullURL();

		$IP = $this->getRequest()->getIP();
		$name = $this->getName();
		$expDate = $wgLang->timeanddate( $expiration, false );

		if( !$ip_arg ) {
			$args = array( $name, $url, $expDate, $invalidateURL, $manualURL, $token );
		} else {
			$args = array( $IP, $name, $url, $expDate, $invalidateURL, $manualURL, $token );
		}

		$priority = 0;
		Hooks::run( 'UserSendConfirmationMail', [ $this, &$args, &$priority, &$url, $token, $ip_arg, $type ] );

		$emailController = $this->getEmailController( $mailtype );
		if ( !empty( $emailController ) ) {
			return $this->sendUsingEmailExtension( $emailController, $url, $language );
		}

		/* Wikia change begin - @author: Marooned */
		/* HTML e-mails functionality */
		global $wgEnableRichEmails;

		if ( empty($wgEnableRichEmails) ) {
			return $this->sendMail( wfMsg( $subject ),
				wfMsg( $message,
					$this->getRequest()->getIP(),
					$this->getName(),
					$url,
					$wgLang->timeanddate( $expiration, false ),
					$invalidateURL,
					$wgLang->date( $expiration, false ),
					$wgLang->time( $expiration, false ) ), null, null, $mailtype, null, $priority );
		} else {
			$wantHTML = $this->isAnon() || $this->getGlobalPreference( 'htmlemails' );

			[$body, $bodyHTML] = wfMsgHTMLwithLanguage( $message, $this->getGlobalPreference( 'language' ), array(), $args, $wantHTML );

			if ( !empty($emailTextTemplate) && $wantHTML ) {
				$emailParams = array(
					'$USERNAME' => $name,
					'$CONFIRMURL' => $url,
				);
				$bodyHTML = strtr( $emailTextTemplate, $emailParams );
			}

			return $this->sendMail( wfMsg( $subject ), $body, null, null, $mailtype, $bodyHTML, $priority );
		}
		/* Wikia change end */
	}

	private function getEmailController( $mailType ) {
		$controller = "";
		if ( $this->isConfirmationMail( $mailType ) ) {
			$controller = Email\Controller\EmailConfirmationController::class;
		} elseif ( $this->isConfirmationReminderMail( $mailType ) ) {
			$controller = Email\Controller\EmailConfirmationReminderController::class;
		} elseif ( $this->isChangeEmailConfirmationMail( $mailType ) ) {
			$controller = Email\Controller\ConfirmationChangedEmailController::class;
		} elseif ( $this->isReactivateAccountMail( $mailType ) ) {
			$controller = Email\Controller\ReactivateAccountController::class;
		}

		return $controller;
	}

	private function isConfirmationMail( $mailType ) {
		return $mailType == EmailConfirmationController::TYPE;
	}

	private function isConfirmationReminderMail( $mailType ) {
		return $mailType == "ConfirmationReminderMail";
	}

	private function isChangeEmailConfirmationMail( $mailType ) {
		return $mailType == "ReConfirmationMail";
	}

	private function isReactivateAccountMail( $mailType ) {
		return $mailType == "ReactivationMail";
	}

	private function sendUsingEmailExtension( $emailController, $url, $language=null ) {
		$params = [
			'targetUser' => $this->getName(),
			'newEmail' => $this->getNewEmail(),
			'confirmUrl' => $url,
		];

		if ($language !== null) {
			$params['targetLang'] = $language;
		}

		$responseData = F::app()->sendRequest( $emailController, 'handle', $params )->getData();

		if ( $responseData['result'] == 'ok' ) {
			return Status::newGood();
		} else {
			return Status::newFatal( $responseData['error'] );
		}

	}

	/**
	 * Confirmation after change the email
	 *
	 * @return Status|bool True on success, a WikiError object on failure.
	 */
	function sendReConfirmationMail() {
		$this->setGlobalFlag("mail_edited","1");
		$this->saveSettings();
		return $this->sendConfirmationMail(
			false,
			!empty( $this->getNewEmail() ) ? 'ReConfirmationMail' : EmailConfirmationController::TYPE
		);
	}

	/**
	 * Confirmation reminder after 7 day
	 *
	 * @return Status|false True on success, a WikiError object on failure.
	 */
	function sendConfirmationReminderMail() {
		if( ($this->getGlobalFlag("cr_mailed", 0) == 1) || ($this->getGlobalFlag("mail_edited", 0) == 1) ) {
			return false;
		}
		$this->setGlobalFlag("cr_mailed","1");
		$this->saveSettings();
		return $this->sendConfirmationMail( false, 'ConfirmationReminder', '', false );
	}

	/**
	 * Send an e-mail to this user's account. Does not check for
	 * confirmed status or validity.
	 *
	 * @param $subject String Message subject
	 * @param $body String Message body
	 * @param $from String Optional From address; if unspecified, default $wgPasswordSender will be used
	 * @param $replyto String Reply-To address
	 * @param $category \string type of e-mail used for statistics (added by Marooned @ Wikia)
	 * @param $bodyHTML \string rich version of $body (added by Marooned @ Wikia)
	 * @return Status
	 */
	public function sendMail( $subject, $body, $from = null, $replyto = null, $category = 'unknown', $bodyHTML = null, $priority = 0 ) {
		if( is_null( $from ) ) {
			global $wgPasswordSender, $wgPasswordSenderName;
			$sender = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
		} else {
			$sender = new MailAddress( $from );
		}

		$to = new MailAddress( $this );

		/* Wikia change begin - @author: Marooned */
		/* HTML e-mails functionality */
		global $wgEnableRichEmails;
		if ( !empty($wgEnableRichEmails) && ($this->isAnon() || $this->getGlobalPreference('htmlemails')) && !empty($bodyHTML) ) {
			$body = array( 'text' => $body, 'html' => $bodyHTML );
		}
		/* Wikia change end */

		return UserMailer::send( $to, $sender, $subject, $body, $replyto, null, $category, $priority );
	}

	/**
	 * Generate, store, and return a new e-mail confirmation code.
	 * A hash (unsalted, since it's used as a key) is stored.
	 *
	 * @note Call saveSettings() after calling this function to commit
	 * this change to the database.
	 *
	 * @param &$expiration \mixed Accepts the expiration time
	 * @return String New token
	 */
	private function confirmationToken( &$expiration ) {
		global $wgUserEmailConfirmationTokenExpiry;
		$now = time();
		$expires = $now + $wgUserEmailConfirmationTokenExpiry;
		$expiration = wfTimestamp( TS_MW, $expires );
		$this->load();
		$token = MWCryptRand::generateHex( 32 );
		$hash = md5( $token );
		$this->mEmailToken = $hash;
		$this->mEmailTokenExpires = $expiration;

		return $token;
	}

	/**
	 * Return a URL the user can use to confirm their email address.
	 * @param $token String Accepts the email confirmation token
	 * @return String New token URL
	 */
	private function confirmationTokenUrl( $token ) {
		return $this->getTokenUrl( 'ConfirmEmail', $token );
	}

	/**
	 * Return a URL the user can use to invalidate their email address.
	 * @param $token String Accepts the email confirmation token
	 * @return String New token URL
	 */
	private function invalidationTokenUrl( $token ) {
		return $this->getTokenUrl( 'Invalidateemail', $token );
	}

	/**
	 * Internal function to format the e-mail validation/invalidation URLs.
	 * This uses a quickie hack to use the
	 * hardcoded English names of the Special: pages, for ASCII safety.
	 *
	 * @note Since these URLs get dropped directly into emails, using the
	 * short English names avoids insanely long URL-encoded links, which
	 * also sometimes can get corrupted in some browsers/mailers
	 * (bug 6957 with Gmail and Internet Explorer).
	 *
	 * @param $page String Special page
	 * @param $token String Token
	 * @return String Formatted URL
	 */
	protected function getTokenUrl( $page, $token ) {
		global $wgEnableNewAuthModal;

		if ( $wgEnableNewAuthModal ) {
			return WikiFactory::getLocalEnvURL( "https://www.fandom.com/confirm-email?token=$token" );
		}

		// Hack to bypass localization of 'Special:'
		$title = Title::makeTitle( NS_MAIN, "Special:$page/$token" );
		return $title->getCanonicalURL();
	}

	/**
	 * Mark the e-mail address confirmed.
	 *
	 * @note Call saveSettings() after calling this function to commit the change.
	 *
	 * @return true
	 */
	public function confirmEmail() {
		$this->setEmailAuthenticationTimestamp( wfTimestampNow() );
		Hooks::run( 'ConfirmEmailComplete', array( $this ) );
		return true;
	}

	/**
	 * Invalidate the user's e-mail confirmation, and unauthenticate the e-mail
	 * address if it was already confirmed.
	 *
	 * @note Call saveSettings() after calling this function to commit the change.
	 * @return true
	 */
	function invalidateEmail() {
		$this->load();
		$this->mEmailToken = null;
		$this->mEmailTokenExpires = null;
		$this->setEmailAuthenticationTimestamp( null );
		return true;
	}

	/**
	 * Set the e-mail authentication timestamp.
	 * @param $timestamp String TS_MW timestamp
	 */
	function setEmailAuthenticationTimestamp( $timestamp ) {
		$this->load();
		$this->mEmailAuthenticated = $timestamp;
		Hooks::run( 'UserSetEmailAuthenticationTimestamp', array( $this, &$this->mEmailAuthenticated ) );
	}

	/**
	 * Is this user allowed to send e-mails within limits of current
	 * site configuration?
	 * @return Bool
	 */
	public function canSendEmail() {
		global $wgEnableEmail, $wgEnableUserEmail;
		if( !$wgEnableEmail || !$wgEnableUserEmail || !$this->isAllowed( 'sendemail' ) ) {
			return false;
		}
		$canSend = $this->isEmailConfirmed();
		Hooks::run( 'UserCanSendEmail', [ $this, &$canSend ] );

		return $canSend;
	}

	/**
	 * Is this user allowed to receive e-mails within limits of current
	 * site configuration?
	 * @return Bool
	 */
	public function canReceiveEmail() {
		return $this->isEmailConfirmed() && !$this->getGlobalPreference( 'disablemail' );
	}

	/**
	 * Is this user's e-mail address valid-looking and confirmed within
	 * limits of the current site configuration?
	 *
	 * @note If $wgEmailAuthentication is on, this may require the user to have
	 * confirmed their address by returning a code or using a password
	 * sent to the address from the wiki.
	 *
	 * @return Bool
	 */
	public function isEmailConfirmed() {
		global $wgEmailAuthentication;
		$this->load();
		$confirmed = true;
		if ( Hooks::run( 'EmailConfirmed', [ $this, &$confirmed ] ) ) {
			if( $this->isAnon() ) {
				return false;
			}
			if( !Sanitizer::validateEmail( $this->mEmail ) ) {
				return false;
			}
			if( $wgEmailAuthentication && !$this->getEmailAuthenticationTimestamp() ) {
				return false;
			}
			return true;
		}
		return $confirmed;
	}

	/**
	 * Check whether there is an outstanding request for e-mail confirmation.
	 * @return Bool
	 */
	public function isEmailConfirmationPending() {
		global $wgEmailAuthentication;
		return $wgEmailAuthentication &&
			!$this->isEmailConfirmed() &&
			$this->mEmailToken &&
			$this->mEmailTokenExpires > wfTimestamp();
	}

	/**
	 * Get the timestamp of account creation.
	 *
	 * @return String|Bool Timestamp of account creation, or false for
	 *     non-existent/anonymous user accounts.
	 */
	public function getRegistration() {
		if ( $this->isAnon() ) {
			return false;
		}
		$this->load();
		return $this->mRegistration;
	}

	/**
	 * Get the timestamp of the first edit
	 *
	 * @return String|Bool Timestamp of first edit, or false for
	 *     non-existent/anonymous user accounts.
	 */
	public function getFirstEditTimestamp() {
		if( $this->getId() == 0 ) {
			return false; // anons
		}
		$dbr = wfGetDB( DB_SLAVE );
		$time = $dbr->selectField( 'revision', 'rev_timestamp',
			array( 'rev_user' => $this->getId() ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp ASC' )
		);
		if( !$time ) {
			return false; // no edits
		}
		return wfTimestamp( TS_MW, $time );
	}

	/**
	 * Increment the user's edit-count field.
	 * Will have no effect for anonymous users.
	 */
	public function incEditCount() {
		if ( !$this->isAnon() ) {
			ServiceFactory::instance()->producerFactory()->editCountTaskProducer()->incrementFor( $this );
		}
	}

	/**
	 * Add a newuser log entry for this user. Before 1.19 the return value was always true.
	 *
	 * @param $byEmail Boolean: account made by email?
	 * @param $reason String: user supplied reason
	 *
	 * @return int|bool True if not $wgNewUserLog; otherwise ID of log item or 0 on failure
	 */
	public function addNewUserLogEntry( $byEmail = false, $reason = '' ) {
		global $wgContLang, $wgNewUserLog, $wgUser;
		if( empty( $wgNewUserLog ) ) {
			return true; // disabled
		}

		if( $this->equals( $wgUser ) ) {
			$action = 'create';
		} else {
			$action = 'create2';
			if ( $byEmail ) {
				if ( $reason === '' ) {
					$reason = wfMsgForContent( 'newuserlog-byemail' );
				} else {
					$reason = $wgContLang->commaList( array(
						$reason, wfMsgForContent( 'newuserlog-byemail' ) ) );
				}
			}
		}
		$log = new LogPage( 'newusers' );
		return (int)$log->addEntry(
			$action,
			$this->getUserPage(),
			$reason,
			array( $this->getId() )
		);
	}

	/**
	 * Add an autocreate newuser log entry for this user
	 * Used by things like CentralAuth and perhaps other authplugins.
	 *
	 * @return true
	 */
	public function addNewUserLogEntryAutoCreate() {
		global $wgNewUserLog;
		if( !$wgNewUserLog ) {
			return true; // disabled
		}
		$log = new LogPage( 'newusers', false );
		$log->addEntry( 'autocreate', $this->getUserPage(), '', array( $this->getId() ) );
		return true;
	}

	/**
	 * @todo document
	 */
	protected function loadOptions() {
		$this->load();
		if ( $this->mOptionsLoaded || !$this->getId() )
			return;

		$this->mOptions = self::getDefaultOptions();
		// Maybe load from the object
		if ( !is_null( $this->mOptionOverrides ) ) {
			wfDebug( "User: loading options for user " . $this->getId() . " from override cache.\n" );
			foreach( $this->mOptionOverrides as $key => $value ) {
				$this->mOptions[$key] = $value;
			}
		} else {
			wfDebug( "User: loading options for user " . $this->getId() . " from database.\n" );
			// Load from database
			// shared users database
			// @author Krzysztof Krzyżaniak (eloy)
			global $wgExternalSharedDB;
			$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

			$res = $dbr->select(
				'user_properties',
				'*',
				array( 'up_user' => $this->getId() ),
				__METHOD__
			);

			$this->mOptionOverrides = array();
			foreach ( $res as $row ) {
				$this->mOptionOverrides[$row->up_property] = $row->up_value;
				$this->mOptions[$row->up_property] = $row->up_value;
			}
		}

		$this->mOptionsLoaded = true;

		Hooks::run( 'UserLoadOptions', array( $this, &$this->mOptions ) );
	}

	/**
	 * Save this user's preferences into the database.
	 *
	 * @see getGlobalPreference for documentation about preferences
	 */
	protected function savePreferences() {
		$this->userPreferences()->save($this->getId());
	}

	/**
	 * Save this user's attributes into the attribute service.
	 */
	protected function saveAttributes() {
		$this->userAttributes()->save( $this->getId() );
	}

	/**
	 * @todo document
	 */
	protected function saveOptions() {

		$this->loadOptions();
		// wikia change
		global $wgExternalSharedDB;
		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$insertRows = $deletePrefs = [];

		$saveOptions = $this->mOptions;

		// Allow hooks to abort, for instance to save to a global profile.
		// Reset options to default state before saving.
		if( !Hooks::run( 'UserSaveOptions', array( $this, &$saveOptions ) ) ) {
			return;
		}

		foreach( $saveOptions as $key => $value ) {
			# Don't bother storing default values
			# <Wikia>
			if ( $this->shouldOptionBeStored( $key, $value ) ) {
				$insertRows[] = [ 'up_user' => $this->getId(), 'up_property' => $key, 'up_value' => $value ];
			} elseif ($this->isDefaultOption($key, $value)) {
				$deletePrefs[] = $key;
			}
		}

		// user has default set, so clear any other entries from db
		if (!empty($deletePrefs)) {
			(new WikiaSQL())
				->DELETE('user_properties')
				->WHERE('up_user')->EQUAL_TO($this->getId())
					->AND_('up_property')->IN($deletePrefs)
				->run($dbw);
		}

		$dbw->upsert('user_properties', $insertRows, [], self::$PROPERTY_UPSERT_SET_BLOCK, __METHOD__);
	}

	/**
	 * @desc Check if user option should be stored in DataBase.
	 * We don't want to store default values in order to easily change them in future.
	 * @param $key
	 * @param $value
	 * @return bool
	 */
	private function shouldOptionBeStored( $key, $value ) {
		if (
			( is_null( self::getDefaultOption( $key ) ) && !( $value === false || is_null($value) ) ) ||
			$value != self::getDefaultOption( $key )
		) {
			return true;
		}
		return false;
	}

	private function isDefaultOption($key, $value) {
		return $value == self::getDefaultOption($key);
	}

	/**
	 * Provide an array of HTML5 attributes to put on an input element
	 * intended for the user to enter a new password.  This may include
	 * required, title, and/or pattern, depending on $wgMinimalPasswordLength.
	 *
	 * Do *not* use this when asking the user to enter his current password!
	 * Regardless of configuration, users may have invalid passwords for whatever
	 * reason (e.g., they were set before requirements were tightened up).
	 * Only use it when asking for a new password, like on account creation or
	 * ResetPass.
	 *
	 * Obviously, you still need to do server-side checking.
	 *
	 * NOTE: A combination of bugs in various browsers means that this function
	 * actually just returns array() unconditionally at the moment.  May as
	 * well keep it around for when the browser bugs get fixed, though.
	 *
	 * @todo FIXME: This does not belong here; put it in Html or Linker or somewhere
	 *
	 * @return array Array of HTML attributes suitable for feeding to
	 *   Html::element(), directly or indirectly.  (Don't feed to Xml::*()!
	 *   That will potentially output invalid XHTML 1.0 Transitional, and will
	 *   get confused by the boolean attribute syntax used.)
	 */
	public static function passwordChangeInputAttribs() {
		global $wgMinimalPasswordLength;

		if ( $wgMinimalPasswordLength == 0 ) {
			return array();
		}

		# Note that the pattern requirement will always be satisfied if the
		# input is empty, so we need required in all cases.
		#
		# @todo FIXME: Bug 23769: This needs to not claim the password is required
		# if e-mail confirmation is being used.  Since HTML5 input validation
		# is b0rked anyway in some browsers, just return nothing.  When it's
		# re-enabled, fix this code to not output required for e-mail
		# registration.
		#$ret = array( 'required' );
		$ret = array();

		# We can't actually do this right now, because Opera 9.6 will print out
		# the entered password visibly in its error message!  When other
		# browsers add support for this attribute, or Opera fixes its support,
		# we can add support with a version check to avoid doing this on Opera
		# versions where it will be a problem.  Reported to Opera as
		# DSK-262266, but they don't have a public bug tracker for us to follow.
		/*
		if ( $wgMinimalPasswordLength > 1 ) {
			$ret['pattern'] = '.{' . intval( $wgMinimalPasswordLength ) . ',}';
			$ret['title'] = wfMsgExt( 'passwordtooshort', 'parsemag',
				$wgMinimalPasswordLength );
		}
		*/

		return $ret;
	}

	/**
	 * Return the memcache key for storing cross-wiki "user_touched" value.
	 * It's used to refresh user caches on Wiki B when user changes his setting on Wiki A
	 * @return string memcache key
	 */
	public function getUserTouchedKey(): string {
		return wfSharedMemcKey( "user_touched", 'v1',  $this->mId );
	}

	/**
	 * Get the global authentication token.
	 * @return string
	 */
	public function getGlobalAuthToken() {
		return $this->globalAuthToken;
	}

	/**
	 * Set the global authentication token.
	 * @param string
	 */
	public function setGlobalAuthToken( $token ) {
		$this->globalAuthToken = $token;
	}

	/**
	 * Get the list of explicit group memberships this user has.
	 * The implicit * and user groups are not included.
	 * @return Array of String internal group names
	 */
	public function getGroups() {
		return self::permissionsService()->getExplicitGroups( $this );
	}

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes all explicit groups, plus 'user' if logged in,
	 * '*' for all accounts, and autopromoted groups
	 * @param $recache Bool Whether to avoid the cache
	 * @return Array of String internal group names
	 */
	public function getEffectiveGroups( $recache = false ) {
		return self::permissionsService()->getEffectiveGroups( $this, $recache );
	}

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes 'user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @param $recache Bool Whether to avoid the cache
	 * @return Array of String internal group names
	 */
	public function getAutomaticGroups( $recache = false ) {
		return self::permissionsService()->getAutomaticGroups( $this, $recache );
	}

	/**
	 * Get a list of implicit groups
	 * @return Array of Strings Array of internal group names
	 */
	public static function getImplicitGroups() {
		return self::permissionsService()->getConfiguration()->getImplicitGroups();
	}

	/**
	 * Return the set of defined explicit groups.
	 * The implicit groups (by default *, 'user' and 'autoconfirmed')
	 * are not included, as they are defined automatically, not in the database.
	 * @return Array of internal group names
	 */
	public static function getAllGroups() {
		return self::permissionsService()->getConfiguration()->getExplicitGroups();
	}

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups Array of Strings List of internal group names
	 * @return Array of Strings List of permission key names for given groups combined
	 */
	public static function getGroupPermissions( $groups ) {
		return self::permissionsService()->getConfiguration()->getGroupPermissions( $groups );
	}

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $role String Role to check
	 * @return Array of Strings List of internal group names with the given permission
	 */
	public static function getGroupsWithPermission( $role ) {
		return self::permissionsService()->getConfiguration()->getGroupsWithPermission( $role );
	}

	/**
	 * Get the permissions this user has.
	 * @return Array of String permission names
	 */
	public function getRights() {
		return self::permissionsService()->getPermissions( $this );
	}

	/**
	 * Get a list of all available permissions.
	 * @return Array of permission names
	 */
	public static function getAllRights() {
		return self::permissionsService()->getConfiguration()->getPermissions();
	}

	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *     'remove' => array( removablegroups ),
	 *     'add-self' => array( addablegroups to self),
	 *     'remove-self' => array( removable groups from self) )
	 */
	public static function changeableByGroup( $group ) {
		return self::permissionsService()->getConfiguration()->getGroupsChangeableByGroup( $group );
	}

	/**
	 * Add the user to the given group(s).
	 * This takes immediate effect.
	 * @param $groups string Name of group or array with list of groups
	 * @return true if operation was successful, false otherwise
	 */
	public function addGroup( $groups ) {
		return self::permissionsService()->addToGroup( RequestContext::getMain()->getUser(), $this, $groups );
	}

	/**
	 * Remove the user from the given group(s).
	 * This takes immediate effect.
	 * @param $groups string Name of group or array with list of groups
	 * @return true if operation was successful, false otherwise
	 */
	public function removeGroup( $groups ) {
		return self::permissionsService()->removeFromGroup( RequestContext::getMain()->getUser(), $this, $groups );
	}

	/**
	 * Returns an array of groups that this user can add and remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *  'remove' => array( removablegroups ),
	 *  'add-self' => array( addablegroups to self),
	 *  'remove-self' => array( removable groups from self) )
	 */
	public function changeableGroups() {
		return self::permissionsService()->getChangeableGroups( $this );
	}

	/**
	 * Check if user is allowed to access a feature / make an action
	 *
	 * internal param \String $varargs permissions to test
	 * @return Boolean: True if user is allowed to perform *any* of the given actions
	 *
	 * @return bool
	 */
	public function isAllowedAny( /*...*/ ){
		$permissions = func_get_args();
		return self::permissionsService()->hasAnyPermission( $this, $permissions );
	}

	/**
	 *
	 * internal param $varargs string
	 * @return bool True if the user is allowed to perform *all* of the given actions
	 */
	public function isAllowedAll( /*...*/ ){
		$permissions = func_get_args();
		return self::permissionsService()->hasAllPermissions( $this, $permissions );
	}

	/**
	 * Internal mechanics of testing a permission
	 * @param $action String
	 * @return bool
	 */
	public function isAllowed( $action = '' ) {
		return self::permissionsService()->hasPermission( $this, $action );
	}

	/**
	 * Whether this user is Wikia staff or not
	 * @return bool
	 */
	public function isStaff() {
		return self::permissionsService()->isInGroup( $this, 'staff' )
			||
			self::permissionsService()->isInGroup( $this, 'wiki-manager' )
			||
			self::permissionsService()->isInGroup( $this, 'content-team-member' );
	}

	/**
	 * Whether this user is a bot (either globally or on this wiki) or not
	 * @return bool
	 */
	public function isBot() {
		return self::permissionsService()->isInGroup( $this, 'bot' )
			||
			self::permissionsService()->isInGroup( $this, 'bot-global' );
	}

	/**
	 * Get the localized descriptive name for a group, if it exists
	 *
	 * @param $group String Internal group name
	 * @return String Localized descriptive group name
	 */
	public static function getGroupName( $group ) {
		$msg = wfMessage( "group-$group" );
		return $msg->isBlank() ? $group : $msg->text();
	}

	/**
	 * Get the localized descriptive name for a member of a group, if it exists
	 *
	 * @param $group String Internal group name
	 * @param $username String Username for gender (since 1.19)
	 * @return String Localized name for group member
	 */
	public static function getGroupMember( $group, $username = '#' ) {
		$msg = wfMessage( "group-$group-member", $username );
		return $msg->isBlank() ? $group : $msg->text();
	}

	/**
	 * Get the title of a page describing a particular group
	 *
	 * @param $group String Internal group name
	 * @return Title|Bool Title of the page if it exists, false otherwise
	 */
	public static function getGroupPage( $group ) {
		$msg = wfMessage( 'grouppage-' . $group )->inContentLanguage();
		if( $msg->exists() ) {
			$title = Title::newFromText( $msg->text() );
			if( is_object( $title ) )
				return $title;
		}
		return false;
	}

	/**
	 * Create a link to the group in HTML, if available;
	 * else return the group name.
	 *
	 * @param $group String Internal name of the group
	 * @param $text String The text of the link
	 * @return String HTML link to the group
	 */
	public static function makeGroupLinkHTML( $group, $text = '' ) {
		if( $text == '' ) {
			$text = self::getGroupName( $group );
		}
		$title = self::getGroupPage( $group );
		if( $title ) {
			return Linker::link( $title, htmlspecialchars( $text ) );
		}
		return $text;
	}

	/**
	 * Create a link to the group in Wikitext, if available;
	 * else return the group name.
	 *
	 * @param $group String Internal name of the group
	 * @param $text String The text of the link
	 * @return String Wikilink to the group
	 */
	public static function makeGroupLinkWiki( $group, $text = '' ) {
		if( $text == '' ) {
			$text = self::getGroupName( $group );
		}
		$title = self::getGroupPage( $group );
		if( $title ) {
			$page = $title->getPrefixedText();
			return "[[$page|$text]]";
		} else {
			return $text;
		}
	}

	/**
	 * Get the description of a given right
	 *
	 * @param $right String Right to query
	 * @return String Localized description of the right
	 */
	public static function getRightDescription( $right ) {
		$key = "right-$right";
		$msg = wfMessage( $key );
		return $msg->isBlank() ? $right : $msg->text();
	}

	/**
	 * Get the username for an account given by the ID. It's basically User::whoIs() will a fallback.
	 *
	 * If it's an anon (userId = 0), return the second argument passed to this method.
	 * The same fallback will happen when there's no database entry for a given user. In such case warning will be logged.
	 *
	 * @see SUS-825
	 *
	 * @param $userId int userId
	 * @param $name string anon username
	 * @return string
	 */
	public static function getUsername( int $userId, string $name ) : string {
		return ( $userId > 0 )
			?
			// logged-in - get the username by user ID
			static::whoIs( $userId )
			:
			// anons - return the second argument - an IP address
			$name;
	}

	/**
	 * Get flag if user is <16 y.o. for CCPA.
	 *
	 * @see ADEN-10054
	 *
	 * @return Boolean User is below 16 y.o.
	 */
	public function isSubjectToCcpa() {
		if ($this->mBirthDate === null) {
			return false;
		}
		try {
			$birthDate = new DateTime($this->mBirthDate);
		} catch (Exception $e) {
			return false;
		}
		if ($birthDate === false) {
			return false;
		}
		$now = new DateTime();
		$diff = $now->diff($birthDate, true);

		return $diff->y < 16;
	}

	/**
	 * Returns a simple representation of user object.
	 *
	 * @return array
	 */
	public function jsonSerialize() {
		// Detailed logging for PLATFORM-2770.
		WikiaLogger::instance()->debug(
			'User::jsonSerialize was called',
			[
				'user_id' => $this->getId(),
				'user_name' => $this->getName(),
				'exception' => new Exception()
			]
		);

		return [
			'mId' => $this->mId,
			'mName' => $this->mName,
		];
	}
}
