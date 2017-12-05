<?php

use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use Wikia\Service\User\ExternalAuth\FacebookService;

class FacebookPreferencesModuleServiceTest extends TestCase {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookService|PHPUnit_Framework_MockObject_MockObject $facebookServiceMock */
	private $facebookServiceMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var FacebookPreferencesModuleService $facebookPreferencesModule */
	private $facebookPreferencesModule;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->facebookServiceMock = $this->createMock( FacebookService::class );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$context = new RequestContext();
		$context->setUser( $this->userMock );

		$this->facebookPreferencesModule = new FacebookPreferencesModuleService();
		$this->facebookPreferencesModule->setContext( $context );
		$this->facebookPreferencesModule->setResponse( $this->response );

		$reflService = new ReflectionProperty( FacebookPreferencesModuleService::class, 'facebookService' );
		$reflService->setAccessible( true );
		$reflService->setValue( $this->facebookPreferencesModule, $this->facebookServiceMock );
	}

	public function testRendersConnectedTemplateIfUserHasLinkedFacebookAccount() {
		$this->facebookServiceMock->expects( $this->once() )
			->method( 'getExternalIdentity' )
			->with( $this->userMock )
			->willReturn( new LinkedFacebookAccount() );

		$this->facebookPreferencesModule->renderFacebookPreferences();

		$this->assertEquals( 'linked', $this->response->getVal( 'state' ) );
	}

	public function testRendersDisconnectedTemplateIfUserDoesNotHaveLinkedFacebookAccount() {
		$this->facebookServiceMock->expects( $this->once() )
			->method( 'getExternalIdentity' )
			->with( $this->userMock )
			->willThrowException( new ApiException() );

		$this->facebookPreferencesModule->renderFacebookPreferences();

		$this->assertEquals( 'disconnected', $this->response->getVal( 'state' ) );
	}
}
