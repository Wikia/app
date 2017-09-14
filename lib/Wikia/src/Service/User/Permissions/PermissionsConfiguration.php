<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsConfiguration {

	/**
	 * @return string[] List of global groups, that is groups to which one is added on all wikis or on none
	 */
	public function getGlobalGroups();

	/**
	 * Checks if the given group is among the global groups
	 * @param $group string Group name
	 * @return string True if is global group
	 */
	public function isGlobalGroup( $group );

	/**
	 * @return string[] List of implicit groups,
	 * that is groups to which one is added automatically and not through manual assignment
	 */
	public function getImplicitGroups();

	/**
	 * Checks if the given group is among the implicit groups
	 * @param $group string Group name
	 * @return string True if is implicit group
	 */
	public function isImplicitGroup( $group );

	/**
	 * @return string[] List of explicit groups, that is groups to which one can be manually assigned.
	 * Both global and local.
	 */
	public function getExplicitGroups();

	/**
	 * Checks if the given group is among the explicit groups
	 * @param $group string Group name
	 * @return string True if is explicit group
	 */
	public function isExplicitGroup( $group );

	/**
	 * @return string[] List of all defined permissions
	 */
	public function getPermissions();

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups string[] List of internal group names
	 * @return string[] List of permission key names for given groups combined
	 */
	public function getGroupPermissions( $groups );

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $permission String Permissions to check
	 * @return string[] List of internal group names with the given permission
	 */
	public function getGroupsWithPermission( $permission );

	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return array array( 'add' => array( addablegroups ),
	 *     'remove' => array( removablegroups ),
	 *     'add-self' => array( addablegroups to self),
	 *     'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByGroup( $group );

	/**
	 * Returns list of groups that require restricted access
	 *
	 * @return array
	 */
	public function getRestrictedAccessGroups();

	/**
	 * Returns list of groups that allow to exempt restricted access
	 *
	 * @return array
	 */
	public function getRestrictedAccessExemptGroups();
}