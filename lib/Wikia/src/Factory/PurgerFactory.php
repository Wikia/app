<?php

namespace Wikia\Factory;

use Wikia\Purger\CdnPurgerQueue;
use Wikia\Purger\CeleryPurgerQueue;
use Wikia\Purger\PurgerQueue;
use Wikia\Rabbit\TaskPublisher;

class PurgerFactory extends AbstractFactory {

	/** @var CeleryPurgerQueue $purger */
	private $purger;

	public function purger(): PurgerQueue {
		if ( !$this->purger ) {
			$this->purger = $this->create( $this->serviceFactory()->rabbitFactory()->taskPublisher() );
		}

		return $this->purger;
	}

	private function create( TaskPublisher $taskPublisher ): PurgerQueue {
		global $wgUseCdnPurger;
		if ( $wgUseCdnPurger === true ) {
			return new CdnPurgerQueue( $taskPublisher );
		} else {
			return new CeleryPurgerQueue( $taskPublisher );
		}
	}
}
