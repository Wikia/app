<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';

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
					->SELECT( 'rev_timestamp' )
					->FROM ( 'revision' )
					->WHERE ( 'rev_user' )->EQUAL_TO( $user->getID() )
					->AND_ ( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->ORDER_BY( 'rev_timestamp' )
					->GROUP_BY( 'rev_user' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$out[] = [
								'rev_timestamp' => $row['rev_timestamp']
							];
						}

						return $out;
					} );

				return $sqlData;
			}
		);

		if (count( $data ) > 0) {
			return $data[0]['rev_timestamp'];
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

	public static function filterGlobalBots( array $users ) {
		$botIds = self::getGlobalBotIds();

		return array_filter( $users, function ( $user ) use ( $botIds ) {
			$userIdIsBot = in_array( $user['userId'], $botIds );
			$userIsWikia = strtolower( $user['userName'] ) === 'wikia';

			return !$userIdIsBot && !$userIsWikia;
		} );
	}

	/** Get all members for the community, with the date of their oldest edit in the last 2 years and the number
	 * of contributions
	 * Membership is defined as the user having made an edit within the last 2 years
	 * @return Mixed|null
	 */
	public function getAllMembers() {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_MEMBERS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'DISTINCT rev_user, rev_timestamp, count(rev_user) AS contributions' )
					->FROM ( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'rev_timestamp' )
					->run( $db, function ( ResultWrapper $result ) {
						$out = [];
						while ( $row = $result->fetchRow() ) {
							$user = User::newFromId( $row['rev_user'] );
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );

							$out[] = [
								'userId' => $row['rev_user'],
								'oldestRevision' => $row['rev_timestamp'],
								'contributions' => $row['contributions'],
								'userName' => $userName,
								'avatar' => $avatar,
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
	 * @param int|null $days
	 * @return int Number of contributions
	 */
	public function getUserContributions( User $user, $days = null ) {

		return 100;
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
	public function getRecentlyJoinedUsers( $days = 14 ) {
		$out = [];
		$allMembers = $this->getAllMembers();

		foreach ($allMembers as $member) {
			if (strtotime($member['oldestRevision']) > strtotime("-$days days")) {
				$out[] = $member;
			}
		}

		return $out;
	}

	public function getRecentActivityData() {
		$app = F::app();
		$data = $app->sendRequest('LatestActivityController', executeIndex)->getData();
		$recentActivity = [];

		foreach ($data['changeList'] as $activity) {
			$recentActivity[] = [
				'timeAgo' => $activity['time_ago'],
				'userAvatar' => AvatarService::renderAvatar(
					$activity['user_name'],
					AvatarService::AVATAR_SIZE_SMALL_PLUS ),
				'changeMessage' => $activity['changemessage'],
				'editedPageTitle' => $activity['page_title'],
			];
		}

		return [
			'activityHeading' => $data['moduleHeader'],
			'moreActivityLink' => Wikia::specialPageLink( 'WikiActivity', 'oasis-more', 'more-activity' ),
			'activity' => $recentActivity,
		];
	}
}
