<?php
use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Wikia\Factory\ServiceFactory;
use Wikia\Service\User\ExternalAuth\FacebookService;

class AuthPreferencesControllerTest extends TestCase {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var WikiaRequest|PHPUnit_Framework_MockObject_MockObject $requestMock */
	private $requestMock;

	/** @var FacebookService|PHPUnit_Framework_MockObject_MockObject $facebookServiceMock */
	private $facebookServiceMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var AuthPreferencesController $authPreferencesController */
	private $authPreferencesController;

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

		ServiceFactory::instance()->externalAuthFactory()->setFacebookService( $this->facebookServiceMock );

		$this->authPreferencesController = new AuthPreferencesController();
		$this->authPreferencesController->setContext( $context );
		$this->authPreferencesController->setRequest( $this->requestMock );
		$this->authPreferencesController->setResponse( $this->response );
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->linkAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->linkFacebookAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->unlinkFacebookAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->unlinkFacebookAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->linkFacebookAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->unlinkFacebookAccount();
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

		$this->authPreferencesController->init();
		$this->authPreferencesController->unlinkFacebookAccount();

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

		$this->authPreferencesController->init();
		$this->authPreferencesController->unlinkFacebookAccount();

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

		$this->authPreferencesController->init();
		$this->authPreferencesController->linkFacebookAccount();

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

		$this->authPreferencesController->init();
		$this->authPreferencesController->linkFacebookAccount();

		$this->assertEquals(
			WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			$this->response->getCode()
		);
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		ServiceFactory::clearState();
	}
}
