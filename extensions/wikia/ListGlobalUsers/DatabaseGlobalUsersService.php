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

		$userInfo = [];

		foreach ( $userIds as $userId ) {
			$userInfo[$userId] = User::whoIs( $userId );
		}

		asort( $userInfo );

		return $userInfo;
	}
}
