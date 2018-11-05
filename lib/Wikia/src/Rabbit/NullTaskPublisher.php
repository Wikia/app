<?php
namespace Wikia\Rabbit;

use Wikia\Logger\Loggable;
use Wikia\Tasks\AsyncTaskList;

/**
 * A no-op task publisher implementation that is used if the task broker is disabled.
 */
class NullTaskPublisher implements TaskPublisher {

	use Loggable;

	public function __construct() {
		// Schedule doUpdate() to be executed at the end of the request
		\Hooks::register( 'RestInPeace', [ $this, 'doUpdate' ] );
	}

	public function pushTask( AsyncTaskList $task ): string {
		return $task->getId();
	}

	function doUpdate() {
		$this->info( 'Task broker is disabled' );
	}

	public function registerProducer( TaskProducer $producer ) {
		// no-op
	}
}
