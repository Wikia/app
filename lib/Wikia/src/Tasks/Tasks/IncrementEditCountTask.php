<?php
namespace Wikia\Tasks\Tasks;

/**
 * SRE-109: Background task to increment users' edit counts
 */
class IncrementEditCountTask extends BaseTask {

	public function increment() {
		$userStatsService = new \UserStatsService( $this->createdByUser()->getId() );
		$userStatsService->increaseEditsCount();
	}
}
