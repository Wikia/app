<?php

use PHPUnit\Framework\TestCase;

class SpecialUserSignupRedirectTest extends TestCase {
	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var SpecialUserSignupRedirect $specialUserSignupRedirect */
	private $specialUserSignupRedirect;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->specialUserSignupRedirect = new SpecialUserSignupRedirect();

		$this->specialUserSignupRedirect->setContext( $this->requestContext );
	}

	public function testRedirectToSignupPage() {
		$this->setupRequest( [] );

		$this->specialUserSignupRedirect->execute();

		$this->assertStringStartsWith( '/register', $this->requestContext->getOutput()->getRedirect() );
	}

	/**
	 * @dataProvider provideBenignPages
	 * @param string $goodTarget
	 */
	public function testReturnsToValidPages( string $goodTarget ) {
		$this->setupRequest( [ 'returnto' => $goodTarget ] );

		$this->specialUserSignupRedirect->execute();

		$params = [];
		$query = parse_url( $this->requestContext->getOutput()->getRedirect(), PHP_URL_QUERY );

		parse_str( $query, $params );

		$this->assertArrayHasKey( 'redirect', $params );
		$this->assertStringEndsWith( $goodTarget, parse_url( $params['redirect'], PHP_URL_PATH ) );
	}

	public function provideBenignPages() {
		yield [ 'Good_article' ];
		yield [ 'Special:RecentChanges' ];
		yield [ 'User:TestUser' ];
	}

	/**
	 * @dataProvider provideBlacklistedPages
	 * @param string $badTarget
	 */
	public function testDoesNotReturnToBlacklistedPages( string $badTarget ) {
		$this->setupRequest( [ 'returnto' => $badTarget ] );

		$this->specialUserSignupRedirect->execute();

		$params = [];
		$query = parse_url( $this->requestContext->getOutput()->getRedirect(), PHP_URL_QUERY );

		parse_str( $query, $params );

		$this->assertArrayHasKey( 'redirect', $params );
		$this->assertStringEndsNotWith( $badTarget, parse_url( $params['redirect'], PHP_URL_PATH ) );
	}

	public function provideBlacklistedPages() {
		yield [ 'Special:Signup' ];
		yield [ 'Special:UserLogin' ];
		yield [ 'Special:UserLogout' ];
		yield [ 'Special:UserSignup' ];
	}

	private function setupRequest( array $params ) {
		$this->requestContext->setRequest( new FauxRequest( $params ) );
	}
}
