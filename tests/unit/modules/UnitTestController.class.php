<?php

class UnitTestController extends WikiaController {

	public function executeIndex() {
		$this->foo = 'Foo';
	}

	public function executeIndex2($params) {
		$this->foo2 = $params['foo2'];
	}
	
}

