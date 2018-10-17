<?php

/**
 * @group Integration
 */
class ProtectSiteSpecialControllerIntegrationTest extends WikiaDatabaseTest {

	const VALID_TOKEN = 'test123';

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var ProtectSiteSpecialController $controller */
	private $controller;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->controller = new ProtectSiteSpecialController();
		$this->controller->setContext( $this->requestContext );
		$this->controller->setResponse( new WikiaResponse( WikiaResponse::FORMAT_INVALID ) );
	}

	public function testShouldRejectGetRequest() {
		$this->expectException( BadRequestException::class );
		$this->createRequest( [] );

		$this->controller->saveProtectionSettings();
	}

	public function testShouldRejectPostRequestWithInvalidToken() {
		$this->expectException( BadRequestException::class );
		$this->createRequest( [ 'token' => 'invalid' ], true );

		$this->controller->saveProtectionSettings();
	}

	private function createRequestWithValidToken( array $params, bool $wasPosted = true ) {
		$this->createRequest( $params + [ 'token' => static::VALID_TOKEN ], $wasPosted );
	}

	private function createRequest( array $params, bool $wasPosted = true ) {
		$request = new FauxRequest( $params, $wasPosted );
		$request->setSessionData( 'token', static::VALID_TOKEN );
		$this->requestContext->setRequest( $request );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/protect_site_model.yaml' );
	}
}
