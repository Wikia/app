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
		$log = WikiaLogger::instance();

		// Get the access token for this user
		$accessToken = $memc->get( $this->getTokenMemcKey() );
		if ( $accessToken ) {
			// If we have an access token, create a session from that
			$session = new \Facebook\FacebookSession( $accessToken );

			try {
				$session->validate();
				$this->session = $session;
			} catch ( \Exception $ex ) {
				$log->warning( __CLASS__ . ': Invalid Facebook session found', [
					'fbUserId' => $this->facebookUserId,
					'method' => __METHOD__,
					'message' => $ex->getMessage(),
				] );
			}
		}
	}

	private function getSessionFromCookie() {
		$memc = F::app()->wg->memc;
		$log = WikiaLogger::instance();

		$session = $this->facebookAPI->getSession();
		try {
			$session->validate();
			$this->session = $session;
			$memc->set( $this->getTokenMemcKey(), $session->getAccessToken(), self::TOKEN_TTL );
		} catch ( \Exception $ex ) {
			$log->warning( __CLASS__ . ': Invalid Facebook session found', [
				'fbUserId' => $this->facebookUserId,
				'method' => __METHOD__,
				'message' => $ex->getMessage(),
			] );
		}
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
				$session = $this->getSession();
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
					'facebookUserId' => $userId,
				]);
				return null;
			}
		}

		return $this->userInfoCache[$this->facebookUserId];
	}

	/**
	 * Same as FacebookClient::getUserInfo but returns the data as an array rather than a Facebook\GraphUser object.
	 *
	 * @param int $userId
	 *
	 * @return array
	 */
	public function getUserInfoAsArray( $userId = 0 ) {
		$userInfo = $this->getUserInfo( $userId );
		if ( ! $userInfo instanceof Facebook\GraphUser ) {
			return [];
		}

		$properties = [
			'email',
			'first_name',
			'middle_name',
			'last_name',
			'gender',
			'link',
			'locale',
			'name',
			'timezone',
			'updated_time',
			'verified'
		];
		$data = [];

		foreach ( $properties as $prop ) {
			$data[ $prop ] = $userInfo->getProperty( $prop );
		}

		return $data;
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
			$base_domain = '.' . $_SERVER[ 'HTTP_HOST' ];

			$metadata = $_COOKIE[ $metaCookieName ];
			if ( !empty( $metadata[ 'base_domain' ] ) ) {
				$base_domain = $metadata[ 'base_domain' ];
			}

			setcookie( $sessionCookieName, '', 0, '/', $base_domain );
		}
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
			$title->isSpecial( 'Connect' ) ||
			$title->isSpecial( 'FacebookConnect' ) ||
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