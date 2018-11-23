<?php
namespace Wikia\Factory;

use Wikia\Tasks\Producer\EditCountTaskProducer;

class ProducerFactory extends AbstractFactory {

	/** @var EditCountTaskProducer $editCountTaskProducer */
	private $editCountTaskProducer;

	public function editCountTaskProducer(): EditCountTaskProducer {
		if ( !$this->editCountTaskProducer ) {
			$this->editCountTaskProducer = new EditCountTaskProducer(
				$this->serviceFactory()->rabbitFactory()->taskPublisher()
			);
		}

		return $this->editCountTaskProducer;
	}
}
