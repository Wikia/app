<?php

class SpecialUserLoginRedirectTest extends AbstractAuthPageRedirectTest {
	
	protected function getTestSubject(): SpecialPage {
		return new SpecialUserLoginRedirect();
	}

	/**
	 * @dataProvider provideForgotPasswordTypes
	 * @param string $forgotPasswordType
	 */
	public function testRedirectToForgotPasswordPageWhenTypeGiven( string $forgotPasswordType ) {
		$this->setupRequest( [ 'type' => $forgotPasswordType ] );

		$this->specialPage->execute();

		$this->assertStringStartsWith( '/forgot-password', $this->requestContext->getOutput()->getRedirect() );
	}

	public function provideForgotPasswordTypes() {
		yield [ 'forgotPassword' ];
		yield [ 'forgotpassword' ];
		yield [ 'ForgotPassword' ];
	}

	public function testRedirectToLoginPageWhenTypeNotGiven() {
		$this->setupRequest( [] );

		$this->specialPage->execute();

		$this->assertStringStartsWith( '/signin', $this->requestContext->getOutput()->getRedirect() );
	}
}
