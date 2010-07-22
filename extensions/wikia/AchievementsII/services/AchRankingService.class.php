<?php

class AchRankingService {
	private $mRecentAwardedUsers;

	function __construct() {
		$this->mRecentAwardedUsers = null;
	}

	public function getUsersRanking($limit = null, $compareToSnapshot = false) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgWikiaBotLikeUsers, $wgExternalSharedDB;
		$ranking = array();
		$rules = array('ORDER BY' => 'score desc');

		if($limit > 0)
			$rules['LIMIT'] = $limit * 2;//bots and blocked users are filtered after the query has been run, let's admit that ratio is 2:1
		
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$res = $dbr->select('ach_user_score', 'user_id, score', array('wiki_id' => $wgCityId), __METHOD__, $rules);
		$rankingSnapshot = ($compareToSnapshot) ? $this->loadFromSnapshot() : null;
		$positionCounter = 0;
		
		while($row = $dbr->fetchObject($res)) {
		    $user = User::newFromId($row->user_id);

		    if($user && !$user->isBlocked() && !in_array( $user->getName(), $wgWikiaBotLikeUsers ) ) {
			$ranking[] = new AchRankedUser($user, $row->score, $positionCounter++, ($rankingSnapshot != null && isset($rankingSnapshot[$user->getId()])) ? $rankingSnapshot[$user->getId()] : null);
		    }

		    if($limit > 0 && $positionCounter == $limit) break;
		}
		
		$dbr->freeResult($res);

		wfProfileOut(__METHOD__);

		return $ranking;
	}

	public function getUserRankingPosition(User $user) {
		if($user) {
			$ranking = $this->getUsersRanking();

			foreach($ranking as $position => $rankedUser) {
				if($rankedUser->getId() == $user->getId()) return ++$position;
			}

			return count($ranking) + 1;
		}
		else
			return false;
	}

	function serialize(){
	    $ranking = $this->getUsersRanking();

	    $result = array();

	    foreach($ranking as $position => $user) {
		$result[$user->getId()] = $position;
	    }

	    return serialize($result);
	}

	function loadFromSnapshot() {
	    global $wgCityId;
	    
	    $dbr = WikiFactory::db( DB_SLAVE );

	    $res = $dbr->select('ach_ranking_snapshots', array('data'), array('wiki_id' => $wgCityId));

	    if($row = $dbr->fetchObject($res)) return unserialize($row->data);

	    return null;
	}

	/**
	* Returns the list of recently awarded badges for the current wiki and specified level
	*
	* @param $badgeLevel the level of the badges to list 
	* @param $limit limit the list to the specified amount of items Integer
	* @param $daySpan a span of days to subtract to the current date Integer
	* @param $blackList a list of the badge type IDs to exclude from the result Array
	* @return Array
	*/
	public function getRecentAwardedBadges($badgeLevel, $limit = null, $daySpan = null, $blackList = null) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgWikiaBotLikeUsers, $wgExternalSharedDB;
		$badges = array();

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$conds = array('wiki_id' => $wgCityId, 'badge_level' => $badgeLevel);
		$rules = array('ORDER BY' => 'date DESC, badge_lap DESC');
		
		if($daySpan != null)
			$conds[] = "date >= (CURDATE() - INTERVAL {$daySpan} DAY)";
		
		if(is_array($blackList))
			$conds[] = 'badge_type_id NOT IN (' . implode($blackList) . ')';
		
		if($limit != null)
			$rules['LIMIT'] = $limit * 2; //bots and blocked users are filtered after the query hs been run, let's admit that ratio is 2:1
		
		$res = $dbr->select('ach_user_badges', 'user_id, badge_type_id, badge_lap, date', $conds, __METHOD__, $rules);
		
		while($row = $dbr->fetchObject($res)) {
			if(AchConfig::getInstance()->isInRecents($row->badge_type_id)) {
				$user = User::newFromId($row->user_id);
				
				if($user && !$user->isBlocked() && !in_array( $user->getName(), $wgWikiaBotLikeUsers ) ) {
					$badges[] = array('user' => $user, 'badge' => new AchBadge($row->badge_type_id, $row->badge_lap), 'date' => $row->date);
				}
			}
		}

		$dbr->freeResult($res);

		wfProfileOut(__METHOD__);

		return $badges;
	}
}