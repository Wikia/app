<?php

/**
 * @group Integration
 */
class WikiFounderIpControllerTest extends WikiaDatabaseTest {
	const WIKI_ID = 1;

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var WikiFounderIpController $wikiFounderIpController */
	private $wikiFounderIpController;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
		$this->wikiFounderIpController = new WikiFounderIpController();
		$this->wikiFounderIpController->setContext($this->requestContext);
		$this->wikiFounderIpController->setResponse(new WikiaResponse(WikiaResponse::FORMAT_JSON));
	}

	public function testPostRequestIsRejected() {
		$this->expectException( MethodNotAllowedException::class );

		$fauxRequest =
			new FauxRequest( ['id' => static::WIKI_ID], true );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->wikiFounderIpController->init();
		$this->wikiFounderIpController->getIp();
	}

	public function testWikiIdIsRequired() {
		$fauxRequest = new FauxRequest( []);
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->wikiFounderIpController->init();
		$this->wikiFounderIpController->getIp();

		$this->assertEquals( 400, $this->wikiFounderIpController->getResponse()->getCode() );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/ip.yaml' );
	}
}