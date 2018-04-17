<?php

class AchRankingService {
	private $mRecentAwardedUsers;

	function __construct() {
		$this->mRecentAwardedUsers = null;
	}

	static public function getRankingCacheKey( int $limit ) {
		$params = array( 'Achievements', 'Ranking', 'default' );

		if ( !empty( $limit ) ) {
			$params[] = "limit{$limit}";
		}

		return call_user_func_array( 'wfMemcKey', $params );
	}

	public function getUsersRanking( int $limit = 1000 ) {
		wfProfileIn(__METHOD__);

		global $wgMemc;
		$cacheKey = self::getRankingCacheKey( $limit );
		$ranking = $wgMemc->get( $cacheKey );

		// We do not flush cache when condition changed. See MAIN-5571
		if( empty( $ranking ) ) {
			$ranking = array();
			$rules = array('ORDER BY' => 'score desc');

			if($limit > 0)
				$rules['LIMIT'] = $limit * 2;//bots and blocked users are filtered after the query has been run, let's admit that ratio is 2:1

			$where = array();
			$dbr = wfGetDB(DB_SLAVE);

			$res = $dbr->select('ach_user_score', 'user_id, score', $where, __METHOD__, $rules);
			$position = 0;
			$counter = 1;
			$prevScore = -1;

			while ( $row = $dbr->fetchObject( $res ) ) {
				$user = User::newFromId($row->user_id);

				if ( $user && AchAwardingService::canEarnBadges( $user ) ) {
					// If this user has the same score as previous user, give them the same (lower) rank (RT#67874).
					if ( $prevScore != $row->score ) {
						$position = $counter;
					}

					$ranking[] = new AchRankedUser( $user, $row->score, $position );

					$counter++;
					$prevScore = $row->score;
				}

				if ( $limit > 0 && $counter == $limit ) break;
			}

			$dbr->freeResult($res);

			$wgMemc->set($cacheKey, $ranking, 86400 /* 24h */ );
		}

		wfProfileOut(__METHOD__);

		return $ranking;
	}

	public function getUserScore($user_id) {
		if ( empty( $user_id ) ) return 0;

		$user = User::newFromId( $user_id );
		$score = false;

		if ( $user && AchAwardingService::canEarnBadges( $user ) ) {
			$where = array('user_id' => $user_id);
			$dbr = wfGetDB(DB_SLAVE);
			$score = $dbr->selectField('ach_user_score', 'score', $where, __METHOD__);
		}

		// if no score found return zero
		return $score ? $score : 0;
	}

	public function getUserRankingPosition( User $user ) {
		if($user) {
			$ranking = $this->getUsersRanking();

			foreach($ranking as $position => $rankedUser) {
				if($rankedUser->getId() == $user->getId()) return $rankedUser->getCurrentRanking();
			}

			return count($ranking) + 1;
		}
		else
			return false;
	}

	/**
	* Returns the list of recently awarded badges for the current wiki and specified level
	*
	* @param $badgeLevel - the level of the badges to list
	* @param $limit - limit the list to the specified amount of items Integer
	* @param $daySpan - a span of days to subtract to the current date Integer
	* @param $blackList - a list of the badge type IDs to exclude from the result Array
	* @return Array
	*/
	public function getRecentAwardedBadges($badgeLevel = null, $limit = null, $daySpan = null, $blackList = null) {
		wfProfileIn(__METHOD__);

		$badges = array();

		$conds = array();
		$dbr = wfGetDB(DB_SLAVE);
		$rules = array('ORDER BY' => 'date DESC, badge_lap DESC');

		if($badgeLevel != null)
			$conds['badge_level'] = $badgeLevel;

		if($daySpan != null)
			$conds[] = "date >= (CURDATE() - INTERVAL {$daySpan} DAY)";

		if(is_array($blackList))
			$conds[] = 'badge_type_id NOT IN (' . implode($blackList) . ')';

		if($limit != null)
			$rules['LIMIT'] = $limit * 2; //bots and blocked users are filtered after the query hs been run, let's admit that ratio is 2:1

		$res = $dbr->select('ach_user_badges', 'user_id, badge_type_id, badge_lap, badge_level, date', $conds, __METHOD__, $rules);

		while(($row = $dbr->fetchObject($res)) && (count($badges) <= $limit)) {
			$user = User::newFromId($row->user_id);

			if ( $user && AchAwardingService::canEarnBadges( $user ) ) {
				$badges[] = [
					'user' => $this->getUsernameAndProfileUrl( $user ),
					'badge' => new AchBadge( $row->badge_type_id, $row->badge_lap, $row->badge_level ),
					'date' => $row->date
				];
			}
		}

		$dbr->freeResult($res);

		wfProfileOut(__METHOD__);

		return $badges;
	}

	/**
	 * Get the user's profileUrl and username.
	 *
	 * Previously we were passing the entire user object, but
	 * that was exposing private user data. See MAIN-9412.
	 */
	private function getUsernameAndProfileUrl( User $user ) : array {
		return [
			'profileUrl' => $user->getUserPage()->getLocalURL(),
			'userName' => $user->getName()
		];
	}
}
