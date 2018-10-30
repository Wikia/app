<?php
namespace Wikia\Factory;

use Wikia\SwiftSync\SwiftSyncTaskProducer;

class SwiftSyncFactory extends AbstractFactory {

	/** @var SwiftSyncTaskProducer $swiftSyncTaskProducer */
	private $swiftSyncTaskProducer;

	public function setSwiftSyncTaskProducer( SwiftSyncTaskProducer $swiftSyncTaskProducer ) {
		$this->swiftSyncTaskProducer = $swiftSyncTaskProducer;
	}

	public function swiftSyncTaskProducer(): SwiftSyncTaskProducer {
		if ( !$this->swiftSyncTaskProducer ) {
			$this->swiftSyncTaskProducer = new SwiftSyncTaskProducer(
				$this->serviceFactory()->rabbitFactory()->taskPublisher()
			);
		}

		return $this->swiftSyncTaskProducer;
	}
}
