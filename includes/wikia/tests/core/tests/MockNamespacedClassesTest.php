<?php

namespace {

	class FakeMockNamespacedClass {}

	class MockNamespacedClassesTest extends WikiaBaseTest {

		/**
		 * @group UsingDB
		 */
		public function testConstructorMocks() {
			$this->mockClass( 'WikiaMockTest', FakeMockNamespacedClass::class );
			$this->mockClass( 'WikiaConstructorClassTest\WikiaMockTest', FakeMockNamespacedClass::class );

			$this->assertInstanceOf('FakeMockNamespacedClass', new WikiaMockTest(),'class from main namespace');
			$this->assertInstanceOf('FakeMockNamespacedClass', new \WikiaMockTest(),'class from main namespace (with \\ at the beginning)');
			$this->assertInstanceOf('FakeMockNamespacedClass', new WikiaConstructorClassTest\WikiaMockTest(),'class from other namespace');
			$this->assertInstanceOf('FakeMockNamespacedClass', new \WikiaConstructorClassTest\WikiaMockTest(),'class from other namespace (with \\ at the beginning)');
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05653 ms
		 */
		public function testStaticMethodMocks() {
			$fakeObject = new stdClass;

			$this->getStaticMethodMock('WikiaMockTest','newFromSomething')
				->expects($this->any())
				->method('newFromSomething')
				->will($this->returnValue($fakeObject));

			$this->getStaticMethodMock('WikiaConstructorClassTest\WikiaMockTest','newFromSomething')
				->expects($this->any())
				->method('newFromSomething')
				->will($this->returnValue($fakeObject));

			$this->assertSame($fakeObject,WikiaMockTest::newFromSomething(),'class from main namespace');
			$this->assertSame($fakeObject,\WikiaMockTest::newFromSomething(),'class from main namespace (with \\ at the beginning)');
			$this->assertSame($fakeObject,WikiaConstructorClassTest\WikiaMockTest::newFromSomething(),'class from other namespace');
			$this->assertSame($fakeObject,\WikiaConstructorClassTest\WikiaMockTest::newFromSomething(),'class from other namespace (with \\ at the beginning)');

		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05473 ms
		 */
		public function testRegularMethodMocks() {
			$fakeObject = new stdClass;

			$this->getMethodMock('WikiaMockTest','returnSomething')
				->expects($this->any())
				->method('returnSomething')
				->will($this->returnValue($fakeObject));

			$this->getMethodMock('WikiaConstructorClassTest\WikiaMockTest','returnSomething')
				->expects($this->any())
				->method('returnSomething')
				->will($this->returnValue($fakeObject));

			$obj = new WikiaMockTest();
			$this->assertSame($fakeObject,$obj->returnSomething(),'class from main namespace');
			$obj = new WikiaConstructorClassTest\WikiaMockTest();
			$this->assertSame($fakeObject,$obj->returnSomething(),'class from other namespace (with \\ at the beginning)');
			$this->assertSame($fakeObject,$obj->returnSomething(),'class from other namespace');

		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05636 ms
		 */
		public function testCallingFromOtherNamespace() {
			$expValue = 2;

			$this->getMethodMock("\\WikiaClassTest\\Cls","testRegular")
				->expects($this->any())
				->method("testRegular")
				->will($this->returnValue($expValue));

			$this->getStaticMethodMock("\\WikiaClassTest\\Cls","testStatic")
				->expects($this->any())
				->method("testStatic")
				->will($this->returnValue($expValue));

			$this->assertEquals($expValue,\WikiaClassTest3\callRegular(),'call regular method from another namespace using alias');
			$this->assertEquals($expValue,\WikiaClassTest3\callRegular(),'call static method from another namespace using alias');
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05362 ms
		 */
		public function testCallingFromOtherNamespaceWithAlias() {
			$expValue = 2;

			$this->getMethodMock("\\WikiaClassTest\\Cls","testRegular")
				->expects($this->any())
				->method("testRegular")
				->will($this->returnValue($expValue));

			$this->getStaticMethodMock("\\WikiaClassTest\\Cls","testStatic")
				->expects($this->any())
				->method("testStatic")
				->will($this->returnValue($expValue));

			$this->assertEquals($expValue,\WikiaClassTest3\callRegular(),'call regular method from another namespace using alias');
			$this->assertEquals($expValue,\WikiaClassTest3\callRegular(),'call static method from another namespace using alias');
		}



	}

}

namespace {

	class WikiaMockTest {

		public function __construct() {
		}

		public static function newFromSomething() {
			return new self;
		}

		public function returnSomething() {
			return $this;
		}
	}
}

namespace WikiaConstructorClassTest {

	class WikiaMockTest {

		public function __construct() {
		}

		public static function newFromSomething() {
			return new self;
		}

		public function returnSomething() {
			return $this;
		}
	}
}

namespace WikiaClassTest {

	class Cls {

		public function testRegular() {
			return 1;
		}

		public static function testStatic() {
			return 1;
		}
	}

}

namespace WikiaClassTest2 {

	use WikiaClassTest\Cls;

	function callRegular() {
		$a = new Cls;
		return $a->testRegular();
	}

	function callStatic() {
		return Cls::testStatic();
	}

}

namespace WikiaClassTest3 {

	use WikiaClassTest\Cls as Cls2;

	function callRegular() {
		$a = new Cls2;
		return $a->testRegular();
	}

	function callStatic() {
		return Cls2::testStatic();
	}

}
