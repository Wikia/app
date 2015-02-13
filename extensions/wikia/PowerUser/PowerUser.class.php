<?php

namespace Wikia\PowerUser;

use Wikia\Logger\WikiaLogger;

class PowerUser {
	const TYPE_ADMIN = 'poweruser_admin';
	const TYPE_FREQUENT = 'poweruser_frequent';
	const TYPE_LIFETIME = 'poweruser_lifetime';

	const MIN_LIFETIME_EDITS = 2000;
	const MIN_FREQUENT_EDITS = 140;

	const LOG_MESSAGE = 'PowerUsersLog';
	const ACTION_ADD = 'add';
	const ACTION_REMOVE = 'remove';

	public static $aPowerUserProperties = [
		self::TYPE_ADMIN,
		self::TYPE_FREQUENT,
		self::TYPE_LIFETIME,
	];

	public static $aPowerUserAdminGroups = [
		'sysop',
	];

	private $oUser;

	function __construct( \User $oUser ) {
		$this->oUser = $oUser;
	}

	public function addPowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) ) {
			$this->oUser->setOption( $sProperty, true );
			$this->oUser->saveSettings();
			$this->logSuccess( $sProperty, self::ACTION_REMOVE, $this->oUser->getId() );
			return true;
		} else {
			$this->logError($sProperty, self::ACTION_REMOVE, $this->oUser->getId());
			return false;
		}
	}

	public function removePowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) &&
			$this->oUser->getBoolOption( $sProperty ) === true
		) {
			$this->oUser->setOption( $sProperty, NULL );
			$this->oUser->saveSettings();
			$this->logSuccess( $sProperty, self::ACTION_REMOVE, $this->oUser->getId() );
			return true;
		} else {
			$this->logError($sProperty, self::ACTION_REMOVE, $this->oUser->getId());
			return false;
		}
	}

	private function logSuccess( $sType, $sAction, $iUserId ) {
		WikiaLogger::instance()->info( self::LOG_MESSAGE, [
			'type' => $sType,
			'action' => $sAction,
			'user_id' => $iUserId,
		]);
	}

	private function logError( $sType, $sAction, $iUserId ) {
		WikiaLogger::instance()->error( self::LOG_MESSAGE, [
			'type' => $sType,
			'action' => $sAction,
			'user_id' => $iUserId,
		]);
	}
}
