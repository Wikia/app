<?php

trait BonusTasksHelperTrait {

	/**
	 * Check if bonus tasks should be unlocked given the present state of tasks completion.
	 * Bonus tasks will be unlocked if they have not yet been unlocked and all normal tasks are skipped or completed.
	 *
	 * @param FounderTask[] $tasks array of founder tasks for this wiki
	 * @return bool whether to unlock bonus tasks.
	 */
	protected function shouldUnlockBonusTasks( array $tasks ): bool {
		foreach ( $tasks as $task ) {
			if ( $task->isBonus() || ( !$task->wasSkipped() && !$task->getCompleted() ) ) {
				return false;
			}
		}

		return true;
	}
}
