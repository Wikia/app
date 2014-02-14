<?php

class SassUtilTest extends WikiaBaseTest {

	/**
	 * @group UsingDB
	 */
	function testSassUtil() {
		$sassParams = SassUtil::getSassParams();

		$this->assertInternalType('string', $sassParams);
		$this->assertRegExp('/&color-page=%23[A-F0-9]{6}&/i', $sassParams);
	}

}
