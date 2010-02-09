<?php

class ReverseParserTest extends PHPUnit_Framework_TestCase {
	var $reverseParser;

	function setUp() {
		global $IP;
		require_once("$IP/extensions/wikia/RTE/RTE.class.php");
		require_once("$IP/extensions/wikia/RTE/RTEReverseParser.class.php");

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
