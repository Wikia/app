<?php

/**
 * CloseMyAccount Helper class
 *
 * @author Daniel Grunwell (grunny)
 */
class CloseMyAccountHelper {

	// Number of days to wait before properly closing account
	const CLOSE_MY_ACCOUNT_WAIT_PERIOD = 30;

	/**
	 * Set an account to be closed, and log them out
	 *
	 * @param  User    $user The user we're scheduling to be closed
	 * @return boolean
	 */
	public function scheduleCloseAccount( User $user ) {
		wfProfileIn( __METHOD__ );
		// Already set?
		if ( $this->isScheduledForClosure( $user ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$user->setOption( 'requested-closure', true );
		$user->setOption( 'requested-closure-date', wfTimestamp( TS_DB ) );
		$user->saveSettings();

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Request the reactivation of the user's account
	 *
	 * This involves confirming they should be allowed to request this,
	 * generating a token, and emailing the link with the token, so we
	 * can confirm that they own this account.
	 *
	 * @param  User    $user The user account to reactivate
	 * @return boolean       True if the reactivation was successfully requested,
	 *                       False otherwise
	 */
	public function requestReactivation( User $user ) {
		wfProfileIn( __METHOD__ );
		// Not scheduled for closure or not email confirmed?
		if ( !$this->isScheduledForClosure( $user ) || !$user->isEmailConfirmed() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$emailTextTemplate = F::app()->renderView( 'CloseMyAccountSpecial', 'email', [ 'language' => $user->getOption( 'language' ) ] );

		$response = $user->sendConfirmationMail( 'reactivateaccount', 'ReactivationMail', 'closemyaccount-reactivation-email', /*$ip_arg = */true, $emailTextTemplate );

		wfProfileOut( __METHOD__ );
		return $response->isGood();
	}

	/**
	 * Reactivate an account that was scheduled to be closed
	 *
	 * This involves checking the token, checking the user has authenticated
	 * successfully, and removing the user options.
	 *
	 * @param  User    $user The user account to reactivate
	 * @return boolean       True if the reactivation was successful,
	 *                       False otherwise
	 */
	public function reactivateAccount( User $user ) {
		wfProfileIn( __METHOD__ );

		// Did they request closure or are already disabled?
		if ( !$this->isScheduledForClosure( $user ) || $this->isClosed( $user ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$user->setOption( 'requested-closure', null );
		$user->setOption( 'requested-closure-date', null );
		$user->saveSettings();

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get the number of days until the account is closed
	 *
	 * @param  User            $user The user account to check
	 * @return integer|boolean       The number of days remaining, or false
	 *                               if no value is set
	 */
	public function getDaysUntilClosure( User $user ) {
		$daysRemaining = false;
		$requestDate = $user->getOption( 'requested-closure-date' );

		if ( $requestDate !== null ) {
			// Number of days remaining until closure
			$daysRemaining = self::CLOSE_MY_ACCOUNT_WAIT_PERIOD - floor( ( time() - strtotime( $requestDate ) ) / 60 / 60 / 24 );
			if ( $daysRemaining < 0 ) {
				$daysRemaining = 0;
			}
		}
		return $daysRemaining;
	}

	/**
	 * Check if the the user account is closed
	 *
	 * @param  User    $user The user account to check
	 * @return boolean       True if the account is disabled,
	 *                       False otherwise
	 */
	public function isClosed( User $user ) {
		return (bool)$user->getOption( 'disabled', false );
	}

	/**
	 * Check if the the user account is scheduled to be closed
	 *
	 * @param  User    $user The user account to check
	 * @return boolean       True if the account is scheduled for closure,
	 *                       False otherwise
	 */
	public function isScheduledForClosure( User $user ) {
		return (bool)$user->getOption( 'requested-closure', false )
			&& ( $user->getOption( 'requested-closure-date', false ) !== false );
	}

}
