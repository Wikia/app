<?php

namespace Wikia\Helios;
use Wikia\Service\User\Auth;
use Wikia\Helios\HelperController;

include_once( __DIR__ . '/HelperControllerWrapper.php' );

class HelperControllerTest extends \WikiaBaseTest {

	private $wikiaRequestMock;
	private $secret = "TheSchwartzSecret";
	private $controller;
	private $username = "Someone";

	public function setUp()
	{
		$this->setupFile =  __DIR__ . '/../Helios.setup.php';
		$this->wikiaRequestMock = $this->getMock( '\WikiaRequest', [ 'getVal' ], [], '', false );
		$this->wikiaResponseMock = $this->getMock( '\WikiaResponse', [ 'setVal', 'setCode' ], [], '', false );
		$this->mockGlobalVariable( 'wgTheSchwartzSecretToken', $this->secret );

		$this->controller = new HelperControllerWrapper();
		$this->controller->setRequest( $this->wikiaRequestMock );
		$this->controller->setResponse( $this->wikiaResponseMock );

		$this->authService = $this->getMock( '\Wikia\Service\User\Auth\AuthService', ['isUsernameBlocked'], [] );
		$this->controller->setAuthService( $this->authService );

		parent::setUp();
	}

	public function testAuthenticateAuthenticationFailed() {
		$this->wikiaRequestMock->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( HelperController::SCHWARTZ_PARAM )
			->willReturn( "foo" );
		$this->wikiaRequestMock->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( HelperController::EXTERNAL_SCHWARTZ_PARAM )
			->willReturn( "foo" );

		$this->wikiaResponseMock->expects( $this->at( 0 ) )
			->method( 'setVal' )
			->with( 'message', 'invalid secret' );
		$this->wikiaResponseMock->expects( $this->at( 1 ) )
			->method( 'setCode' )
			->with( \WikiaResponse::RESPONSE_CODE_FORBIDDEN );

		$this->assertFalse( $this->controller->authenticateViaTheSchwartz() );
	}

	public function testAuthenticateAuthenticationSuccess() {
		$this->wikiaRequestMock->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( HelperController::SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( HelperController::EXTERNAL_SCHWARTZ_PARAM )
			->willReturn( "wrong" );

		$this->wikiaResponseMock->expects( $this->never() )
			->method( 'setVal' );

		$this->assertTrue( $this->controller->authenticateViaTheSchwartz() );
	}


	public function testIsUserBlockedYes() {
		$this->wikiaRequestMock->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( HelperController::SCHWARTZ_PARAM )
			->willReturn( "wrong" );
		$this->wikiaRequestMock->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( HelperController::EXTERNAL_SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'username' )
			->willReturn( $this->username );

		$this->authService->expects( $this->once() )
			->method( 'isUsernameBlocked' )
			->with( $this->username )
			->willReturn( true );

		$this->controller->isBlocked();
		$this->assertEquals( true, $this->controller->getResponse()->getVal( 'blocked' ) );
	}

	public function testIsUserBlockedNo() {
		$this->wikiaRequestMock->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( HelperController::SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( HelperController::EXTERNAL_SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'username' )
			->willReturn( $this->username );

		$this->authService->expects( $this->once() )
			->method( 'isUsernameBlocked' )
			->with( $this->username )
			->willReturn( false );

		$this->controller->isBlocked();
		$this->assertEquals( false, $this->controller->getResponse()->getVal( 'blocked' ) );
	}

	public function testIsBlockedNotFound() {
		$this->wikiaRequestMock->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( HelperController::SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( HelperController::EXTERNAL_SCHWARTZ_PARAM )
			->willReturn( $this->secret );
		$this->wikiaRequestMock->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'username' )
			->willReturn( $this->username );

		$this->authService->expects( $this->once() )
			->method( 'isUsernameBlocked' )
			->with( $this->username )
			->willReturn( null );

		$this->wikiaResponseMock->expects( $this->once() )
			->method( 'setVal' )
			->with( 'message', 'user not found' );
		$this->wikiaResponseMock->expects( $this->once() )
			->method( 'setCode' )
			->with( \WikiaResponse::RESPONSE_CODE_NOT_FOUND );

		$this->controller->isBlocked();
	}
}
