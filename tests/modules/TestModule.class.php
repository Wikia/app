<?php

class TestModule extends Module {

	public $foo;

	public function executeIndex() {
		$this->foo = 'Foo';
	}

	public $foo2;

	public function executeIndex2($params) {
		$this->foo2 = $params['foo2'];
	}

	public $wgFoo;

	public function executeIndex3() {
	}

}

