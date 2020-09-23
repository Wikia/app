<?php

/**
 * CloseMyAccount Helper class
 *
 * @author Daniel Grunwell (grunny)
 */
class CloseMyAccountHelper {

	// Number of days to wait before properly closing account
	const CLOSE_MY_ACCOUNT_WAIT_PERIOD = 30;

	const REQUEST_CLOSURE_PREF = 'requested-closure-date';
	const DISABLED_BY_USER_PREF = 'disabled-by-user-request';

	/**
	 * Set an account to be closed, and log them out
	 *
	 * @param User $user The user we're scheduling to be closed
	 * @return boolean
	 */
	public function scheduleCloseAccount( User $user ) {
		// Already set?
		if ( $this->isScheduledForClosure( $user ) ) {
			return true;
		}

		$user->setGlobalPreference( self::REQUEST_CLOSURE_PREF, wfTimestamp( TS_DB ) );

		$user->saveSettings();

		$this->track( $user, 'request-closure' );

		return true;
	}

	/**
	 * Request the reactivation of the user's account
	 *
	 * This involves confirming they should be allowed to request this,
	 * generating a token, and emailing the link with the token, so we
	 * can confirm that they own this account.
	 *
	 * @param User $user The user account to reactivate
	 * @return boolean True if the reactivation was successfully requested, False otherwise
	 */
	public function requestReactivation( User $user ) {
		// Not scheduled for closure or not email confirmed?
		if ( !$this->isScheduledForClosure( $user ) || !$user->isEmailConfirmed() ) {
			return false;
		}

		$response = $user->sendConfirmationMail( 'reactivateaccount', 'ReactivationMail' );

		$this->track( $user, 'request-reactivation' );

		return $response->isGood();
	}

	/**
	 * Reactivate an account that was scheduled to be closed
	 *
	 * This involves checking the token, checking the user has authenticated
	 * successfully, and removing the user options.
	 *
	 * @param User $user The user account to reactivate
	 * @return boolean True if the reactivation was successful, False otherwise
	 */
	public function reactivateAccount( User $user ) {
		// Did they request closure or are already disabled?
		if ( !$this->isScheduledForClosure( $user ) || $this->isClosed( $user ) ) {
			return false;
		}

		$user->setGlobalPreference( self::REQUEST_CLOSURE_PREF, null );
		$user->saveSettings();

		Hooks::run( 'ReactivateAccount', [ $user ] );
		$this->track( $user, 'account-reactivated' );

		return true;
	}

	/**
	 * Get the number of days until the account is closed
	 *
	 * @param User $user The user account to check
	 * @return integer|boolean The number of days remaining, or false if no value is set
	 */
	public function getDaysUntilClosure( User $user ) {
		$daysRemaining = false;
		$requestDate = $user->getGlobalPreference( self::REQUEST_CLOSURE_PREF );

		if ( $requestDate !== null ) {
			// Number of days remaining until closure
			$daysSinceRequest = floor( ( time() - strtotime( $requestDate ) ) / 86400 );
			$daysRemaining = self::CLOSE_MY_ACCOUNT_WAIT_PERIOD - $daysSinceRequest;
			if ( $daysRemaining < 0 ) {
				$daysRemaining = 0;
			}
		}
		return $daysRemaining;
	}

	/**
	 * Check if the the user account is closed
	 *
	 * @param  User $user The user account to check
	 * @return boolean True if the account is disabled, False otherwise
	 */
	public function isClosed( User $user ) {
		return ( bool ) $user->getGlobalFlag( 'disabled', false );
	}

	/**
	 * Check if the the user account is scheduled to be closed
	 *
	 * @param User $user The user account to check
	 * @return boolean True if the account is scheduled for closure, False otherwise
	 */
	public function isScheduledForClosure( User $user ) {
		return ( bool ) $user->getGlobalPreference( self::REQUEST_CLOSURE_PREF, false );
	}

	/**
	 * Track an event
	 *
	 * @param User $user User account the event is affecting
	 * @param string $action The type of close account event, can be one of:
	 *
	 *     request-closure
	 *     request-reactivation
	 *     account-reactivated
	 *     account-closed
	 *
	 * @return void
	 */
	public function track( User $user, $action ) {
		global $wgUser, $wgDevelEnvironment;
		// Make sure the right user is set for the user ID that will be collected
		// when called from the maintenance script
		$oldUser = $wgUser;
		$wgUser = $user;

		// FIXME SUS-4812
		/*Track::event( 'trackingevent', [
			'ga_action' => 'submit',
			'ga_category' => 'closemyaccount',
			'ga_label' => $action,
			'beacon' => !empty( $wgDevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );*/

		$wgUser = $oldUser;
	}
}
