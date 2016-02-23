<?php

namespace Wikia\Service\User\Permissions;

class PermissionsServiceImpl implements PermissionsService {

	/** @var  PermissionsDefinition */
	private $permissionsDefinition;

	/** @var string[string] - key is user id */
	private $localExplicitUserGroups = [];

	/** @var string[string] - key is the user id */
	private $globalExplicitUserGroups = [];

	/** @var string[string] - key is the user id */
	private $implicitUserGroups = [];

	/** @var string[string] - key is user id */
	private $userPermissions = [];

	public function __construct() {
		$this->permissionsDefinition = new PermissionsDefinitionImpl();
	}

	public function getDefinitions() {
		return $this->permissionsDefinition;
	}

	public function getExplicitUserGroups( \User $user ) {
		return array_unique( array_merge (
			$this->getExplicitLocalUserGroups( $user ) ?: [],
			$this->getExplicitGlobalUserGroups( $user ) ?: []
		) );
	}

	public function getExplicitLocalUserGroups( \User $user ) {
		$this->loadLocalGroups( $user->getId() );
		return $this->localExplicitUserGroups[ $user->getId() ];
	}

	public function getExplicitGlobalUserGroups( \User $user ) {
		$this->loadGlobalUserGroups( $user->getId() );
		return $this->globalExplicitUserGroups[ $user->getId() ];
	}

	public function isUserInGroup( \User $user, $group ) {
		return in_array( $group, $this->getEffectiveUserGroups( $user ) );
	}

	/**
	 * Return memcache key used for storing groups for a given user
	 *
	 * @param $userId
	 * @return string memcache key
	 */
	static public function getMemcKey( $userId ) {
		return wfSharedMemcKey( __CLASS__, 'permissions-groups', $userId );
	}

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes 'user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @param \User $user
	 * @param $reCacheAutomaticGroups
	 * @return string[] internal group names
	 */
	public function getAutomaticUserGroups( \User $user, $reCacheAutomaticGroups = false ) {
		if ( !$reCacheAutomaticGroups && isset( $this->implicitUserGroups[ $user->getId() ] ) ) {
			$implicitGroups = $this->implicitUserGroups[ $user->getId() ];
		} else {
			$implicitGroups = array( '*' );
			if ( $user->getId() ) {
				$implicitGroups[] = 'user';

				$implicitGroups = array_unique( array_merge(
					$implicitGroups,
					\Autopromote::getAutopromoteGroups( $user )
				) );
				$this->implicitUserGroups[ $user->getId() ] = $implicitGroups;
			}
		}

		return $implicitGroups;
	}

	/**
	 * Get the list of explicit and implicit group memberships this user has.
	 * This includes all explicit groups, plus 'user' if logged in,
	 * '*' for all accounts, and autopromoted groups
	 * @param \User $user
	 * @param $reCacheAutomaticGroups
	 * @return string[] internal group names
	 */
	public function getEffectiveUserGroups( \User $user, $reCacheAutomaticGroups = false ) {

		return array_unique( array_merge(
			$this->getExplicitUserGroups( $user ),
			$this->getAutomaticUserGroups( $user, $reCacheAutomaticGroups )
		) );
	}

	/**
	 * Get the permissions this user has.
	 * @param \User $user
	 * @return string[] permission names
	 */
	public function getUserPermissions( \User $user ) {
		$userId = $user->getId();

		if ( isset( $this->userPermissions[ $userId ] ) ) {
			$permissions = $this->userPermissions[ $userId ];
		} else {
			$permissions = $this->permissionsDefinition->getGroupPermissions( $this->getEffectiveUserGroups( $user ) );
			wfRunHooks( 'UserGetRights', array( $user, &$permissions ) );
			if ( !empty( $userId ) ) {
				$this->userPermissions[ $userId ] = array_values( $permissions );
			}
		}
		return $permissions;
	}

	private function loadLocalGroups( $userId ) {
		if ( !empty( $userId ) && !isset( $this->localExplicitUserGroups[ $userId ] ) ) {
			$dbr = wfGetDB( DB_MASTER );
			$res = $dbr->select( 'user_groups',
				array( 'ug_group' ),
				array( 'ug_user' => $userId ),
				__METHOD__ );
			$userLocalGroups = [];
			foreach ( $res as $row ) {
				$userLocalGroups[] = $row->ug_group;
			}
			$this->localExplicitUserGroups[ $userId ] = $userLocalGroups;
		}
	}

	/**
	 * @param int $db DB_SLAVE or DB_MASTER
	 * @return DatabaseBase
	 */
	static private function getSharedDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}

	private function loadGlobalUserGroups( $userId ) {
		if ( !empty( $userId ) && !isset( $this->globalExplicitUserGroups[$userId ] ) ) {

			$fname = __METHOD__;
			$globalGroups = \WikiaDataAccess::cache(
				self::getMemcKey( $userId ),
				\WikiaResponse::CACHE_LONG,
				function() use ( $userId, $fname ) {
					$dbr = self::getSharedDB( DB_MASTER );
					return $dbr->selectFieldValues(
						'user_groups',
						'ug_group',
						[ 'ug_user' => $userId ],
						$fname
					);
				}
			);

			$globalGroups = array_intersect( $globalGroups, $this->permissionsDefinition->getGlobalGroups() );
			$this->globalExplicitUserGroups[$userId ] = $globalGroups;
		}
	}

	private function isCentralWiki() {
		global $wgWikiaIsCentralWiki;
		return (bool)$wgWikiaIsCentralWiki;
	}

	private function addUserToGlobalGroup( \User $user, $group ) {
		if ( !$this->isCentralWiki() ) {
			return false;
		}
		$dbw = self::getSharedDB( DB_MASTER );
		if ( $user->getId() ) {
			$dbw->insert( 'user_groups',
				[
					'ug_user'  => $user->getID(),
					'ug_group' => $group,
				],
				__METHOD__
			);
		}

		wfRunHooks( 'AfterUserAddGlobalGroup', [ $user, $group ] );
		return true;
	}

	private function addUserToLocalGroup( \User $user, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		if( $user->getId() ) {
			$dbw->insert( 'user_groups',
				array(
					'ug_user'  => $user->getId(),
					'ug_group' => $group,
				),
				__METHOD__,
				array( 'IGNORE' ) );
		}

		return true;
	}

	private function canGroupBeAdded( \User $performer, \User $userToChange, $group ) {
		$groups = $this->getGroupsChangeableByUser( $performer );
		if ( in_array($group, $groups['add']) ) {
			return true;
		}
		if ( $performer->getId() == $userToChange->getId() && in_array($group, $groups['add-self'] ) ) {
			return true;
		}

		return false;
	}

	private function canGroupBeRemoved( \User $performer, \User $userToChange, $group ) {
		$groups = $this->getGroupsChangeableByUser( $performer );
		if ( in_array($group, $groups['remove']) ) {
			return true;
		}
		if ( $performer->getId() == $userToChange->getId() && in_array($group, $groups['remove-self'] ) ) {
			return true;
		}

		return false;
	}

	public function addUserToGroup( \User $performer, \User $userToChange, $group ) {
		if ( !$this->canGroupBeAdded( $performer, $userToChange, $group ) ) {
			return false;
		}

		try {
			if ( in_array( $group, $this->permissionsDefinition->getGlobalGroups() ) ) {
				$result = $this->addUserToGlobalGroup( $userToChange, $group );
			} else {
				$result = $this->addUserToLocalGroup( $userToChange, $group );
			}
		}
		finally {
			$this->invalidateCache( $userToChange );
			$userToChange->invalidateCache();
		}

		return $result;
	}

	private function removeUserFromGlobalGroup( \User $user, $group ) {
		if ( !$this->isCentralWiki() ) {
			return false;
		}

		$dbw = self::getSharedDB( DB_MASTER );
		$dbw->delete( 'user_groups',
			[
				'ug_user'  => $user->getID(),
				'ug_group' => $group,
			],
			__METHOD__
		);

		wfRunHooks( 'AfterUserRemoveGlobalGroup', [ $user, $group ] );

		return true;
	}

	private function removeUserFromLocalGroup( \User $user, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'user_groups',
			array(
				'ug_user'  => $user->getId(),
				'ug_group' => $group,
			), __METHOD__ );

		return true;
	}

	public function removeUserFromGroup( \User $performer, \User $userToChange, $group ) {
		if ( !$this->canGroupBeRemoved( $performer, $userToChange, $group ) ) {
			return false;
		}

		try {
			if ( in_array( $group, $this->permissionsDefinition->getGlobalGroups() ) ) {
				$result = $this->removeUserFromGlobalGroup( $userToChange, $group );
			} else {
				$result = $this->removeUserFromLocalGroup( $userToChange, $group );
			}
		}
		finally {
			$this->invalidateCache( $userToChange );
			$userToChange->invalidateCache();
		}
		return $result;
	}

	private function invalidateUserGroupsAndPermissions( $userId ) {
		unset( $this->userPermissions[$userId] );
		unset( $this->localExplicitUserGroups[$userId] );
		unset( $this->implicitUserGroups[$userId] );
		unset( $this->globalExplicitUserGroups[$userId] );
	}

	public function doesUserHavePermission( \User $user, $permission ) {
		if ( $permission === '' ) {
			return true; // In the spirit of DWIM
		}
		# Patrolling may not be enabled
		if( $permission === 'patrol' || $permission === 'autopatrol' ) {
			global $wgUseRCPatrol, $wgUseNPPatrol;
			if( !$wgUseRCPatrol && !$wgUseNPPatrol )
				return false;
		}
		# Use strict parameter to avoid matching numeric 0 accidentally inserted
		# by misconfiguration: 0 == 'foo'
		return in_array( $permission, $this->getUserPermissions( $user ), true );
	}

	public function doesUserHaveAllPermissions( \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( !$this->doesUserHavePermission( $user, $permission ) ){
				return false;
			}
		}
		return true;
	}

	public function doesUserHaveAnyPermission( \User $user, $permissions ) {
		foreach( $permissions as $permission ){
			if( $this->doesUserHavePermission( $user, $permission ) ){
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns an array of groups that this user can add and remove
	 * @param \User user
	 * @return array array( 'add' => array( addablegroups ),
	 *  'remove' => array( removablegroups ),
	 *  'add-self' => array( addablegroups to self),
	 *  'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByUser( \User $performer ) {
		if( $this->doesUserHavePermission( $performer, 'userrights' ) ) {
			// This group gives the right to modify everything (reverse-
			// compatibility with old "userrights lets you change
			// everything")
			// Using array_merge to make the groups reindexed
			$all = array_merge( $this->permissionsDefinition->getExplicitGroups() );
			return array(
				'add' => $all,
				'remove' => $all,
				'add-self' => array(),
				'remove-self' => array()
			);
		}

		// Okay, it's not so simple, we will have to go through the arrays
		$groups = array(
			'add' => array(),
			'remove' => array(),
			'add-self' => array(),
			'remove-self' => array()
		);
		$addergroups = $this->getEffectiveUserGroups( $performer );

		foreach( $addergroups as $addergroup ) {
			$groups = array_merge_recursive(
				$groups, $this->permissionsDefinition->getGroupsChangeableByGroup( $addergroup )
			);
		}
		$groups['add']    = array_unique( $groups['add'] );
		$groups['remove'] = array_unique( $groups['remove'] );
		$groups['add-self'] = array_unique( $groups['add-self'] );
		$groups['remove-self'] = array_unique( $groups['remove-self'] );
		return $groups;
	}

	public function invalidateCache( \User $user ) {
		$this->invalidateUserGroupsAndPermissions( $user->getId() );
		\WikiaDataAccess::cachePurge( self::getMemcKey( $user->getId() ) );
	}
}
