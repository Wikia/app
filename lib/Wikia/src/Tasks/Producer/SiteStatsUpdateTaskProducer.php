<?php

namespace Wikia\Tasks\Producer;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Tasks\SiteStatsUpdateTask;

/**
 * This class holds pending changes to site stats in memory during the lifetime of the request.
 * Before background tasks are published, it will create a task to apply these changes asynchronously.
 */
class SiteStatsUpdateTaskProducer implements TaskProducer {

	/**
	 * @var int[] $deltas change values corresponding to SiteStatsUpdate::factory() arguments
	 * @see SiteStatsUpdate::factory()
	 */
	private $deltas = [
		'views' => 0,
		'edits' => 0,
		'pages' => 0,
		'articles' => 0,
		'users' => 0,
		'images' => 0,
	];

	public function __construct( TaskPublisher $publisher ) {
		$publisher->registerProducer( $this );
	}

	public function addEdit() {
		$this->deltas['edits'] ++;
	}

	/** Increment total page count in site stats */
	public function addNewPage() {
		$this->deltas['pages'] ++;
	}

	/** Decrement total page count in site stats */
	public function removePage() {
		$this->deltas['pages'] --;
	}

	/** Increment count of content pages in site stats */
	public function addContentPage() {
		$this->deltas['articles'] ++;
	}

	/** Decrement count of content pages in site stats */
	public function removeContentPage() {
		$this->deltas['articles'] --;
	}

	public function addMedia() {
		$this->deltas['images'] ++;
	}

	public function removeMedia() {
		$this->deltas['images'] --;
	}

	public function getTasks() {
		if ( empty( array_filter( $this->deltas ) ) ) {
			return [];
		}

		$task = SiteStatsUpdateTask::newLocalTask();
		$task->call( 'doUpdate', $this->deltas );

		return $task->convertToTaskLists();
	}
}
