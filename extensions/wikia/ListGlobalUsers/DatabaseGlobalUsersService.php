<?php

class DatabaseGlobalUsersService implements GlobalUsersService {
	public function getGroupMembers( array $groupSet ): array {
		if ( empty( $groupSet ) ) {
			return [];
		}

		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$groupMemberQuery = [ 'ug_group' => $groupSet ];
		$usersInGroups = $dbr->selectFieldValues( 'user_groups', 'ug_user', $groupMemberQuery, __METHOD__ );
		// get all other groups for these users
		$result = $dbr->select( 'user_groups', '*', [ 'ug_user' => $usersInGroups ], __METHOD__ );

		$userIdsToGroups = [];

		foreach ( $result as $row ) {
			$userIdsToGroups[$row->ug_user] = $userIdsToGroups[$row->ug_user] ?? [];

			$userIdsToGroups[$row->ug_user][] = $row->ug_group;
			$userIds[] = $row->ug_user;
		}

		$userNameMap = User::whoAre( $userIds );

		// unset default entry for anonymous user since there can't be any of them here
		unset( $userNameMap[0] );
		asort( $userNameMap );

		$userMap = [];

		foreach ( $userNameMap as $userId => $userName ) {
			$userMap[$userId]['groups'] = $userIdsToGroups[$userId];
			$userMap[$userId]['name'] = $userName;
		}

		return $userMap;
	}
}
