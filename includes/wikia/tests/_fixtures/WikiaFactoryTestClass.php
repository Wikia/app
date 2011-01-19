<?php

class WikiaFactoryTestClass {
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
		$object = new WikiaFactoryTestClass($type);
		$object->bar = $bar;
		return $object;
	}
}
