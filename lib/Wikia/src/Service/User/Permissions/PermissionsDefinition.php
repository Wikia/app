<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsDefinition {

	/**
	 * @return string[] List of global groups, that is groups to which one is added on all wikis or on none
	 */
	public function getGlobalGroups();

	/**
	 * @return string[] List of implicit groups,
	 * that is groups to which one is added automatically and not through manual assignment
	 */
	public function getImplicitGroups();

	/**
	 * @return string[] List of explicit groups, that is groups to which one can be manually assigned.
	 * Both global and local.
	 */
	public function getExplicitGroups();

	/**
	 * @return string[] List of all defined permissions
	 */
	public function getPermissions();

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups Array of Strings List of internal group names
	 * @return Array of Strings List of permission key names for given groups combined
	 */
	public function getGroupPermissions( $groups );

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $role String Role to check
	 * @return Array of Strings List of internal group names with the given permission
	 */
	public function getGroupsWithPermission( $role );
	
	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *     'remove' => array( removablegroups ),
	 *     'add-self' => array( addablegroups to self),
	 *     'remove-self' => array( removable groups from self) )
	 */
	public function getGroupsChangeableByGroup( $group );
}