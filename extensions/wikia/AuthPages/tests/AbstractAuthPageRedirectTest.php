<?php

use PHPUnit\Framework\TestCase;

abstract class AbstractAuthPageRedirectTest extends TestCase {

	/** @var RequestContext $requestContext */
	protected $requestContext;

	/** @var SpecialPage $specialPage */
	protected $specialPage;
	
	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->specialPage = $this->getTestSubject();

		$this->specialPage->setContext( $this->requestContext );
	}

	abstract protected function getTestSubject(): SpecialPage;

	/**
	 * @dataProvider provideBenignPages
	 * @param string $goodTarget
	 */
	public function testReturnsToValidPages( string $goodTarget ) {
		$this->setupRequest( [ 'returnto' => $goodTarget ] );

		$this->specialPage->execute();

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

		$this->specialPage->execute();

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

	protected function setupRequest( array $params ) {
		$this->requestContext->setRequest( new FauxRequest( $params ) );
	}
}
