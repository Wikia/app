<?php
namespace Wikia\Tasks\Producer;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Tasks\IncrementEditCountTask;

class EditCountTaskProducer implements TaskProducer {

	/** @var IncrementEditCountTask[] $tasksByUser */
	private $tasksByUser = [];

	public function __construct( TaskPublisher $publisher ) {
		$publisher->registerProducer( $this );
	}

	/**
	 * Get a task instance prepared for the given user. At most one task instance per user will be prepared per request.
	 *
	 * @param \User $user
	 * @return IncrementEditCountTask
	 */
	public function forUser( \User $user ): IncrementEditCountTask {
		$userId = $user->getId();

		if ( !isset( $this->tasksByUser[$userId] ) ) {
			$task = IncrementEditCountTask::newLocalTask();
			$task->createdBy( $user );

			$this->tasksByUser[$userId] = $task;
		}

		return $this->tasksByUser[$userId];
	}

	public function getTasks() {
		foreach ( $this->tasksByUser as $task ) {
			foreach ( $task->convertToTaskLists() as $taskList ) {
				yield $taskList;
			}
		}
	}
}
