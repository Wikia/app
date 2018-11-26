<?php

namespace Wikia\Tasks\Producer;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Tasks\SiteStatsUpdateTask;

class SiteStatsUpdateTaskProducer implements TaskProducer {

	/** @var int[] $deltas */
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

	public function addNewPage() {
		$this->deltas['pages'] ++;
	}

	public function removePage() {
		$this->deltas['pages'] --;
	}

	public function addContentPage() {
		$this->deltas['articles'] ++;
	}

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
