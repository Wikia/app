<?php
namespace Wikia\Tasks\Tasks;

/**
 * Class UserStatsUpdateTask updates user stats of a given user in DB
 *
 * @see \UserStats
 * @see \UserStatsService
 * @package Wikia\Tasks\Tasks
 */
class UserStatsUpdateTask extends BaseTask {
	/**
	 * Persist the given user stats to DB
	 * @param int $userId user ID of user these stats belong to
	 * @param array $statData serialized data of UserStats
	 */
	public function update( int $userId, $statData ) {
		$db = wfGetDB( DB_MASTER );
		$userStats = new \UserStats( $userId );

		$statData = (array) $statData;
		foreach ( $statData as $statName => $statValue ) {
			$userStats[$statName] = $statValue;
		}

		$userStats->persist( $db );
	}
}
