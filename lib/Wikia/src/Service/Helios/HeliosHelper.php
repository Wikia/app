<?php
namespace Wikia\Service\Helios;


class HeliosHelper {

	const ACCESS_TOKEN_COOKIE_NAME = 'access_token';
	const AUTHORIZATION_HEADER = 'AUTHORIZATION';
	const BEARER_REGEX = '/^Bearer\s*(\S*)$/';

	// This is set to 6 months,(365/2)*24*60*60 = 15768000
	const ACCESS_TOKEN_COOKIE_TTL = 15768000;


	/**
	 * Extracts access token from HTTP request data.
	 *
	 * @param \WebRequest $request the HTTP request data as an object
	 * @return String access token or null
	 */
	public static function getAccessToken( \WebRequest $request ) {
		// A cookie takes precedence over an HTTP header.
		$token = $request->getCookie( self::ACCESS_TOKEN_COOKIE_NAME, '' );

		// No access token in the cookie, try the HTTP header.
		if ( !$token ) {
			$header = $request->getHeader( self::AUTHORIZATION_HEADER );

			$matches = [ ];
			preg_match( self::BEARER_REGEX, $header, $matches );

			if ( !empty( $matches[ 1 ] ) ) {
				$token = $matches[ 1 ];
			}
		}

		// Normalize the value so the method returns a non-empty string or null.
		if ( empty( $token ) ) {
			return null;
		}

		return $token;
	}

	/**
	 * Clear the access token cookie by setting a time in the past
	 */
	public static function clearAccessTokenCookie() {
		$response = \RequestContext::getMain()->getRequest()->response();
		$response->setcookie(
			self::ACCESS_TOKEN_COOKIE_NAME,
			'',
			time() - self::ACCESS_TOKEN_COOKIE_TTL,
			\WebResponse::NO_COOKIE_PREFIX
		);
	}
}
