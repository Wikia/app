<?php
/**
 * A trait adding PowerUser related methods.
 * Intended to be used by the User class.
 *
 * @package PowerUser
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */
use Wikia\PowerUser\PowerUser;

trait PowerUserTrait {
	// Required base-class methods
	abstract function getBoolOption( $oname );

	/**
	 * Checks if a user has one of the poweruser
	 * properties set to true
	 *
	 * @return bool
	 */
	public function isPowerUser() {
		foreach ( PowerUser::$aPowerUserProperties as $sProperty ) {
			if ( $this->getBoolOption( $sProperty ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Checks if a user has a specific poweruser
	 * property set to true
	 *
	 * @return bool
	 */
	public function isSpecificPowerUser( $sProperty ) {
		return in_array( $sProperty, PowerUser::$aPowerUserProperties ) &&
			$this->getBoolOption( $sProperty );
	}
}
