<?php

class bla {


	static function a($hello) {
		echo $hello;
	}

	function b() {
		$a="a";
		$x=$this->$a;
		$x("hello world");
	}
}

$c=new bla();
$c->b();


?>
