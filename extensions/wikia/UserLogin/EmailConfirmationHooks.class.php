<?php

class EmailConfirmationHooks {

	/**
	 * Add JS messages to the output
	 * @param \OutputPage $out An output object passed from a hook
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$emailConfirmedParam = $out->getRequest()->getVal( 'emailConfirmed' );

		if ( $emailConfirmedParam == '1' ) {
			BannerNotificationsController::addConfirmation(
				wfMessage( 'userlogin-email-confirmation-banner-success-message' )->escaped(),
				BannerNotificationsController::CONFIRMATION_CONFIRM
			);
		} else if ( $emailConfirmedParam == '0' ) {
			BannerNotificationsController::addConfirmation(
				wfMessage( 'userlogin-email-confirmation-banner-error' )->parse(),
				BannerNotificationsController::CONFIRMATION_WARN
			);
		}

		return true;
	}
}
