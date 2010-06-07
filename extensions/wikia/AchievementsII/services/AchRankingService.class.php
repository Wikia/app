<?php

class AchRankingService {
	private $mRecentAwardedUsers;

	function __construct() {
		$this->mRecentAwardedUsers = null;
	}

	public function getUsersRanking() {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgWikiaBotLikeUsers, $wgExternalSharedDB;
		$ranking = array();

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$res = $dbr->select('ach_user_score', 'user_id, score', array('wiki_id' => $wgCityId), __METHOD__, array('ORDER BY' => 'score desc', 'LIMIT' => 99));

		while($row = $dbr->fetchObject($res)) {
			$user = User::newFromId($row->user_id);
			if($user && !$user->isBlocked() && !in_array( $user->getName(), $wgWikiaBotLikeUsers ) )
				$ranking[] = new AchRankedUser($user, $row->score);
		}
		
		$dbr->freeResult($res);

		wfProfileOut(__METHOD__);

		return $ranking;
	}

	public function getRecentAwardedBadges($badgeLevel) {
		wfProfileIn(__METHOD__);

		global $wgCityId, $wgWikiaBotLikeUsers, $wgExternalSharedDB;
		$badges = array();

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$res = $dbr->select('ach_user_badges', 'user_id, badge_type_id, badge_lap', array('wiki_id' => $wgCityId, 'badge_level' => $badgeLevel), __METHOD__, array('ORDER BY' => 'date DESC, badge_lap DESC', 'LIMIT' => 6));

		while($row = $dbr->fetchObject($res)) {
			if(AchConfig::getInstance()->isInRecents($row->badge_type_id))
				$badges[] = array('user' => User::newFromId($row->user_id), 'badge' => new AchBadge($row->badge_type_id, $row->badge_lap));
		}

		$dbr->freeResult($res);

		wfProfileOut(__METHOD__);

		return $badges;
	}
}