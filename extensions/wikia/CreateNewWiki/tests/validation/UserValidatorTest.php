<?php

use Wikia\CreateNewWiki\UserValidator;
use Wikia\CreateNewWiki\UserValidatorProxy;

class UserValidatorTest extends WikiaBaseTest {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var UserValidatorProxy|PHPUnit_Framework_MockObject_MockObject */
	private $userValidatorProxyMock;

	/** @var UserValidator $userValidator */
	private $userValidator;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->userValidatorProxyMock = $this->createMock( UserValidatorProxy::class );

		$this->userValidator = new UserValidator( $this->userValidatorProxyMock );
	}

	public function testLoggedInUserIsValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$result = $this->userValidator->assertLoggedIn( $this->userMock );

		$this->assertTrue( $result );
	}

	/**
	 * @expectedException \Wikia\CreateNewWiki\NotLoggedInException
	 */
	public function testLoggedOutUserIsNotValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->userValidator->assertLoggedIn( $this->userMock );
	}

	public function testEmailConfirmedUserIsValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isEmailConfirmed' )
			->willReturn( true );

		$result = $this->userValidator->assertEmailConfirmed( $this->userMock );

		$this->assertTrue( $result );
	}

	/**
	 * @expectedException \Wikia\CreateNewWiki\EmailNotConfirmedException
	 */
	public function testEmailNotConfirmedUserIsNotValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isEmailConfirmed' )
			->willReturn( false );

		$this->userValidator->assertEmailConfirmed( $this->userMock );
	}

	public function testNotBlockedUserIsValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( false );

		$result = $this->userValidator->assertNotBlocked( $this->userMock );

		$this->assertTrue( $result );
	}

	/**
	 * @expectedException \Wikia\CreateNewWiki\UserBlockedException
	 */
	public function testBlockedUserIsNotValid() {
		$this->userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$this->userMock->expects( $this->any() )
			->method( 'getBlock' )
			->willReturn( new Block() );

		$this->userValidator->assertNotBlocked( $this->userMock );
	}

	public function testNotRateLimitedUserIsValid() {
		$this->userValidatorProxyMock->expects( $this->once() )
			->method( 'getWikiCreationsToday' )
			->with( $this->userMock )
			->willReturn( 0 );

		$result = $this->userValidator->assertNotExceededRateLimit( $this->userMock );

		$this->assertTrue( $result );
	}

	/**
	 * @expectedException \Wikia\CreateNewWiki\RateLimitedException
	 */
	public function testRateLimitedUserIsNotValid() {
		$this->userValidatorProxyMock->expects( $this->once() )
			->method( 'getWikiCreationsToday' )
			->with( $this->userMock )
			->willReturn( 1000 );

		$this->userValidator->assertNotExceededRateLimit( $this->userMock );
	}
}
