<?php
namespace Wikia\Rabbit;

use Wikia\Tasks\AsyncTaskList;

/**
 * Interface for a class that can produce multiple background tasks
 */
interface TaskProducer {

	/**
	 * Get the list of tasks produced by the class
	 * @return AsyncTaskList[] iterable of tasks, such as an array or a generator
	 */
	public function getTasks();
}
