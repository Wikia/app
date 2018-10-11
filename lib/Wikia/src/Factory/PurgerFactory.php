<?php
namespace Wikia\Factory;

use Wikia\Purger\CeleryPurger;

class PurgerFactory extends AbstractFactory {

	/** @var CeleryPurger $purger */
	private $purger;

	public function purger(): CeleryPurger {
		if ( !$this->purger ) {
			$this->purger = new CeleryPurger( $this->serviceFactory()->rabbitFactory()->taskPublisher() );
		}

		return $this->purger;
	}
}
