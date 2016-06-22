<?php

class CommunityPageSpecialHooks {

	/**
	 * Cache key invalidation when an article is edited
	 *
	 * @param $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	public static function onArticleSaveComplete(
		$article, User $user, $text, $summary, $minoredit, $watchthis,
		$sectionanchor, $flags, $revision, $status, $baseRevId
	) {
		// Early exit for edits that do not affect any cached item
		if ( $user->isAnon() ) {
			return true;
		}

		// Purge Top Contributors list
		$key = CommunityPageSpecialUsersModel::getMemcKey( CommunityPageSpecialUsersModel::TOP_CONTRIB_MCACHE_KEY );
		WikiaDataAccess::cachePurge( $key );
		CommunityPageSpecialUsersModel::logUserModelPerformanceData( 'purge', 'top_contributors' );

		// Purge All Members List
		$key = CommunityPageSpecialUsersModel::getMemcKey( CommunityPageSpecialUsersModel::ALL_MEMBERS_MCACHE_KEY );
		WikiaDataAccess::cachePurge( $key );
		CommunityPageSpecialUsersModel::logUserModelPerformanceData( 'purge', 'all_contributors' );

		// Purge All Members Count
		$key = CommunityPageSpecialUsersModel::getMemcKey(
			CommunityPageSpecialUsersModel::ALL_MEMBERS_COUNT_MCACHE_KEY
		);
		WikiaDataAccess::cachePurge( $key );

		// Purge all admins list
		if ( self::isAdmin( $user->getId() ) ) {
			$key = CommunityPageSpecialUsersModel::getMemcKey( CommunityPageSpecialUsersModel::ALL_ADMINS_MCACHE_KEY );
			WikiaDataAccess::cachePurge( $key );
			CommunityPageSpecialUsersModel::logUserModelPerformanceData( 'purge', 'all_admins' );
		}

		return true;
	}

	/**
	 * Adds assets for Community Page Benefits Modal
	 *
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( $out->getUser()->isAnon() && !isset( $_COOKIE['cpBenefitsModalShown'] ) ) {
			\Wikia::addAssetsToOutput( 'community_page_benefits_js' );
			\Wikia::addAssetsToOutput( 'community_page_benefits_scss' );
		}
		return true;
	}

	/**
	 * Add community page entry point to article page right rail module
	 *
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( array &$railModuleList ) {
		global $wgTitle;

		if ( $wgTitle->inNamespace( NS_MAIN ) || $wgTitle->isSpecial( 'WikiActivity' ) ) {
			$railModuleList[1342] = [ 'CommunityPageEntryPoint', 'Index', null ];
		}

		return true;
	}

	/**
	 * Purge admins list on user rights change
	 * @param User $user
	 * @param array $validGroupsToAdd
	 * @param array $validGroupsToRemove
	 * @return bool
	 */
	public static function onUserRights( User $user, array $validGroupsToAdd, array $validGroupsToRemove ) {
		if ( self::hasAdminGroup( $validGroupsToAdd ) || self::hasAdminGroup( $validGroupsToRemove ) ) {
			$key = CommunityPageSpecialUsersModel::getMemcKey( CommunityPageSpecialUsersModel::ALL_ADMINS_MCACHE_KEY );
			WikiaDataAccess::cachePurge( $key );
			CommunityPageSpecialUsersModel::logUserModelPerformanceData( 'purge', 'all_admins' );
		}

		return true;
	}

	public static function onUserFirstEditOnLocalWiki( $userId, $wikiId ) {
		$key = CommunityPageSpecialUsersModel::getMemcKey(
			[ CommunityPageSpecialUsersModel::RECENTLY_JOINED_MCACHE_KEY, 14 ]
		);
		WikiaDataAccess::cachePurge( $key );
		CommunityPageSpecialUsersModel::logUserModelPerformanceData( 'purge', 'recently_joined' );

		return true;
	}

	private static function hasAdminGroup( $userGroups ) {
		return !empty( array_intersect( WikiService::ADMIN_GROUPS, $userGroups ) );
	}

	private static function isAdmin( $userId ) {
		return in_array( $userId, ( new CommunityPageSpecialUsersModel() )->getAdmins() );
	}
}
