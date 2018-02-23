<?php
/**
 * Replacement task for the core RefreshLinksJob.
 *
 * This job is created by \LinksUpdate::queueRefreshTasks
 */

namespace Wikia\Tasks\Tasks;

class BatchRefreshLinksForTemplate extends BaseTask {

	const BACKLINK_CACHE_TABLE = 'templatelinks';

	/** @var integer|false $start */
	private $start = null;

	/** @var integer|false $end */
	private $end   = null;

	public function refreshTemplateLinks( $start, $end ) {
		$this->setStartAndEndBoundaries( $start, $end );

		if ( !$this->isValidTask() ) {
			return false;
		}

		$this->clearLinkCache();

		$titles = $this->getTitlesWithBackLinks();

		// refresh a batch of pages
		// do not enqueue tasks for each title, run them one by one - PLATFORM-2375
		foreach( $titles as $title ) {
			$this->runForTitle( $title );
		}

		return true;
	}

	/**
	 * Set the start and end boundaries for the batch processing.
	 *
	 * @param int $start
	 * @param int $end
	 */
	public function setStartAndEndBoundaries( $start, $end ) {
		$this->start = $start;
		$this->end   = $end;
	}

	/**
	 * Is the task valid? start and end should be either int or false
	 *
	 * @return bool true on success, false on failure
	 */
	public function isValidTask() {
		if ( !isset( $this->start ) || !isset( $this->end ) ) {
			$this->error( "invalid task; start or end is undefined" );
			return false;
		}

		return true;
	}

	protected function clearLinkCache() {
		\LinkCache::singleton()->clear();
	}

	public function getTitlesWithBackLinks() {
		return $this->title->getLinksFromBacklinkCache( self::BACKLINK_CACHE_TABLE, $this->start, $this->end );
	}

	/**
	 * @param \Title $title
	 */
	private function runForTitle( \Title $title ) {
		$task = new RefreshLinksForTitleTask();

		$task
			->setTitle( $title )
			->refresh();
	}

	public function getStart() {
		return $this->start;
	}

	public function getEnd() {
		return $this->end;
	}


	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}

}
