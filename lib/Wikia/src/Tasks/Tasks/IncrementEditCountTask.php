<?php
namespace Wikia\Tasks\Tasks;

/**
 * Asynchronously increment an user's edit count after an edit
 * @see SRE-109
 */
class IncrementEditCountTask extends BaseTask {

	public function increaseEditCount() {
		$userStatsService = new \UserStatsService( $this->createdBy );
		$userStatsService->increaseEditsCount();
	}
}
