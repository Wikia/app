<?php

use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use Wikia\Service\User\ExternalAuth\FacebookService;

class AuthPreferencesModuleServiceTest extends TestCase {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookService|PHPUnit_Framework_MockObject_MockObject $facebookServiceMock */
	private $facebookServiceMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var AuthPreferencesModuleService $authPreferencesModule */
	private $authPreferencesModule;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->facebookServiceMock = $this->createMock( FacebookService::class );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$context = new RequestContext();
		$context->setUser( $this->userMock );

		$this->authPreferencesModule = new AuthPreferencesModuleService();
		$this->authPreferencesModule->setContext( $context );
		$this->authPreferencesModule->setResponse( $this->response );

		$reflService = new ReflectionProperty( AuthPreferencesModuleService::class, 'facebookService' );
		$reflService->setAccessible( true );
		$reflService->setValue( $this->authPreferencesModule, $this->facebookServiceMock );
	}

	public function testRendersConnectedTemplateIfUserHasLinkedFacebookAccount() {
		$this->facebookServiceMock->expects( $this->once() )
			->method( 'getExternalIdentity' )
			->with( $this->userMock )
			->willReturn( new LinkedFacebookAccount() );

		$this->authPreferencesModule->renderAuthPreferences();

		$this->assertEquals( 'linked', $this->response->getVal( 'state' ) );
	}

	public function testRendersDisconnectedTemplateIfUserDoesNotHaveLinkedFacebookAccount() {
		$this->facebookServiceMock->expects( $this->once() )
			->method( 'getExternalIdentity' )
			->with( $this->userMock )
			->willThrowException( new ApiException() );

		$this->authPreferencesModule->renderAuthPreferences();

		$this->assertEquals( 'disconnected', $this->response->getVal( 'state' ) );
	}
}
