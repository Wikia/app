<?php

class AuthPagesHooks {

	/**
	 * Add JS messages to the output
	 * @param \OutputPage $out An output object passed from a hook
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$emailConfirmedParam = $out->getRequest()->getVal( 'emailConfirmed' );

		if ( $emailConfirmedParam == '1' ) {
			BannerNotificationsController::addConfirmation(
				$out->msg( 'userlogin-email-confirmation-banner-success-message' )->escaped(),
				BannerNotificationsController::CONFIRMATION_CONFIRM
			);
		} elseif ( $emailConfirmedParam == '0' ) {
			BannerNotificationsController::addConfirmation(
				$out->msg( 'userlogin-email-confirmation-banner-error' )->parse(),
				BannerNotificationsController::CONFIRMATION_WARN
			);
		}
	}
}
