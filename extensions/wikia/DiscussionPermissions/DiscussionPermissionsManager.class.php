<?php

class DiscussionPermissionsManager {

	const CAN_DELETE_PERMISSION = "canDelete";
	const CAN_UNDELETE_PERMISSION = "canUndelete";
	const CAN_EDIT_PERMISSION = "canEdit";
	const CAN_VALIDATE_PERMISSION = "canModerate";
	const CAN_LOCK_PERMISSION = "canLock";
	const CAN_UNLOCK_PERMISSION = "canUnlock";
	const CAN_MOVE_THREADS_PERMISSION = "canMove";

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

	private static $postPermissions = [
		'posts:delete' => [ self::CAN_DELETE_PERMISSION, self::CAN_UNDELETE_PERMISSION ],
		'posts:validate' => [ self::CAN_VALIDATE_PERMISSION ]
	];

	private static $threadPermissions = [
		'posts:delete' => [ self::CAN_DELETE_PERMISSION, self::CAN_UNDELETE_PERMISSION ],
		'posts:validate' => [ self::CAN_VALIDATE_PERMISSION ],
		'threads:delete' => [ self::CAN_DELETE_PERMISSION, self::CAN_UNDELETE_PERMISSION ],
		'threads:lock' => [ self::CAN_LOCK_PERMISSION, self::CAN_UNLOCK_PERMISSION ],
		'threads:move' => [ self::CAN_MOVE_THREADS_PERMISSION ]
	];

	public static function getRights( User $user, Post $post ) : array {
		if ( $post->isFirstPost() ) {
			$userRights = self::getThreadRights( $user, $post );
		} else {
			$userRights = self::getPostRights( $user, $post );
		}

		return array_values( array_filter( array_unique( $userRights ) ) );
	}

	private static function getThreadRights( User $user, Post $post ) : array {
		$rights = self::verifyPermissions( $user, self::$threadPermissions );

		if ( self::canMove( $user, $post ) ) {
			$rights[] = self::CAN_MOVE_THREADS_PERMISSION;
		}

		if ( self::canEdit( $user, $post ) ) {
			$rights[] = self::CAN_EDIT_PERMISSION;
		}

		return $rights;
	}

	private static function getPostRights( User $user, Post $post ) : array {
		$rights = self::verifyPermissions( $user, self::$postPermissions );

		if ( self::canEdit( $user, $post ) ) {
			$rights[] = self::CAN_EDIT_PERMISSION;
		}

		return $rights;
	}

	private static function verifyPermissions( User $user, array $permissions ) : array {
		$userRights = [];

		foreach ( $permissions as $permission => $rights ) {
			if ( $user->isAllowed( $permission ) ) {
				foreach ( $rights as $right ) {
					if ( !in_array( $right, $userRights ) ) {
						$userRights[] = $right;
					}
				}
			}
		}

		return $userRights;
	}

	private static function canMove( User $user, Post $post ) : bool {
		return self::canEditThread( $user, $post ) && $post->isEditable() && $post->isThreadEditable();
	}

	private static function canEdit( User $user, Post $post ) : bool {
		return self::canEditPost( $user, $post ) && $post->isEditable() && $post->isThreadEditable();
	}

	private static function canEditThread( User $user, Post $post ): bool {
		return $user->isAllowed( 'threads:superedit' )
			|| ( $post->isAuthor( $user ) && $post->isDuringEditablePeriod() );
	}

	private static function canEditPost( User $user, Post $post ): bool {
		return $user->isAllowed( 'posts:superedit' )
			   || ( $post->isAuthor( $user ) && $post->isDuringEditablePeriod() );
	}

	public static function getPermissionBadge( User $user ): string {
		$userGroups = $user->getEffectiveGroups();

		foreach ( self::BADGE_PRIORITY as $badge ) {
			if ( in_array( explode(':', $badge)[1], $userGroups) ) {
				return $badge;
			}
		}

		return '';
	}
}
