<?php

namespace Wikia\Service\User\ExternalAuth;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use User;

class FacebookServiceTest extends TestCase {
	const TOKEN = 'wikia123';
	const TEST_USER_ID = 123;

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookApi|PHPUnit_Framework_MockObject_MockObject $apiMock */
	private $apiMock;

	/** @var ExternalAuthApiFactory|PHPUnit_Framework_MockObject_MockObject $apiFactoryMock */
	private $apiFactoryMock;

	/** @var FacebookService $facebookService */
	private $facebookService;

	protected function setUp() {
		parent::setUp();
		$this->userMock = $this->createMock( User::class );
		$this->apiMock = $this->createMock( FacebookApi::class );
		$this->apiFactoryMock = $this->createMock( ExternalAuthApiFactory::class );

		$this->userMock->expects( $this->any() )
			->method( 'getId' )
			->willReturn( static::TEST_USER_ID );

		$this->apiFactoryMock->expects( $this->any() )
			->method( 'getFacebookApi' )
			->willReturn( $this->apiMock );

		$this->facebookService = new FacebookService( $this->apiFactoryMock );
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
