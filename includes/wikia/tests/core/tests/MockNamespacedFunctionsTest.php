<?php

namespace {

	class MockNamespacedFunctionsTest extends WikiaBaseTest {

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05464 ms
		 */
		public function testFunctionNameSpec() {
			$expValue = 2;

			$this->getGlobalFunctionMock("NamespacedFunctions\\named1")
				->expects($this->any())
				->method("named1")
				->will($this->returnValue($expValue));

			$this->getGlobalFunctionMock("NamespacedFunctions\\named2")
				->expects($this->any())
				->method("named2")
				->will($this->returnValue($expValue));

			$this->assertEquals($expValue,\NamespacedFunctions\named1(),'with \\ at the beginning');
			$this->assertEquals($expValue,\NamespacedFunctions\named2(),'without \\ at the beginning');
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.05561 ms
		 */
		public function testNamespacedFunctionsMocks() {
			$expValue = 2;

			$this->getGlobalFunctionMock("NamespacedFunctions\\testFunction")
				->expects($this->any())
				->method("testFunction")
				->will($this->returnValue($expValue));

			$this->getGlobalFunctionMock("testFunction44")
				->expects($this->any())
				->method("testFunction44")
				->will($this->returnValue($expValue));

			$this->assertEquals($expValue,\NamespacedFunctions\testFunction(),'direct call');
			$this->assertEquals($expValue,\NamespacedFunctions\testFunction2(),'call unqualified function from the same namespace');
			$this->assertEquals($expValue,\NamespacedFunctions\testFunction3(),'call qualified function from the name namespace');
			$this->assertEquals($expValue,\NamespacedFunctions2\testFunction2(),'call function from another namespace');
			$this->assertEquals($expValue,\NamespacedFunctions2\testFunction4(),'call function within main namespace from other namespace');
		}

	}

}


namespace NamespacedFunctions {

	function named1() {
		return 1;
	}

	function named2() {
		return 1;
	}

	function testFunction() {
		return 1;
	}

	function testFunction2() {
		return testFunction();
	}

	function testFunction3() {
		return \NamespacedFunctions\testFunction();
	}

}

namespace NamespacedFunctions2 {

	function testFunction2() {
		return \NamespacedFunctions\testFunction();
	}

	function testFunction4() {
		return testFunction44();
	}
}

namespace {
	function testFunction44() {
		return 1;
	}
}
