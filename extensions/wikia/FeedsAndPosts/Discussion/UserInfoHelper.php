<?php

namespace Wikia\FeedsAndPosts\Discussion;

use FatalError;
use MWException;
use User;
use UserArray;

class UserInfoHelper {
	/**
	 * @param array $userInfoList
	 * @return array
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function applyBadges( array $userInfoList ) {
		if ( empty( $userInfoList ) ) {
			return $userInfoList;
		}

		$userIds = [];
		foreach ( $userInfoList as $entry ) {
			$userIds[] = (int)$entry['id'];
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

		$userInfoList = array_map( function ( array $entry ) use ( $badges ) {
			$entry['badgePermission'] = $badges[(int)$entry['id']] ?? '';

			return $entry;
		}, $userInfoList );

		return $userInfoList;
	}
}
