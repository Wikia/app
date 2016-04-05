<?php
/**
 *
 * @author Bartłomiej Kowalczyk
 */

class AuthModalHooks {
	const REGISTRATION_SUCCESS_COOKIE_NAME = 'registerSuccess';

	/**
	 * Adds assets for AuthPages on each Oasis pageview
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'auth_modal_js' );
		}

		self::displaySuccessRegistrationNotification();

		return true;
	}

	private static function displaySuccessRegistrationNotification() {
		global $wgUser, $wgRequest;

		if (
			$wgUser->isLoggedIn() &&
			$wgRequest->getCookie( self::REGISTRATION_SUCCESS_COOKIE_NAME, WebResponse::NO_COOKIE_PREFIX ) === '1'
		) {
			$wgRequest->response()->setcookie(
				self::REGISTRATION_SUCCESS_COOKIE_NAME,
				'',
				time() - 3600,
				WebResponse::NO_COOKIE_PREFIX
			);
			BannerNotificationsController::addConfirmation(
				wfMessage( 'authmodal-registration-success', $wgUser->getName() )->escaped()
			);
		}

	}
}
