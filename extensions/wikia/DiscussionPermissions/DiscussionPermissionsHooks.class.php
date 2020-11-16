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

	public static function onUserRights( User $user, $validGroupsToAdd, $validGroupsToRemove ): void {
		DiscussionBadgesManager::purgeBadgeCache( $user->getId() );
	}
}
