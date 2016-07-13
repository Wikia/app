<?php

use Wikia\Logger\WikiaLogger;

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const ALL_ADMINS_MCACHE_KEY = 'community_page_all_admins';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_BOTS_MCACHE_KEY = 'community_page_all_bots';
	const ALL_BLACKLISTED_IDS_MCACHE_KEY = 'community_page_all_blacklisted_ids';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const ALL_MEMBERS_COUNT_MCACHE_KEY = 'community_page_all_members_count';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';
	const MCACHE_VERSION = '1.2';

	const ALL_CONTRIBUTORS_MODAL_LIMIT = 50;

	private $wikiService;
	private $user;
	private $admins;

	public function __construct( User $user = null ) {
		$this->user = $user;
		$this->wikiService = new WikiService();
	}

	/**
	 * Returns list of User IDs that are admins
	 * @return array of User IDs
	 */
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
	 * Get the user id and this week contribution count of all users contributed to this wiki whis week;
	 * Bots filtered out;
	 * Ordered from most to least active;
	 *
	 * @return array|null
	 */
	public function getTopContributors() {
		$data = WikiaDataAccess::cache(
			self::getMemcKey( self::TOP_CONTRIB_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				self::logUserModelPerformanceData( 'query', 'top_contributors' );

				$db = wfGetDB( DB_SLAVE );

				$blacklistedIds = $this->getBlacklistedIds();

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'wup_user, wup_value' )
					->FROM ( 'wikia_user_properties' )
					->WHERE( 'wup_property' )->EQUAL_TO( 'editcountThisWeek' )
					->AND_( 'wup_user' )->NOT_IN( $blacklistedIds )
					->AND_( 'wup_value' )->GREATER_THAN( 0 )
					->ORDER_BY( 'CAST(wup_value as unsigned) DESC, wup_user ASC' );

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->wup_user,
						'contributions' => $row->wup_value,
						'isAdmin' => $this->isAdmin( $row->wup_user, $this->getAdmins() ),
					];
				} );
				
				$us = new UserStatsService(1853435);
				$us2 = new UserStatsService(28325524);
				var_dump($us->getStats());
				var_dump($us2->getStats());
				var_dump($result);
				var_dump($blacklistedIds);
				if(in_array(1853435,$blacklistedIds))
					echo "IT'S HERE!";
				exit();

				return $result;
			}
		);
		self::logUserModelPerformanceData(
			'view',
			'top_contributors',
			$this->isUserOnList( $data ),
			$this->isUserLoggedIn()
		);
		return $data;
	}
	/**
	 * Get all admins who have contributed in the last two years ordered by number of contributions
	 * filter out bots
	 *
	 * @return array|null
	 */
	public function getAllAdmins() {
		$data = WikiaDataAccess::cache(
			self::getMemcKey( self::ALL_ADMINS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				self::logUserModelPerformanceData( 'query', 'all_admins' );

				$db = wfGetDB( DB_SLAVE );

				$adminIds = $this->getAdmins();

				if ( !$adminIds ) {
					return [];
				}

				$botIds = $this->getBotIds();
				$dateTwoYearsAgo = date( 'Y-m-d', strtotime( '-2 years' ) );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user_text, rev_user, wup_value' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( 'wikia_user_properties' )
					->ON( 'rev_user', 'wup_user' )
					->WHERE( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'rev_user' )->IN( $adminIds )
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->AND_( 'rev_timestamp' )->GREATER_THAN( $dateTwoYearsAgo )
					->AND_( 'wup_property' )->EQUAL_TO( 'editcount' )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'CAST(wup_value as unsigned) DESC, rev_user_text' );

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->rev_user,
						'contributions' => (int)$row->wup_value,
						'isAdmin' => true,
					];
				} );

				return $result;
			}
		);
		self::logUserModelPerformanceData( 'view', 'all_admins', $this->isUserOnList( $data ), $this->isUserLoggedIn() );
		return $data;
	}

	/**
	 * @return array|null
	 */
	private function getGlobalBotIds() {
		$botIds = WikiaDataAccess::cache(
			self::getMemcKey( self::GLOBAL_BOTS_MCACHE_KEY ),
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
			self::getMemcKey( self::ALL_BOTS_MCACHE_KEY ),
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
	 * @return array list of blacklisted ids for Top Contributors
	 */
	private function getBlacklistedIds() {
		$blacklistedIds = WikiaDataAccess::cache(
			self::getMemcKey( self::ALL_BLACKLISTED_IDS_MCACHE_KEY ),
			WikiaResponse::CACHE_LONG,
			function () {
				global $wgExternalSharedDB;
				$globalDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

				$globalIds = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->IN( [ 'bot', 'bot-global', 'staff', 'util', 'helper', 'vstf' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $globalDb, function ( &$globalIds, $row ) {
						$globalIds[] = $row->ug_user;
					} );

				$localDb = wfGetDB( DB_SLAVE );

				$localUsers = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->NOT_IN( [ 'bot' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $localDb, function ( &$localUsers, $row ) {
						$localUsers[] = $row->ug_user;
					} );


				$allBlacklistedIds = array_merge( array_diff( $globalIds, $localUsers ), $this->getBotIds() );

				return $allBlacklistedIds;
			}
		);

		return $blacklistedIds;
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
			self::getMemcKey( [ self::RECENTLY_JOINED_MCACHE_KEY, $limit ] ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit ) {
				self::logUserModelPerformanceData( 'query', 'recently_joined' );

				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM( 'wikia_user_properties' )
					->WHERE( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_( 'wup_value > DATE_SUB(now(), INTERVAL 14 DAY)' )
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

		self::logUserModelPerformanceData(
			'view',
			'recently_joined',
			$this->isUserOnList( $data ),
			$this->isUserLoggedIn()
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
	 * Gets a list of 50 members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @param int $currentUserId
	 * @return Mixed|null
	 */
	public function getAllContributors( $currentUserId = 0 ) {
		$allContributorsData = WikiaDataAccess::cache(
			self::getMemcKey( self::ALL_MEMBERS_MCACHE_KEY ),
			WikiaResponse::CACHE_SHORT,
			function () {
				self::logUserModelPerformanceData( 'query', 'all_contributors' );

				$db = wfGetDB( DB_SLAVE );
				$usersData = [];

				$botIds = $this->getBotIds();
				$dateTwoYearsAgo = date( 'Y-m-d', strtotime( '-2 years' ) );

				$result = ( new WikiaSQL() )
					->SELECT( 'wup_user', 'wup_value' )
					->FROM( 'wikia_user_properties' )
					->WHERE( 'wup_property' )->EQUAL_TO( 'lastContributionTimestamp' )
					->AND_( 'CAST(wup_value as date)' )->GREATER_THAN( $dateTwoYearsAgo )
					->AND_( 'wup_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'wup_user' )->NOT_IN( $botIds )
					->ORDER_BY( 'wup_value DESC' )
					->LIMIT( self::ALL_CONTRIBUTORS_MODAL_LIMIT )
					->run( $db );

				$numberOfUsers = $db->numRows( $result );

				if ( $numberOfUsers == self::ALL_CONTRIBUTORS_MODAL_LIMIT ) {
					while ( $user = $result->fetchObject() ) {
						$userData = $this->prepareUserData( (int)$user->wup_user, $user->wup_value );
						if ( !empty( $userData ) ) {
							$usersData[] = $userData;
						}
					}

					return $usersData;
				}

				$usersData = ( new WikiaSQL() )
					->SELECT( 'rev_user, MAX(rev_timestamp) as last_revision' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp' )->GREATER_THAN( $dateTwoYearsAgo )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'last_revision DESC' )
					->LIMIT( self::ALL_CONTRIBUTORS_MODAL_LIMIT )
					->runLoop( $db, function ( &$usersData, $row ) {
						$userData = $this->prepareUserData( (int)$row->rev_user, $row->last_revision );

						if ( !empty( $userData ) ) {
							$usersData[] = $userData;
						}
					} );

				if ( $numberOfUsers !== count( $usersData ) ) {
					WikiaLogger::instance()->info( 'Community Page User Model All Contributors difference' );
				}

				return $usersData;
			}
		);

		self::logUserModelPerformanceData(
			'view',
			'all_contributors',
			$this->isUserOnList( $allContributorsData ),
			$this->isUserLoggedIn()
		);

		return $this->addCurrentUserIfContributor( $allContributorsData, $currentUserId );
	}

	private function prepareUserData( $userId, $lastRevision ) {
		$user = User::newFromId( $userId );

		if ( !$user->isBlocked() ) {
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

			if ( User::isIp( $userName ) ) {
				$userName = wfMessage( 'oasis-anon-user' )->plain();
			}

			return [
				'userId' => $userId,
				'latestRevision' => $lastRevision,
				'userName' => $userName,
				'isAdmin' => $this->isAdmin( $userId, $this->getAdmins() ),
				'isCurrent' => false,
				'avatar' => $avatar,
				'profilePage' => $user->getUserPage()->getLocalURL(),
			];
		}

		return [];
	}

	/**
	 * Gets a count of all members of the community.
	 *
	 * @return integer
	 */
	public function getMemberCount() {
		$numberOfMembers = WikiaDataAccess::cache(
			self::getMemcKey( self::ALL_MEMBERS_COUNT_MCACHE_KEY ),
			WikiaResponse::CACHE_SHORT,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$botIds = $this->getBotIds();

				$numberOfMembers = ( new WikiaSQL() )
					->SELECT()
					->COUNT( 'DISTINCT rev_user' )->AS_( 'members_count' )
					->FROM( 'revision' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->runLoop( $db, function ( &$numberOfMembers, $row ) {
						$numberOfMembers = (int)$row->members_count;
					} );

				return $numberOfMembers;
			}
		);

		return $numberOfMembers;
	}

	public static function logUserModelPerformanceData( $action, $method, $userOnList = '', $userLoggedIn = '' ) {
		WikiaLogger::instance()->info(
			'Community Page User Model',
			[
				'cp_action' => $action,
				'cp_method' => $method,
				'cp_user_on_list' => $userOnList,
				'cp_user_logged_in' => $userLoggedIn
			]
		);
	}

	private function isUserOnList( $data ) {
		if ( $this->user instanceof User ) {
			$key = array_search( $this->user->getId(), array_column( $data, 'userId' ) );
			if ( $key ) {
				return true;
			}

			return false;
		}

		return '';
	}

	private function isUserLoggedIn() {
		if ( $this->user instanceof User ) {
			return $this->user->isLoggedIn();
		}

		return false;
	}

	public static function getMemcKey( $params ) {
		if ( is_array( $params ) ) {
			$params = implode( ':', $params );
		}
		return wfMemcKey( $params, self::MCACHE_VERSION );
	}
}
