<?php
// TODO: move to /extensions/wikia/RTE/tests
class ReverseParserTest extends WikiaBaseTest {

	/* @var RTEReverseParser */
	var $reverseParser;

	function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RTE/RTE.class.php";
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
