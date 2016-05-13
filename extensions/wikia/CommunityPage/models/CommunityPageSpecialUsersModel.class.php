<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const MEMBER_COUNT_MCACHE_KEY = 'community_member_count';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';
	const CURR_USER_CONTRIBUTIONS_MCACHE_KEY = 'community_page_current_user_contributions';

	private $wikiService;
	private $admins;

	// fixme: Remove WikiService hard dependency
	public function __construct( WikiService $wikiService ) {
		$this->wikiService = $wikiService;
	}

	public function getAdmins() {
		if ( $this->admins === null ) {
			$this->admins = $this->wikiService->getWikiAdmins();
		}

		return $this->admins;
	}

	/**
	 * Check if a user is an admin
	 *
	 * @param int $userId
	 * @param array $admins
	 * @return bool
	 */
	public function isAdmin( $userId, $admins ) {
		return in_array( $userId, $admins );
	}

	/**
	 * Get the user id and contribution count of the top n contributors to the current wiki,
	 * optionally filtered by admins only
	 *
	 * @param int|NULL $limit Number of rows to fetch
	 * @param string $weekly True for weekly top contributors, false for all members (2 years)
	 * @param bool $onlyAdmins Whether to filter by admins
	 * @return Mixed|null
	 */
	public function getTopContributors( $limit = 10, $weekly = true, $onlyAdmins = false ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY, $limit, $weekly, $onlyAdmins ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit, $weekly, $onlyAdmins ) {
				global $wgExternalSharedDB, $wgDBcluster;
				$db = wfGetDB( DB_SLAVE );
				$adminFilter = '';
				if ( $onlyAdmins ) {
					$adminFilter = ' AND (ug_group = "sysop")';
				}

				if ( $weekly ) {
					// From last Sunday (matches wikia_user_properties)
					$dateFilter = 'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))';
				} else {
					$dateFilter = 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_name, user_id, ug_group, count(rev_id) AS revision_count' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( $wgExternalSharedDB . '_' . $wgDBcluster . '.user' )->ON( '(rev_user <> 0) AND (user_id = rev_user)' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'user_id' )->IS_NOT_NULL()
					->AND_( $dateFilter )
					->AND_( '(ug_group IS NULL or (ug_group <> "bot"))' . $adminFilter )
					// TODO: also filter by global bot user ids?
					->GROUP_BY( 'user_name' )
					->ORDER_BY( 'revision_count DESC, user_name' );

				if ( $limit ) {
					$sqlData->LIMIT( $limit );
				}

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->user_id,
						'userName' => $row->user_name,
						'contributions' => $row->revision_count,
						'isAdmin' => $this->isAdmin( $row->user_id, $this->getAdmins() ),
					];
				} );

				return $result;
			}
		);
		return $data;
	}

	public function getGlobalBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::GLOBAL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_id' )
					->FROM ( 'user' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'ug_group' )->EQUAL_TO( 'bot-global' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData[] = $row->user_id;
					} );

				return $sqlData;
			}
		);

		return $botIds;
	}

	public function filterGlobalBots( array $users ) {
		$botIds = $this->getGlobalBotIds();

		return array_filter( $users, function ( $user ) use ( $botIds ) {
			$userIdIsBot = in_array( $user['userId'], $botIds );
			$userIsWikia = strtolower( $user['userName'] ) === 'wikia';

			return !$userIdIsBot && !$userIsWikia;
		} );
	}

	/**
	 * Get all contributions for a user, limited by most recent n days if $days is not null
	 *
	 * @param User $user
	 * @param weekly If true get user's contributions current week. Otherwise for entire membership period (2 years)
	 * @return int Number of contributions
	 */
	public function getUserContributions( User $user, $weekly = true ) {
		$userId = $user->getId();

		$revisionCount = WikiaDataAccess::cache(
			// TODO: Should purge this when user edits
			wfMemcKey( self::CURR_USER_CONTRIBUTIONS_MCACHE_KEY, $userId, $weekly ),
			WikiaResponse::CACHE_VERY_SHORT, // short cache b/c it's for the current user's info
			function () use ( $userId, $weekly ) {
				$db = wfGetDB( DB_SLAVE );

				if ( $weekly ) {
					// From last Sunday (matches wikia_user_properties)
					$dateFilter = 'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))';
				} else {
					$dateFilter = 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'count(rev_id) AS revision_count' )
					->FROM( 'revision' )
					->WHERE( 'rev_user' )->EQUAL_TO( $userId )
					->AND_( $dateFilter )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData = $row->revision_count;
					} );

				return $sqlData;
			}
		);

		return $revisionCount;
	}

	/**
	 * Get a list of users in order of their edit count in the last n days or all time if null
	 *
	 * @param int|null $limit Total number of Admins to get or get all if null
	 * @param int|null $days Count only contributions in the last n days or all if null
	 */
	public function getTopUsers( $limit = null, $days = null ) {

	}

	/**
	 * Utility function used to filter out users that should not show up on the member's list
	 * @param $user
	 * @return bool
	 */
	private function showMember( $user ) {
		if ( $user->isAnon() ) {
			return false;
		} elseif ( $user->isBlocked() ) {
			return false;
		} elseif ( in_array( $user->getId(), self::getGlobalBotIds() ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Get a list of users who have made their first edits in the last n days
	 *
	 * @param int $limit
	 * @return array
	 */
	public function getRecentlyJoinedUsers( $limit = 14 ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::RECENTLY_JOINED_MCACHE_KEY, $limit ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit ) {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( 'wup_value > DATE_SUB(now(), INTERVAL 14 DAY)' )
					->ORDER_BY( 'wup_value DESC' )
					->LIMIT( $limit )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$user = User::newFromId( $row->wup_user );
						$userName = $user->getName();

						if ( $this->showMember( $user ) ) {
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$sqlData[] = [
								'userId' => $row->wup_user,
								'oldestRevision' => $row->wup_value,
								'contributions' => 0, // $row->contributions,
								'userName' => $userName,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}
					} );

				return $sqlData;
			}
		);

		return $data;
	}

	/**
	 * Gets a list of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @return array
	 */
	public function getAllMembers() {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_MEMBERS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( 'wup_value > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->ORDER_BY( 'wup_value DESC' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$user = User::newFromId( $row->wup_user );
						$userName = $user->getName();

						if ( $this->showMember( $user ) ) {
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );
							$dateString = strftime( '%b %e, %Y', strtotime( $row->wup_value ) );

							$sqlData[] = [
								'userId' => $row->wup_user,
								'oldestRevision' => $row->wup_value,
								'joinDate' => $dateString,
								'userName' => $userName,
								'isAdmin' => $this->isAdmin( $row->wup_user, $this->getAdmins() ),
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}
					} );

				return $sqlData;
			}
		);

		return $data;
	}

	/**
	 * Gets a count of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @return integer
	 */
	public function getMemberCount() {
		// fixme: Rewrite modal logic so that this function is not needed, and use getAllMembers only
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::MEMBER_COUNT_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'COUNT(*) AS user_count' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( 'wup_value > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->ORDER_BY( 'wup_value DESC' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData = $row->user_count;
					} );

				return $sqlData;
			}
		);

		return $data;
	}
}
