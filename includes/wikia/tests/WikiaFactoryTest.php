<?php

require_once dirname(__FILE__) . "/_fixtures/WikiaFactoryTestClass.php";

/**
 * @group mwabstract
 */
class WikiaFactoryTest extends PHPUnit_Framework_TestCase {

	const TEST_ID = 12345;
	const TEST_TYPE = '-x-TestType-x-';
	const TEST_DEFAULT_TYPE = '-x-TestDefaultType-x-';
	const TEST_BAR = '-x-TestBar-x-';

	protected function setUp() {
		WikiaFactory::addClassConstructor('WikiaFactoryTestClass');
		WikiaFactory::addClassConstructor('WikiaFactoryTestClass', array( 'type' => self::TEST_DEFAULT_TYPE), 'newFromTypeAndBar');
	}

	protected function tearDown() {
		WikiaFactory::reset('WikiaFactoryTestClass');
	}

	public function testBuildWithDefaultConstructor() {
		// call default constructor with all params set
		$object = WikiaFactory::build('WikiaFactoryTestClass', array( 'type' => self::TEST_TYPE, 'id' => self::TEST_ID));

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(self::TEST_ID, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertNull($object->bar);

		// call default constructor with default id
		$object = WikiaFactory::build('WikiaFactoryTestClass', array( 'type' => self::TEST_TYPE ));

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertNull($object->bar);
	}

	public function testBuildWithFactoryConstructor() {
		// call factory constructor with all params set
		$object = WikiaFactory::build('WikiaFactoryTestClass', array( 'type' => self::TEST_TYPE, 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);

		// call factory constructor without all params, so defaults should be passed
		$object = WikiaFactory::build('WikiaFactoryTestClass', array( 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_DEFAULT_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);
	}

	public function testBuildWithClassSetters() {
		WikiaFactory::setClassSetters('WikiaFactoryTestClass', array( 'setId' => self::TEST_ID, 'setBar' => self::TEST_BAR ));

		$object = WikiaFactory::build('WikiaFactoryTestClass', array( self::TEST_TYPE ));

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(self::TEST_ID, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);

		$object = 	WikiaFactory::build('WikiaFactoryTestClass', array( 'type' => self::TEST_TYPE, 'bar' => 'anotherBarToOverride'), 'newFromTypeAndBar');

		$this->assertInstanceOf('WikiaFactoryTestClass', $object);
		$this->assertEquals(self::TEST_ID, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);
	}

	public function testSettingInstance() {
		$id = 12345;
		$type = '01010101';
		$bar = 'barbarbar';

		$objectObjA = new WikiaFactoryTestClass($type, $id);
		$objectObjA->setBar($bar);

		WikiaFactory::reset('WikiaFactoryTestClass');
		WikiaFactory::setInstance('WikiaFactoryTestClass', $objectObjA);

		$objectObjB = WikiaFactory::build('WikiaFactoryTestClass');

		$this->assertEquals($objectObjA, $objectObjB);

		//re-instantiate
		$objectObjC = new WikiaFactoryTestClass('reinstantiate', 5);

		WikiaFactory::setInstance('WikiaFactoryTestClass', $objectObjC);

		$this->assertEquals($objectObjC, WikiaFactory::build('WikiaFactoryTestClass'));
	}

	public function testUnknownConstructorCall() {
		$this->setExpectedException('WikiaException');
		$object = WikiaFactory::build('WikiaFactoryTestClass', array(), 'nonExistentFactoryMethod');
	}

	public function testSettingInstanceWithConstructorDefined() {
		$this->setExpectedException('WikiaException');
		WikiaFactory::setInstance('WikiaFactoryTestClass', new WikiaFactoryTestClass(1));
	}

	public function testAddingConstructorWithInstancePredefined() {
		WikiaFactory::reset('WikiaFactoryTestClass');
		WikiaFactory::setInstance('WikiaFactoryTestClass', new WikiaFactoryTestClass(1));

		$this->setExpectedException('WikiaException');
		WikiaFactory::addClassConstructor('WikiaFactoryTestClass');
	}
}
