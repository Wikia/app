<?php

namespace Wikia\Service\User\Auth;

use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;

class MediaWikiAuthServiceTest extends \WikiaBaseTest {
	private $authService;
	private $heliosClientMock;

	public function setUp() {
		parent::setUp();

		$this->heliosClientMock = $this->getMock( HeliosClient::class,
			[ 'login', 'forceLogout', 'invalidateToken', 'register', 'info', 'generateToken' , 'setPassword', 'validatePassword', 'deletePassword', 'requestPasswordReset' ] );

		$this->authService = new MediaWikiAuthService( $this->heliosClientMock );
	}

	public function testAuthenticateAuthenticationFailed() {
		$username = 'SomeName';
		$password = 'Password';

		$this->heliosClientMock->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [ \WikiaResponse::RESPONSE_CODE_OK, new \StdClass ] );

		$resultData = $this->authService->authenticate( $username, $password );
		$this->assertFalse( $resultData->success() );
	}

	public function testAuthenticateAuthenticationImpossible() {
		$username = 'SomeName';
		$password = 'Password';

		$this->heliosClientMock->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->will( $this->throwException( new ClientException( 'test' ) ) );

		$resultData = $this->authService->authenticate( $username, $password );
		$this->assertFalse( $resultData->success() );
		$this->assertTrue( $resultData->checkStatus( \WikiaResponse::RESPONSE_CODE_SERVICE_UNAVAILABLE ) );
	}

	public function testAuthenticateAuthenticationSucceded() {
		$username = 'SomeName';
		$password = 'Password';

		$loginInfo = new \StdClass;
		$loginInfo->access_token = 'orvb9pM6wX';

		$this->heliosClientMock->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [\WikiaResponse::RESPONSE_CODE_OK, $loginInfo] );

		$resultData = $this->authService->authenticate( $username, $password );
		$this->assertTrue( $resultData->success() );
	}
}
