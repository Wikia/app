<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsService {
	public function getGlobalGroups();

	public function getImplicitGroups();

	public function getExplicitGroups();

	public function getPermissions();

	public function getExplicitUserGroups( $userId );

	public function getExplicitGlobalUserGroups( $userId );

	public function getExplicitLocalUserGroups( $userId );

	public function getEffectiveUserGroups( \User $user, $reCacheAutomaticGroups = false );

	public function getAutomaticUserGroups( \User $user, $reCacheAutomaticGroups = false );

	public function getGroupPermissions( $groups );

	public function getGroupsWithPermission( $role );

	public function getUserPermissions( \User $user );

	public function getGroupsChangeableByGroup( $group );

	public function getGroupsChangeableByUser( \User $user );

	public function addUserToGroup( \User $userPerformingChange, \User $userToChange, $group );

	public function removeUserFromGroup( \User $userPerformingChange, \User $userToChange, $group );

	public function doesUserHavePermission( \User $user, $permission );

	public function doesUserHaveAllPermissions( \User $user, $permissions );

	public function doesUserHaveAnyPermission( \User $user, $permissions );
}
