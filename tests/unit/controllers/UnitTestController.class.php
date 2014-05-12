<?php

class UnitTestController extends WikiaController {

	public function index() {
		$this->foo = "Foo";
	}

	// This is the way to handle parameters now
	public function successWithParams() {
		$this->foo2 = $this->getVal('foo2');
	}

	// This should fail -- module legacy code
	public function failureWithParams($params) {
		$this->foo2 = isset($params['foo2']) ? $params['foo2']: null;
	}

	// "execute" functions can have params -- module legacy code only
	public function executeLegacyFunctionWithParams($params) {
		$this->foo2 = $params['foo2'];
	}

}

