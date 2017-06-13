<?php

use Wikia\CreateNewWiki\RequestValidator;
use Wikia\CreateNewWiki\UserValidator;
use Wikia\CreateNewWiki\ValidationException;
use Wikia\DependencyInjection\Injector;
use Wikia\DependencyInjection\InjectorBuilder;

class CreateNewWikiValidationTest extends WikiaBaseTest {
	/** @var Injector $injector */
	private static $injector;

	/** @var WikiaRequest|PHPUnit_Framework_MockObject_MockObject $wikiaRequestMock */
	private $wikiaRequestMock;

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var WebRequest|PHPUnit_Framework_MockObject_MockObject $webRequestMock */
	private $webRequestMock;

	/** @var UserValidator|PHPUnit_Framework_MockObject_MockObject $userValidatorMock */
	private $userValidatorMock;

	/** @var RequestValidator|PHPUnit_Framework_MockObject_MockObject $requestValidatorMock */
	private $requestValidatorMock;

	/** @var ValidationException|PHPUnit_Framework_MockObject_MockObject $validationExceptionMock */
	private $validationExceptionMock;

	/** @var WikiaResponse $wikiaResponse */
	private $wikiaResponse;

	/** @var CreateNewWikiController $createNewWikiController */
	private $createNewWikiController;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$injector = Injector::getInjector();
	}

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->userValidatorMock = $this->createMock( UserValidator::class );
		$this->requestValidatorMock = $this->createMock( RequestValidator::class );

		$injector = ( new InjectorBuilder() )
			->bind( UserValidator::class )->to( $this->userValidatorMock )
			->bind( RequestValidator::class )->to( $this->requestValidatorMock )
			->build();

		Injector::setInjector( $injector );

		$this->validationExceptionMock = $this->getMockBuilder( ValidationException::class )
			->setMethods( [
				'getHttpStatusCode',
				'getHeaderMessageKey',
				'getErrorMessageKey',
				'getHeaderMessageParams',
				'getErrorMessageParams',
			] )
			->getMockForAbstractClass();

		$this->wikiaRequestMock = $this->createMock( WikiaRequest::class );
		$this->wikiaResponse = new WikiaResponse( WikiaResponse::FORMAT_JSON, $this->wikiaRequestMock );

		$this->userMock = $this->createMock( User::class );
		$this->webRequestMock = $this->createMock( WebRequest::class );

		// Stub out messaging completely
		$messageMock = $this->createMock( Message::class );
		$messageMock->expects( $this->any() )
			->method( $this->anything() )
			->willReturnSelf();

		/** @var RequestContext|PHPUnit_Framework_MockObject_MockObject $contextMock */
		$contextMock = $this->getMockBuilder( RequestContext::class )
			->setMethods( [ 'msg' ] )
			->getMock();

		$contextMock->expects( $this->any() )
			->method( 'msg' )
			->willReturn( $messageMock );

		$contextMock->setUser( $this->userMock );
		$contextMock->setRequest( $this->webRequestMock );

		$this->createNewWikiController = new CreateNewWikiController();
		$this->createNewWikiController->setRequest( $this->wikiaRequestMock );
		$this->createNewWikiController->setResponse( $this->wikiaResponse );
		$this->createNewWikiController->setContext( $contextMock );
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionCode 400
	 * @expectedExceptionMessage Bad request
	 */
	public function testMustBePostedWithCorrectEditToken() {
		$this->wikiaRequestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' )
			->willThrowException( new BadRequestException() );

		$this->createNewWikiController->CreateWiki();
	}

	/**
	 * Test that CreateNewWikiController applies all required validation constraints to the request.
	 *
	 * @dataProvider provideRequestValidationConstraints
	 * @param string $validationConstraintMethod
	 */
	public function testRequestIsValidated( string $validationConstraintMethod ) {
		$this->wikiaRequestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHttpStatusCode' )
			->willReturn( 400 );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHeaderMessageKey' )
			->willReturn( '' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getErrorMessageKey' )
			->willReturn( '' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHeaderMessageParams' )
			->willReturn( [] );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getErrorMessageParams' )
			->willReturn( [] );

		$this->requestValidatorMock->expects( $this->once() )
			->method( $validationConstraintMethod )
			->with( $this->webRequestMock )
			->willThrowException( $this->validationExceptionMock);

		$this->createNewWikiController->CreateWiki();

		$response = $this->wikiaResponse->getData();

		$this->assertEquals(
			CreateNewWikiController::STATUS_ERROR,
			$response[CreateNewWikiController::STATUS_FIELD]
		);

		$this->assertEquals(
			400,
			$this->wikiaResponse->getCode()
		);
	}

	public function provideRequestValidationConstraints() {
		return [
			'params must be valid' => [ 'assertValidParams' ],
			'must not be from Tor node' => [ 'assertNotTorNode' ],
		];
	}

	/**
	 * Test that CreateNewWikiController applies all required validation constraints to the user.
	 *
	 * @dataProvider provideUserValidationConstraints
	 * @param string $validationConstraintMethod
	 */
	public function testUserIsValidated( string $validationConstraintMethod ) {
		$this->wikiaRequestMock->expects( $this->once() )
			->method( 'assertValidWriteRequest' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHttpStatusCode' )
			->willReturn( 400 );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHeaderMessageKey' )
			->willReturn( '' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getErrorMessageKey' )
			->willReturn( '' );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getHeaderMessageParams' )
			->willReturn( [] );

		$this->validationExceptionMock->expects( $this->once() )
			->method( 'getErrorMessageParams' )
			->willReturn( [] );

		$this->userValidatorMock->expects( $this->once() )
			->method( $validationConstraintMethod )
			->with( $this->userMock )
			->willThrowException( $this->validationExceptionMock);

		$this->createNewWikiController->CreateWiki();

		$response = $this->wikiaResponse->getData();

		$this->assertEquals(
			CreateNewWikiController::STATUS_ERROR,
			$response[CreateNewWikiController::STATUS_FIELD]
		);

		$this->assertEquals(
			400,
			$this->wikiaResponse->getCode()
		);
	}

	public function provideUserValidationConstraints() {
		return [
			'must be logged in' => [ 'assertLoggedIn' ],
			'must be email confirmed' => [ 'assertEmailConfirmed' ],
			'must not be blocked' => [ 'assertNotBlocked' ],
			'must not be rate limited' => [ 'assertNotExceededRateLimit' ],
		];
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		Injector::setInjector( static::$injector );
	}
}
