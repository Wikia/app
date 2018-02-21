<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Service\Helios\HeliosClient;

class UserPasswordTest extends WikiaBaseTest {

	const TEST_USER_ID = 4;

	/** @var User */
	private $testUser;

	private $heliosClientMock;

	public function setUp() {
		parent::setUp();
		$this->setupAndInjectServiceMocks();

		$this->testUser = User::newFromId( self::TEST_USER_ID );
	}

	private function setupAndInjectServiceMocks() {
		$this->heliosClientMock = $this->createMock( HeliosClient::class );

		ServiceFactory::instance()->heliosFactory()->setHeliosClient( $this->heliosClientMock );
	}

	public function testSetPassword() {
		$response = new StdClass();
		$response->success = true;

		$this->heliosClientMock->expects( $this->once() )
			->method( 'setPassword' )
			->willReturn( $response );

		$this->assertTrue( $this->testUser->setPassword( 'goodpassword123' ) );
	}

	/**
	 * @expectedException PasswordError
	 */
	public function testSetPasswordError() {
		$error = new StdClass();
		$error->description = 'passwordtooshort';
		$response = new StdClass();
		$response->errors = [ $error ];

		$mockMessage =
			$this->getMockBuilder( 'Message' )
				->disableOriginalConstructor()
				->setMethods( [ 'text' ] )
				->getMock();
		$mockMessage->expects( $this->once() )->method( 'text' )->willReturn( '' );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->once() )
			->method( 'wfMessage' )
			->with( 'passwordtooshort' )
			->willReturn( $mockMessage );

		$this->heliosClientMock->expects( $this->once() )
			->method( 'setPassword' )
			->willReturn( $response );

		$this->testUser->setPassword( '' );
	}

	public function testSetPasswordDeletePassword() {
		$response = new StdClass();
		$response->success = true;

		$this->heliosClientMock->expects( $this->never() )->method( 'setPassword' );

		$this->heliosClientMock->expects( $this->once() )
			->method( 'deletePassword' )
			->willReturn( $response );

		$this->assertTrue( $this->testUser->setPassword( null ) );
	}

	/**
	 * @expectedException PasswordError
	 */
	public function testSetPasswordDeletePasswordError() {
		$error = new StdClass();
		$error->description = 'server_error';
		$response = new StdClass();
		$response->errors = [ $error ];

		$mockMessage =
			$this->getMockBuilder( 'Message' )
				->disableOriginalConstructor()
				->setMethods( [ 'text' ] )
				->getMock();
		$mockMessage->expects( $this->once() )->method( 'text' )->willReturn( '' );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->once() )
			->method( 'wfMessage' )
			->with( $error->description )
			->willReturn( $mockMessage );

		$this->heliosClientMock->expects( $this->never() )->method( 'setPassword' );

		$this->heliosClientMock->expects( $this->once() )
			->method( 'deletePassword' )
			->willReturn( $response );

		$this->testUser->setPassword( null );
	}

	/**
	 * @expectedException PasswordError
	 */
	public function testSetPasswordDeletePasswordUnknownError() {
		$mockMessage =
			$this->getMockBuilder( 'Message' )
				->disableOriginalConstructor()
				->setMethods( [ 'text' ] )
				->getMock();
		$mockMessage->expects( $this->once() )->method( 'text' )->willReturn( '' );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->once() )
			->method( 'wfMessage' )
			->with( 'externaldberror' )
			->willReturn( $mockMessage );

		$this->heliosClientMock->expects( $this->never() )->method( 'setPassword' );

		$this->heliosClientMock->expects( $this->once() )
			->method( 'deletePassword' )
			->willReturn( null );

		$this->testUser->setPassword( null );
	}

	public function testGetPasswordValidity() {
		$response = new StdClass();
		$response->success = true;

		$this->heliosClientMock->expects( $this->once() )
			->method( 'validatePassword' )
			->willReturn( $response );

		$this->assertTrue( $this->testUser->getPasswordValidity( 'abc' ) );
	}

	public function testGetPasswordValidityOneError() {
		$error = new StdClass();
		$error->description = 'passwordtooshort';
		$response = new StdClass();
		$response->errors = [ $error ];

		$this->heliosClientMock->expects( $this->once() )
			->method( 'validatePassword' )
			->willReturn( $response );

		$this->assertEquals( 'passwordtooshort', $this->testUser->getPasswordValidity( '' ) );
	}

	public function testGetPasswordValidityMultipleErrors() {
		$error = new StdClass();
		$error->description = 'passwordtooshort';
		$errorTwo = new StdClass();
		$errorTwo->description = 'password-name-match';
		$response = new StdClass();
		$response->errors = [ $error, $errorTwo ];

		$this->heliosClientMock->expects( $this->once() )
			->method( 'validatePassword' )
			->willReturn( $response );

		$this->assertEquals( [ 'passwordtooshort', 'password-name-match' ],
			$this->testUser->getPasswordValidity( 'foo' ) );
	}

	public function testGetPasswordValidityUnknownError() {
		$this->heliosClientMock->expects( $this->once() )
			->method( 'validatePassword' )
			->willReturn( null );

		$this->assertEquals( 'unknown-error', $this->testUser->getPasswordValidity( 'abc' ) );
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();

		ServiceFactory::clearState();
	}
}
