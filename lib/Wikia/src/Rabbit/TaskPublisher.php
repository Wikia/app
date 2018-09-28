<?php
namespace Wikia\Rabbit;

use Wikia\Tasks\AsyncTaskList;

interface TaskPublisher extends \DeferrableUpdate {

	/**
	 * Push a task to be queued.
	 * @param AsyncTaskList $task
	 * @return string ID of the task
	 */
	public function pushTask( AsyncTaskList $task ): string;
}
