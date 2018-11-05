<?php
namespace Wikia\SwiftSync;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Tasks\ImageSyncTask;

class SwiftSyncTaskProducer implements TaskProducer {

	/**
	 * Stack of DFS operation to be pushed to tasks queue when an upload is completed
	 * @var array $operations
	 */
	private $operations = [];

	public function __construct( TaskPublisher $publisher ) {
		$publisher->registerProducer( $this );
	}

	public function addOperation( array $operation ) {
		$this->operations[] = $operation;
	}

	public function getTasks() {
		$task = ImageSyncTask::newLocalTask();

		$task->call( 'synchronize', $this->operations );

		return $task->convertToTaskLists();
	}
}
