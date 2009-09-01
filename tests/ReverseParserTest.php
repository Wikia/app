<?php

class ReverseParserTest extends PHPUnit_Framework_TestCase {
	var $reverseParser;

	function setUp() {
		global $IP;
		require_once("$IP/extensions/wikia/Wysiwyg/ReverseParser.php");

		$this->reverseParser = new ReverseParser();
	}

	function testHeading2() {
		$in = '<h2>123</h2>';
		$out = "== 123 ==\n";

		$this->assertEquals(
			$out,
			$this->reverseParser->parse( $in ) );
	}
}
