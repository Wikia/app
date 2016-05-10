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

		$user->setGlobalFlag( 'requested-closure', true );

		// Temporarily save requested-closure-date as both an attribute and a preference. This
		// will be changed to just a preference once we complete the migration. See SOC-2185
		$user->setGlobalAttribute( 'requested-closure-date', wfTimestamp( TS_DB ) );
		$user->setGlobalPreference( 'requested-closure-date', wfTimestamp( TS_DB ) );

		$user->saveSettings();

		$this->track( $user, 'request-closure' );

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
	 * @param  User     $user The user account to reactivate
	 * @param  WikiaApp $app  An instance of WikiaApp
	 * @return boolean        True if the reactivation was successfully requested,
	 *                        False otherwise
	 */
	public function requestReactivation( User $user, $app ) {
		wfProfileIn( __METHOD__ );
		// Not scheduled for closure or not email confirmed?
		if ( !$this->isScheduledForClosure( $user ) || !$user->isEmailConfirmed() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$response = $user->sendConfirmationMail( 'reactivateaccount', 'ReactivationMail' );

		$this->track( $user, 'request-reactivation' );

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

		$user->setGlobalFlag( 'requested-closure', null );

		// requested-closure-date is temporarily being stored as both an attribute and a preference.
		// Make sure to delete from both places. This will be changed to just a preference once the
		// migration is complete. See SOC-2185
		$user->setGlobalAttribute( 'requested-closure-date', null );
		$user->setGlobalPreference( 'requested-closure-date', null );

		$user->saveSettings();

		$this->track( $user, 'account-reactivated' );

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
		$requestDate = $user->getGlobalAttribute( 'requested-closure-date' );

		if ( $requestDate !== null ) {
			// Number of days remaining until closure
			$daysRemaining = (int)( self::CLOSE_MY_ACCOUNT_WAIT_PERIOD - floor( ( time() - strtotime( $requestDate ) ) / 86400 ) );
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
		return (bool)$user->getGlobalFlag( 'disabled', false );
	}

	/**
	 * Check if the the user account is scheduled to be closed
	 *
	 * @param  User    $user The user account to check
	 * @return boolean       True if the account is scheduled for closure,
	 *                       False otherwise
	 */
	public function isScheduledForClosure( User $user ) {
		return (bool)$user->getGlobalFlag( 'requested-closure', false )
			&& ( $user->getGlobalAttribute( 'requested-closure-date', false ) !== false );
	}

	/**
	 * Track an event
	 *
	 * @param  User   $user   User account the event is affecting
	 * @param  string $action The type of close account event, can be one of
	 *                        request-closure, request-reactivation, account-reactivated,
	 *                        account-closed
	 * @return void
	 */
	public function track( User $user, $action ) {
		global $wgUser, $wgDevelEnvironment;
		// Make sure the right user is set for the user ID that will be collected
		// when called from the maintenance script
		$oldUser = $wgUser;
		$wgUser = $user;

		Track::event( 'trackingevent', [
			'ga_action' => 'submit',
			'ga_category' => 'closemyaccount',
			'ga_label' => $action,
			'beacon' => !empty( $wgDevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );

		$wgUser = $oldUser;
	}

}
