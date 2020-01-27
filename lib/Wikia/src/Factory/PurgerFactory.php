<?php

namespace Wikia\Factory;

use Wikia\Purger\CdnPurger;
use Wikia\Purger\CeleryPurger;
use Wikia\Purger\Purger;
use Wikia\Rabbit\TaskPublisher;

class PurgerFactory extends AbstractFactory {

	/** @var CeleryPurger $purger */
	private $purger;

	public function purger(): Purger {
		if ( !$this->purger ) {
			$this->purger = $this->create( $this->serviceFactory()->rabbitFactory()->taskPublisher() );
		}

		return $this->purger;
	}

	private function create( TaskPublisher $taskPublisher ): Purger {
		global $wgUseCdnPurger;
		if ( $wgUseCdnPurger === true ) {
			return new CdnPurger( $taskPublisher );
		} else {
			return new CeleryPurger( $taskPublisher );
		}
	}
}
