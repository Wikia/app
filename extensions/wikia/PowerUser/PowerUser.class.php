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
use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Permissions\PermissionsServiceAccessor;
use Wikia\Service\User\Permissions\PermissionsService;

class PowerUser {
	use Loggable;
	use PermissionsServiceAccessor;

	/**
	 * Names of properties used to described PowerUsers
	 */
	const TYPE_FREQUENT = 'poweruser_frequent';
	const TYPE_LIFETIME = 'poweruser_lifetime';

	/**
	 * Name of a group rights given to PowerUsers
	 */
	const GROUP_NAME = 'poweruser';

	/**
	 * Requirement to meet to become a PowerUser
	 */
	const MIN_LIFETIME_EDITS = 2000;
	const MIN_FREQUENT_EDITS = 140;

	/**
	 * Logging parameters
	 */
	const LOG_MESSAGE = 'PowerUsersLog';
	const ACTION_ADD_SET_OPTION = 'Add option';
	const ACTION_ADD_GROUP = 'Add group';
	const ACTION_REMOVE_SET_OPTION = 'Remove option';
	const ACTION_REMOVE_GROUP = 'Remove group';

	/**
	 * A table of all poweruser properties' names
	 * for in_array checks
	 * @var array
	 */
	public static $aPowerUserProperties = [
		self::TYPE_FREQUENT,
		self::TYPE_LIFETIME,
	];

	/**
	 * A table mapping PU properties to JS variables names
	 */
	public static $aPowerUserJSVariables = [
		self::TYPE_FREQUENT => 'wikiaIsPowerUserFrequent',
		self::TYPE_LIFETIME => 'wikiaIsPowerUserLifetime',
	];

	private $oUser;

	function __construct( \User $oUser ) {
		global $wgEnableSharedUserRightsExt;
		$this->oUser = $oUser;
		$this->bUseGroups = $wgEnableSharedUserRightsExt;
	}

	/**
	 * Gets current PowerUser types for a user
	 *
	 * @return array
	 */
	public function getTypesForUser() {
		$aUserTypes = [];
		foreach ( self::$aPowerUserProperties as $sProperty ) {
			if ( $this->oUser->isSpecificPowerUser( $sProperty ) ) {
				$aUserTypes[] = $sProperty;
			}
		}
		return $aUserTypes;
	}

	/**
	 * Perform all actions to make a user a PowerUser
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function addPowerUserProperty( $sProperty ) {
		return ( $this->addPowerUserSetOption( $sProperty )
			&& $this->addPowerUserAddGroup( $sProperty ) );
	}

	/**
	 * Sets a specified PowerUser option to 1 in user_properties
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function addPowerUserSetOption( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) ) {
			$this->oUser->setGlobalFlag( $sProperty, true );
			$this->oUser->saveSettings();
			$this->logSuccess( $sProperty, self::ACTION_ADD_SET_OPTION );
			return true;
		} else {
			$this->logError( $sProperty, self::ACTION_ADD_SET_OPTION );
			return false;
		}
	}

	/**
	 * Adds group rights to a user if the property's name
	 * matches one in the aPowerUsersRightsMapping array
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool Always return true until the groups is only companion
	 */
	public function addPowerUserAddGroup( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties )
			&& $this->bUseGroups
			&& !$this->permissionsService()->isInGroup( $this->oUser, self::GROUP_NAME )
		) {
			global $wgUser;
			$this->permissionsService()->addToGroup( $wgUser, $this->oUser, self::GROUP_NAME );
			$this->logSuccess( $sProperty, self::ACTION_ADD_GROUP );
		}
		return true;
	}

	/**
	 * Performs all actions to downgrade a PowerUser to a user
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function removePowerUserProperty( $sProperty ) {
		return ( $this->removePowerUserSetOption( $sProperty )
			&& $this->removePowerUserRemoveGroup( $sProperty ) );
	}

	/**
	 * Sets a specified PowerUser option to 0 in user_properties
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function removePowerUserSetOption( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties ) ) {
			if ( (bool)$this->oUser->getGlobalFlag( $sProperty ) === true ) {
				$this->oUser->setGlobalFlag( $sProperty, null );
				$this->oUser->saveSettings();
				$this->logSuccess( $sProperty, self::ACTION_REMOVE_SET_OPTION );
			}
			return true;
		} else {
			$this->logError( $sProperty, self::ACTION_REMOVE_SET_OPTION );
			return false;
		}
	}

	/**
	 * Removes group rights from a user if the property's name
	 * matches one in the aPowerUsersRightsMapping array and
	 * a user actually has it
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool Always return true until the groups is only companion
	 */
	public function removePowerUserRemoveGroup( $sProperty ) {
		if ( in_array( $sProperty, self::$aPowerUserProperties )
			&& $this->bUseGroups
			&& $this->isGroupForRemoval( $sProperty )
		) {
			global $wgUser;
			$this->permissionsService()->removeFromGroup( $wgUser, $this->oUser, self::GROUP_NAME );
			$this->logSuccess( $sProperty, self::ACTION_REMOVE_GROUP );
		}
		return true;
	}

	/**
	 * Checks if removal of a property should remove a group
	 * and if a user still has a PowerUser type that qualifies him
	 * to have the 'poweruser' group
	 *
	 * @param string $sProperty One of the types in consts
	 * @return bool
	 */
	public function isGroupForRemoval( $sProperty ) {
		foreach ( self::$aPowerUserProperties as $sPowerUserProperty ) {
			if ( $sPowerUserProperty !== $sProperty
				&& $this->oUser->isSpecificPowerUser( $sPowerUserProperty )
			) {
				return false;
			}
		}
		return $this->permissionsService()->isInGroup( $this->oUser, self::GROUP_NAME );
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
	 */
	private function logError( $sType, $sAction ) {
		$this->error( self::LOG_MESSAGE, [
			'type' => $sType,
			'action' => $sAction,
		] );
	}
}
