<?php

class DiscussionBadgesManager {

	const BADGE_SYSOP = "badge:sysop";
	const BADGE_VSTF = "badge:vstf";
	const BADGE_STAFF = "badge:staff";
	const BADGE_THREADMODERATOR = "badge:threadmoderator";
	const BADGE_HELPER = "badge:helper";
	const BADGE_GLOBAL_DISCUSSIONS_MOD = "badge:global-discussions-moderator";
	const BADGE_PRIORITY = [
		self::BADGE_SYSOP,
		self::BADGE_THREADMODERATOR,
		self::BADGE_STAFF,
		self::BADGE_HELPER,
		self::BADGE_GLOBAL_DISCUSSIONS_MOD,
		self::BADGE_VSTF,
	];

	public static function getBadges( array $userIds ) {
		$badges = [];
		$users = self::getUsersMap( $userIds );
		foreach ( $users as $user ) {
			$badge = self::getPermissionBadge( $user );
			$badges[$user->getId()] = $badge;
		}

		return $badges;
	}

	private static function getUsersMap( array $userIds ): array {
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

	private static function getPermissionBadge( User $user ): string {
		$memcache = F::app()->wg->Memc;
		$key = self::badgeCacheKey( $user->getId() );
		$badge = $memcache->get( $key );

		if ( $badge === false ) {
			$badge = '';
			$userGroups = $user->getEffectiveGroups();
			foreach ( self::BADGE_PRIORITY as $badgeOption ) {
				if ( in_array( explode( ':', $badgeOption )[1], $userGroups ) ) {
					$badge = $badgeOption;
					break;
				}
			}
			$memcache->set( $key, $badge, 86400 ); // 1 day
		}

		return $badge;
	}

	private static function badgeCacheKey( $userId ) {
		return wfMemcKey( __CLASS__, 'badgePermission', $userId );
	}

	public static function purgeBadgeCache( $userId ) {
		return F::app()->wg->Memc->delete( self::badgeCacheKey( $userId ) );
	}
}
