<?php

class ReverseParserTest extends WikiaBaseTest {
	var $reverseParser;

	function setUp() {
		global $wgAutoloadClasses;
		require_once($wgAutoloadClasses['RTE']);
		require_once($wgAutoloadClasses['RTEReverseParser']);

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