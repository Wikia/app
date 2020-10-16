<?php


class LeaderboardHelper {
	/**
	 * @param array $body response body from Leaderboard resource in discussion
	 * @return array|void
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function applyBadges( array $body ) {
		if ( !isset( $body['users'] ) ) {
			return $body;
		}

		$userIds = [];
		foreach ( $body['users'] as $entry ) {
			$userIds[] = (int)$entry['userInfo']['id'];
		}

		$usersMap = [];
		if ( !empty( $userIds ) ) {
			foreach ( UserArray::newFromIDs( $userIds ) as $user ) {
				$usersMap[$user->getId()] = $user;
			}
		}

		if ( in_array( 0, $userIds ) && !array_key_exists( 0, $usersMap ) ) {
			$usersMap[0] = User::newFromId( 0 );
		}

		$badges = [];
		foreach ( $usersMap as $user ) {
			$badge = '';
			\Hooks::run( 'BadgePermissionsRequired', [ $user, &$badge ] );
			$badges[$user->getId()] = $badge;
		}

		$body['users'] = array_map( function ( array $entry ) use ( $badges ) {
			$entry['userInfo']['badgePermission'] = $badges[(int)$entry['userInfo']['id']] ?? '';

			return $entry;
		}, $body['users'] );

		return $body;
	}
}
