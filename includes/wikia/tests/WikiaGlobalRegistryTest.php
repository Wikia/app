<?php
/**
 * @ingroup mwabstract
 */
class WikiaGlobalRegistryTest extends PHPUnit_Framework_TestCase {
	const VALID_KEY   = 'registryTestKey';
	const OTHER_VALID_KEY = 'otherRegistryTestKey';
	const INVALID_NULL_KEY = null;
	const INVALID_NUMERIC_KEY = 13;

	/* @var WikiaGlobalRegistry */
	private $registry;

	public function setUp() {
		$this->registry = new WikiaGlobalRegistry();
		unset($GLOBALS[self::VALID_KEY]);
		unset($GLOBALS[self::OTHER_VALID_KEY]);
	}

	public function tearDown() {
		unset($GLOBALS[self::VALID_KEY]);
		unset($GLOBALS[self::OTHER_VALID_KEY]);
	}

	public function testGettingNotRegisteredDataReturnNull() {
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertNull($this->registry->get(self::VALID_KEY));
	}

	public function testGettingRegisteredDataReturnCorrectData() {
		global $registryTestKey;
		$registryTestKey = array(rand());

		$this->assertEquals($GLOBALS[self::VALID_KEY], $registryTestKey);
		$this->assertTrue($this->registry->has(self::VALID_KEY));
		$this->assertEquals($registryTestKey, $this->registry->get(self::VALID_KEY));

		$registryTestKey = rand();
		$this->assertEquals($registryTestKey, $this->registry->get(self::VALID_KEY));
	}

	public function testRemovingRegisteredDataRemoveItFromRegistry() {
		$data = array(rand());

		$this->registry->set(self::VALID_KEY, $data);
		$this->assertTrue($this->registry->has(self::VALID_KEY));

		global $registryTestKey;
		$this->assertEquals($registryTestKey, $data);

		$this->registry->remove(self::VALID_KEY);
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertFalse(isset($GLOBALS[self::VALID_KEY]));
	}

	public function testRemovingNotRegisteredDataDoesNothing() {
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->registry->remove(self::VALID_KEY);
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertFalse(isset($GLOBALS[self::VALID_KEY]));
	}

	public function testSettingDataInRegistryChains() {
		$dataA = array(rand());
		$dataB = rand();
		$this->registry->set(self::VALID_KEY, $dataA)->set(self::OTHER_VALID_KEY, $dataB);
		$this->assertTrue($this->registry->has(self::VALID_KEY));
		$this->assertTrue($this->registry->has(self::OTHER_VALID_KEY));
		$this->assertEquals($dataA, $this->registry->get(self::VALID_KEY));
		$this->assertEquals($dataB, $this->registry->get(self::OTHER_VALID_KEY));

		global $registryTestKey, $otherRegistryTestKey;
		$this->assertEquals($dataA, $registryTestKey);
		$this->assertEquals($dataB, $otherRegistryTestKey);
	}

	public function testUpdatingDataInRegistryOverwritesOldData() {
		$dataA = array(rand());
		$dataB = rand();
		$this->registry->set(self::VALID_KEY, $dataA)->set(self::VALID_KEY, $dataB);
		$this->assertTrue($this->registry->has(self::VALID_KEY));
		$this->assertEquals($dataB, $this->registry->get(self::VALID_KEY));

		global $registryTestKey;
		$this->assertEquals($dataB, $registryTestKey);
	}

	public function testRemovingDataFromRegistryChains() {
		$dataA = array(rand());
		$dataB = rand();
		$this->registry
		     ->set(self::VALID_KEY, $dataA)
		     ->set(self::OTHER_VALID_KEY, $dataB)
		     ->remove(self::VALID_KEY, $dataA)
		     ->remove(self::OTHER_VALID_KEY, $dataB);
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertFalse($this->registry->has(self::OTHER_VALID_KEY));

		$this->assertFalse(isset($GLOBALS[self::VALID_KEY]));
		$this->assertFalse(isset($GLOBALS[self::OTHER_VALID_KEY]));
	}

	public function testSettingDataUsingInvalidKeyThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->set(self::INVALID_NULL_KEY, rand());
	}

	public function testRemovingDataUsingInvalidKeyThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->remove(self::INVALID_NUMERIC_KEY);
	}

	public function testGettingDataUsingInvalidKeyThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->get(self::INVALID_NULL_KEY, rand());
	}

	public function testCheckingDataUsingInvalidKeyThrowsException() {
		$this->setExpectedException('WikiaException');
		$this->registry->has(self::INVALID_NUMERIC_KEY);
	}

	public function testRegistryImplementsArrayAccessInterface() {
		$data = rand();

		$this->assertInstanceOf('ArrayAccess', $this->registry);
		$this->assertInstanceOf('WikiaRegistry', $this->registry);

		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertFalse(isset($this->registry[self::VALID_KEY]));

		$this->registry[self::VALID_KEY] = $data;
		$this->assertTrue($this->registry->has(self::VALID_KEY));
		$this->assertTrue(isset($this->registry[self::VALID_KEY]));
		$this->assertEquals($data, $this->registry[self::VALID_KEY]);

		unset($this->registry[self::VALID_KEY]);
		$this->assertFalse($this->registry->has(self::VALID_KEY));
		$this->assertFalse(isset($this->registry[self::VALID_KEY]));
	}

	public function testSettingDataUnderKeyOfGlobalArray() {
		global $registryTestKey;
		$registryTestKey = array();
		$data = rand();

		$this->registry->set(self::VALID_KEY, $data, self::OTHER_VALID_KEY);
		$this->assertEquals($GLOBALS[self::VALID_KEY][self::OTHER_VALID_KEY], $data);
		$this->assertEquals($registryTestKey[self::OTHER_VALID_KEY], $data);
	}

	public function testAppendingDataWithoutKeyGivenExtendsGlobalArray() {
		global $registryTestKey;
		$registryTestKey = array();
		$data = rand();

		$this->registry->append(self::VALID_KEY, $data);
		$this->assertEquals($GLOBALS[self::VALID_KEY][0], $data);
		$this->assertEquals($registryTestKey[0], $data);
	}

	public function testAppendingDataWithKeyExtendsArrayUnderGlobalArrayIndex() {
		global $registryTestKey;
		$registryTestKey = array(
			self::OTHER_VALID_KEY => array()
		);
		$data = rand();

		$this->registry->append(self::VALID_KEY, $data, self::OTHER_VALID_KEY);
		$this->assertEquals($GLOBALS[self::VALID_KEY][self::OTHER_VALID_KEY][0], $data);
		$this->assertEquals($registryTestKey[self::OTHER_VALID_KEY][0], $data);
	}
}
