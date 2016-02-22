<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsService {

	/**
	 * Gets the object containing definitions of groups and permissions in the system
	 * @return PermissionsDefinition
	 */
	public function getDefinitions();

	/**
	 * @param \User $user
	 * @return string[] Get list of global and local groups to which the given user has been explicitly assigned to.
	 */
	public function getExplicitUserGroups( \User $user );

	/**
	 * @param \User $user
	 * @return string[] Get list of global groups to which the given user has been explicitly assigned to.
	 */
	public function getExplicitGlobalUserGroups( \User $user );

	/**
	 * @param \User $user
	 * @return string[] Get list of local groups to which the given user has been explicitly assigned to.
	 */
	public function getExplicitLocalUserGroups( \User $user );

	/**
	 * @param \User $user
	 * @param $group string group name
	 * @return bool True if user is member of the given group
	 */
	public function isUserInGroup( \User $user, $group );

	/**
	 * Get the list of explicit and implicit group memberships this user has.
	 * This includes all explicit groups, plus 'user' if logged in,
	 * '*' for all accounts, and autopromoted groups
	 * @param \User $user
	 * @param $reCacheAutomaticGroups
	 * @return Array of String internal group names
	 */
	public function getEffectiveUserGroups( \User $user, $reCacheAutomaticGroups = false );

	/**
	 * Get the list of implicit group memberships this user has.
	 * This includes 'user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @param \User $user
	 * @param $reCacheAutomaticGroups
	 * @return Array of String internal group names
	 */
	public function getAutomaticUserGroups( \User $user, $reCacheAutomaticGroups = false );

	/**
	 * Get the permissions this user has.
	 * @param \User $user
	 * @return Array of String permission names
	 */
	public function getUserPermissions( \User $user );

	/**
	 * Returns an array of groups that this user can add and remove
	 * @param \User $userPerformingChange
	 * @return Array array( 'add' => array( addablegroups ),
	 *  'remove' => array( removablegroups ),
	 *  'add-self' => array( addablegroups to self),
	 *  'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByUser( \User $performer );

	/**
	 * Adds the given user to the given group
	 * @param \User $performer User that is currently logged in and is performing the operation
	 * @param \User $userToChange User whose groups we're changing
	 * @param $group string Name of group
	 * @return bool True if operation was successful
	 */
	public function addUserToGroup( \User $performer, \User $userToChange, $group );

	/**
	 * Removes the given user from the given group
	 * @param \User $performer User that is currently logged in and is performing the operation
	 * @param \User $userToChange User whose groups we're changing
	 * @param $group string Name of group
	 * @return bool True if operation was successful
	 */
	public function removeUserFromGroup( \User $performer, \User $userToChange, $group );

	/**
	 * Checks whether the given user has the requested permission
	 * @param \User $user
	 * @param $permission string Name of permission
	 * @return bool True if the user has the provided permission
	 */
	public function doesUserHavePermission( \User $user, $permission );

	/**
	 * Checks whether the given user has all the requested permissions
	 * @param \User $user
	 * @param $permissions string[] List of permissions
	 * @return bool True if the user has all the provided permissions
	 */
	public function doesUserHaveAllPermissions( \User $user, $permissions );

	/**
	 * Checks whether the given user has at least one of the requested permissions
	 * @param \User $user
	 * @param $permissions string[] List of permissions
	 * @return bool True if the user has at least one of the provided permissions
	 */
	public function doesUserHaveAnyPermission( \User $user, $permissions );

	/**
	 * Invalidates all cached permissions data for the given user
	 * @param \User $user
	 */
	public function invalidateCache( \User $user );
}
