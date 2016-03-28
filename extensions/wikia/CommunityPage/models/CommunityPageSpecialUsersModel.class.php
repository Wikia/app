<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const TOP_CONTRIB_DETAILS_MCACHE_KEY = 'community_page_top_contrib_details'; // todo not used
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';

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
