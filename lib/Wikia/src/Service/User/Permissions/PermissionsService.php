<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsService
{

    /**
     * Gets the object containing definitions of groups and permissions in the system
     * @return PermissionsConfiguration
     */
    public function getConfiguration();

    /**
     * @param \User $user
     * @return string[] Get list of global and local groups to which the given user has been explicitly assigned to.
     */
    public function getExplicitGroups( \User $user );

    /**
     * @param \User $user
     * @return string[] Get list of global groups to which the given user has been explicitly assigned to.
     */
    public function getExplicitGlobalGroups( \User $user );

    /**
     * @param \User $user
     * @return string[] Get list of local groups to which the given user has been explicitly assigned to.
     */
    public function getExplicitLocalGroups( \User $user );

    /**
     * @param \User $user
     * @param $group string group name
     * @return bool True if user is member of the given group
     */
    public function isInGroup( \User $user, $group );

    /**
     * Get the list of explicit and implicit group memberships this user has.
     * This includes all explicit groups, plus 'user' if logged in,
     * '*' for all accounts, and autopromoted groups
     * @param \User $user
     * @param $recacheAutomaticGroups
     * @return string[] internal group names
     */
    public function getEffectiveGroups( \User $user, $recacheAutomaticGroups = false );

    /**
     * Get the list of implicit group memberships this user has.
     * This includes 'user' if logged in, '*' for all accounts,
     * and autopromoted groups
     * @param \User $user
     * @param $recacheAutomaticGroups
     * @return string[] internal group names
     */
    public function getAutomaticGroups( \User $user, $recacheAutomaticGroups = false );

    /**
     * Get the permissions this user has.
     * @param \User $user
     * @return string[] permission names
     */
    public function getPermissions( \User $user );

    /**
     * Returns an array of groups that this user can add and remove
     * @param \User $userPerformingChange
     * @return array array( 'add' => array( addablegroups ),
     *  'remove' => array( removablegroups ),
     *  'add-self' => array( addablegroups to self),
     *  'remove-self' => array( removable groups from self) )
     */
    public function getChangeableGroups( \User $performer );

    /**
     * Adds the given user to the given group(s)
     * @param \User $performer User that is currently logged in and is performing the operation
     * @param \User $userToChange User whose groups we're changing
     * @param $groups string Name of group or array with list of groups
     * @return bool True if operation was successful
     */
    public function addToGroup( \User $performer, \User $userToChange, $groups );

    /**
     * Removes the given user from the given group(s)
     * @param \User $performer User that is currently logged in and is performing the operation
     * @param \User $userToChange User whose groups we're changing
     * @param $groups string Name of group or array with list of groups
     * @return bool True if operation was successful
     */
    public function removeFromGroup( \User $performer, \User $userToChange, $groups );

    /**
     * Checks whether the given user has the requested permission
     * @param \User $user
     * @param $permission string Name of permission
     * @return bool True if the user has the provided permission
     */
    public function hasPermission( \User $user, $permission );

    /**
     * Checks whether the given user has all the requested permissions
     * @param \User $user
     * @param $permissions string[] List of permissions
     * @return bool True if the user has all the provided permissions
     */
    public function hasAllPermissions( \User $user, $permissions );

    /**
     * Checks whether the given user has at least one of the requested permissions
     * @param \User $user
     * @param $permissions string[] List of permissions
     * @return bool True if the user has at least one of the provided permissions
     */
    public function hasAnyPermission( \User $user, $permissions );

    /**
     * Invalidates all cached permissions data for the given user
     * @param \User $user
     */
    public function invalidateCache( \User $user );
}
