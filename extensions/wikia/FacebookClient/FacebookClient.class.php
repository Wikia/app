<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class FacebookClient
 *
 * Wrapper around the Facebook SDK
 */
class FacebookClient {

	// How long to save tokens we get from a signed cookie.  The tokens Facebook gives out are only
	// valid 1-2 hours so lets cache for 2 hours.  If it turns out its already expired we'll check
	// for that and grab a new token from the cookie if possible.
	const TOKEN_TTL = 7200;

	/** @var FacebookClient - Only create one instance of this object per request */
	private static $instance;

	/** @var Facebook\FacebookSignedRequestFromInputHelper  */
	private $facebookAPI;

	/** @var int|null Facebook user id */
	private $facebookUserId;

	/** @var array */
	private $userInfoCache;

	/** @var Facebook\FacebookSession */
	private $session;

	/**
	 * Only called internally
	 *
	 * @param FacebookClientConfig $config
	 *
	 * @throws Exception
	 */
	private function __construct( FacebookClientConfig $config ) {

		$this->facebookUserId = null;

		if ( $config->hasFacebookAPI() ) {
			// Use client passed to our constructor
			$this->facebookAPI = $config->getFacebookAPI();
		} else {
			// Construct our own client

			// Make sure we have the ID and secret
			if ( !$config->hasAppID() || !$config->hasAppSecret() ) {
				throw new Exception( wfMessage( 'fbconnect-graphapi-not-configured' )->text() );
			}

			Facebook\FacebookSession::setDefaultApplication( $config->getAppID(), $config->getAppSecret() );
			$this->facebookAPI = new Facebook\FacebookJavaScriptLoginHelper();
		}
	}

	/**
	 * Return an instance of the FacebookClient
	 *
	 * @param FacebookClientConfig $config
	 *
	 * @return FacebookClient
	 */
	public static function getInstance( FacebookClientConfig $config = null ) {
		global $fbAppId, $fbAppSecret;

		// If an instance hasn't been created yet, create one
		if ( empty( self::$instance ) ) {

			// See if an alternate config has been passed in
			if ( empty( $config ) ) {
				$config = ( new FacebookClientConfig() )
					->setAppID( $fbAppId )
					->setAppSecret( $fbAppSecret );
			}
			self::$instance = new FacebookClient( $config );
		}
		return self::$instance;
	}

	/**
	 * Tries to get a new FacebookSession object for the current Facebook user.  If this is the first time
	 * this user is here, the session will be created from the signed cookies Facebook sets.  It will then
	 * be cached in memcached for 2 hours and created from there for subsequent requests.
	 *
	 * @return \Facebook\FacebookSession
	 * @throws Exception
	 */
	public function getSession() {

		// If there's no session defined, try getting it from DB/memc
		if ( empty( $this->session ) ) {
			$this->getSessionFromMemcached();
		}

		// If the session is still not defined try to get it from the signed cookie
		if ( empty( $this->session ) ) {
			$this->getSessionFromCookie();
		}

		// If we still don't have a session then give up
		if ( empty( $this->session ) ) {
			throw new Exception( "Could not create Facebook session" );
		}

		return $this->session;
	}

	private function getSessionFromMemcached() {
		$memc = F::app()->wg->memc;

		// Get the access token for this user
		$accessToken = $memc->get( $this->getTokenMemcKey() );
		if ( $accessToken ) {
			// If we have an access token, create a session from that
			$session = new \Facebook\FacebookSession( $accessToken );

			try {
				$session->validate();
				$this->session = $session;
			} catch ( \Exception $ex ) {
				$this->logInvalidSession( __METHOD__, $ex->getMessage() );
			}
		}
	}

	/**
	 * Clear out the session saved for this user
	 */
	public function clearSessionFromMemcache() {
		if ( $this->getUserId() ) {
			$memc = F::app()->wg->memc;
			$memc->delete( $this->getTokenMemcKey() );
		}
	}

	private function getSessionFromCookie() {
		$memc = F::app()->wg->memc;
		$session = $this->facebookAPI->getSession();

		if ( empty( $session ) ) {
			$this->logInvalidSession( __METHOD__, 'Session object empty' );
			return;
		}

		try {
			$session->validate();
			$this->session = $session;
			$memc->set( $this->getTokenMemcKey(), $session->getAccessToken(), self::TOKEN_TTL );
		} catch ( \Exception $ex ) {
			$this->logInvalidSession( __METHOD__, $ex->getMessage() );
		}
	}

	/**
	 * @param string $method
	 * @param string $message
	 */
	private function logInvalidSession( $method, $message ) {
		WikiaLogger::instance()->warning( __CLASS__ . ': Invalid Facebook session found', [
			'fbUserId' => $this->facebookUserId,
			'method' => $method,
			'message' => $message,
		] );
	}

	private function getTokenMemcKey() {
		return wfSharedMemcKey( 'fbAccessToken', $this->facebookUserId );
	}

	/**
	 * Get the Facebook user ID for the current user, if set
	 *
	 * @return int
	 */
	public function getUserId() {
		if ( $this->facebookUserId !== null ) {
			return $this->facebookUserId;
		}

		$this->facebookUserId = $this->facebookAPI->getUserId();
		if ( !empty( $this->facebookUserId ) ) {
			try {
				// Try and create a session to see if facebookUserId is valid
				$this->getSession();
			} catch ( \Exception $e ) {
				$this->facebookUserId = 0;
				WikiaLogger::instance()->warning( 'Unable to create valid session', [
					'method' => __METHOD__,
					'message' => $e->getMessage()
				] );
			}
		} else {
			$this->facebookUserId = 0;
			WikiaLogger::instance()->warning( 'Null Facebook user id', [
				'method' => __METHOD__,
			] );
		}

		return $this->facebookUserId;
	}

	/**
	 * Get Facebook information about the current user
	 *
	 * @param int $userId
	 *
	 * @return Facebook\GraphUser
	 */
	public function getUserInfo( $userId = 0 ) {
		$log = WikiaLogger::instance();

		$this->facebookUserId = empty( $userId ) ? $this->getUserId() : $userId;

		// If we still couldn't get a user ID, return null
		if ( empty( $this->facebookUserId ) ) {
			$log->warning( __CLASS__ . ': Could not get user ID from FB session', [ 'method' => __METHOD__ ]);
			return null;
		}

		if ( empty( $this->userInfoCache[$this->facebookUserId] ) ) {
			try {
				$userProfile = ( new \Facebook\FacebookRequest(
					$this->getSession(),
					'GET',
					'/me'
				) )->execute()->getGraphObject( Facebook\GraphUser::className() );

				$this->userInfoCache[$this->facebookUserId] = $userProfile;
			} catch( Exception $e ) {
				$log->error( __CLASS__ . ': Failure in the api requesting "/me"', [
					'method' => __METHOD__,
					'message' => $e->getMessage(),
					'fbUserId' => $userId,
				]);
				return null;
			}
		}

		return $this->userInfoCache[$this->facebookUserId];
	}

	/**
	 * Returns what Facebook reports as the full user name for the current user.
	 *
	 * @param int $user
	 *
	 * @return null|string
	 */
	public function getFullName( $user = 0 ) {
		$userInfo = $this->getUserInfo( $user );
		return $userInfo->getName();
	}

	/**
	 * Returns user's email address from Facebook
	 *
	 * @param int $userId Facebook User id
	 * @return string|null email address if exists
	 */
	public function getEmail( $userId ) {
		$userInfo = $this->getUserInfo( $userId );
		if ( !$userInfo ) {
			return null;
		}

		return $userInfo->getProperty( 'email' );
	}

	/**
	 * Returns a Wikia User object for the current (or passed) Facebook ID
	 *
	 * @param int|null $fbId [optional] A Facebook ID
	 *
	 * @return null|User
	 * @throws MWException
	 */
	public function getWikiaUser( $fbId = null ) {

		if ( empty( $fbId ) ) {
			$fbId = $this->getUserId();
			if ( empty( $fbId ) ) {
				return null;
			}
		}

		$map = FacebookMapModel::lookupFromFacebookID( $fbId );
		if ( empty( $map ) ) {
			return null;
		}

		// Create a new mapping that includes the app ID.  Leave the default App ID behind
		// as there is no way to tell what other apps this user had connected, and removing this
		// default mapping will force the user to reconnect on those apps.
		if ( $map->isDefaultAppId() ) {
			$this->migrateMapping( $map );
		}

		// Update the business token for this user if not already set.  The business token
		// gives us a unique ID across all apps that we can use to reference a user.
		if ( !$map->getBizToken() ) {
			$this->updateBizTokenMapping( $map );
		}

		$wikiUserId = $map->getWikiaUserId();
		if ( !$wikiUserId ) {
			return null;
		}

		$user = User::newFromId( $wikiUserId );

		// This handles the case when a user record doesn’t exist on wikicities_c3 yet and it has to be created
		if ( F::app()->wg->ExternalAuthType ) {
			$user->load();
			if ( $user->getId() == 0 ) {
				$mExtUser = ExternalUser::newFromId( $wikiUserId );
				if ( is_object( $mExtUser ) && ( $mExtUser->getId() != 0 ) ) {
					$mExtUser->linkToLocal( $mExtUser->getId() );
					$user->setId( $wikiUserId );
				}
			}
		}

		return $user;
	}

	/**
	 * Retrieve the business token for this user
	 *
	 * @return string|null
	 * @throws Exception
	 */
	public function getBizToken() {
		$session = $this->getSession();
		if ( empty( $session ) ) {
			return null;
		}
		try {
			/** @var Facebook\GraphUser $userProfile */
			$userProfile = (new Facebook\FacebookRequest(
				$session, 'GET', '/me?fields=token_for_business'
			))->execute()->getGraphObject( Facebook\GraphUser::className() );

			$token = $userProfile->getProperty( 'token_for_business' );
		} catch(Facebook\FacebookRequestException $e) {
			WikiaLogger::instance()->error( 'Failed to retrieve business token', [
				'exception' => $e,
			] );
			return null;
		}

		return $token;
	}

	/**
	 * Updates old v1 mappings to a new mapping with an App ID
	 *
	 * @param FacebookMapModel $map
	 */
	public function migrateMapping( FacebookMapModel $map ) {
		WikiaLogger::instance()->notice( 'Migrating FB user mapping', [
			'wikiaUserId' => $map->getWikiaUserId(),
			'facebookUserId' => $map->getFacebookUserId(),
			'appId' => $map->getAppId()
		] );

		$newMapping = FacebookMapModel::createUserMapping(
			$map->getWikiaUserId(),
			$map->getFacebookUserId()
		);

		if ( !$newMapping ) {
			WikiaLogger::instance()->warning( 'Unable to migrate mapping', [
				'wikiaUserId' => $map->getWikiaUserId(),
				'facebookUserId' => $map->getFacebookUserId(),
				'appId' => $map->getAppId()
			] );
		}
	}

	/**
	 * Update the FacebookMapModel object with the correct business token
	 *
	 * @param FacebookMapModel $map
	 *
	 * @throws FacebookMapModelDbException
	 */
	public function updateBizTokenMapping( FacebookMapModel $map ) {
		$token = $this->getBizToken();

		if ( $token ) {
			WikiaLogger::instance()->info( 'Updating business token', [
				'wikiaUserId' => $map->getWikiaUserId(),
				'facebookUserId' => $map->getFacebookUserId(),
				'appId' => $map->getAppId(),
				'bizToken' => $token,
			] );
			$map->updateBizToken( $token );
		} else {
			WikiaLogger::instance()->warning( 'Unable to get business token', [
				'wikiaUserId' => $map->getWikiaUserId(),
				'facebookUserId' => $map->getFacebookUserId(),
				'appId' => $map->getAppId(),
			] );
		}
	}

	/**
	 * Returns the Facebook user ID for the current Wikia user
	 *
	 * @param User|int $user
	 *
	 * @return int|null
	 */
	public function getFacebookUserId( $user ) {

		// Determine if we got an ID or an object
		if ( $user instanceof User && $user->getId() != 0 ) {
			$wikiaUserId = $user->getId();
		} else {
			$wikiaUserId = $user;
		}

		if ( empty( $wikiaUserId ) ) {
			return null;
		}

		$map = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );
		if ( empty( $map ) ) {
			return null;
		}

		return $map->getFacebookUserId();
	}

	/**
	 * Cleans up cookies related to Facebook when logging out
	 */
	public function logout() {
		global $fbAppId;

		$sessionCookieName = 'fbsr_'.$fbAppId;
		$metaCookieName = 'fbm_'.$fbAppId;

		unset( $_COOKIE[$sessionCookieName] );
		if ( !headers_sent() ) {
			// The base domain is stored in the metadata cookie if not we fallback
			// to the current hostname
			$baseDomain = '.' . $_SERVER[ 'HTTP_HOST' ];

			$metadata = $_COOKIE[ $metaCookieName ];
			if ( preg_match( '/base_domain=([^&]+)/', $metadata, $matches ) ) {
				$baseDomain = $matches[1];
			}

			setcookie( $sessionCookieName, '', time() - 86400, '/', $baseDomain );
		}

		$this->clearSessionFromMemcache();
	}

	/**
	 * Check if we should redirect back to the specified page by comparing it to this black list
	 * @param Title|null $title
	 * @return bool
	 */
	private function isInvalidRedirectOnConnect( Title $title = null ) {
		return (
			!$title instanceof Title ||
			$title->isSpecial( 'Userlogout' ) ||
			$title->isSpecial( 'Signup' ) ||
			$title->isSpecial( 'UserLogin' )
		);
	}

	/**
	 * Get a fully resolved URL for redirecting after login/signup with facebook
	 * @param $returnTo String Title of page to return to
	 * @param $returnToQuery String Query string of page to return to
	 * @param $cb String Cachebuster value
	 * @return string
	 */
	public function getReturnToUrl( $returnTo, $returnToQuery, $cb = null ) {
		if ( is_null( $cb ) ) {
			$cb = rand( 1, 10000 );
		}
		$queryStr = '&fbconnected=1&cb=' . $cb;
		$titleObj = Title::newFromText( $returnTo );

		if ( $this->isInvalidRedirectOnConnect( $titleObj ) ) {
			// Don't redirect if the location is no good.  Go to the main page instead
			$titleObj = Title::newMainPage();
		} else if ( $returnToQuery ) {
			// Include the return to query string if its ok to redirect
			$queryStr = urldecode( $returnToQuery ) . $queryStr;
		}

		return $titleObj->getFullURL( $queryStr );
	}

	/**
	 * Get facebook mapping for current user
	 * @return FacebookMapModel
	 */
	public function getMapping() {
		$id = $this->getUserId();
		$map = FacebookMapModel::lookupFromFacebookID( $id );
		return $map;
	}
}

/**
 * Class FacebookClientConfig
 *
 * Defines the configuration needed to create an instance of FacebookClient
 */
class FacebookClientConfig {

	/** @var int */
	private $appID;

	/** @var string */
	private $appSecret;

	/** @var Facebook\FacebookSignedRequestFromInputHelper */
	private $facebookAPI;

	public function getAppID() {
		return $this->appID;
	}

	public function setAppID( $id ) {
		$this->appID = $id;
		return $this;
	}

	public function hasAppID() {
		return isset( $this->appID );
	}

	public function getAppSecret() {
		return $this->appSecret;
	}

	public function setAppSecret( $secret ) {
		$this->appSecret = $secret;
		return $this;
	}

	public function hasAppSecret() {
		return isset( $this->appSecret );
	}

	public function getFacebookAPI() {
		return $this->facebookAPI;
	}

	public function setFacebookAPI( Facebook\FacebookSignedRequestFromInputHelper $facebookAPI ) {
		$this->facebookAPI = $facebookAPI;
		return $this;
	}

	public function hasFacebookAPI() {
		return isset( $this->facebookAPI );
	}
}