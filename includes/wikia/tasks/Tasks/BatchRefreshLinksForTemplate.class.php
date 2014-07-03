<?php
/**
 * Replacement task for the core RefreshLinksJob.
 */

namespace Wikia\Tasks\Tasks;

class BatchRefreshLinksForTemplate extends BaseTask {

	const BACKLINK_CACHE_TABLE = 'templatelinks';

	// Note: these instance variables need to remain protected to ensure that they
	// will be serialized when the job is queued. @nmonterroso is planning on changing
	// this behavior.

	/** @var integer $start */
	protected $start = null;

	/** @var integer $end */
	protected $end   = null;

	function __construct( $start=null, $end=null ) {
		if (isset($start)) {
			$this->start = $start;
		}

		if (isset($end)) {
			$this->end = $end;
		}
	}

	public function refreshTemplateLinks() {
		if ( !$this->isValidTask() ) {
			return false;
		}

		$this->clearLinkCache();

		$titles = $this->getTitlesWithBackLinks();
		$this->enqueueRefreshLinksTasksForTitles( $titles );

		return true;
	}

	/**
	 * Is the task valid?
	 *
	 * @return bool true on success, false on failure
	 */
	public function isValidTask() {
		if ( is_null( $this->title ) ) {
			$this->error( "invalid task; undefined title" );
			return false;
		}

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
		$this->info( sprintf( "queueing %d RefreshLinksForTitleTasks", count($titles) ) );
		foreach ( $titles as $title ) {
			$this->enqueueRefreshLinksForTitleTask( $title );
		}
	}

	public function enqueueRefreshLinksForTitleTask( \Title $title ) {
		$task = new RefreshLinksForTitleTask();
		$task->title( $title );
		$task->call( 'refresh' );
		$task->queue();
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
