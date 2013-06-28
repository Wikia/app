<?php

class UIFactoryTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();

		global $IP;

		include_once $IP.'/includes/wikia/ui/UIFactory.class.php';
	}

	public function testInitalizationAndSingleton() {
		$instanceA = UIFactory::getInstance();
		$instanceB = UIFactory::getInstance();

		$this->assertEquals($instanceA, $instanceB);
	}

	public function testInitalizingComponents() {
		$component = UIFactory::getInstance()->init( $this->findOneComponentName() );
	}

	private function findOneComponentName() {
		
	}

}
