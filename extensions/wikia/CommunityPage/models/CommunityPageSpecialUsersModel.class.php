<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_BOTS_MCACHE_KEY = 'community_page_all_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const MEMBER_COUNT_MCACHE_KEY = 'community_member_count';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';
	const CURR_USER_CONTRIBUTIONS_MCACHE_KEY = 'community_page_current_user_contributions';

	const ALL_CONTRIBUTORS_MODAL_LIMIT = 50;

	private $wikiService;
	private $admins;

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	public function getAdmins() {
		if ( $this->admins === null ) {
			$this->admins = $this->wikiService->getWikiAdminIds( 0, false, false, null, false );
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
	 * @param boolean $weekly True for weekly top contributors, false for all members (2 years)
	 * @param bool $onlyAdmins Whether to filter by admins
	 * @return array|null
	 */
	public function getTopContributors( $limit = 10, $weekly = true, $onlyAdmins = false ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY, $limit, $weekly, $onlyAdmins ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit, $weekly, $onlyAdmins ) {
				$db = wfGetDB( DB_SLAVE );

				$botIds = $this->getBotIds();

				if ( $weekly ) {
					// From last Sunday (matches wikia_user_properties)
					$dateFilter = 'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))';
				} else {
					$dateFilter = 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user_text, rev_user, count(rev_id) AS revision_count' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->WHERE( 'rev_user' )->NOT_EQUAL_TO( 0 );

				if ( $onlyAdmins ) {
					$adminIds = $this->getAdmins();
					$sqlData
						->AND_( 'rev_user' )->IN( $adminIds );
				}

				$sqlData
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->AND_( $dateFilter )
					->GROUP_BY( 'rev_user_text' )
					->ORDER_BY( 'revision_count DESC, rev_user_text' );

				if ( $limit ) {
					$sqlData->LIMIT( $limit );
				}

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->rev_user,
						'userName' => $row->rev_user_text,
						'contributions' => $row->revision_count,
						'isAdmin' => $this->isAdmin( $row->rev_user, $this->getAdmins() ),
					];
				} );

				return $result;
			}
		);
		return $data;
	}

	/**
	 * @return array|null
	 */
	private function getGlobalBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::GLOBAL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_LONG,
			function () {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->IN( [ 'bot', 'bot-global' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData[] = $row->ug_user;
					} );

				return $sqlData;
			}
		);

		return $botIds;
	}

	private function getBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$localBots = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->IN( [ 'bot', 'bot-global' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $db, function ( &$localBots, $row ) {
						$localBots[] = $row->ug_user;
					} );

				$allBots = array_merge( $localBots, $this->getGlobalBotIds() );

				return $allBots;
			}
		);

		return $botIds;
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
	 * Utility function used to filter out users that should not show up on the member's list
	 * @param User $user
	 * @return bool
	 */
	private function showMember( User $user ) {
		return !( $user->isAnon() || $user->isBlocked() || in_array( $user->getId(), $this->getBotIds() ) );
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

	private function addCurrentUserIfContributor( $allContributorsData, $currentUserId ) {
		global $wgCityId;

		$key = array_search( $currentUserId, array_column( $allContributorsData, 'userId' ) );

		if ( $key !== false ) {
			$data = $allContributorsData[$key];
			$data['isCurrent'] = true;
			unset( $allContributorsData[$key] );
			array_unshift( $allContributorsData, $data );
		} else {
			// Get current user's stats
			$userInfo = $this->wikiService->getUserInfo(
				$currentUserId,
				$wgCityId,
				AvatarService::AVATAR_SIZE_SMALL_PLUS
			);

			if ( $userInfo['lastRevision'] !== null ) {
				// Add current user on top of list
				$avatar = AvatarService::renderAvatar( $userInfo['name'], AvatarService::AVATAR_SIZE_SMALL_PLUS );

				$data = [
					'userId' => $currentUserId,
					'latestRevision' => $userInfo['lastRevision'],
					'timeAgo' => wfTimeFormatAgo( $userInfo['lastRevision'] ),
					'userName' => $userInfo['name'],
					'isAdmin' => $this->isAdmin( $currentUserId, $this->getAdmins() ),
					'isCurrent' => true,
					'avatar' => $avatar,
					'profilePage' => $userInfo['userPageUrl'],
				];

				array_unshift( $allContributorsData, $data );
			}
		}

		return $allContributorsData;
	}

	/**
	 * Gets a list of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @param int $currentUserId
	 * @return Mixed|null
	 */
	public function getAllContributors( $currentUserId = 0 ) {
		$allContributorsData = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_MEMBERS_MCACHE_KEY ),
			WikiaResponse::CACHE_SHORT,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$userSqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user, rev_timestamp' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'rev_timestamp DESC' )
					->LIMIT( self::ALL_CONTRIBUTORS_MODAL_LIMIT )
					->runLoop( $db, function ( &$userSqlData, $row ) {
						$userId = (int) $row->rev_user;
						$user = User::newFromId( $userId );

						if ( $this->showMember( $user ) ) {
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$data = [
								'userId' => $userId,
								'latestRevision' => $row->rev_timestamp,
								'timeAgo' => wfTimeFormatAgo( $row->rev_timestamp ),
								'userName' => $userName,
								'isAdmin' => $this->isAdmin( $userId, $this->getAdmins() ),
								'isCurrent' => false,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];

							$userSqlData[] = $data;
						}
					} );

				return $userSqlData;
			}
		);

		return $this->addCurrentUserIfContributor( $allContributorsData, $currentUserId );
	}

	/**
	 * Gets a count of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @return integer
	 */
	public function getMemberCount() {
		$allContributorsCount = WikiaDataAccess::cache(
			wfMemcKey( self::MEMBER_COUNT_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlCount = ( new WikiaSQL() )
					->SELECT( 'COUNT( DISTINCT rev_user )' )
					->AS_( 'all_contributors_count' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->runLoop( $db, function ( &$sqlCount, $row ) {
						$sqlCount = $row->all_contributors_count;
					} );

				return $sqlCount;
			}
		);

		return $allContributorsCount;
	}
}
