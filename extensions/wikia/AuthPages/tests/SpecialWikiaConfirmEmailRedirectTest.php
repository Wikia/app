<?php

use PHPUnit\Framework\TestCase;

class SpecialWikiaConfirmEmailRedirectTest extends TestCase {
	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var SpecialWikiaConfirmEmailRedirect $specialWikiaConfirmEmailRedirect */
	private $specialWikiaConfirmEmailRedirect;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->specialWikiaConfirmEmailRedirect = new SpecialWikiaConfirmEmailRedirect();

		$this->specialWikiaConfirmEmailRedirect->setContext( $this->requestContext );
	}

	public function testRedirectToConfirmEmailPageUsingTokenFromParam() {
		$this->setupRequest( [] );

		$this->specialWikiaConfirmEmailRedirect->execute( 'abc' );

		$this->assertStringStartsWith(
			'/confirm-email?token=abc',
			$this->requestContext->getOutput()->getRedirect()
		);
	}

	public function testRedirectToConfirmEmailPageUsingTokenFromRequest() {
		$this->setupRequest( [ 'code' => 'abc'] );

		$this->specialWikiaConfirmEmailRedirect->execute();

		$this->assertStringStartsWith(
			'/confirm-email?token=abc',
			$this->requestContext->getOutput()->getRedirect()
		);
	}

	public function testTokenFromRequestOverridesTokenFromParam() {
		$this->setupRequest( [ 'code' => 'def' ] );

		$this->specialWikiaConfirmEmailRedirect->execute( 'abc' );

		$this->assertStringStartsWith(
			'/confirm-email?token=def',
			$this->requestContext->getOutput()->getRedirect()
		);
	}

	/**
	 * @dataProvider provideBenignPages
	 * @param string $goodTarget
	 */
	public function testReturnsToValidPages( string $goodTarget ) {
		$this->setupRequest( [ 'returnto' => $goodTarget ] );

		$this->specialWikiaConfirmEmailRedirect->execute();

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

		$this->specialWikiaConfirmEmailRedirect->execute( 'abc' );

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
