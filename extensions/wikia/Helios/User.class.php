<?php

namespace Wikia\Helios;

use Wikia\DependencyInjection\Injector;
use Wikia\Logger\WikiaLogger;
use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\User\Auth\CookieHelper;

/**
 * A helper class for dealing with user-related objects.
 */
class User {

	const ACCESS_TOKEN_COOKIE_NAME = 'access_token';
	const ACCESS_TOKEN_HEADER_NAME = 'X-Wikia-AccessToken';
	const AUTH_METHOD_NAME = 'auth_method';
	const STATUS_NAME = 'status';
	const MERCURY_ACCESS_TOKEN_COOKIE_NAME = 'sid';
	const AUTH_TYPE_FAILED = 0;
	const AUTH_TYPE_NORMAL_PW = 1;
	const AUTH_TYPE_RESET_PW = 2;
	const AUTH_TYPE_FB_TOKEN = 4;
	const INVALIDATE_CACHE_THROTTLE_SESSION_KEY = 'invalidate-cache-throttle';
	const INVALIDATE_CACHE_THROTTLE = 60; /* seconds */

	// This is set to 6 months,(365/2)*24*60*60 = 15768000
	const ACCESS_TOKEN_COOKIE_TTL = 15768000;

	private static $authenticationCache = [];

	/**
	 * Logs character encoding data for the given password.
	 *
	 * @param string $password
	 * @param string $callingMethod
	 */
	public static function debugLogin( $password, $callingMethod ) {
		$detectedEncoding = mb_detect_encoding( $password );
		$internalEncoding = mb_internal_encoding();

		WikiaLogger::instance()->info( $callingMethod, [
			'byte_length'			=> strlen( $password ),
			'character_length_detected'	=> mb_strlen( $password, $detectedEncoding ),
			'character_length_internal'	=> mb_strlen( $password, $internalEncoding ),
			'detected_encoding'		=> $detectedEncoding,
			'internal_encoding'		=> $internalEncoding,
		] );
	}

	/**
	 * Extracts access token from HTTP request data.
	 *
	 * @param \WebRequest $request the HTTP request data as an object
	 * @return String access token or null
	 */
	public static function getAccessToken( \WebRequest $request ) {
		// A cookie takes precedence over an HTTP header.
		// FIXME: replace with CookieHelper
		$token = $request->getCookie( self::ACCESS_TOKEN_COOKIE_NAME, '' );

		// No access token in the cookie, try the HTTP header.
		if ( ! $token ) {
			$token = $request->getHeader( self::ACCESS_TOKEN_HEADER_NAME );
		}

		// Normalize the value so the method returns a non-empty string or null.
		if ( empty( $token ) ) {
			return null;
		}

		return $token;
	}

	/**
	 * Creates a MediaWiki User object based on the token given in the HTTP request.
	 *
	 * @param \WebRequest $request the HTTP request data as an object
	 *
	 * @return \User on successful authentication
	 */
	public static function newFromToken( \WebRequest $request ) {
		// Extract access token from HTTP request data.
		wfProfileIn(__METHOD__);
		$token = self::getAccessToken( $request );

		// Authenticate with the token, if present.
		if ( $token ) {
			$heliosClient = self::getHeliosClient();

			try {
				$tokenInfo = $heliosClient->info( $token );
				if ( !empty( $tokenInfo->user_id ) ) {
					$user = \User::newFromId( $tokenInfo->user_id );
					$user->setGlobalAuthToken( $token );

					// dont return the user object if it's disabled
					// @see SERVICES-459
					if ( (bool)$user->getGlobalFlag( 'disabled' ) ) {
						self::clearAccessTokenCookie();
						wfProfileOut(__METHOD__);
						return null;
					}

					// start the session if there's none so far
					// the code is borrowed from SpecialUserlogin
					// @see PLATFORM-1261
					if ( session_id() == '' ) {
						$sessionId = substr(hash('sha256',$token),0,32);
						wfSetupSession($sessionId);
						WikiaLogger::instance()->debug( __METHOD__ . '::startSession' );

						// Update mTouched on user when he starts new MW session, but not too often
						// @see SOC-1326 and SUS-546
						global $wgMemc;
						$throttleKey = wfSharedMemcKey( self::INVALIDATE_CACHE_THROTTLE_SESSION_KEY, $tokenInfo->user_id );
						$invalidateCacheThrottleTime = $wgMemc->get( $throttleKey );
						if ( $invalidateCacheThrottleTime === null || $invalidateCacheThrottleTime < time() ) {
							$wgMemc->set( $throttleKey, time() + self::INVALIDATE_CACHE_THROTTLE, self::INVALIDATE_CACHE_THROTTLE);
							$user->invalidateCache();
						}
					}

					// return a MediaWiki's User object
					wfProfileOut(__METHOD__);
					return $user;
				}
			}

			catch ( ClientException $e ) {
				WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
			}
		}

		wfProfileOut(__METHOD__);
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

		$logger = WikiaLogger::instance();
		$logger->info( 'HELIOS_LOGIN authenticate', [ 'method' => __METHOD__, 'username' => $username ] );

		self::debugLogin( $password, __METHOD__ );

		$heliosClient = self::getHeliosClient();

		$result = false;
		$authMethod = self::AUTH_TYPE_FAILED;
		$status = \WikiaResponse::RESPONSE_CODE_ERROR;
		$throwException = null;

		// Authenticate with username and password.
		try {
			list($status, $loginInfo) = $heliosClient->login( $username, $password );
			if ( !empty( $loginInfo->error ) ) {
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
			$authMethod = isset($loginInfo->auth_method) ? $loginInfo->auth_method : self::AUTH_TYPE_NORMAL_PW;
		}
		catch ( ClientException $e ) {
			$logger->error(
				'HELIOS_LOGIN authentication_error',
				[ 'exception' => $e, 'response' => $e->getResponse(), 'username' => $username, 'method' => __METHOD__ ]
			);
			$throwException = $e;
		}

		// save in local cache
		self::$authenticationCache[$username][$password] = [
			'result' => $result,
			'exception' => $throwException,
			self::AUTH_METHOD_NAME => $authMethod,
			self::STATUS_NAME => $status,
		];

		if ( $throwException ) {
			throw $throwException;
		}

		if ( isset( $loginInfo->access_token ) && $authMethod != self::AUTH_TYPE_RESET_PW ) {
			self::setAccessTokenCookie( $loginInfo->access_token );
		}

		return $result;
	}

	/**
	 * @param $username
	 * @param $password
	 *
	 * @return bool
	 */
	public static function wasResetPassAuth( $username, $password ) {
		if ( empty( self::$authenticationCache[$username][$password][self::AUTH_METHOD_NAME] ) ) {
			return false;
		}
		$authMethod = self::$authenticationCache[$username][$password][self::AUTH_METHOD_NAME];

		return $authMethod == self::AUTH_TYPE_RESET_PW;
	}

	public static function checkAuthenticationStatus( $username, $password, $status ) {
		if ( empty( self::$authenticationCache[$username][$password][self::STATUS_NAME] ) ) {
			return false;
		}

		return self::$authenticationCache[$username][$password][self::STATUS_NAME] == $status;
	}

	/**
	 * Set the access_token cookie with the token value passed.
	 *
	 * @param string $accessToken
	 */
	public static function setAccessTokenCookie( $accessToken ) {
		$response = \RequestContext::getMain()->getRequest()->response();
		self::getCookieHelper()->setAuthenticationCookieWithToken( $accessToken, $response );
	}

	public static function onUserLogout() {
		self::invalidateAccessTokenInHelios();
		self::clearAccessTokenCookie();
		return true; // So that wfRunHooks evaluates to true.
	}

	/**
	 * Call helios invalidate token.
	 */
	private static function invalidateAccessTokenInHelios() {
		global $wgUser;
		$request = \RequestContext::getMain()->getRequest();
		$heliosClient = self::getHeliosClient();
		$accessToken = self::getAccessToken( $request );
		if ( !empty( $accessToken ) && !empty( $wgUser ) ) {
			$heliosClient->invalidateToken( $accessToken, $wgUser->getId() );
		}
	}

	/**
	 * Clear the access token cookie by setting a time in the past
	 */
	public static function clearAccessTokenCookie() {
		// FIXME: replace with CookieHelper::clearAuthenticationCookie
		self::clearCookie( self::ACCESS_TOKEN_COOKIE_NAME );

		/*
		 * Mercury's backend (Hapi) is setting access_token cookie in an encrypted form, so we need
		 * to destroy this one as well on UserLogout
		 * This is a temporary change which will be deleted while implementing SOC-798
		 */
		self::clearCookie( self::MERCURY_ACCESS_TOKEN_COOKIE_NAME );
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
		catch ( ClientException $e ) {
			$heliosException = $e;
		}

		// If we are in shadow mode calculate mediawiki response and log comparison result
		if ( $wgHeliosLoginShadowMode ) {
			$mediawikiResult = \User::comparePasswords( $hash, $password, $id );

			// Detect discrepancies between Helios and MediaWiki results.
			if ( $heliosResult !== null && $heliosResult != $mediawikiResult ) {
				self::debugLogin( $password, __METHOD__ );
				WikiaLogger::instance()->error(
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

	/*
	 * Invalidate all tokens for given user in helios service
	 */
	public static function onInvalidateAllTokens( $userId ) {
		$heliosClient = self::getHeliosClient();
		$heliosClient->forceLogout($userId);

		return true;
	}

	/**
	 * Called in ExternalUser_Wikia registers a user.
	 *
	 * @param string $username The username
	 * @param string $password The plaintext password the user entered
	 * @param string $email The user's email
	 * @param string $langCode The language code of the community the user is registering on
	 * @param string $birthDate
	 *
	 * @return bool true on success, false otherwise
	 */
	public static function register( $username, $password, $email, $birthDate, $langCode ) {
		$logger = WikiaLogger::instance();
		$logger->info( 'HELIOS_REGISTRATION START', [ 'method' => __METHOD__ ] );

		$helios = self::getHeliosClient();

		try {
			$registration = $helios->register( $username, $password, $email, $birthDate, $langCode );
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

	/**
	 * @param bool $result
	 * @param int $userId
	 * @param \User $user
	 * @param string $password
	 * @param string $email
	 *
	 * @return bool
	 */
	public static function onRegister( &$result, &$userId, $user, $password, $email ) {
		global $wgLang;

		$heliosUserId = null;
		$heliosResult = self::register( $user->mName, $password, $email, $user->mBirthDate, $wgLang->getCode() );
		$logger = WikiaLogger::instance();

		global $wgHeliosRegistrationShadowMode;

		if ( $heliosResult ) {

			global $wgExternalSharedDB;

			$table = $wgHeliosRegistrationShadowMode ? 'user_helios' : '`user`';

			$dbw = \wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
			$dbw->commit(); // PLATFORM-1151 This commit is required in order to refresh the database state.
			$heliosUserId = $dbw->selectField( $table, 'user_id', [ 'user_name' => $user->mName ], __METHOD__ );

			if ( $heliosUserId ) {

				if ( ! $wgHeliosRegistrationShadowMode ) {
					$result = $heliosResult;
					$userId = $heliosUserId;
				}

				$logger->info( 'HELIOS_REGISTRATION SUCCESS', [
					'method' => __METHOD__,
					'user_id' => $heliosUserId,
					'user_name' => $user->mName,
					'shadow' => $wgHeliosRegistrationShadowMode
				] );
			} else {
				$logger->error( 'HELIOS_REGISTRATION FAILURE FETCH_ID', [
					'method' => __METHOD__,
					'user_id' => null,
					'user_name' => $user->mName,
					'shadow' => $wgHeliosRegistrationShadowMode
				] );
			}

		} else {
			$logger->error( 'HELIOS_REGISTRATION FAILURE CALL', [
				'method' => __METHOD__,
				'user_name' => $user->mName,
				'shadow' => $wgHeliosRegistrationShadowMode
			] );
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

	/**
	 * Clears selected cookie
	 *
	 * @param $cookieName
	 */
	private static function clearCookie( $cookieName ) {
		$response = \RequestContext::getMain()->getRequest()->response();
		$response->setcookie(
			$cookieName,
			'',
			time() - self::ACCESS_TOKEN_COOKIE_TTL,
			\WebResponse::NO_COOKIE_PREFIX
		);
	}

	/**
	 * wrapper function added for strong typing and testing
	 * @return \Wikia\Service\Helios\HeliosClient
	 */
	public static function getHeliosClient() {
		return Injector::getInjector()->get(HeliosClient::class);
	}

	/**
	 * @return \Wikia\Service\User\Auth\CookieHelper
	 */
	private static function getCookieHelper() {
		return Injector::getInjector()->get(CookieHelper::class);
	}

}
