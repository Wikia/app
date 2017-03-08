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
	 * @param \UserStats $userStats
	 */
	public function update( \UserStats $userStats ) {
		$db = wfGetDB( DB_MASTER );
		$userStats->persist( $db );
	}
}
