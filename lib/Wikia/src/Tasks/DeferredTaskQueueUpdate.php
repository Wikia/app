<?php
namespace Wikia\Tasks;

use Wikia\Tasks\Tasks\BaseTask;

class DeferredTaskQueueUpdate implements \DeferrableUpdate {

	/** @var BaseTask $task */
	private $task;

	public function __construct( BaseTask $task ) {
		$this->task = $task;
	}

	function doUpdate() {
		$this->task->queue();
	}
}
