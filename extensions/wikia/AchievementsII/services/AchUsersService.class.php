<?php


class AchUsersService {

	/**
	 * Service method to get the most recently earned badge for a list of users
	 * This is used in the new Leaderboard special page
	 *
	 * @param array $user_ids
	 * @return array of badge objects key by user_id
	 *
	 * Usage: $profileService->getMostRecentUserBadge(array('1', '2'));
	 * Returns: Array (
	 *			[1] => AchBadge Object
	 *			[2] => AchBadge Object
	 *		)
	 */
	public function getMostRecentUserBadge($user_ids) {
		global $wgCityId, $wgExternalSharedDB;
		global $wgEnableAchievementsStoreLocalData;
		wfProfileIn(__METHOD__);

		$badges = array();

		if (is_array($user_ids) && count($user_ids) > 0) {
			if(empty($wgEnableAchievementsStoreLocalData)) {
				$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
				$sql = "SELECT user_id, badge_type_id, badge_lap FROM `ach_user_badges` a1
					WHERE wiki_id='$wgCityId'
					AND user_id IN (" . implode(',', $user_ids) . ")
					AND date = (SELECT max(date) from ach_user_badges a2 where wiki_id = $wgCityId and a1.user_id = a2.user_id) ";
			} else {
				$dbr = wfGetDB(DB_SLAVE);
				$sql = 'SELECT  a.user_id, a.badge_type_id, a.badge_lap FROM
				(SELECT user_id, max(date) as max_date from ach_user_badges a2
					where a2.user_id in (' . implode(',', $user_ids) . ') group by user_id ) sub
					join ach_user_badges a
					on a.user_id = sub.user_id AND a.date = sub.max_date';
			}

			$res = $dbr->query( $sql, __METHOD__ );
			while($row = $dbr->fetchObject($res)) {
				$badges[$row->user_id] = new AchBadge($row->badge_type_id, $row->badge_lap);
			}
		}
		wfProfileOut(__METHOD__);
		return $badges;
	}

}