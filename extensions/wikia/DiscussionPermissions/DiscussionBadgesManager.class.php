<?php

class DiscussionBadgesManager {

	const GROUP_SYSOP = "sysop";
	const GROUP_VSTF = "vstf";
	const GROUP_STAFF = "staff";
	const GROUP_THREADMODERATOR = "threadmoderator";
	const GROUP_HELPER = "helper";
	const GROUP_GLOBAL_DISCUSSIONS_MOD = "global-discussions-moderator";

	const LOCAL_GROUPS = [
		self::GROUP_SYSOP,
		self::GROUP_THREADMODERATOR,
	];

	const GLOBAL_GROUPS = [
		self::GROUP_VSTF,
		self::GROUP_STAFF,
		self::GROUP_HELPER,
		self::GROUP_GLOBAL_DISCUSSIONS_MOD,
	];

	const BADGE_PRIORITY = [
		'badge:' . self::GROUP_SYSOP,
		'badge:' . self::GROUP_THREADMODERATOR,
		'badge:' . self::GROUP_STAFF,
		'badge:' . self::GROUP_HELPER,
		'badge:' . self::GROUP_GLOBAL_DISCUSSIONS_MOD,
		'badge:' . self::GROUP_VSTF,
	];

	public static function getBadges( array $userIds ) {
		$badges = self::getCachedBadges( $userIds );

		$noBadgeUsers = array_diff( $userIds, array_keys( $badges ) );

		if ( !$noBadgeUsers ) {
			return $badges;
		}

		foreach ( $noBadgeUsers as $user ) {
			$badges[$user] = '';
		}

		return $badges;
	}

	private static function getCachedBadges( array $userIds ) {
		$localGroups = self::localGroupsCache();
		$globalGroups = self::globalGroupsCache();

		$badges = [];

		foreach ( $userIds as $userId ) {
			$group = $globalGroups[$userId] ?? $localGroups[$userId] ?? false;
			if ( $group ) {
				$badges[$userId] = self::matchBadge( $group );
			}
		}

		return $badges;
	}

	public static function purgeLocalGroupCache() {
		$cache = F::app()->wg->Memc;
		$key = wfMemcKey( __CLASS__, 'groups' );
		return $cache->delete( $key );
	}

	public static function purgeGlobalGroupCache() {
		$cache = F::app()->wg->Memc;
		$key = wfForeignMemcKey( 'global', '', __CLASS__, 'groups' );
		return $cache->delete( $key );
	}

	private static function localGroupsCache() {
		$method = __METHOD__;
		$key = wfMemcKey( __CLASS__, 'groups' );

		$cache = F::app()->wg->Memc;
		$localGroups = $cache->get( $key );

		if ( $localGroups === false ) {
			$dbr = wfGetDB( DB_REPLICA );

			$result = $dbr->select(
				[
					'user_groups'
				],
				[
					'ug_user',
					'ug_group'
				],
				[
					'ug_group' => self::LOCAL_GROUPS
				],
				$method
			);

			$localGroups = [];
			foreach ( $result as $row ) {
				$localGroups[$row->ug_user][] = $row->ug_group;
			}

			$cache->set( $key, $localGroups, 604800 ); // 1 week
		}

		return $localGroups;
	}

	private static function globalGroupsCache() {
		global $wgExternalSharedDB;
		$method = __METHOD__;
		$globalKey = wfForeignMemcKey( 'global', '', __CLASS__, 'groups' );

		$cache = F::app()->wg->Memc;
		$globalGroups = $cache->get( $globalKey );

		if ( $globalGroups === false ) {
			$dbr = wfGetDB( DB_REPLICA, [], $wgExternalSharedDB );

			$result = $dbr->select(
				[
					'user_groups'
				],
				[
					'ug_user',
					'ug_group'
				],
				[
					'ug_group' => self::GLOBAL_GROUPS
				],
				$method
			);

			$globalGroups = [];
			foreach ( $result as $row ) {
				$globalGroups[$row->ug_user][] = $row->ug_group;
			}

			$cache->set( $globalKey, $globalGroups, 604800 ); // 1 week
		}

		return $globalGroups;
	}

	private static function matchBadge( $group ) {
		foreach ( self::BADGE_PRIORITY as $badge ) {
			if ( in_array( explode( ':', $badge )[1], $group ) ) {
				return $badge;
			}
		}
		return '';
	}
}
