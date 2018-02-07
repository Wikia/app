<?php

interface GlobalUsersService {
	/**
	 * Return all users who are member of any of the given user groups, as a map of user IDs to corresponding user names.
	 * If the provided set of groups is empty, an empty map is returned.
	 *
	 * @param string[] $groupSet
	 * @return array a map of user IDs to user names
	 */
	public function getGroupMembers( array $groupSet ): array;
}
