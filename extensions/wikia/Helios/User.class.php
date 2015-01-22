<?php

namespace Wikia\Helios;

/**
 * A helper class for dealing with user-related objects.
 */
class User {

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
	 * Hooked to the UserComparePasswords event, authenticates a user.
	 *
	 * Sets &$bResult to false and returns false if the authentication fails.
	 * Sets &$bResult to false and returns true if the authentication cannot be done.
	 * Sets &$bResult to true and returns false if the authentication succeeds.
	 *
	 * @param string &$sHash string of the password hash (from the database)
	 * @param string &$sPassword string of the plaintext password the user entered
	 * @param integer &$iUserId integer of the user's ID or Boolean false if the user ID was not supplied
	 * @param boolean &$bResult on false returned, this value will be checked to determine if the password was valid
	 *
	 * @return boolean false if the authentication has been done, true otherwise (yeah, I know...)
	 */
	public static function comparePasswords( &$sHash, &$sPassword, &$iUserId, &$bResult )
	{
		// Only proceed for the given percentage of login attempts.
		global $wgHeliosLoginSamplingRate;
		if ( rand(0, 100) > $wgHeliosLoginSamplingRate ) {
			return true;
		}
		
		// Get the user's name from the request context.
		$sUserName= \RequestContext::getMain()->getRequest()->getText( 'username' );

		global $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret;
		$oHelios = new Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

		// Authenticate with username and password.
		try {
			global $wgHeliosLoginShadowMode;
			$oLogin = $oHelios->login( $sUserName, $sPassword );
			$bResult = !empty( $oLogin->access_token ) && empty( $wgHeliosShadowMode ); // always false (so unchanged)  when in shadow mode
		}

		catch ( \Wikia\Helios\ClientException $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
			return true;
		}

		return !empty( $wgHeliosShadowMode ); // always true when in shadow mode

		// when true is returned, the original password comparison will be executed
	}

}
