<?php

namespace Wikia\FeedsAndPosts\Discussion;

use FatalError;
use Hooks;
use MWException;
use User;
use UserArray;

class PermissionsHelper {
	/**
	 * @param array $userIds
	 * @return array
	 */
	public static function getUsersMap( array $userIds ): array {
		$usersMap = [];
		if ( !empty( $userIds ) ) {
			foreach ( UserArray::newFromIDs( $userIds ) as $user ) {
				$usersMap[$user->getId()] = $user;
			}
		}

		if ( in_array( 0, $userIds ) && !array_key_exists( 0, $usersMap ) ) {
			$usersMap[0] = User::newFromId( 0 );
		}

		return $usersMap;
	}

	/**
	 * @param array $usersMap
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function getBadgesMap( array $usersMap ): array {
		$badges = [];
		foreach ( $usersMap as $user ) {
			$badge = '';
			Hooks::run( 'BadgePermissionsRequired', [ $user, &$badge ] );
			$badges[$user->getId()] = $badge;
		}

		return $badges;
	}
}
