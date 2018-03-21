<?php

class SpecialUserLoginRedirectTest extends AbstractAuthPageRedirectTest {
	
	protected function getTestSubject(): SpecialPage {
		return new SpecialUserLoginRedirect();
	}

	/**
	 * @dataProvider provideMercuryEndpointRedirectData
	 *
	 * @param string $param
	 * @param string $expectedEndpoint
	 */
	public function testRedirectToSupportedMercuryEndpoints( string $param, string $expectedEndpoint ) {
		$this->setupRequest( [ 'type' => $param ] );

		$this->specialPage->execute();

		$this->assertStringStartsWith( $expectedEndpoint, $this->requestContext->getOutput()->getRedirect() );
	}

	public function provideMercuryEndpointRedirectData() {
		yield [ 'forgotPassword', '/forgot-password' ];
		yield [ 'forgotpassword', '/forgot-password' ];
		yield [ 'ForgotPassword', '/forgot-password' ];

		yield [ 'signup', '/signup' ];
		yield [ 'Signup', '/signup' ];
		yield [ 'signUp', '/signup' ];
	}

	public function testRedirectToLoginPageWhenTypeNotGiven() {
		$this->setupRequest( [] );

		$this->specialPage->execute();

		$this->assertStringStartsWith( '/signin', $this->requestContext->getOutput()->getRedirect() );
	}
}
