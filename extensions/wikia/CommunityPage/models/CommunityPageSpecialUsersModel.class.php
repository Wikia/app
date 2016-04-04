<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';
	const CURR_USER_CONTRIBUTIONS_MCACHE_KEY = 'community_page_current_user_contributions';

	private $wikiService;

	private function getWikiService() {
		return $this->wikiService;
	}

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	/**
	 * Get the date a member made their first edit to a wiki.
	 * Membership is defined as having edited in the last two years
	 *
	 * @param User $user
	 * @return Mixed|null
	 */
	public function getFirstRevisionDate( User $user ) {
		if ( $user->isAnon() ) {
			return null;
		}

		$data = WikiaDataAccess::cache(
			wfMemcKey( self::FIRST_REV_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () use ($user) {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( 'wup_user' )->EQUAL_TO( $user->getID() )
					->AND_ ( 'wup_value > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->ORDER_BY( 'wup_value DESC' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$out[] = [
								'wup_value' => $row['wup_value']
							];
						}

						return $out;
					} );

				return $sqlData;
			}
		);

		if (count( $data ) > 0) {
			return $data[0]['wup_value'];
		} else {
			return null;
		}
	}

	/**
	 * Get the user id and contribution count of the top n contributors to the current wiki,
	 * optionally filtered by admins only
	 *
	 * @param int $limit Number of rows to fetch
	 * @param string $interval Time interval for DATE_SUB()
	 * @param bool $onlyAdmins Whether to filter by admins
	 * @return Mixed|null
	 */
	public static function getTopContributors( $limit = 10, $interval = '1 WEEK', $onlyAdmins = false ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY, $limit, $interval, $onlyAdmins ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit, $interval, $onlyAdmins ) {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE );
				$adminFilter = '';
				if ( $onlyAdmins ) {
					$adminFilter = ' AND (ug_group = "sysop")';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_name, user_id, count(rev_id) AS revision_count' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( $wgExternalSharedDB . '.user')->ON( '(rev_user <> 0) AND (user_id = rev_user)' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'user_id' )->IS_NOT_NULL()
					->AND_( 'rev_timestamp > DATE_SUB(now(), INTERVAL '. $interval . ')' )
					->AND_( '(ug_group IS NULL or (ug_group <> "bot"))' . $adminFilter)
					// TOOD: also filter by glboal bot user ids?
					->GROUP_BY( 'user_name' )
					->ORDER_BY( 'revision_count' )->DESC()
					->LIMIT( $limit )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$out[] = [
								'userId' => $row['user_id'],
								'userName' => $row['user_name'],
								'contributions' => $row['revision_count']
							];
						}
						return $out;
					} );
				return $sqlData;
			}
		);
		return $data;
	}

	public static function getGlobalBotIds() {
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
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$out[] = $row['user_id'];
						}
						return $out;
					} );
				return $sqlData;
			}
		);
		return $botIds;
	}

	// todo: I think we can do this in the initial query
	public static function filterGlobalBots( array $users ) {
		$botIds = self::getGlobalBotIds();

		return array_filter( $users, function ( $user ) use ( $botIds ) {
			$userIdIsBot = in_array( $user['userId'], $botIds );
			$userIsWikia = strtolower( $user['userName'] ) === 'wikia';

			return !$userIdIsBot && !$userIsWikia;
		} );
	}

	/**
	 * @param User $user
	 * @param int|null $days Get ranking by number of edits made in the last n days or all time if null
	 * @return array
	 */
	public function getUserRanking( User $user, $days = null ) {

		return [
			'userRank' => 2,
			'totalUsers' => 100
		];
	}

	/**
	 * Get all contributions for a user, limited by most recent n days if $days is not null
	 *
	 * @param User $user
	 * @param string $interval Time interval for DATE_SUB()
	 * @return int Number of contributions
	 */
	public function getUserContributions( User $user, $interval = '2 WEEK' ) {
		$userId = $user->getId();

		$revisionCount = WikiaDataAccess::cache(
			// TODO: Should purge this when user edits
			wfMemcKey( self::CURR_USER_CONTRIBUTIONS_MCACHE_KEY, $userId, $interval ),
			WikiaResponse::CACHE_VERY_SHORT, // short cache b/c it's for the current user's info
			function () use ( $userId, $interval ) {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'count(rev_id) AS revision_count' )
					->FROM( 'revision' )
					->WHERE('rev_user')->EQUAL_TO( $userId )
					->AND_( 'rev_timestamp > DATE_SUB(now(), INTERVAL ' . $interval . ')' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = 0;
						while ( $row = $result->fetchRow() ) {
							$out = $row['revision_count'];
						}

						return $out;
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
	 * Get a list of users who have made their first edits in the last n days
	 *
	 * @param int $days
	 * @return array
	 */
	public function getRecentlyJoinedUsers() {
		$data = WikiaDataAccess::cache(
			wfMemcKey( key ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( "wup_value > DATE_SUB(now(), INTERVAL 14 DAY)" )
					->ORDER_BY( 'wup_value DESC' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];

						while ( $row = $result->fetchRow() ) {
							$user = User::newFromId( $row['wup_user'] );
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$out[] = [
								'userId' => $row['wup_user'],
								'oldestRevision' => $row['wup_value'],
								'contributions' => 0, // $row['contributions'],
								'userName' => $userName,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}

						return $out;
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
			WikiaResponse::CACHE_DISABLED,
			function ()  {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( "wup_value > DATE_SUB(now(), INTERVAL 2 YEAR)" )
					->ORDER_BY( 'wup_value DESC' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];

						while ( $row = $result->fetchRow() ) {
							$user = User::newFromId( $row['wup_user'] );
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );
							$datestr = strftime( '%b %e, %Y', strtotime( $row['wup_value'] ) );

							$out[] = [
								'userId' => $row['wup_user'],
								'oldestRevision' => $row['wup_value'],
								'joinDate' => $datestr,
								'userName' => $userName,
								'isAdmin' => true, // FIXME: need to check if the user is admin of this
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}

						return $out;
					} );

				return $sqlData;
			}
		);

		return $data;

	}
}
