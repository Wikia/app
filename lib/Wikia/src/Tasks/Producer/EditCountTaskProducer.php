<?php
namespace Wikia\Tasks\Producer;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Tasks\IncrementEditCountTask;

class EditCountTaskProducer implements TaskProducer {

	/** @var IncrementEditCountTask $task */
	private $task;

	public function __construct( TaskPublisher $publisher ) {
		$publisher->registerProducer( $this );
	}

	public function incrementFor( \User $user ) {
		if ( empty( $this->task ) ) {
			$this->task = IncrementEditCountTask::newLocalTask();
		}

		$this->task->call( 'increment', $user->getId() );
	}

	/**
	 * @return \Wikia\Tasks\AsyncTaskList[]
	 */
	public function getTasks() {
		if ( $this->task ) {
			return $this->task->convertToTaskLists();
		}

		return [];
	}
}
