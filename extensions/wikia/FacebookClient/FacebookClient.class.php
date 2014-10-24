<?php

class FacebookClient {

	// Only create one instance of this object per request
	private static $instance;

	/** @var Facebook\FacebookSignedRequestFromInputHelper  */
	private $facebookAPI;
	private $userInfoCache;

	public function __construct( Facebook\FacebookSignedRequestFromInputHelper $facebookAPI = null) {
		global $fbAppId, $fbAppSecret;

		// Only hold one version of this client per request
		if ( empty( $this->facebookAPI ) ) {
			if ( $facebookAPI ) {
				// Use client passed to our constructor
				$this->facebookAPI = $facebookAPI;
			} else {
				// Construct our own client

				// Make sure we have the ID and secret set
				if ( empty( $fbAppId ) || empty( $fbAppSecret ) ) {
					throw new Exception( wfMessage( 'facebookgraphapi-not-configured' ) );
				}

				Facebook\FacebookSession::setDefaultApplication( $fbAppId, $fbAppSecret );
				$this->facebookAPI = new Facebook\FacebookJavaScriptLoginHelper();
			}
		}
	}

	public static function getInstance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new FacebookClient();
		}
		return self::$instance;
	}

	public function getUserId() {
		return $this->facebookAPI->getUserId();
	}

	/**
	 * @param int $userId
	 *
	 * @return Facebook\GraphUser
	 */
	public function getUserInfo( $userId = 0 ) {
		if ( $userId == 0 ) {
			$userId = $this->getUserId();
		}

		if ( $userId != 0 && !isset( $this->userInfoCache[$userId] ) ) {
			try {
				$userProfile = ( new \Facebook\FacebookRequest(
					$this->facebookAPI->getSession(),
					'GET',
					'/me'
				) )->execute()->getGraphObject( Facebook\GraphUser::className() );

				$this->userInfoCache[$userId] = $userProfile;
			} catch( Exception $e ) {
				error_log( "Failure in the api requesting '/me' on uid $userId: " . $e->getMessage() );
			}
		}
		return $this->userInfoCache[$userId];
	}

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

	public function getFullName( $user = 0 ) {
		$userInfo = $this->getUserInfo( $user );
		return $userInfo->getName();
	}

	public function getWikiaUser( $fbid = null ) {

		if ( empty( $fbid ) ) {
			$fbid = $this->getUserId();
		}

		// NOTE: Do not just pass this dbr into getUserByDB since that function prevents
		// rewriting of the database name for shared tables.
		$dbr = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );

		$wikiaID = ( new WikiaSQL() )
			->select( 'user_id' )
			->from( 'user_fbconnect' )
			->where( 'user_fbid' )->EQUAL_TO( $fbid )
			->runLoop( $dbr, function ( &$id, $row ) {
				$id = $row->user_id;
			} );

		if ( $wikiaID ) {
			global $wgExternalAuthType;

			$user = User::newFromId( $wikiaID );

			// @TODO is this still used at Wikia?
			if ( $wgExternalAuthType ) {
				$user->load();
				if ( $user->getId() == 0 ) {
					$mExtUser = ExternalUser::newFromId( $id );
					if ( is_object( $mExtUser ) && ( $mExtUser->getId() != 0 ) ) {
						$mExtUser->linkToLocal( $mExtUser->getId() );
						$user->setId( $id );
					}
				}
			}

			return $user;
		} else {
			return null;
		}
	}

	/**
	 * @param User|int $user
	 *
	 * @return array|bool|mixed
	 */
	public function getFacebookUserIds( $user ) {
		$wg = F::app()->wg;

		$dbr = wfGetDB( DB_SLAVE, null, $wg->ExternalSharedDB );

		// Determine if we got an ID or an object
		if ( $user instanceof User && $user->getId() != 0 ) {
			$wikiaUserId = $user->getId();
		} else {
			$wikiaUserId = $user;
		}

		if ( $wikiaUserId ) {
			$memkey = wfSharedMemcKey( "fb_user_id", $wikiaUserId );
			$val = $wg->Memc->get( $memkey );
			if ( is_array( $val ) ) {
				return $val;
			}

			$fbid = ( new WikiaSQL() )
				->SELECT( 'user_fbid' )
				->FROM( 'user_fbconnect' )
				->WHERE( 'user_id' )->EQUAL_TO( $wikiaUserId )
				->runLoop( $dbr, function ( &$ids, $row ) {
					$ids[] = $row->user_fbid;
				} );

			$wg->Memc->set( $memkey, $fbid );
		} else {
			$fbid = [];
		}

		return $fbid;
	}

	/**
	 *
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