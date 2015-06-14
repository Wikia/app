<?php

/**
 * Async celery task class runs any single celery task in a "generic" way
 * Since the task is defined in the celery-workers python library we just need the name and parameters
 * We do reuse some functionality from AsyncTaskList, but we only run 1 task
 *
 * Sample usage:
 *
 * 	        ( new AsyncCeleryTask() )
 *          ->taskType('celery_workers.purger.purge')
 *            		->setArgs( $urlArr, [] )
 *                  ->setPriority( PurgeQueue::NAME )
 *                  ->queue();
 *
 */

namespace Wikia\Tasks;

class AsyncCeleryTask extends AsyncTaskList
{

	/**
	 * @var task arguments corresponding to *args in python task.  **kwargs are not supported by AsyncTaskList
	 */
	private $args;

	public function setArgs() {
		$this->args = func_get_args();
		return $this;
	}

	// Uniquely identifies our task
	protected function initializeWorkId() {
		$this->workId = [
			"task" => $this->taskType,
			"args" => $this->args
		 ];
	}

	// return our name/value pairs of arguments wrapped in an extra array ("because")
	protected function payloadArgs() {
		return $this->args;
	}

	// Executor is used to run tasks in the mediawiki/PHP farm, we don't use that
	protected function getExecutor() {
		return null;
	}

}
