<?php

class ReportDetailsHelper {
	public static function applyBadgePermission( array $userInfo ): array {
		$userIds = array_map( function ( $ui ) {
			return (int)$ui['id'];
		}, $userInfo );

		$userArray = \UserArray::newFromIDs( $userIds );

		$badges = [];
		foreach ( $userArray as $user ) {
			$badges[$user->getId()] = DiscussionPermissionManager::getPermissionBadge( $user );
		}

		return array_map( function ( $ui ) use ( $badges ) {
			$ui['badgePermission'] = $badges[(int)$ui['id']] ?? '';

			return $ui;
		}, $userInfo );
	}
}