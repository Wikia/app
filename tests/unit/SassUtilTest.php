<?php

class SassUtilTest extends PHPUnit_Framework_TestCase {

	function testSassUtil() {
		$sassParams = SassUtil::getSassParams();

		$this->assertType('string', $sassParams);
		$this->assertRegExp('/&color-page=%23[A-F0-9]{6}&/i', $sassParams);
	}

}