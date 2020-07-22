<?php

declare( strict_types=1 );

namespace Wikia\UCP;

use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\AsyncTaskList;

class UcpQueue implements TaskProducer {

	/** @var AsyncTaskList[] */
	private $tasks = [];

	public function __construct( TaskPublisher $taskPublisher ) {
		$taskPublisher->registerProducer( $this );
	}

	public function getTasks() {
		return $this->tasks;
	}

	public function attemptToFinishRename( int $renameLogId ) {
		$this->tasks[] = new FinishRenameTask( $renameLogId );
	}
}
