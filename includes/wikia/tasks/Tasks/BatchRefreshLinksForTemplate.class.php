<?php
/**
 * Replacement task for the core RefreshLinksJob.
 */

namespace Wikia\Tasks\Tasks;

class BatchRefreshLinksForTemplate extends BaseTask {

	const BACKLINK_CACHE_TABLE = 'templatelinks';

	/** @var integer $start */
	private $start = null;

	/** @var integer $end */
	private $end   = null;

	public function refreshTemplateLinks( $start, $end ) {
		$this->setStartAndEndBoundaries( $start, $end );

		if ( !$this->isValidTask() ) {
			return false;
		}

		$this->clearLinkCache();

		$titles = $this->getTitlesWithBackLinks();

		$this->enqueueRefreshLinksTasksForTitles( $titles );

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
	 * Is the task valid?
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

	public function enqueueRefreshLinksTasksForTitles( $titles ) {
		$batchTasks = array();
		foreach ( $titles as $title ) {
			if ( is_null( $title ) ) {
				$this->error( "empty BackLink title" );
				continue;
			}

			$batchTasks[] = $this->readyRefreshLinksForTitleTask( $title );
		}

		$this->batchEnqueue( $batchTasks );
	}

	public function readyRefreshLinksForTitleTask( \Title $title ) {
		$task = new RefreshLinksForTitleTask();
		$task->title( $title );
		$task->call( 'refresh' );
		$task->wikiId( $this->getWikiId() );

		// TODO: delay the tasks - see PLATFORM-1192

		return $task;
	}

	protected function batchEnqueue( array $tasks ) {
		if ( !empty( $tasks ) ) {
			$this->info( 'BatchRefreshLinksForTemplate::batchEnqueue', [
				'tasks' => count( $tasks ),
				'title' => $this->title->getText(),
				'start' => $this->getStart(),
				'end' => $this->getEnd()
			] );
			BaseTask::batch( $tasks );
		}
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
