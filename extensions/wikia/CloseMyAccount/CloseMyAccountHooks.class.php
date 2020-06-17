<?php

class CloseMyAccountHooks {
	
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
	public static function onUserSendConfirmationMail(
		User $user, &$args, &$priority, &$url, $token, $ip_arg, $type
	) {
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
