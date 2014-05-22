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
	 * @var str it's useful to have the base URL for the wiki for making API calls, etc.
	 */
	protected $wikiUrl;

	/**
	 * add a task call to the task list
	 *
	 * @param string $pageId
	 * @return $this
	 */
	public function add($pageId) {
		$this->workId['page_ids'][] = $pageId;
		return $this;
	}

	/**
	 * Returns the "args" value of the payload. Required in base class to valuate work id
	 * @return array
	 */
	protected function payloadArgs() {
		return [$this->wikUrl, $this->workId['page_ids']];
	}

	/**
	 * Initializes the data we're using to identify a set of tasks so we can reuse the runner without leaky state
	 * @return $this
	 */
	protected function initializeWorkId() {
		$this->workId = [$this->wikiUrl, 'page_ids' => []];
		return $this;
	}

	protected function getExecutor() {
		return null;
	}
}