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
	 * Uses Helios to authenticate user credentials.
	 *
	 * Due to MediaWiki flow during authentication results are cached within the request
	 * to prevent spamming Helios backend with the same calls.
	 *
	 * @param string &$username string of the user name
	 * @param string &$password string of the plaintext password the user entered
	 *
	 * @return boolean true on success, false otherwise
	 */
	public static function authenticate( $username, $password ) {
		// check the local cache
		if ( @self::$authenticationCache[$username][$password] !== null ) {
			return self::$authenticationCache[$username][$password];
		}

		$logger = \Wikia\Logger\WikiaLogger::instance();
		$logger->info( 'HELIOS_LOGIN authenticate', [ 'method' => __METHOD__, 'username' => $username ] );

		self::debugLogin( $password, __METHOD__ );

		global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
		$heliosClient = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

		// Authenticate with username and password.
		try {
			$loginInfo = $heliosClient->login( $username, $password );
			$result = !empty( $loginInfo->access_token );
	
			if ( !empty( $loginInfo->error ) ) {
				if ( $loginInfo->error === "access_denied" ) {
					// normal case: password incorrect, log it as info
					$logger->info(
						'HELIOS_LOGIN access_denied',
						[ 'response' => $loginInfo, 'username' => $username, 'method' => __METHOD__ ]
					);
				} else {
					$logger->error(
						'HELIOS_LOGIN response_error',
						[ 'response' => $loginInfo, 'username' => $username, 'method' => __METHOD__ ]
					);
				}
				$result = false;
			}
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			$logger->error(
				'HELIOS_LOGIN client_exception',
				[ 'exception' => $e, 'username' => $username, 'method' => __METHOD__ ]
			);
			$result = false;
		}

		// save in local cache
		self::$authenticationCache[$username][$password] = $result;

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
	 * @param bool &$result Authentication result
	 * @return bool true - hook handler
	 */
	public static function onUserCheckPassword( $id, $username, $hash, $password, &$result ) {
		global $wgHeliosLoginShadowMode;
		$heliosResult = \Wikia\Helios\User::authenticate( $username, $password );

		// If we are in shadow mode calculate mediawiki response and log comparison result
		if ( $wgHeliosLoginShadowMode ) {
			$mediawikiResult = \User::comparePasswords( $hash, $password, $id );

			// Detect discrepancies between Helios and MediaWiki results.
			if ( $heliosResult != $mediawikiResult ) {
				\Wikia\Helios\User::debugLogin( $password, __METHOD__ );
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
			$result = $heliosResult;
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
