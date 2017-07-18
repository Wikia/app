<?php

use PHPUnit\Framework\TestCase;
use Swagger\Client\ApiException;
use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;

class FacebookPreferencesModuleServiceTest extends TestCase {
	/** @var int $userId */
	private $userId = 1563;

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookApi|PHPUnit_Framework_MockObject_MockObject $apiMock */
	private $apiMock;

	/** @var FacebookApiFactory|PHPUnit_Framework_MockObject_MockObject $facebookApiFactoryMock */
	private $facebookApiFactoryMock;

	/** @var WikiaResponse $response */
	private $response;

	/** @var FacebookPreferencesModuleService $facebookPreferencesModule */
	private $facebookPreferencesModule;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->apiMock = $this->createMock( FacebookApi::class );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$context = new RequestContext();
		$context->setUser( $this->userMock );

		$this->facebookApiFactoryMock = $this->createMock( FacebookApiFactory::class );
		$this->facebookApiFactoryMock->expects( $this->any() )
			->method( 'getApi' )
			->willReturn( $this->apiMock );

		$this->facebookPreferencesModule = new FacebookPreferencesModuleService();
		$this->facebookPreferencesModule->setContext( $context );
		$this->facebookPreferencesModule->setResponse( $this->response );

		$reflApi = new ReflectionProperty( FacebookPreferencesModuleService::class, 'facebookApiFactory' );
		$reflApi->setAccessible( true );
		$reflApi->setValue( $this->facebookPreferencesModule, $this->facebookApiFactoryMock );
	}

	public function testRendersConnectedTemplateIfUserHasLinkedFacebookAccount() {
		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $this->userId );

		$this->apiMock->expects( $this->once() )
			->method( 'me' )
			->willReturn( new LinkedFacebookAccount() );

		$this->facebookPreferencesModule->renderFacebookPreferences();

		$this->assertStringEndsWith(
		'linked.php',
			$this->response->getView()->getTemplatePath()
		);
	}

	public function testRendersDisconnectedTemplateIfUserDoesNotHaveLinkedFacebookAccount() {
		$this->userMock->expects( $this->once() )
			->method( 'getId' )
			->willReturn( $this->userId );

		$this->apiMock->expects( $this->once() )
			->method( 'me' )
			->willThrowException( new ApiException() );

		$this->facebookPreferencesModule->renderFacebookPreferences();

		$this->assertStringEndsWith(
			'connected.php',
			$this->response->getView()->getTemplatePath()
		);
	}
}
