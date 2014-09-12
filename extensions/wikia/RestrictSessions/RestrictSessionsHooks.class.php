<?php

namespace RestrictSessions;

use User;

/**
 * Hooks class for the RestrictSessions extension
 *
 * @author grunny
 */
class RestrictSessionsHooks extends \ContextSource {

	const IP_SESSION_KEY = 'wsIPAddr';

	public static function setupHooks() {
		$rsObj = new self();

		\Hooks::register( 'UserSetCookies', $rsObj );
		\Hooks::register( 'UserLoadFromSession', $rsObj );
		\Hooks::register( 'UserLogout', $rsObj );
	}

	/**
	 * Add IP address to session data if user is a staff member.
	 *
	 * @param  User   $user    The current user object
	 * @param  array  $session Array of session data that will be added to $_SESSION
	 * @param  array  $cookies Array of cookies that will be set
	 * @return bool
	 */
	public function onUserSetCookies( User $user, &$session, &$cookies ) {
		$request = $this->getRequest();

		if ( $user->isAllowed( 'restrictsession' ) ) {
			$session[self::IP_SESSION_KEY] = $request->getIP();
		}

		return true;
	}

	/**
	 * Check IP address matches session data if user is a staff member.
	 *
	 * @param  User   $user   The user object being loaded
	 * @param  bool   $result Whether or not to continue authentication process
	 * @return bool
	 */
	public function onUserLoadFromSession( User $user, &$result ) {
		$request = $this->getRequest();
		$sessionUserId = $request->getSessionData( 'wsUserID' );
		$cookieUserId = $request->getCookie( 'UserID' );

		if ( $sessionUserId === null && $cookieUserId === null ) {
			return true;
		}

		$cookieUser = User::newFromId( $cookieUserId );

		if ( $cookieUser->isAnon() ) {
			// Don't load a staff session from just a session cookie.
			if ( $sessionUserId !== null ) {
				$sessionUser = User::newFromId( $sessionUserId );
				if ( $sessionUser->isAllowed( 'restrictsession' ) ) {
					$result = false;
				}
			}

			return true;
		} elseif ( $sessionUserId !== null && $cookieUserId != $sessionUserId ) {
			$result = false;
			return true;
		}

		$restrictSession = $cookieUser->isAllowed( 'restrictsession' );

		if ( $restrictSession ) {
			$reqIp = $request->getIP();
			$cookieToken = $request->getCookie( 'Token' );

			if ( $sessionUserId === null && $cookieToken !== null ) {
				// If the user has opted to remember their login, check the token
				// and update session data
				$token = rtrim( $cookieUser->getToken( false ) );
				if ( $restrictSession && strlen ( $token )
					&& \hash_equals( $token, $cookieToken )
				) {
					$request->setSessionData( self::IP_SESSION_KEY, $reqIp );
				}
			}

			$ipAddr = $request->getSessionData( self::IP_SESSION_KEY );

			if ( $reqIp !== $ipAddr && !$this->isWhiteListedIP( $reqIp ) ) {
				$result = false;
			}
		}

		return true;
	}

	/**
	 * Clear extra session data on logout.
	 *
	 * @param  User   $user The current user object
	 * @return bool
	 */
	public function onUserLogout( User $user ) {
		$request = $this->getRequest();

		if ( $user->isAllowed( 'restrictsession' ) ) {
			$request->setSessionData( self::IP_SESSION_KEY, null );
		}

		return true;
	}

	/**
	 * Check if an IP address is in a whitelisted range.
	 *
	 * @param  string  $ipAddress IP address to whitelist
	 * @return boolean
	 */
	public function isWhiteListedIP( $ipAddress ) {
		$ipAddress = \IP::sanitizeIP( $ipAddress );
		$whitelistRanges = $this->getWhitelistRanges();
		$isWhitelisted = false;

		foreach ( $whitelistRanges as $range ) {
			if ( \IP::isInRange( $ipAddress, $range ) ) {
				$isWhitelisted = true;
				break;
			}
		}

		return $isWhitelisted;
	}

	/**
	 * Get whitelisted IP ranges
	 *
	 * @return array List of whitelisted IP ranges
	 */
	private function getWhitelistRanges() {
		global $wgSessionIPWhitelist;

		$whitelist = [];

		if ( !empty( $wgSessionIPWhitelist ) && is_array( $wgSessionIPWhitelist ) ) {
			$whitelist = $wgSessionIPWhitelist;
		}

		return $whitelist;
	}

}
