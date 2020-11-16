<?php

namespace Wikia\FeedsAndPosts\Discussion;

use FatalError;
use MWException;

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

		$badges = [];
		\Hooks::run( 'BadgePermissionsRequired', [ $userIds, &$badges ] );

		$userInfoList = array_map( function ( array $entry ) use ( $badges ) {
			$entry['badgePermission'] = $badges[(int)$entry['id']] ?? '';

			return $entry;
		}, $userInfoList );

		return $userInfoList;
	}

	public static function applyBadgesMultipleUserInfoLists(
		array $objectsWithUserInfo, string $key
	): array {
		$userIds = [];

		foreach ( $objectsWithUserInfo as $obj ) {
			foreach ( $obj[$key] as $userInfo ) {
				$userIds[] = (int)$userInfo['id'];
			}
		}

		$badges = PermissionsHelper::getBadgesMap( $userIds );

		foreach ( $objectsWithUserInfo as &$obj ) {
			foreach ( $obj[$key] as &$userInfo ) {
				$userInfo['badgePermission'] = $badges[(int)$userInfo['id']] ?? '';
			}
		}

		return $objectsWithUserInfo;
	}
}
