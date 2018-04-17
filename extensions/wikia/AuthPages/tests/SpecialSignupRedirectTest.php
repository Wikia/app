<?php

use PHPUnit\Framework\TestCase;

class SpecialSignupRedirectTest extends TestCase {
	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var SpecialSignupRedirect $specialSignupRedirect */
	private $specialSignupRedirect;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../AuthPages.setup.php';

		$this->requestContext = new RequestContext();
		$this->specialSignupRedirect = new SpecialSignupRedirect();

		$this->specialSignupRedirect->setContext( $this->requestContext );
	}

	public function testRedirectToSignupPageWhenTypeParameterIsSignup() {
		$this->setupRequest( [ 'type' => 'signup' ] );

		$title = $this->specialSignupRedirect->getRedirect();

		$this->assertEquals( NS_SPECIAL, $title->getNamespace() );
		$this->assertEquals( 'UserSignup', $title->getText() );
	}

	public function testRedirectToLoginPageWhenNoParameterGiven() {
		$this->setupRequest( [] );

		$title = $this->specialSignupRedirect->getRedirect();

		$this->assertEquals( NS_SPECIAL, $title->getNamespace() );
		$this->assertEquals( 'UserLogin', $title->getText() );
	}
	public function testRedirectToLoginPageWhenOtherTypeParameterGiven() {
		$this->setupRequest( [ 'type' => 'karamba' ] );

		$title = $this->specialSignupRedirect->getRedirect();

		$this->assertEquals( NS_SPECIAL, $title->getNamespace() );
		$this->assertEquals( 'UserLogin', $title->getText() );
	}

	private function setupRequest( array $params ) {
		$this->requestContext->setRequest( new FauxRequest( $params ) );
	}
}
