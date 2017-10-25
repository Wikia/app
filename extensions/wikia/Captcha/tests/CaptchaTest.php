<?php
use PHPUnit\Framework\TestCase;

/**
 * Captcha test
 *
 * @category Wikia
 * @group MediaFeatures
 */
class CaptchaTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Factory/Module.class.php';
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Invalid Captcha class: BadCaptchaClass
	 */
	public function testVerifyCaptchaThrowsExceptionWhenPassedBadData() {
		\Captcha\Factory\Module::verifyCaptchaClass( 'BadCaptchaClass' );
	}

	public function testVerifyCaptchaDoesNotThrowExceptionWhenPassedGoodData() {
		$res = \Captcha\Factory\Module::verifyCaptchaClass( '\Captcha\Module\ReCaptcha' );
		$this->assertTrue( $res );

		$res = \Captcha\Factory\Module::verifyCaptchaClass( '\Captcha\Module\FancyCaptcha' );
		$this->assertTrue( $res );
	}
}
