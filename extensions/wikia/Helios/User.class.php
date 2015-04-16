<?php

namespace Wikia\Helios;

/**
 * A helper class for dealing with user-related objects.
 */
class User {

	private static $authenticationCache = [];

	/**
	 * Logs character encoding data for the given password.
	 */
	public static function debugLogin( $password, $callingMethod )
	{
		$detectedEncoding = mb_detect_encoding( $password );
		$internalEncoding = mb_internal_encoding();

		\Wikia\Logger\WikiaLogger::instance()->info( $callingMethod, [
			'byte_length'			=> strlen( $password ),
			'character_length_detected'	=> mb_strlen( $password, $detectedEncoding ),
			'character_length_internal'	=> mb_strlen( $password, $internalEncoding ),
			'detected_encoding'		=> $detectedEncoding,
			'internal_encoding'		=> $internalEncoding,
		] );
	}

	/**
	 * Creates a MediaWiki User object based on the token given in the HTTP request.
	 */
	public static function newFromToken( \WebRequest $request )
	{

		$header = $request->getHeader( 'AUTHORIZATION' );

		if ( $header ) {

			$matches = [];
			preg_match( '/^Bearer\s*(\S*)$/', $header, $matches );

			if ( !empty( $matches[1] ) ) {

				global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;

				$heliosClient = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

				try {
					// Authenticate with the token and create a MediaWiki User object.
					$tokenInfo = $heliosClient->info( $matches[1] );
					if ( !empty( $tokenInfo->user_id ) ) {
						return \User::newFromId( $tokenInfo->user_id );
					}
				}

				catch ( \Wikia\Helios\ClientException $e ) {
					\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
				}
			}
		}

		return null;
	}

	/**
	 * Performs authentication request to Helios
	 *
	 * @throws ClientException
	 *
	 * @param string &$username string of the user name
	 * @param string &$password string of the plaintext password the user entered
	 *
	 * @return boolean true on success, false otherwise
	 */
	public static function authenticate( $username, $password ) {
		// check the local cache
		if ( @self::$authenticationCache[$username][$password] !== null ) {
			$resultData = self::$authenticationCache[$username][$password];
			if ( $resultData[ 'exception' ] ) {
				throw $resultData[ 'exception' ];
			}
			return $resultData[ 'result' ];
		}

		$logger = \Wikia\Logger\WikiaLogger::instance();
		$logger->info( 'HELIOS_LOGIN authenticate', [ 'method' => __METHOD__, 'username' => $username ] );

		self::debugLogin( $password, __METHOD__ );

		global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
		$heliosClient = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

		$result = false;
		$throwException = null;

		// Authenticate with username and password.
		try {
			$loginInfo = $heliosClient->login( $username, $password );

			if ( !empty($loginInfo->error) ) {
				if ( $loginInfo->error === 'access_denied' ) {
					$logger->info(
						'HELIOS_LOGIN authentication_failed',
						[ 'response' => $loginInfo, 'username' => $username, 'method' => __METHOD__ ]
					);
				} else {
					throw new ClientException( 'Response error: ' . $loginInfo->error, 0, null, [ 'response' => $loginInfo ] );
				}
			}

			$result = !empty( $loginInfo->access_token );
		}
		catch ( ClientException $e )
		{
			$logger->error(
				'HELIOS_LOGIN authentication_error',
				[ 'exception' => $e, 'response' => $e->getResponse(), 'username' => $username, 'method' => __METHOD__ ]
			);
			$throwException = $e;
		}

		// save in local cache
		self::$authenticationCache[$username][$password] = [
			'result'=> $result,
			'exception' => $throwException
		];

		if ( $throwException ) {
			throw $throwException;
		}

		return $result;
	}

	/**
	 * Purge the authentication cache. If the username is specified only that username is affected.
	 *
	 * @param string $username (optional) Username
	 */
	public static function purgeAuthenticationCache( $username = null ) {
		if ( $username === null ) {
			self::$authenticationCache = [];
		} else {
			unset( self::$authenticationCache[$username] );
		}
	}


	/**
	 * Listens for any authentication attempts and uses Helios to determine the result
	 *
	 * @param int $id Id
	 * @param string $username Username
	 * @param string $hash Password hash
	 * @param string $password Password
	 * @param bool &$result (out) Authentication result
	 * @param string &$errorMessageKey (out) Error message
	 * @return bool true - hook handler
	 */
	public static function onUserCheckPassword( $id, $username, $hash, $password, &$result, &$errorMessageKey ) {
		global $wgHeliosLoginShadowMode;

		$heliosResult = null;
		$heliosException = null;
		try {
			$heliosResult = self::authenticate( $username, $password );
		}
		catch ( ClientException $e )
		{
			$heliosException = $e;
		}

		// If we are in shadow mode calculate mediawiki response and log comparison result
		if ( $wgHeliosLoginShadowMode ) {
			$mediawikiResult = \User::comparePasswords( $hash, $password, $id );

			// Detect discrepancies between Helios and MediaWiki results.
			if ( $heliosResult !== null && $heliosResult != $mediawikiResult ) {
				self::debugLogin( $password, __METHOD__ );
				\Wikia\Logger\WikiaLogger::instance()->error(
					'HELIOS_LOGIN check_password_discrepancy',
					[	'helios'         => $heliosResult,
						'mediawiki'      => $mediawikiResult,
						'user_id'        => $id,
						'username'       => $username ]
				);
			}

			$result = $mediawikiResult;
		} else { // pure-Helios mode
			if ( $heliosException ) {
				$errorMessageKey = 'login-abort-service-unavailable';
			}

			$result = $heliosResult;
		}

		return true;
	}

    /**
     * Called in ExternalUser_Wikia registers a user.
     *
     * @param string $username string of the user name
     * @param string $password string of the plaintext password the user entered
     * @param string $email string of the user email
     *
     * @return boolean true on success, false otherwise
     */
    public static function register( $username, $password, $email, $birthdate )
    {
        $logger = \Wikia\Logger\WikiaLogger::instance();
        $logger->info( 'HELIOS_REGISTRATION START', [ 'method' => __METHOD__ ] );

        global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
        $helios = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

        try {
            $registration = $helios->register( $username, $password, $email, $birthdate );
            $result = !empty( $registration->success );

            if ( !empty( $registration->error ) ) {
                $logger->error(
                    'HELIOS_REGISTRATION ERROR_FROM_SERVICE',
                    [ 'method' => __METHOD__ ]
                );
            }
        }

        catch ( ClientException $e ) {
            $logger->error(
                'HELIOS_REGISTRATION ERROR_FROM_CLIENT',
                [ 'exception' => $e, 'method' => __METHOD__ ]
            );
            $result = false;
        }

        return $result;
    }

    public static function onRegister( &$result, &$userId, $User, $password, $email ) {

        $heliosUserId = null;
        $heliosResult = self::register( $User->mName, $password, $email, $User->mBirthDate );
        $logger = \Wikia\Logger\WikiaLogger::instance();

        global $wgHeliosRegistrationShadowMode;

        if ( $heliosResult ) {

            global $wgExternalSharedDB;

            $table = $wgHeliosRegistrationShadowMode ? 'user_helios' : '`user`';

            $dbw = \wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
            $heliosUserId = $dbw->selectField( $table, 'user_id', [ 'user_name' => $User->mName ], __METHOD__ );

            if ( $heliosUserId ) {

                if ( ! $wgHeliosRegistrationShadowMode ) {
                    $result = $heliosResult;
                    $userId = $heliosUserId;
                }

                $logger->info( 'HELIOS_REGISTRATION SUCCESS', [ 'method' => __METHOD__, 'user_id' => $heliosUserId, 'user_name' => $User->mName, 'shadow' => $wgHeliosRegistrationShadowMode ] );
            } else {
                $logger->error( 'HELIOS_REGISTRATION FAILURE FETCH_ID', [ 'method' => __METHOD__, 'user_id' => null, 'user_name' => $User->mName, 'shadow' => $wgHeliosRegistrationShadowMode ] );
            }

        } else {
            $logger->error( 'HELIOS_REGISTRATION FAILURE CALL', [ 'method' => __METHOD__, 'user_name' => $User->mName, 'shadow' => $wgHeliosRegistrationShadowMode ] );
        }

        return true;

    }


	/**
	 * Listens for any user data save events and purges the authentication cache
	 *
	 * @param \User $user User
	 * @return bool true - hook handler
	 */
	public static function onUserSave( \User $user ) {
		self::purgeAuthenticationCache( $user->getName() );
		return true;
	}

}
