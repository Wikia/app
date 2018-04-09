<?php

use PHPUnit\Framework\TestCase;

class SpecialPiggybackRedirectTest extends TestCase {

	/** @var RequestContext $requestContext */
	protected $requestContext;

	/** @var SpecialPiggybackRedirect $specialPiggybackRedirect */
	private $specialPiggybackRedirect;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->specialPiggybackRedirect = new SpecialPiggybackRedirect();

		$this->specialPiggybackRedirect->setContext( $this->requestContext );
	}

	public function testRedirectToTargetGivenAsPar() {
		$this->specialPiggybackRedirect->execute( 'my-target' );

		$this->assertStringEndsWith( 'target=my-target', $this->requestContext->getOutput()->getRedirect() );
	}

	public function testRedirectToTargetGivenAsRequestParam() {
		$this->requestContext->setRequest( new FauxRequest( [ 'target' => 'my-target' ] ) );
		$this->specialPiggybackRedirect->execute( '' );

		$this->assertStringEndsWith( 'target=my-target', $this->requestContext->getOutput()->getRedirect() );
	}

	public function testParTakesPrecedenceWhenBothParAndQueryParamGiven() {
		$this->requestContext->setRequest( new FauxRequest( [ 'target' => 'other-target' ] ) );
		$this->specialPiggybackRedirect->execute( 'my-target' );

		$this->assertStringEndsWith( 'target=my-target', $this->requestContext->getOutput()->getRedirect() );
	}
}
