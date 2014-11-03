<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class FacebookClient
 *
 * Wrapper around the Facebook SDK
 */
class FacebookClient {

	/** @var FacebookClient - Only create one instance of this object per request */
	private static $instance;

	/** @var Facebook\FacebookSignedRequestFromInputHelper  */
	private $facebookAPI;
	/** @var  array */
	private $userInfoCache;

	/**
	 * Only called internally
	 *
	 * @param FacebookClientConfig $config
	 *
	 * @throws Exception
	 */
	private function __construct( FacebookClientConfig $config ) {

		if ( $config->hasFacebookAPI() ) {
			// Use client passed to our constructor
			$this->facebookAPI = $config->getFacebookAPI();
		} else {
			// Construct our own client

			// Make sure we have the ID and secret
			if ( !$config->hasAppID() || !$config->hasAppSecret() ) {
				throw new Exception( wfMessage( 'facebookclient-graphapi-not-configured' ) );
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
	 * Get the Facebook user ID for the current user, if set
	 *
	 * @return null|string
	 */
	public function getUserId() {
		return $this->facebookAPI->getUserId();
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

		// Pull the user ID from the signed FB cookie if it wasn't passed in
		if ( $userId == 0 ) {
			$userId = $this->getUserId();
		}

		// If we still couldn't get a user ID, return null
		if ( empty( $userId ) ) {
			$log->warning( __CLASS__ . ': Could not get user ID from FB session', [ 'method' => __METHOD__ ]);
			return null;
		}

		if ( empty( $this->userInfoCache[$userId] ) ) {
			try {
				$userProfile = ( new \Facebook\FacebookRequest(
					$this->facebookAPI->getSession(),
					'GET',
					'/me'
				) )->execute()->getGraphObject( Facebook\GraphUser::className() );

				$this->userInfoCache[$userId] = $userProfile;
			} catch( Exception $e ) {
				$log->error( __CLASS__ . ': Failure in the api requesting "/me"', [
					'method' => __METHOD__,
					'message' => $e->getMessage(),
					'facebookUserId' => $userId,
				]);
				return null;
			}
		}

		return $this->userInfoCache[$userId];
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
	 * Returns the what Facebook reports as the full user name for the current user.
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
	 * @param int $fbid [optional] A Facebook ID
	 *
	 * @return null|User
	 * @throws MWException
	 */
	public function getWikiaUser( $fbid = null ) {

		if ( empty( $fbid ) ) {
			$fbid = $this->getUserId();
		}

		$map = FacebookMapModel::lookupFromFacebookID( $fbid );
		if ( empty( $map ) ) {
			return null;
		} else {
			$wikiaID = $map->getWikiaUserId();
		}

		if ( $wikiaID ) {
			global $wgExternalAuthType;

			$user = User::newFromId( $wikiaID );

			// @TODO is this still used at Wikia?
			if ( $wgExternalAuthType ) {
				$user->load();
				if ( $user->getId() == 0 ) {
					$mExtUser = ExternalUser::newFromId( $wikiaID );
					if ( is_object( $mExtUser ) && ( $mExtUser->getId() != 0 ) ) {
						$mExtUser->linkToLocal( $mExtUser->getId() );
						$user->setId( $wikiaID );
					}
				}
			}

			return $user;
		} else {
			return null;
		}
	}

	/**
	 * Returns all known Facebook user IDs for the current Wikia user (could be many since Wikia has more
	 * than one Facebook app
	 *
	 * @param User|int $user
	 *
	 * @return array|bool|mixed
	 */
	public function getFacebookUserIds( $user ) {

		// Determine if we got an ID or an object
		if ( $user instanceof User && $user->getId() != 0 ) {
			$wikiaUserId = $user->getId();
		} else {
			$wikiaUserId = $user;
		}

		$fbid = [];
		if ( $wikiaUserId ) {
			$mappings = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );

			foreach ( $mappings as $map ) {
				/** @var FacebookMapModel $map */
				$fbid[] = $map->getFacebookUserId();
			}
		}

		return $fbid;
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
			if ( array_key_exists( 'base_domain', $metadata ) &&
				!empty( $metadata[ 'base_domain' ] )
			) {
				$base_domain = $metadata[ 'base_domain' ];
			}

			setcookie( $sessionCookieName, '', 0, '/', $base_domain );
		}
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