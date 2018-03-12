<?php

use PHPUnit\Framework\TestCase;

class SpecialUserLoginRedirectTest extends TestCase {
	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var SpecialUserLoginRedirect $specialUserLoginRedirect */
	private $specialUserLoginRedirect;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->specialUserLoginRedirect = new SpecialUserLoginRedirect();

		$this->specialUserLoginRedirect->setContext( $this->requestContext );
	}

	/**
	 * @dataProvider provideForgotPasswordTypes
	 * @param string $forgotPasswordType
	 */
	public function testRedirectToForgotPasswordPageWhenTypeGiven( string $forgotPasswordType ) {
		$this->setupRequest( [ 'type' => $forgotPasswordType ] );

		$this->specialUserLoginRedirect->execute();

		$this->assertStringStartsWith( '/forgot-password', $this->requestContext->getOutput()->getRedirect() );
	}

	public function provideForgotPasswordTypes() {
		yield [ 'forgotPassword' ];
		yield [ 'forgotpassword' ];
		yield [ 'ForgotPassword' ];
	}

	public function testRedirectToLoginPageWhenTypeNotGiven() {
		$this->setupRequest( [] );

		$this->specialUserLoginRedirect->execute();

		$this->assertStringStartsWith( '/signin', $this->requestContext->getOutput()->getRedirect() );
	}

	/**
	 * @dataProvider provideBenignPages
	 * @param string $goodTarget
	 */
	public function testReturnsToValidPages( string $goodTarget ) {
		$this->setupRequest( [ 'returnto' => $goodTarget ] );

		$this->specialUserLoginRedirect->execute();

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

		$this->specialUserLoginRedirect->execute();

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
