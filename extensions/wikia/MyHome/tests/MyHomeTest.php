<?php
class MyHomeTest extends WikiaBaseTest {

	function setUp() {
		$this->setupFile = __DIR__ . "/../MyHome.php";
		parent::setUp();
	}

	function testPackData() {
		$in = array('foo' => 'bar');
		$out = MyHome::CUSTOM_DATA_PREFIX . '{"foo":"bar"}';

		$this->assertEquals(
			$out,
			MyHome::packData($in)
		);
	}

	function testUnpackData() {
		$in = MyHome::CUSTOM_DATA_PREFIX . '{"foo":"bar"}';
		$out = array('foo' => 'bar');

		$this->assertEquals(
			$out,
			MyHome::unpackData($in)
		);
	}
}
