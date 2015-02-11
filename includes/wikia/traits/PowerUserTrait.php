<?php

trait PowerUserTrait {
	private $aPowerUserProperties = [
		'poweruser_lifetime',
		'poweruser_frequent',
		'poweruser_admin',
	];

	// Required base-class methods
	abstract function setOption();
	abstract function getOption();
	abstract function saveOptions();

	public function addPowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, $this->aPowerUserProperties ) ) {
			$this->setOption( $sProperty, true );
			$this->saveOptions();
			return true;
		}
		return false;
	}

	public function removePowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, $this->aPowerUserProperties ) &&
			$this->getOption( $sProperty ) == true
		) {
			$this->setOption( $sProperty, NULL );
			$this->saveOptions();
			return true;
		}
		return false;
	}

	public function isPowerUser() {
		foreach ( $this->aPowerUserProperties as $sProperty ) {
			if ( $this->getOption( $sProperty ) ) {
				return true;
			}
		}
		return false;
	}

	public function isSpecificPowerUser( $sProperty ) {
		if ( in_array( $sProperty, $this->aPowerUserProperties ) &&
			$this->getOption( $sProperty )
		) {
			return true;
		}
		return false;
	}
}
