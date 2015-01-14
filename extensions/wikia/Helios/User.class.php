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

				$oHelios = new \Wikia\Helios\Client( $wgHeliosBaseUri, $wgHeliosClientId, $wgHeliosClientSecret );

				try {
					// Authenticate with the token and create a MediaWiki User object.
					$oInfo = $oHelios->info( $aMatches[1] );
					if ( $oInfo->user_id ) {
						return \User::newFromId( $oInfo->user_id );
					}
				}

				catch ( \Wikia\Helios\ClientException $e ) {
					\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e ] );
				}
			}
		}
	}

}
