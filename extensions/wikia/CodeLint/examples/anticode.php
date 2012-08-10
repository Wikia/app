<?php

class Foo {

	private $field = 42;
	const VALUE = false;

	public function bar($arg) {
		return $this->field;
		$arg++;
	}

	private function priv() {
		global $foo, $bar;
		return $foo;
	}
}

// calling as static method
Foo::bar();

$obj = new Foo();

// required argument omitted
$obj->bar();

// to many arguments
$obj->bar('foo', 'bar');

// undefined constant
echo Foo::NOT_EXISTING_CONST;

// calling private method from outside the class
$obj->priv();

// typo
$obk->bar();

// missing semicolon
$foo = bar
$test = 123;
