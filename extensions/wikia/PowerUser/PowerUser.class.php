<?php

namespace Wikia\PowerUser;

class PowerUser {
	const TYPE_ADMIN = 'poweruser_admin';
	const TYPE_FREQUENT = 'poweruser_frequent';
	const TYPE_LIFETIME = 'poweruser_lifetime';

	public static $aPowerUserProperties = [
		self::TYPE_ADMIN,
		self::TYPE_FREQUENT,
		self::TYPE_LIFETIME,
	];

	private $oUser;

	function __construct( \User $oUser ) {
		$this->oUser = $oUser;
	}

	public function addPowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) ) {
			$this->oUser->setOption( $sProperty, true );
			$this->oUser->saveOptions();
			return true;
		}
		return false;
	}

	public function removePowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) &&
			$this->oUser->getBoolOption( $sProperty ) === true
		) {
			$this->oUser->setOption( $sProperty, NULL );
			$this->oUser->saveOptions();
			return true;
		}
		return false;
	}
}