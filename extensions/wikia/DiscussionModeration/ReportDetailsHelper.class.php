<?php

class ReportDetailsHelper {
	public static function applyBadgePermission( array $userInfo ): array {
		$userIds = array_map( function ( $ui ) {
			return (int)$ui['id'];
		}, $userInfo );

		$badges = self::getBadges( $userIds );

		return array_map( function ( $ui ) use ( $badges ) {
			$ui['badgePermission'] = $badges[(int)$ui['id']] ?? '';

			return $ui;
		}, $userInfo );
	}

	public static function applyBadgePermissionToList( array $posts ): array {
		$userIds = [];
		foreach ( $posts as $post ) {
			foreach ( $post['userInfo'] as $ui ) {
				$userIds[] = (int)$ui['id'];
			}
		}

		$badges = self::getBadges( $userIds );

		foreach ( $posts as $pk => $post ) {
			foreach ( $post['userInfo'] as $uk => $ui ) {
				$posts[$pk]['userInfo'][$uk]['badgePermission'] = $badges[(int)$ui['id']] ?? '';
			}
		}

		return $posts;
	}

	private static function getBadges( array $userIds ): array {
		$userArray = \UserArray::newFromIDs( $userIds );

		$badges = [];
		foreach ( $userArray as $user ) {
			$userBadge = '';
			Hooks::run( 'BadgePermissionsRequired', [ $user, &$userBadge ] );
			$badges[$user->getId()] = $userBadge;
		}

		return $badges;
	}
}
