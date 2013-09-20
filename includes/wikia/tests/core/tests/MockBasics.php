<?php

abstract class MockBasics extends WikiaBaseTest {

	public function testConstructorMock() {
	}

}

class MockBasicsTarget {

	public static $staticValue = null;

	public $constructorCalled = false;
	public $callValue = null;
	public $id = null;

	public function __construct() {
		$this->constructorCalled = true;
	}

	public function regularMethod( $value ) {
		$this->callValue = $value;
	}

	public function staticMethod( $value ) {
		self::$staticValue = $value;
	}

	public static function newFromSomething( $id ) {
		$obj = new self;
		$obj->id = $id;
		return $obj;
	}

}