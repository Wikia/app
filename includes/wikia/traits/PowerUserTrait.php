<?php

use Wikia\PowerUser\PowerUser;

trait PowerUserTrait {
	// Required base-class methods
	abstract function getBoolOption();

	public function isPowerUser() {
		foreach ( PowerUser::$aPowerUserProperties as $sProperty ) {
			if ( $this->getBoolOption( $sProperty ) ) {
				return true;
			}
		}
		return false;
	}

	public function isSpecificPowerUser( $sProperty ) {
		if ( in_array( $sProperty, PowerUser::$aPowerUserProperties ) &&
			$this->getBoolOption( $sProperty )
		) {
			return true;
		}
		return false;
	}
}
