<?php

use Wikia\Tasks\Tasks\BaseTask;

/**
 * Process founder tasks done by users in the background and check completion / unlock bonus tasks
 */
class UpdateFounderProgressTask extends BaseTask {

	use BonusTasksHelperTrait;

	/** @var int[] $taskIds */
	protected $taskIds;

	public function doUpdate() {
		$model = new FounderProgressBarModel();
		$tasks = $model->getTasksStatus();

		$updated = [];

		// We can complete only unlocked tasks that are either bonus tasks or have not yet been completed
		foreach ( $this->taskIds as $id ) {
			if ( isset( $tasks[$id] ) && ( $tasks[$id]->isBonus() || !$tasks[$id]->getCompleted() ) ) {
				$updated[] = $tasks[$id]->increment();
			}
		}

		if ( $this->checkAllTasksCompleted( $tasks ) ) {
			$updated[] = FounderTask::newEmpty( FounderTask::TASKS['FT_COMPLETION'] )->increment();
		}

		$model->updateTasksStatus( $updated );

		if ( $this->shouldUnlockBonusTasks( $tasks ) ) {
			$model->unlockBonusTasks();
		}

		// Purge frontend cache after finishing with tasks updates
		FounderProgressBarController::purgeTaskList();
	}

	public function pushTask( int $taskId ) {
		$this->taskIds[] = $taskId;
	}

	/**
	 * @param FounderTask[] $tasks
	 * @return bool
	 */
	private function checkAllTasksCompleted( array $tasks ): bool {
		$total = 0;
		$completed = 0;

		foreach ( $tasks as $task ) {
			// bonus tasks do not count towards the overall total to be completed
			// but they do count towards completion
			if ( !$task->isBonus() ) {
				$total++;
			}

			$completed += $task->getCompleted();
		}

		return $completed >= $total;
	}
}
