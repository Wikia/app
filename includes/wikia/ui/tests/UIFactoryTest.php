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

	public function testLoadingComponentsDirectory() {
	}

	public function testInitializeSingleObject() {
		$component = UIFactory::getInstance()->init( $this->findOneComponentName() );

		var_dump($component);
		die;
	}

	private function findOneComponentName() {
	}

}
