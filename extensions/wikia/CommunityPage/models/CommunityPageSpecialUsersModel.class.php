<?php

//SELECT  user_name,user_id, count(rev_id) AS revision_count, ug_user, ug_group
//FROM `revision`
//FORCE INDEX (user_timestamp)
//  INNER JOIN `page` ON ((page_id = rev_page))
//  LEFT JOIN `wikicities`.`user` ON ((rev_user != 0) AND (user_id = rev_user))
//  LEFT JOIN `wikicities`.`user_groups` ON (user_id = ug_user)
//  LEFT JOIN `tag_summary` ON ((ts_rev_id=rev_id))
//WHERE user_id != 'NULL' AND rev_timestamp > '20151001000000' AND (ug_group IS NULL or (ug_group !='bot' AND ug_group !='bot-global'))
//GROUP BY user_name
//ORDER BY revision_count DESC
//LIMIT 5 \G;


class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib12471fsgsadf';
	const TOP_CONTRIB_DETAILS_MCACHE_KEY = 'community_page_top_contrib_details'; // todo not used
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';

	private $wikiService;

	private function getWikiService() {
		return $this->wikiService;
	}

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	/**
	 * Get the date a user made their first edit to a wiki
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
					->LIMIT( 1 )
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

		return $data;
	}

	/**
	 * Get the user id and contribution count of the top n contributors to the current wiki
	 *
	 * @param int $limit
	 * @return Mixed|null
	 */
	public static function getTopContributors( $limit = 10 ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY ),
			0, // WikiaResponse::CACHE_STANDARD,
			function () use ( $limit ) {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE );
				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_name, user_id, count(rev_id) AS revision_count' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( $wgExternalSharedDB . '.user')->ON( '(rev_user <> 0) AND (user_id = rev_user)' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'user_id' )->IS_NOT_NULL()
//					->AND_( 'rev_timestamp' )->GREATER_THAN( 'DATE_SUB(now(), INTERVAL 7 DAY)' )
					->AND_( 'rev_timestamp > DATE_SUB(now(), INTERVAL 1 DAY)' )
					->AND_( 'ug_group IS NULL or (ug_group <> "bot")')
					->GROUP_BY( 'user_name' )
					->ORDER_BY( 'revision_count' )->DESC()
					->LIMIT( $limit )
					->__toString();
//					->run( $db, function ( ResultWrapper $result ) {
//						$out = [];
//						while ( $row = $result->fetchRow() ) {
//							$out[] = [
//								'userId' => $row['user_id'],
//								'userName' => $row['user_name'],
//								'contributions' => $row['revision_count']
//							];
//						}
//						return $out;
//					} );
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
			return !in_array( $user['userId'], $botIds );
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
	 * @param int|null $days
	 * @return int Number of contributions
	 */
	public function getUserContributions( User $user, $days = null ) {

		return 100;
	}

	/**
	 * Get a list of admins in order of their edit count in the last n days or all time if null
	 *
	 * @param int|null $limit Total number of Admins to get or get all if null
	 * @param int|null $days Count only contributions in the last n days or all if null
	 * @return array Array of admin data
	 */
	public function getTopAdmins( $limit = null, $days = null ) {
		return [
			'id' => 1
		];
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
		return [];
	}
}
