<?php

namespace Wikia\Helios;

/**
 * A helper class for dealing with user-related objects.
 */
class User {

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
	 * Called in ExternalUser_Wikia::authenticate() authenticates a user.
	 *
	 * @param string &$username string of the user name
	 * @param string &$password string of the plaintext password the user entered
	 *
	 * @return boolean true on success, false otherwise
	 */
	public static function authenticate( $username, $password )
	{
		$logger = \Wikia\Logger\WikiaLogger::instance();
		$logger->info( 'HELIOS_LOGIN', [ 'method' => __METHOD__, 'username' => $username ] );

		self::debugLogin( $password, __METHOD__ );

		global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
		$heliosClient = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

		// Authenticate with username and password.
		try {
			$loginInfo = $heliosClient->login( $username, $password );
			$result = !empty( $loginInfo->access_token );
	
			if ( !empty( $loginInfo->error ) ) {
				$logger->error(
					'HELIOS_LOGIN',
					[ 'response' => $loginInfo, 'username' => $username, 'method' => __METHOD__ ]
				);
				$result = false;
			}
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			$logger->error(
				'HELIOS_LOGIN',
				[ 'exception' => $e, 'username' => $username, 'method' => __METHOD__ ]
			);
			$result = false;
		}

		return $result;
	}

}
