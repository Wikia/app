<?php

class FacebookClientHelper {

	/**
	 * Track an event with a given label with user-sign-up category
	 * @param string $label
	 * @param string $action optional, 'submit' by default
	 */
	public static function track( $label, $action = 'submit' ) {
		\Track::event( 'trackingevent', [
				'ga_action' => $action,
				'ga_category' => 'user-sign-up',
				'ga_label' => $label,
				'beacon' => !empty( F::app()->wg->DevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );
	}

	/**
	 * Create a new user mapping between a Wikia user account and a FB account
	 *
	 * @param $wikiaUserId
	 * @param $fbUserId
	 * @return bool True on success, False on failure
	 * @throws FacebookMapModelInvalidDataException
	 */
	public static function createUserMapping( $wikiaUserId, $fbUserId ) {
		$map = new FacebookMapModel();
		$map->relate( $wikiaUserId, $fbUserId );
		try {
			$map->save();
		} catch ( FacebookMapModelException $e ) {
			F::app()->wg->Out->showErrorPage( 'fbconnect-error', 'fbconnect-errortext' );
			return false;
		}

		return true;
	}

}