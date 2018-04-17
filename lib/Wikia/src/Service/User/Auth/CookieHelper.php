<?php

namespace Wikia\Service\User\Auth;

use Wikia\HTTP\Response;
use Wikia\Service\Helios\HeliosClient;

class CookieHelper {

	const ACCESS_TOKEN_COOKIE_NAME = 'access_token';
	const ACCESS_TOKEN_HEADER_NAME = 'X-Wikia-AccessToken';
	// This is set to 6 months,(365/2)*24*60*60 = 15768000
	const ACCESS_TOKEN_COOKIE_TTL = 15768000;
	const COOKIE_PREFIX = '';

	private $heliosClient;

	public function __construct( HeliosClient $client ) {
		$this->heliosClient = $client;
	}


	/**
	 * @param HeliosClient $client
	 */
	public function setHeliosClient( HeliosClient $client ) {
		$this->heliosClient = $client;
	}

	public function getAccessToken( \WebRequest $request ) {
		$token = $request->getCookie( self::ACCESS_TOKEN_COOKIE_NAME, '' );
		if ( !$token ) {
			$token = $request->getHeader( self::ACCESS_TOKEN_HEADER_NAME );
		}

		if ( empty( $token ) ) {
			return null;
		}

		return $token;
	}

	/**
	 * Set the authentication cookie using the user id. This method will retrieve a new
	 * authentication token from Helios and then set the authentication cookie.
	 *
	 * Warning: this should only be called once the user has been authenticated (e.g. from a 3rd party)
	 *
	 * @param int $userId
	 * @param Response $response
	 */
	public function setAuthenticationCookieWithUserId( $userId, Response $response ) {
		$tokenData = $this->heliosClient->generateToken( $userId );
		$this->setAuthenticationCookieWithToken( $tokenData->access_token, $response );
	}

	/**
	 * Set the authentication cookie for the user using the given access token.
	 *
	 * @param string $accessToken
	 * @param Response $response
	 */
	public function setAuthenticationCookieWithToken( $accessToken, Response $response ) {
		$response->setcookie(
			self::ACCESS_TOKEN_COOKIE_NAME,
			// FIXME: generateToken should return an object so we don't have to rely on the
			// structure of the json map
			$accessToken,
			time() + self::ACCESS_TOKEN_COOKIE_TTL,
			self::COOKIE_PREFIX
		);
	}

	/**
	 * Clears the authentication cookie.
	 *
	 * @param Response $response
	 *
	 */
	public function clearAuthenticationCookie( Response $response ) {
		$response->setcookie(
			self::ACCESS_TOKEN_COOKIE_NAME,
			'',
			time() - self::ACCESS_TOKEN_COOKIE_TTL,
			self::COOKIE_PREFIX
		);
	}

}
