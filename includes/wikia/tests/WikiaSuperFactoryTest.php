<?php

require_once dirname(__FILE__) . "/_fixtures/WikiaSuperFactoryTestClass.php";

/**
 * @ingroup mwabstract
 */
class WikiaSuperFactoryTest extends PHPUnit_Framework_TestCase {

	const TEST_ID = 12345;
	const TEST_TYPE = '-x-TestType-x-';
	const TEST_DEFAULT_TYPE = '-x-TestDefaultType-x-';
	const TEST_BAR = '-x-TestBar-x-';
	const TEST_HELLO_WORLD = 'Hell0W0rld!';

	protected function setUp() {
		//WikiaSuperFactory::addClassConstructor('WikiaSuperFactoryTestClass');
		WikiaSuperFactory::addClassConstructor('WikiaSuperFactoryTestClass', array( 'type' => self::TEST_DEFAULT_TYPE), 'newFromTypeAndBar');
	}

	protected function tearDown() {
		WikiaSuperFactory::reset('WikiaSuperFactoryTestClass');
	}

	public function testBuildWithDefaultConstructor() {
		// call default constructor with all params set
		/* @var $object WikiaSuperFactoryTestClass */
		$object = WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array( 'type' => self::TEST_TYPE, 'id' => self::TEST_ID));

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', $object);
		$this->assertEquals(self::TEST_ID, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertNull($object->bar);

		// call default constructor with default id
		$object = WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array( 'type' => self::TEST_TYPE ));

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertNull($object->bar);
	}

	public function testBuildWithFactoryConstructor() {
		// call factory constructor with all params set
		/* @var $object WikiaSuperFactoryTestClass */
		$object = WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array( 'type' => self::TEST_TYPE, 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);

		// call factory constructor without all params, so defaults should be passed
		$object = WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array( 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_DEFAULT_TYPE, $object->type);
		$this->assertEquals(self::TEST_BAR, $object->bar);

		// call factory constructor that isn't configured in factory
		$object= WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array( 'type' => self::TEST_TYPE ), 'newFromType');

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', $object);
		$this->assertEquals(0, $object->id);
		$this->assertEquals(self::TEST_TYPE, $object->type);
	}

	public function testSettingInstance() {
		$id = 12345;
		$type = '01010101';
		$bar = 'barbarbar';

		$objectObjA = new WikiaSuperFactoryTestClass($type, $id);
		$objectObjA->setBar($bar);

		WikiaSuperFactory::reset('WikiaSuperFactoryTestClass');
		WikiaSuperFactory::setInstance('WikiaSuperFactoryTestClass', $objectObjA);

		$objectObjB = WikiaSuperFactory::build('WikiaSuperFactoryTestClass');

		$this->assertEquals($objectObjA, $objectObjB);

		//re-instantiate
		$objectObjC = new WikiaSuperFactoryTestClass('reinstantiate', 5);

		WikiaSuperFactory::setInstance('WikiaSuperFactoryTestClass', $objectObjC);

		$this->assertEquals($objectObjC, WikiaSuperFactory::build('WikiaSuperFactoryTestClass'));
	}

	public function testUnknownConstructorCall() {
		$this->setExpectedException('WikiaException');
		WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array(), 'nonExistentFactoryMethod');
	}

	public function testAddingConstructorWithInstancePredefined() {
		WikiaSuperFactory::reset('WikiaSuperFactoryTestClass');
		WikiaSuperFactory::setInstance('WikiaSuperFactoryTestClass', new WikiaSuperFactoryTestClass(1));

		$this->setExpectedException('WikiaException');
		WikiaSuperFactory::addClassConstructor('WikiaSuperFactoryTestClass');
	}

	public function testNoArgsConstructor() {
		$bar = WikiaSuperFactory::build('WikiaSuperFactoryTestClass2'); /* @var $bar WikiaSuperFactoryTestClass2 */
		$this->assertEquals(self::TEST_HELLO_WORLD, $bar->helloWorld());
	}

	public function testUnsettingInstanceDoesNotResetConstructors() {
		$object = new WikiaSuperFactoryTestClass('reinstantiate', 5);
		WikiaSuperFactory::setInstance('WikiaSuperFactoryTestClass', $object);

		$this->assertEquals($object, WikiaSuperFactory::build('WikiaSuperFactoryTestClass'));

		WikiaSuperFactory::unsetInstance('WikiaSuperFactoryTestClass');

		$this->assertInstanceOf('WikiaSuperFactoryTestClass', WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array(1)));
		$this->assertInstanceOf('WikiaSuperFactoryTestClass', WikiaSuperFactory::build('WikiaSuperFactoryTestClass', array(1, 2), 'newFromTypeAndBar'));

		WikiaSuperFactory::reset('WikiaSuperFactoryTestClass');
	}
}
