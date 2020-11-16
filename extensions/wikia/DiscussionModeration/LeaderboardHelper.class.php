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

		$badges = [];
		\Hooks::run( 'BadgePermissionsRequired', [ $userIds, &$badges ] );

		$body['users'] = array_map( function ( array $entry ) use ( $badges ) {
			$entry['userInfo']['badgePermission'] = $badges[(int)$entry['userInfo']['id']] ?? '';

			return $entry;
		}, $body['users'] );

		return $body;
	}
}
