<?php

class SassUtilTest extends PHPUnit_Framework_TestCase {

	function testSassUtil() {
		$sassParams = SassUtil::getSassParams();

		// we're assuming that this wiki uses default theme
		$this->assertType('string', $sassParams);
		$this->assertRegExp('/&color-page=%23FFFFFF&/', $sassParams);
		$this->assertFalse(SassUtil::isThemeDark());
	}

}

?>