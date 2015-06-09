<?php

/**
 * Captcha test
 *
 * @category Wikia
 * @group MediaFeatures
 */
class Captcha extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../Captcha.setup.php';
		parent::setUp();
	}

	public function testVerifyCaptcha() {

		// Test verifyCaptcha throws an exception when passed bad data
		try {
			\Captcha\Factory\Module::verifyCaptchaClass( 'BadCaptchaClass' );
			$this->fail( 'verifyCaptchaClass should throw exception' );
		} catch ( Exception $e ) {

		};

		// Test verifyCaptcha does not throws an exception when passed good data
		try {
			\Captcha\Factory\Module::verifyCaptchaClass( '\Captcha\Module\ReCaptcha' );
			\Captcha\Factory\Module::verifyCaptchaClass( '\Captcha\Module\FancyCaptcha' );
		} catch ( Exception $e ) {
			$this->fail( 'verifyCaptchaClass should not throw exception' );
		};
	}
}
