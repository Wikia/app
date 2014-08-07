<?php

namespace RestrictSessions;
use User;
use RequestContext;

/**
 * Hooks class for the RestrictSessions extension
 *
 * @author grunny
 */
class RestrictSessionsHooks {

	const IP_SESSION_KEY = 'wsIPAddr';

	/**
	 * Add IP address and User Agent to session data if user is a staff member.
	 *
	 * @param  User   $user    The current user object
	 * @param  array  $session Array of session data that will be added to $_SESSION
	 * @param  array  $cookies Array of cookies that will be set
	 * @return bool
	 */
	public static function onUserSetCookies( User $user, &$session, &$cookies ) {
		$request = RequestContext::getMain()->getRequest();

		if ( $user->isAllowed( 'restrictsession' ) ) {
			$session[self::IP_SESSION_KEY] = $request->getIP();
		}

		return true;
	}

	/**
	 * Check IP address and User Agent match session data if user is a staff member.
	 *
	 * @param  User   $user   The user object being loaded
	 * @param  bool   $result Whether or not to continue authentication process
	 * @return bool
	 */
	public static function onUserLoadFromSession( User $user, &$result ) {
		$request = RequestContext::getMain()->getRequest();
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

			if ( $request->getIP() !== $ipAddr ) {
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
	public static function onUserLogout( User $user ) {
		$request = RequestContext::getMain()->getRequest();

		if ( $user->isAllowed( 'restrictsession' ) ) {
			$request->setSessionData( self::IP_SESSION_KEY, null );
		}

		return true;
	}

}
