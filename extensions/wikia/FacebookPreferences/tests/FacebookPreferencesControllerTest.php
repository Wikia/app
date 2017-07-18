<?php
use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Swagger\Client\ExternalAuth\Api\FacebookApi;

class FacebookPreferencesControllerTest extends TestCase {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var WikiaRequest|PHPUnit_Framework_MockObject_MockObject $requestMock */
	private $requestMock;

	/** @var FacebookApi|PHPUnit_Framework_MockObject_MockObject $apiMock */
	private $apiMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var FacebookPreferencesController $facebookPreferencesController */
	private $facebookPreferencesController;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->requestMock = $this->createMock( WikiaRequest::class );
		$this->apiMock = $this->createMock( FacebookApi::class );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$context = new RequestContext();
		$context->setUser( $this->userMock );

		$this->facebookPreferencesController = new FacebookPreferencesController();
		$this->facebookPreferencesController->setContext( $context );
		$this->facebookPreferencesController->setResponse( $this->response );

		$reflApi = new ReflectionProperty( FacebookPreferencesController::class, 'api' );
		$reflApi->setAccessible( true );
		$reflApi->setValue( $this->facebookPreferencesController, $this->apiMock );
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

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->linkAccount();
	}

	/**
	 * @expectedException WikiaHttpException
	 */
	public function testLoggedOutUserWithInvalidTokenCannotLinkAccount() {
		$this->requestMock->expects( $this->any() )
			->method( 'assertValidWriteRequest' )
			->willReturn( false );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

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

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->unlinkAccount();
	}

	/**
	 * @expectedException WikiaHttpException
	 */
	public function testLoggedOutUserWithInvalidTokenCannotUnLinkAccount() {
		$this->requestMock->expects( $this->any() )
			->method( 'assertValidWriteRequest' )
			->willReturn( false );

		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->unlinkAccount();
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionCode 400
	 */
	public function testLoggedInUserWithoutValidTokenCannotLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( false );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->linkAccount();
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionCode 400
	 */
	public function testLoggedInUserWithoutValidTokenCannotUnLinkAccount() {
		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( false );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->apiMock->expects( $this->never() )
			->method( 'unlinkAccount' );

		$this->facebookPreferencesController->unlinkAccount();
	}

	public function testLoggedInUserWithValidTokenCanUnLinkAccount() {
		$userId = 58;

		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $userId );

		$this->apiMock->expects( $this->once() )
			->method( 'unlinkAccount' )
			->with( $userId );

		$this->facebookPreferencesController->unlinkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_OK,
			$this->response->getCode()
		);
	}

	public function testServiceErrorCodeIsReturnedToClientWhenUnlinkFails() {
		$userId = 58;
		$apiException = new ApiException( 'error', WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );

		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $userId );

		$this->apiMock->expects( $this->once() )
			->method( 'unlinkAccount' )
			->willThrowException( $apiException );

		$this->facebookPreferencesController->unlinkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			$this->response->getCode()
		);
	}

	public function testLoggedInUserWithValidTokenCanLinkAccount() {
		$userId = 58;
		$token = 'secret';

		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->requestMock->expects( $this->once() )
			->method( 'getVal' )
			->with( 'accessToken' )
			->willReturn( $token );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $userId );

		$this->apiMock->expects( $this->once() )
			->method( 'linkAccount' )
			->with( $userId, $token );

		$this->facebookPreferencesController->unlinkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_OK,
			$this->response->getCode()
		);
	}

	public function testServiceErrorCodeIsReturnedToClientWhenLinkFails() {
		$userId = 58;
		$apiException = new ApiException( 'error', WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );

		$this->requestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $userId );

		$this->apiMock->expects( $this->once() )
			->method( 'linkAccount' )
			->willThrowException( $apiException );

		$this->facebookPreferencesController->linkAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			$this->response->getCode()
		);
	}


}
