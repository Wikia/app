<?php
/**
 * @group mwabstract
 */
class WikiaCompositeRegistryTest extends PHPUnit_Framework_TestCase {
	const TEST_NAMESPACE = 'test';
	const VALID_KEY   = 'key';
	const OTHER_VALID_KEY = 'other';
	const INVALID_NULL_KEY = null;
	const INVALID_NUMERIC_KEY = 13;
	
	private $registry;
	
	public function setUp() {
		$this->registry = new WikiaCompositeRegistry(array(
			WikiaCompositeRegistry::DEFAULT_NAMESPACE => new WikiaLocalRegistry(),
			self::TEST_NAMESPACE => new WikiaLocalRegistry()
		));
	}
	
	public function testAddingExistingRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->addRegistry(new WikiaLocalRegistry(), self::TEST_NAMESPACE);
	}

	public function testRemovingNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->removeRegistry('nonexistent' . rand());
	}

	public function testDefaultCompositeRegistryDoesNotContainAnyRegistry() {
		$registry = new WikiaCompositeRegistry();
		$this->assertEquals(0, $registry->countRegistries());
	}
	
	public function testCountingRegistries() {
		$count = $this->registry->countRegistries();
		$namespace = 'foo';
		$this->registry->addRegistry(new WikiaLocalRegistry(), $namespace);
		$this->assertTrue($this->registry->hasRegistry($namespace));
		$this->assertEquals($count + 1, $this->registry->countRegistries());
		
		$this->registry->removeRegistry($namespace);
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->assertEquals($count, $this->registry->countRegistries());
	}

	public function testGettingNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$namespace = 'nonexistent' . rand();
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->registry->getRegistry($namespace);
	}
	

	public function testGettingDataFromNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$namespace = 'nonexistent' . rand();
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->registry->get(self::VALID_KEY, $namespace);
	}
	

	public function testGettingDataFromExistingRegistryButNonExistentIndexReturnNull() {
		$this->assertNull($this->registry->get(self::VALID_KEY));
	}
	

	public function testSettingDataInRegistrySetsItOnlyInSelectedRegistry() {
		$data = rand();
		$this->registry->set(self::VALID_KEY, $data, WikiaCompositeRegistry::DEFAULT_NAMESPACE);
		$this->assertEquals($data, $this->registry->get(self::VALID_KEY, WikiaCompositeRegistry::DEFAULT_NAMESPACE));
		$this->assertNull($this->registry->get(self::VALID_KEY, self::TEST_NAMESPACE));
	}
	

	public function testSettingDataInNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$namespace = 'nonexistent' . rand();
		$data = rand();
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->registry->set($data, self::VALID_KEY, $namespace);
	}

	public function testRemovingDataFromNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$namespace = 'nonexistent' . rand();
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->registry->remove(self::VALID_KEY, $namespace);
	}

	public function testRemovingDataFromRegistryRemovesItOnlyFromGivenRegistry() {
		$data = rand();
		$this->registry->set(self::VALID_KEY, $data, WikiaCompositeRegistry::DEFAULT_NAMESPACE);
		$this->registry->set(self::VALID_KEY, $data, self::TEST_NAMESPACE);
		$this->assertEquals($data, $this->registry->get(self::VALID_KEY, WikiaCompositeRegistry::DEFAULT_NAMESPACE));
		$this->assertEquals($data, $this->registry->get(self::VALID_KEY, self::TEST_NAMESPACE));
		$this->registry->remove(self::VALID_KEY, WikiaCompositeRegistry::DEFAULT_NAMESPACE);
		$this->assertNull($this->registry->get(self::VALID_KEY, WikiaCompositeRegistry::DEFAULT_NAMESPACE));
		$this->assertEquals($data, $this->registry->get(self::VALID_KEY, self::TEST_NAMESPACE));
	}

	public function testCheckingInRegistryContainsDataOnNonExistentRegistryThrowsException() {
		$this->setExpectedException('WikiaException');
		$namespace = 'nonexistent' . rand();
		$this->assertFalse($this->registry->hasRegistry($namespace));
		$this->registry->has(self::VALID_KEY, $namespace);
	}

	public function testCheckingIfRegistryContainsDataPerformsOnlyOnGivenRegistry() {
		$data = rand();
		$this->registry->set(self::VALID_KEY, $data, WikiaCompositeRegistry::DEFAULT_NAMESPACE);
		$this->assertTrue($this->registry->has(self::VALID_KEY, WikiaCompositeRegistry::DEFAULT_NAMESPACE));
		$this->assertFalse($this->registry->has(self::VALID_KEY, self::TEST_NAMESPACE));
	}
}
