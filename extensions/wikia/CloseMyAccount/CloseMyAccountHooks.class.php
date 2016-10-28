<?php

class CloseMyAccountHooks {

	/**
	 * Abort a login if the user has provided a correct username and
	 * password, but has requested an account closure.
	 *
	 * @param  User    $user      The user attempting to log in
	 * @param  string  $result    The result code of the login attempt
	 * @param  string  $resultMsg The reason the login was aborted
	 * @return boolean            True if login should succeed, false otherwise
	 */
	public static function onWikiaUserLoginSuccess( $user, &$result, &$resultMsg ) {
		$closeAccountHelper = new CloseMyAccountHelper();
		if ( $closeAccountHelper->isScheduledForClosure( $user ) ) {
			$result = 'closurerequested';
			$resultMsg = 'Account closure requested';
			return false;
		}
		return true;
	}

	/**
	 * Abort a successful login through Facebook Connect if the user has
	 * requested an account closure.
	 *
	 * @param  User    $user     The user attempting to log in
	 * @param  string  $errorMsg Error message to display to the user
	 * @return boolean           True if login should succeed, false otherwise
	 */
	public static function onFacebookUserLoginSuccess( User $user, &$errorMsg ) {
		$closeAccountHelper = new CloseMyAccountHelper();
		if ( $closeAccountHelper->isScheduledForClosure( $user ) ) {
			$errorMsg = wfMessage( 'closemyaccount-reactivate-error-fbconnect', $user->getName() )->parse();
			return false;
		}
		return true;
	}

	/**
	 * Hijack SendConfirmationMail for our purposes, correcting the URL
	 * to point to the CloseMyAccount reactivation page.
	 *
	 * @param  User    $user     The user the mail is being sent to
	 * @param  array   $args     The email arguments used to build the message content
	 * @param  integer $priority The priority with which to send the mail
	 * @param  string  $url      The URL with the confirmation token
	 * @param  string  $token    The confirmation token
	 * @param  boolean $ip_arg   Whether the arguments include the IP address
	 * @param  string  $type     The type of confirmation mail
	 * @return boolean
	 */
	public static function onUserSendConfirmationMail( &$user, &$args, &$priority, &$url, $token, $ip_arg, $type ) {
		if ( $type === 'reactivateaccount' ) {
			$priority = 1;  // reactivation emails are higher than default priority of 0
			$title = Title::makeTitle( NS_MAIN, 'Special:CloseMyAccount/reactivate' );
			$url = $title->getCanonicalUrl( [ 'code' => $token ] );
			if ( !$ip_arg ) {
				$args[1] = $url;
			} else {
				$args[2] = $url;
			}
		}

		return true;
	}

}
