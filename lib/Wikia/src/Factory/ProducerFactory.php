<?php
namespace Wikia\Factory;

use Wikia\Tasks\Producer\SiteStatsUpdateTaskProducer;

class ProducerFactory extends AbstractFactory {

	/** @var SiteStatsUpdateTaskProducer $siteStatsUpdateTaskProducer */
	private $siteStatsUpdateTaskProducer;

	public function siteStatsUpdateTaskProducer(): SiteStatsUpdateTaskProducer {
		if ( !$this->siteStatsUpdateTaskProducer ) {
			$this->siteStatsUpdateTaskProducer = new SiteStatsUpdateTaskProducer(
				$this->serviceFactory()->rabbitFactory()->taskPublisher()
			);
		}

		return $this->siteStatsUpdateTaskProducer;
	}
}
