<?php

class FounderProgressBarModel extends WikiaModel {

	/**
	 * @return FounderTask[]
	 */
	public function getTasksStatus(): array {
		$res = $this->getSharedDB()->select(
			'founder_progress_bar_tasks',
			[ 'task_id', 'task_completed', 'task_count', 'task_skipped' ],
			[ 'wiki_id' => $this->wg->CityId ],
			__METHOD__
		);

		$tasks = [];

		foreach ( $res as $row ) {
			$tasks[$row->task_id] = FounderTask::newFromRow( $row );
		}

		return $tasks;
	}

	public function wasCompletionTaskFinished(): bool {
		return (bool) $this->getSharedDB()->selectField(
			'founder_progress_bar_tasks',
			'task_id',
			[ 'wiki_id' => $this->wg->CityId, 'task_id' => FounderTask::TASKS['FT_COMPLETION'] ],
			__METHOD__
		);
	}

	/**
	 * @param FounderTask[] $tasks
	 */
	public function updateTasksStatus( array $tasks ) {
		$rows = [];

		foreach ( $tasks as $task ) {
			$rows[] = $task->toDatabaseArray();
		}

		$this->getSharedDB( DB_MASTER )->upsert(
			'founder_progress_bar_tasks',
			$rows,
			[],
			[ 'task_count = VALUES(task_count)', 'task_completed = VALUES(task_completed)' ]
		);
	}

	public function skipTask( int $taskId, bool $status ) {
		$this->getSharedDB( DB_MASTER )->update(
			'founder_progress_bar_tasks',
			[ 'task_skipped' => $status, ],
			[ 'task_id' => $taskId, 'wiki_id' => $this->wg->CityId ],
			__METHOD__
		);
	}

	public function unlockBonusTasks() {
		$rows = [];

		foreach ( FounderTask::BONUS as $id ) {
			$rows[] = [
				'wiki_id' => $this->wg->CityId,
				'task_id' => $id
			];
		}

		$this->getSharedDB( DB_MASTER )->upsert(
			'founder_progress_bar_tasks',
			$rows,
			[],
			[ 'task_id = VALUES(task_id)' ]
		);
	}
}
