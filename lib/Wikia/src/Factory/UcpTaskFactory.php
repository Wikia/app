<?php

namespace Wikia\Factory;

use Wikia\Rabbit\TaskPublisher;
use Wikia\UCP\UcpQueue;

class UcpTaskFactory extends AbstractFactory {

	/** @var UcpQueue $queue */
	private $queue;

	public function queue(): UcpQueue {
		if ( !$this->queue ) {
			$this->queue = $this->create( $this->serviceFactory()->rabbitFactory()->taskPublisher() );
		}

		return $this->queue;
	}

	private function create( TaskPublisher $taskPublisher ): UcpQueue {
		return new UcpQueue( $taskPublisher );
	}
}
