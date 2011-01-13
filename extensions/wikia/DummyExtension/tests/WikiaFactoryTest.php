<?php

require_once( dirname(__FILE__) . "/../includes/WikiaFactory.class.php");

class Foo {
	public $id = null;
	public $type = null;
	public $bar = null;

	public function __construct($type, $id = 0)	{
		$this->id = $id;
		$this->type = $type;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function setBar($value) {
		$this->bar = $value;
	}

	public static function newFromTypeAndBar($type, $bar) {
		$object = new Foo($type);
		$object->bar = $bar;
		return $object;
	}
}


/**
 * @group all
 * @group core
 */
class WikiaFactoryTest	extends PHPUnit_Framework_TestCase {

	const TEST_ID = 12345;
	const TEST_TYPE = '-x-TestType-x-';
	const TEST_DEFAULT_TYPE = '-x-TestDefaultType-x-';
	const TEST_BAR = '-x-TestBar-x-';

	protected function setUp() {
		WikiaFactory::addClassConstructor('Foo');
		WikiaFactory::addClassConstructor('Foo', array( 'type' => self::TEST_DEFAULT_TYPE), 'newFromTypeAndBar');
	}

	protected function tearDown() {
		WikiaFactory::reset('Foo');
		WikiaFactory::reset(); // just for making code coverage report all green ;)
	}

	public function testBuildWithDefaultConstructor() {
		// call default constructor with all params set
		$foo = WikiaFactory::build('Foo', array( 'type' => self::TEST_TYPE, 'id' => self::TEST_ID));

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(self::TEST_ID, $foo->id);
		$this->assertEquals(self::TEST_TYPE, $foo->type);
		$this->assertNull($foo->bar);

		// call default constructor with default id
		$foo = WikiaFactory::build('Foo', array( 'type' => self::TEST_TYPE ));

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(0, $foo->id);
		$this->assertEquals(self::TEST_TYPE, $foo->type);
		$this->assertNull($foo->bar);
	}

	public function testBuildWithFactoryConstructor() {
		// call factory constructor with all params set
		$foo = WikiaFactory::build('Foo', array( 'type' => self::TEST_TYPE, 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(0, $foo->id);
		$this->assertEquals(self::TEST_TYPE, $foo->type);
		$this->assertEquals(self::TEST_BAR, $foo->bar);

		// call factory constructor without all params, so defaults should be passed
		$foo = WikiaFactory::build('Foo', array( 'bar' => self::TEST_BAR), 'newFromTypeAndBar');

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(0, $foo->id);
		$this->assertEquals(self::TEST_DEFAULT_TYPE, $foo->type);
		$this->assertEquals(self::TEST_BAR, $foo->bar);
	}

	public function testBuildWithClassSetters() {
		WikiaFactory::setClassSetters('Foo', array( 'setId' => self::TEST_ID, 'setBar' => self::TEST_BAR ));

		$foo = WikiaFactory::build('Foo', array( self::TEST_TYPE ));

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(self::TEST_ID, $foo->id);
		$this->assertEquals(self::TEST_TYPE, $foo->type);
		$this->assertEquals(self::TEST_BAR, $foo->bar);

		$foo = 	WikiaFactory::build('Foo', array( 'type' => self::TEST_TYPE, 'bar' => 'anotherBarToOverride'), 'newFromTypeAndBar');

		$this->assertInstanceOf('Foo', $foo);
		$this->assertEquals(self::TEST_ID, $foo->id);
		$this->assertEquals(self::TEST_TYPE, $foo->type);
		$this->assertEquals(self::TEST_BAR, $foo->bar);
	}

	public function testSettingInstance() {
		$id = 12345;
		$type = '01010101';
		$bar = 'barbarbar';

		$fooObjA = new Foo($type, $id);
		$fooObjA->setBar($bar);

		WikiaFactory::reset('Foo');
		WikiaFactory::setInstance('Foo', $fooObjA);

		$fooObjB = WikiaFactory::build('Foo');

		$this->assertEquals($fooObjA, $fooObjB);

		//re-instantiate
		$fooObjC = new Foo('reinstantiate', 5);

		WikiaFactory::setInstance('Foo', $fooObjC);

		$this->assertEquals($fooObjC, WikiaFactory::build('Foo'));
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testUnknownConstructorCall() {
		$foo = WikiaFactory::build('Foo', array(), 'nonExistentFactoryMethod');
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testSettingInstanceWithConstructorDefined() {
		WikiaFactory::setInstance('Foo', new Foo(1));
	}

	public function testAddingConstructorWithInstancePredefined() {
		WikiaFactory::reset('Foo');
		WikiaFactory::setInstance('Foo', new Foo(1));

		$this->setExpectedException('WikiaException');

		WikiaFactory::addClassConstructor('Foo');
	}
}
