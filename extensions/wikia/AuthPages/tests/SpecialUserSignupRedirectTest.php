<?php

class SpecialUserSignupRedirectTest extends AbstractAuthPageRedirectTest {

	protected function getTestSubject(): SpecialPage {
		return new SpecialUserSignupRedirect();
	}

	public function testRedirectToSignupPage() {
		$this->setupRequest( [] );

		$this->specialPage->execute();

		$this->assertStringStartsWith( '/register', $this->requestContext->getOutput()->getRedirect() );
	}
}
