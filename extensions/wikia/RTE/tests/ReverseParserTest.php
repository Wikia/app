<?php
class ReverseParserTest extends WikiaBaseTest {

	/* @var RTEReverseParser */
	private $reverseParser;

	function setUp() {
		$this->setupFile = __DIR__ . "/..//RTE_setup.php";
		parent::setUp();

		$this->reverseParser = new RTEReverseParser();
	}

	function testHeading2() {
		$in = '<h2>123</h2>';
		$out = "==123==";

		$this->assertEquals(
			$out,
			$this->reverseParser->parse( $in ) );
	}
}
