<?php

/**
 * @group Integration
 */
class ProtectSiteSpecialControllerIntegrationTest extends WikiaDatabaseTest {

	const TEST_WIKI_ID = 123;
	const OTHER_WIKI_ID = 2;
	const VALID_TOKEN = 'test123';

	/** @var User $normalUser */
	private $normalUser;

	/** @var User $staffUser */
	private $staffUser;

	/** @var User $soapUser */
	private $soapUser;

	/** @var ProtectSiteModel $model */
	private $model;

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var WikiaResponse $response */
	private $response;

	/** @var ProtectSiteSpecialController $controller */
	private $controller;

	protected function setUp() {
		parent::setUp();
		$this->mockGlobalVariable( 'wgCityId', static::TEST_WIKI_ID );

		$this->normalUser = User::newFromName( 'NormalUser' );
		$this->staffUser = User::newFromName( 'StaffUser' );
		$this->soapUser = User::newFromName( 'SoapUser' );

		$this->model = new ProtectSiteModel();
		$this->requestContext = new RequestContext();
		$this->response = new WikiaResponse( WikiaResponse::FORMAT_INVALID );

		$this->controller = new ProtectSiteSpecialController();
		$this->controller->setContext( $this->requestContext );
		$this->controller->setResponse( $this->response );
	}

	public function testShouldRejectGetRequest() {
		$this->expectException( BadRequestException::class );
		$this->prepareRequest( [], false );

		try {
			$this->controller->saveProtectionSettings();
		} finally {
			$this->assertEquals( 0, $this->model->getProtectionSettings( static::TEST_WIKI_ID ), 'Settings should not have been set' );
		}
	}

	public function testShouldRejectPostRequestWithInvalidToken() {
		$this->expectException( BadRequestException::class );
		$this->prepareRequest( [ 'token' => 'invalid' ] );

		try {
			$this->controller->saveProtectionSettings();
		} finally {
			$this->assertEquals( 0, $this->model->getProtectionSettings( static::TEST_WIKI_ID ), 'Settings should not have been set' );
		}
	}

	public function testShouldRejectUserIfTheyHaveNoRight() {
		$this->expectException( PermissionsError::class );
		$this->prepareRequestWithToken( [] );
		$this->requestContext->setUser( $this->normalUser );

		try {
			$this->controller->saveProtectionSettings();
		} finally {
			$this->assertEquals( 0, $this->model->getProtectionSettings( static::TEST_WIKI_ID ), 'Settings should not have been set' );
		}
	}

	/**
	 * @dataProvider longTimeProvider
	 * @param string $time
	 *
	 * @throws PermissionsError
	 * @throws UserBlockedError
	 */
	public function testShouldRejectLongExpiryTimeWhenUserCannotBypassTimeRestriction( string $time ) {

		$this->prepareRequestWithToken( [ 'edit' => 1, 'create' => 1, 'expiry' => $time ] );
		$this->requestContext->setUser( $this->soapUser );

		$result = $this->controller->saveProtectionSettings();

		$this->assertFalse( $result );
		$this->assertEquals( 0, $this->model->getProtectionSettings( static::TEST_WIKI_ID ), 'Settings should not have been set' );
	}

	public function longTimeProvider() {
		yield [ '1 day' ];
		yield [ '2 weeks' ];
		yield [ '3 years' ];
	}

	/**
	 * @dataProvider paramsProvider
	 * @param array $params
	 *
	 * @throws ForbiddenException
	 * @throws PermissionsError
	 * @throws BadRequestException
	 */
	public function testShouldSuccessfullySaveSettings( array $params ) {
		$this->prepareRequestWithToken( $params );
		$this->requestContext->setUser( $this->staffUser );

		$this->controller->saveProtectionSettings();

		$settings = $this->model->getProtectionSettings( static::TEST_WIKI_ID );

		foreach ( ProtectSiteModel::getValidActions() as $action ) {
			$value = ProtectSiteModel::isActionFlagSet( $settings, $action );
			if ( isset( $params[$action] ) ) {
				$this->assertTrue( $value, "Expected action '$action' to be blocked'" );
			} else {
				$this->assertFalse( $value, "Expected action '$action' to not be blocked'" );
			}
		}

		$anonsOnly = ProtectSiteModel::isPreventAnonsOnlyFlagSet( $settings );

		if ( isset( $params['prevent_anons_only'] ) ) {
			$this->assertTrue( $anonsOnly, 'Expected anons-only flag to be set' );
		} else {
			$this->assertFalse( $anonsOnly, 'Expected anons-only flag to not be set' );
		}

		$this->assertEquals( 303, $this->response->getCode(), 'Response should be a redirect' );
	}

	public function paramsProvider() {
		yield [ [ 'edit' => 1, 'create' => 1, 'expiry' => '3 hours', ], ];
		yield [ [ 'edit' => 1, 'create' => 1, 'upload' => 1, 'move' => 1, 'expiry' => '1 day', ], ];
		yield [ [ 'edit' => 1, 'create' => 1, 'upload' => 1, 'move' => 1, 'prevent_anons_only' => 1, 'expiry' => '10 minutes', ], ];
		yield [ [ 'move' => 1, 'prevent_anons_only' => 1, 'expiry' => '30 seconds', ], ];
		yield [ [ 'edit' => 1, 'create' => 1, 'expiry' => '1 week', ], ];
		yield [ [ 'edit' => 1, 'create' => 1, 'expiry' => '3 months', ], ];
	}

	public function testShouldRemoveProtection() {
		$this->mockGlobalVariable( 'wgCityId', static::OTHER_WIKI_ID );
		$this->prepareRequestWithToken( [] );
		$this->requestContext->setUser( $this->staffUser );

		$this->controller->saveProtectionSettings();

		$settings = $this->model->getProtectionSettings( static::TEST_WIKI_ID );

		$this->assertEquals( 0, $settings, 'Protection should be removed' );
	}

	private function prepareRequestWithToken( array $params, bool $wasPosted = true ) {
		$this->prepareRequest( $params + [ 'token' => md5( static::VALID_TOKEN ) . EDIT_TOKEN_SUFFIX ], $wasPosted );
	}

	private function prepareRequest( array $params, bool $wasPosted = true ) {
		$request = new FauxRequest( $params, $wasPosted );
		$request->setSessionData( 'wsEditToken', static::VALID_TOKEN );
		$this->requestContext->setRequest( $request );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/protect_site_shared.yaml' );
	}
}
