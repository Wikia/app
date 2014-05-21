<?php

/**
 * BackendAsyncTaskList
 *
 * Lets us generate a list of async tasks to be run by the backend
 *
 * @author Robert Elwell <robert@wikia-inc.com>
 */

namespace Wikia\Tasks;

class AsyncBackendTaskList extends AsyncTaskList
{
	/**
	 * add a task call to the task list
	 *
	 * @param string $documentId
	 * @return $this
	 */
	public function add($documentId) {
		$this->workId['docids'][] = $documentId;
		return $this;
	}

	/**
	 * Returns the "args" value of the payload. Required in base class to valuate work id
	 * @return array
	 */
	protected function payloadArgs() {
		return $this->workId['docids'];
	}

	/**
	 * Initializes the data we're using to identify a set of tasks so we can reuse the runner without leaky state
	 * @return $this
	 */
	protected function initializeWorkId() {
		$this->workId = ['docids' => []];
		return $this;
	}

	protected function getExecutor() {
		return null;
	}
}