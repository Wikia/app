<?php

class WikiaSuperFactoryTestClass {
	public $id = null;
	public $type = null;
	public $bar = null;

	public function __construct($type, $id = 0) {
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
		$object = new WikiaSuperFactoryTestClass($type);
		$object->bar = $bar;
		return $object;
	}

	public static function newFromType($type) {
		$object = new WikiaSuperFactoryTestClass($type);
		return $object;
	}
}

class WikiaSuperFactoryTestClass2 {
	public function helloWorld() {
		return WikiaSuperFactoryTest::TEST_HELLO_WORLD;
	}
}
