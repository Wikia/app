<?php

/**
 * AsyncNLPTaskList
 *
 * Lets us generate a list of async tasks to be run by the NLP backend
 *
 * @author Robert Elwell <robert@wikia-inc.com>
 */

namespace Wikia\Tasks;

class AsyncNLPTaskList extends AsyncTaskList
{
	/**
	 * @var str it's useful to have the base URL for the wiki for making API calls, etc.
	 */
	protected $wikiUrl;

	/**
	 * @var array ids of the pages we want to work with
	 */
	protected $pageIds = [];

	/**
	 * add a task call to the task list
	 *
	 * @param string $pageId
	 * @return $this
	 */
	public function add($pageId) {
		$this->pageIds[] = $pageId;
		return $this;
	}

	/**
	 * Mutate the wiki URL property
	 * @param $wikiUrl the url for the originating event
	 * @return $this
	 */
	public function wikiUrl($wikiUrl) {
		$this->wikiUrl = $wikiUrl;
		return $this;
	}

	/**
	 * Returns the "args" value of the payload. Required in base class to valuate work id
	 * @return array
	 */
	protected function payloadArgs() {
		return $this->workId;
	}

	/**
	 * Initializes the data we're using to identify a set of tasks so we can reuse the runner without leaky state
	 * Also in this case reinitializes stateful values once we're done with them (e.g. page ids)
	 * @return $this
	 */
	protected function initializeWorkId() {
		$this->workId = [$this->wikiUrl, $this->wikiId, $this->pageIds];
		$this->pageIds = [];
		return $this;
	}

	protected function getExecutor() {
		return null;
	}
}