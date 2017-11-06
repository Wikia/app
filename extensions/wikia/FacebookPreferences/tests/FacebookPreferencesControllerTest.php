<?php
use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Wikia\Service\User\ExternalAuth\FacebookService;

class FacebookPreferencesControllerTest extends TestCase {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var WikiaRequest|PHPUnit_Framework_MockObject_MockObject $requestMock */
	private $requestMock;

	/** @var FacebookService|PHPUnit_Framework_MockObject_MockObject $facebookServiceMock */
	private $facebookServiceMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var FacebookPreferencesController $facebookPreferencesController */
	private $facebookPreferencesController;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->requestMock = $this->getMockBuilder( WikiaRequest::class )
			->disableOriginalConstructor()
			->setMethods( [ 'assertValidWriteRequest' ] )
			->getMock();
		$this->facebookServiceMock = $this->createMock( FacebookService::class );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$context = new RequestContext();
		$context->setUser( $this->userMock );

		$this->facebookPreferencesController = new FacebookPreferencesController();
		$this->facebookPreferencesController->setContext( $context );
		$this->facebookPreferencesController->setRequest( $this->requestMock );
		$this->facebookPreferencesController->setResponse( $this->response );

		$reflService = new ReflectionProperty( FacebookPreferencesController::class, 'facebookService' );
		$reflService->setAccessible( true );
		$reflService->setValue( $this->facebookPreferencesController, $this->facebookServiceMock );
	}

	/**
	 * @expectedException ForbiddenException
	 * @expectedExceptionCode 403
	 */
	public function testLoggedOutUserWithValidTokenCannotLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->linkAccount();
	}

	/**
	 * @expectedException WikiaHttpException
	 */
	public function testLoggedOutUserWithInvalidTokenCannotLinkAccount() {
		$this->requestMock->expects( $this->any() )
			->method( 'assertValidWriteRequest' )
			->willThrowException( new BadRequestException() );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->linkAccount();
	}

	/**
	 * @expectedException ForbiddenException
	 * @expectedExceptionCode 403
	 */
	public function testLoggedOutUserWithValidTokenCannotUnLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->unlinkAccount();
	}

	/**
	 * @expectedException WikiaHttpException
	 */
	public function testLoggedOutUserWithInvalidTokenCannotUnLinkAccount() {
		$this->requestMock->expects( $this->any() )
			->method( 'assertValidWriteRequest' )
			->willThrowException( new BadRequestException() );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->unlinkAccount();
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionCode 400
	 */
	public function testLoggedInUserWithoutValidTokenCannotLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willThrowException( new BadRequestException() );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->linkAccount();
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionCode 400
	 */
	public function testLoggedInUserWithoutValidTokenCannotUnLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willThrowException( new BadRequestException() );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->unlinkAccount();
	}

	public function testLoggedInUserWithValidTokenCanUnLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->once() )
			->method( 'unlinkAccount' )
			->with( $this->userMock );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->unlinkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_OK,
			$this->response->getCode()
		);
	}

	public function testServiceErrorCodeIsReturnedToClientWhenUnlinkFails() {
		$apiException = new ApiException( 'error', WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );

		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->once() )
			->method( 'unlinkAccount' )
			->with( $this->userMock )
			->willThrowException( $apiException );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->unlinkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			$this->response->getCode()
		);
	}

	public function testLoggedInUserWithValidTokenCanLinkAccount() {
		$token = 'secret';

		$this->requestMock->setVal( 'accessToken', $token );
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->once() )
			->method( 'linkAccount' )
			->with( $this->userMock, $token );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->linkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_CREATED,
			$this->response->getCode()
		);
	}

	public function testServiceErrorCodeIsReturnedToClientWhenLinkFails() {
		$apiException = new ApiException( 'error', WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		$token = 'secret';

		$this->requestMock->setVal( 'accessToken', $token );
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->facebookServiceMock->expects( $this->once() )
			->method( 'linkAccount' )
			->with( $this->userMock, $token )
			->willThrowException( $apiException );

		$this->facebookPreferencesController->init();
		$this->facebookPreferencesController->linkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			$this->response->getCode()
		);
	}
}
