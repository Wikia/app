<?php

namespace Wikia\Helios;

/**
 * A helper class for dealing with user-related objects.
 */
class User {

	/**
	 * Logs character encoding data for the given password.
	 */
	public static function debugLogin( $sPassword, $sCallingMethod )
	{
		$sDetectedEncoding = mb_detect_encoding( $sPassword );
		$sInternalEncoding = mb_internal_encoding();

		\Wikia\Logger\WikiaLogger::instance()->info( $sCallingMethod, [
			'byte_length'			=> strlen( $sPassword ),
			'character_length_detected'	=> mb_strlen( $sPassword, $sDetectedEncoding ),
			'character_length_internal'	=> mb_strlen( $sPassword, $sInternalEncoding ),
			'detected_encoding'		=> $sDetectedEncoding,
			'internal_encoding'		=> $sInternalEncoding,
		] );
	}

	/**
	 * Creates a MediaWiki User object based on the token given in the HTTP request.
	 */
	public static function newFromToken( \WebRequest $oRequest )
	{

		$sHeader = $oRequest->getHeader( 'AUTHORIZATION' );

		if ( $sHeader ) {

			$aMatches = [];
			preg_match( '/^Bearer\s*(\S*)$/', $sHeader, $aMatches );

			if ( !empty( $aMatches[1] ) ) {

				global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;

				$oHelios = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

				try {
					// Authenticate with the token and create a MediaWiki User object.
					$oInfo = $oHelios->info( $aMatches[1] );
					if ( !empty( $oInfo->user_id ) ) {
						return \User::newFromId( $oInfo->user_id );
					}
				}

				catch ( \Wikia\Helios\ClientException $e ) {
					\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
				}
			}
		}
	}

	/**
	 * Called in ExternalUser_Wikia::authenticate() authenticates a user.
	 *
	 * @param string &$sUserName string of the user name
	 * @param string &$sPassword string of the plaintext password the user entered
	 *
	 * @return boolean true on success, false otherwise
	 */
	public static function authenticate( $sUserName, $sPassword )
	{
		$oLogger = \Wikia\Logger\WikiaLogger::instance();
		$oLogger->info( 'HELIOS_LOGIN', [ 'method' => __METHOD__, 'username' => $sUserName ] );

		self::debugLogin( $sPassword, __METHOD__ );

		global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
		$oHelios = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

		// Authenticate with username and password.
		try {
			global $wgHeliosLoginShadowMode;
			$oLogin = $oHelios->login( $sUserName, $sPassword );
			$bResult = !empty( $oLogin->access_token ); 
	
			if ( !empty( $oLogin->error ) ) {
				$oLogger->error(
					'HELIOS_LOGIN',
					[ 'response' => $oLogin, 'username' => $sUserName, 'method' => __METHOD__ ]
				);
				$bResult = false;
			}
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			$oLogger->error(
				'HELIOS_LOGIN',
				[ 'exception' => $e, 'username' => $sUserName, 'method' => __METHOD__ ]
			);
			$bResult = false;
		}

		return $bResult;
	}

}
