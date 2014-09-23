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

		$restrictSession = false;

		if ( $cookieUserId === $sessionUserId ) {
			$restrictSession = User::newFromId( $cookieUserId )->isAllowed( 'restrictsession' );
		} else {
			// Check both cookie and session for the user because the user
			// can be loaded from both
			$cookieUser = User::newFromId( $cookieUserId );
			$sessionUser = User::newFromId( $sessionUserId );

			$restrictSession = $cookieUser->isAllowed( 'restrictsession' )
				|| $sessionUser->isAllowed( 'restrictsession' );
		}

		if ( $restrictSession ) {
			$ipAddr = $request->getSessionData( self::IP_SESSION_KEY );
			$reqIp = $request->getIP();

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
