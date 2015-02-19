<?php
/**
 * Class to manage data on wikia's PowerUsers.
 * It implements methods to add and remove
 * poweruser properties and log these actions
 * in a consistent way.
 *
 * @package PowerUser
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\PowerUser;

use Wikia\Logger\Loggable;

class PowerUser {
	use Loggable;

	/**
	 * Names of properties used to described PowerUsers
	 */
	const TYPE_ADMIN = 'poweruser_admin';
	const TYPE_FREQUENT = 'poweruser_frequent';
	const TYPE_LIFETIME = 'poweruser_lifetime';

	/**
	 * Requirement to meet to become a PowerUser
	 */
	const MIN_LIFETIME_EDITS = 2000;
	const MIN_FREQUENT_EDITS = 140;

	const LOG_MESSAGE = 'PowerUsersLog';
	const ACTION_ADD = 'add';
	const ACTION_REMOVE = 'remove';

	/**
	 * A table of all poweruser properties' names
	 * for in_array checks
	 * @var array
	 */
	public static $aPowerUserProperties = [
		self::TYPE_ADMIN,
		self::TYPE_FREQUENT,
		self::TYPE_LIFETIME,
	];

	/**
	 * A table mapping PU properties to JS variables names
	 */
	public static $aPowerUserJSVariables = [
		self::TYPE_ADMIN => 'wikiaIsPowerUserAdmin',
		self::TYPE_FREQUENT => 'wikiaIsPowerUserFrequent',
		self::TYPE_LIFETIME => 'wikiaIsPowerUserLifetime',
	];

	/**
	 * An array of the names of groups defining
	 * PowerUsers of an admin type
	 * @var array
	 */
	public static $aPowerUserAdminGroups = [
		'sysop',
	];

	private $oUser;

	function __construct( \User $oUser ) {
		$this->oUser = $oUser;
	}

	/**
	 * Adds a given PowerUser property to a user
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function addPowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) ) {
			$this->oUser->setOption( $sProperty, true );
			$this->oUser->saveSettings();
			$this->logSuccess( $sProperty, self::ACTION_ADD );
			return true;
		} else {
			$this->logError( $sProperty, self::ACTION_ADD );
			return false;
		}
	}

	/**
	 * Removes a given PowerUser property from a user
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function removePowerUserProperty( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) &&
			$this->oUser->getBoolOption( $sProperty ) === true
		) {
			$this->oUser->setOption( $sProperty, null );
			$this->oUser->saveSettings();
			$this->logSuccess( $sProperty, self::ACTION_REMOVE );
			return true;
		} else {
			$this->logError( $sProperty, self::ACTION_REMOVE );
			return false;
		}
	}

	/**
	 * Sets a basic context for logging
	 * @return array
	 */
	protected function getLoggerContext() {
		return [
			'user_id' => $this->oUser->getId(),
		];
	}

	/**
	 * Logs a successful action
	 *
	 * @param string $sType One of the types in consts
	 * @param string $sAction One of the actions in consts
	 * @param int $iUserId A user's ID
	 */
	private function logSuccess( $sType, $sAction ) {
		$this->info( self::LOG_MESSAGE, [
			'type' => $sType,
			'action' => $sAction,
		] );
	}

	/**
	 * Logs a failed action
	 *
	 * @param string $sType One of the types in consts
	 * @param string $sAction One of the actions in consts
	 * @param int $iUserId A user's ID
	 */
	private function logError( $sType, $sAction ) {
		$this->error( self::LOG_MESSAGE, [
			'type' => $sType,
			'action' => $sAction,
		] );
	}
}
