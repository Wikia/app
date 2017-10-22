<?php

use PHPUnit\Framework\TestCase;
use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;

class FacebookServiceTest extends TestCase {
	const TOKEN = 'wikia123';
	const TEST_USER_ID = 123;

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookApi|PHPUnit_Framework_MockObject_MockObject $apiMock */
	private $apiMock;

	/** @var FacebookApiFactory|PHPUnit_Framework_MockObject_MockObject $facebookApiFactoryMock */
	private $facebookApiFactoryMock;

	/** @var FacebookService $facebookService */
	private $facebookService;

	protected function setUp() {
		parent::setUp();
		$this->userMock = $this->createMock( User::class );
		$this->apiMock = $this->createMock( FacebookApi::class );
		$this->facebookApiFactoryMock = $this->createMock( FacebookApiFactory::class );

		$this->userMock->expects( $this->any() )
			->method( 'getId' )
			->willReturn( static::TEST_USER_ID );

		$this->facebookApiFactoryMock->expects( $this->any() )
			->method( 'getApi' )
			->willReturn( $this->apiMock );

		$this->facebookService = new FacebookService( $this->facebookApiFactoryMock );
	}

	public function testUnlinkAccountUsesWikiaUserId() {
		$this->apiMock->expects( $this->once() )
			->method( 'unlinkAccount' )
			->with( static::TEST_USER_ID );

		$this->facebookService->unlinkAccount( $this->userMock);
	}

	public function testLinkAccountUsesWikiaUserIdAndFacebookToken() {
		$this->apiMock->expects( $this->once() )
			->method( 'linkAccount' )
			->with( static::TEST_USER_ID, static::TOKEN );

		$this->facebookService->linkAccount( $this->userMock, static::TOKEN );
	}

	public function testGetExternalIdentityUsesWikiaUserId() {
		$this->apiMock->expects( $this->once() )
			->method( 'me' )
			->willReturn( new LinkedFacebookAccount() );

		$this->facebookService->getExternalIdentity( $this->userMock);
	}
}
