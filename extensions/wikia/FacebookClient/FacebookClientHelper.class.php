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

}