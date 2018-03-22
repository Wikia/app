<?php

use PHPUnit\Framework\TestCase;

class AuthPagesTest extends TestCase {
	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../AuthPages.setup.php';
	}

	public function testSpecialPageRegistration() {
		$this->assertInstanceOf(
			SpecialSignupRedirect::class,
			SpecialPageFactory::getPage( 'Signup' )
		);

		$this->assertInstanceOf(
			SpecialUserLoginRedirect::class,
			SpecialPageFactory::getPage( 'UserLogin' )
		);

		$this->assertInstanceOf(
			SpecialUserSignupRedirect::class,
			SpecialPageFactory::getPage( 'UserSignup' )
		);

		$this->assertInstanceOf(
			SpecialWikiaConfirmEmailRedirect::class,
			SpecialPageFactory::getPage( 'WikiaConfirmEmail' )
		);

		$this->assertInstanceOf(
			UserLogoutSpecialController::class,
			SpecialPageFactory::getPage( 'Userlogout' )
		);
	}
}
