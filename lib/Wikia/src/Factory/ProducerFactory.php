<?php
namespace Wikia\Factory;

use Wikia\Tasks\Producer\EditCountTaskProducer;
use Wikia\Tasks\Producer\SiteStatsUpdateTaskProducer;

class ProducerFactory extends AbstractFactory {

	/** @var EditCountTaskProducer $editCountTaskProducer */
	private $editCountTaskProducer;

	/** @var SiteStatsUpdateTaskProducer $siteStatsUpdateTaskProducer */
	private $siteStatsUpdateTaskProducer;

	public function editCountTaskProducer(): EditCountTaskProducer {
		if ( !$this->editCountTaskProducer ) {
			$this->editCountTaskProducer = new EditCountTaskProducer(
				$this->serviceFactory()->rabbitFactory()->taskPublisher()
			);
		}

		return $this->editCountTaskProducer;
	}

	public function siteStatsUpdateTaskProducer(): SiteStatsUpdateTaskProducer {
		if ( !$this->siteStatsUpdateTaskProducer ) {
			$this->siteStatsUpdateTaskProducer = new SiteStatsUpdateTaskProducer(
				$this->serviceFactory()->rabbitFactory()->taskPublisher()
			);
		}

		return $this->siteStatsUpdateTaskProducer;
	}
}
