<?php

class DatabaseGlobalUsersService implements GlobalUsersService {
	public function getGroupMembers( array $groupSet ): array {
		if ( empty( $groupSet ) ) {
			return [];
		}

		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$selectQuery = [ 'ug_group' => $groupSet ];
		$userIds = $dbr->selectFieldValues( 'user_groups', 'ug_user', $selectQuery, __METHOD__, [ 'DISTINCT' ] );

		$userMap = User::whoAre( $userIds );

		asort( $userMap );

		return $userMap;
	}
}
