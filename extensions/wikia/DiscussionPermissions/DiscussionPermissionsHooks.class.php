<?php

class DiscussionPermissionsHooks {

	public static function onUserPermissionsRequired( User $user, Post $post, array &$permissions ): void {
		$calculatedPermissions = DiscussionPermissionsManager::getRights( $user, $post );
		$permissions = $calculatedPermissions;
	}

	public static function onBadgePermissionsRequired( array $userIds, array &$badges ): void {
		$calculatedBadges = DiscussionBadgesManager::getBadges( $userIds );
		$badges = $calculatedBadges;
	}

	public static function onUserRights( User $user, array $validGroupsToAdd, array $validGroupsToRemove ): void {
		if ( array_intersect( DiscussionBadgesManager::LOCAL_GROUPS, $validGroupsToAdd ) ||
			 array_intersect( DiscussionBadgesManager::LOCAL_GROUPS, $validGroupsToRemove ) ) {
			DiscussionBadgesManager::purgeLocalGroupCache();
		}

		if ( array_intersect( DiscussionBadgesManager::GLOBAL_GROUPS, $validGroupsToAdd ) ||
			 array_intersect( DiscussionBadgesManager::GLOBAL_GROUPS, $validGroupsToRemove ) ) {
			DiscussionBadgesManager::purgeGlobalGroupCache();
		}
	}
}
