<?php
namespace Wikia\Rabbit;

use Wikia\Logger\Loggable;
use Wikia\Tasks\AsyncTaskList;

class NullTaskPublisher implements TaskPublisher {

	use Loggable;

	public function __construct() {
		\DeferredUpdates::addUpdate( $this );
	}

	public function pushTask( AsyncTaskList $task ): string {
		return $task->getId();
	}

	function doUpdate() {
		$this->info( 'Task broker is disabled' );
	}
}
