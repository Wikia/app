<?php

namespace Wikia\Service\User\ExternalAuth;

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Swagger\Client\ExternalAuth\Api\FacebookApi;
use User;
use Wikia\Factory\ServiceFactory;
use Wikia\Service\Constants;

/**
 * @group Integration
 */
class FacebookServiceIntegrationTest extends TestCase {
	use \HttpIntegrationTest;

	private $token = 'wikia123';
	private $testUserId = '123';

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var FacebookApi|PHPUnit_Framework_MockObject_MockObject $apiMock */
	private $apiMock;

	/** @var FacebookService $facebookService */
	private $facebookService;

	protected function setUp() {
		parent::setUp();
		$this->userMock = $this->createMock( User::class );
		$this->apiMock = $this->createMock( FacebookApi::class );

		$this->userMock->expects( $this->any() )
			->method( 'getId' )
			->willReturn( $this->testUserId );

		$serviceFactory = new ServiceFactory();
		$serviceFactory->providerFactory()->setUrlProvider( $this->getMockUrlProvider() );

		$this->facebookService = $serviceFactory->externalAuthFactory()->facebookService();
	}

	public function testUnlinkAccountUsesWikiaUserId() {
		$unlinkRequest =
			A::deleteRequest()
				->andUrl( Is::equalTo( "/facebook/users/{$this->testUserId}" ) )
				->andHeader( Constants::HELIOS_AUTH_HEADER, Is::equalTo( $this->testUserId ) );

		$exp = Phiremock::on( $unlinkRequest )->thenRespond( 204, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->facebookService->unlinkAccount( $this->userMock );

		$this->assertEquals( 1, $this->getMockServer()->countExecutions( $unlinkRequest ) );
	}

	public function testLinkAccountUsesWikiaUserIdAndFacebookToken() {
		$linkRequest =
			A::postRequest()
				->andUrl( Is::equalTo( "/facebook/users/{$this->testUserId}" ) )
				->andHeader( Constants::HELIOS_AUTH_HEADER, Is::equalTo( $this->testUserId ) )
				->andBody( Is::containing( $this->token ) );

		$exp = Phiremock::on( $linkRequest )->thenRespond( 204, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->facebookService->linkAccount( $this->userMock, $this->token );

		$this->assertEquals( 1, $this->getMockServer()->countExecutions( $linkRequest ) );
	}

	public function testGetExternalIdentityUsesWikiaUserId() {
		$exp =
			Phiremock::on( A::getRequest()
				->andUrl( Is::equalTo( "/facebook/me" ) )
				->andHeader( Constants::HELIOS_AUTH_HEADER, Is::equalTo( $this->testUserId ) ) )
				->thenRespond( 200, json_encode( [
					'wikiaUserId' => $this->testUserId,
					'facebookUserId' => '456',
					'facebookAppId' => '789',
				] ) );

		$this->getMockServer()->createExpectation( $exp );

		$linkedFacebookAccount = $this->facebookService->getExternalIdentity( $this->userMock );

		$this->assertEquals( $this->testUserId, $linkedFacebookAccount->getWikiaUserId() );
		$this->assertEquals( '456', $linkedFacebookAccount->getFacebookUserId() );
		$this->assertEquals( '789', $linkedFacebookAccount->getFacebookAppId() );
	}

	protected function tearDown() {
		parent::tearDown();

		$this->getMockServer()->clearExpectations();
	}
}
