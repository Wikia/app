<?php

class DiscussionPermissionsHooks {

	public static function onUserPermissionsRequired( User $user, Post $post, array &$permissions ): void {
		$calculatedPermissions = DiscussionPermissionsManager::getRights( $user, $post );
		$permissions = $calculatedPermissions;
	}

	public static function onBadgePermissionsRequired( User $user, string &$badge ): void {
		$calculatedBadges = DiscussionPermissionsManager::getPermissionBadge( $user );
		$badge = $calculatedBadges;
	}

}
