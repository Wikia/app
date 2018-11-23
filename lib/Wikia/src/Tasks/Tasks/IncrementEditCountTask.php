<?php
namespace Wikia\Tasks\Tasks;

/**
 * SRE-109: Background task to increment users' edit counts
 */
class IncrementEditCountTask extends BaseTask {

	public function increment( int $userId ) {
		$userStatsService = new \UserStatsService( $userId );
		$userStatsService->increaseEditsCount();
	}
}
