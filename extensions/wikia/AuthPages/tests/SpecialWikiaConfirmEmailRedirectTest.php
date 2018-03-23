<?php

class SpecialWikiaConfirmEmailRedirectTest extends AbstractAuthPageRedirectTest {

	protected function getTestSubject(): SpecialPage {
		return new SpecialWikiaConfirmEmailRedirect();
	}

	public function testRedirectToConfirmEmailPageUsingTokenFromParam() {
		$this->setupRequest( [] );

		$this->specialPage->execute( 'abc' );

		$this->assertStringStartsWith(
			'/confirm-email?token=abc',
			$this->requestContext->getOutput()->getRedirect()
		);
	}

	public function testRedirectToConfirmEmailPageUsingTokenFromRequest() {
		$this->setupRequest( [ 'code' => 'abc'] );

		$this->specialPage->execute();

		$this->assertStringStartsWith(
			'/confirm-email?token=abc',
			$this->requestContext->getOutput()->getRedirect()
		);
	}

	public function testTokenFromRequestOverridesTokenFromParam() {
		$this->setupRequest( [ 'code' => 'def' ] );

		$this->specialPage->execute( 'abc' );

		$this->assertStringStartsWith(
			'/confirm-email?token=def',
			$this->requestContext->getOutput()->getRedirect()
		);
	}
}
