<?php
namespace Wikia\Rabbit;

use Wikia\Tasks\AsyncTaskList;

interface TaskPublisher {

	/**
	 * Push a task to be queued.
	 * @param AsyncTaskList $task
	 * @return string ID of the task
	 */
	public function pushTask( AsyncTaskList $task ): string;

	/**
	 * Register a task producer with this publisher.
	 * Implementations are expected to call TaskProducer::getTasks during the publish process
	 * to publish all tasks created by the producer.
	 *
	 * @param TaskProducer $producer
	 */
	public function registerProducer( TaskProducer $producer );

	public function doUpdate();
}
