<?php

/**
 * @group Integration
 */
class WikiFounderIpControllerTest extends WikiaDatabaseTest {
	const WIKI_ID = 2;

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var WikiFounderIpController $wikiFounderIpController */
	private $wikiFounderIpController;

	protected function setUp() {
		parent::setUp();
		$dbw = WikiFactory::db( DB_SLAVE );

		$dbw->insert( "city_list", [
				"city_id" => self::WIKI_ID,
				"city_url" => "http://test.wikia.com",
				"city_sitename" => "wikdia",
				"city_vertical" => 5,
				"city_cluster" => "c1",
				"city_dbname" => "unittests",
				"city_founding_ip_bin" => inet_pton( "149.6.28.163" ),
			], __METHOD__ );

		$this->requestContext = new RequestContext();
		$this->wikiFounderIpController = new WikiFounderIpController();
		$this->wikiFounderIpController->setContext( $this->requestContext );
		$this->wikiFounderIpController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_JSON ) );
	}

	public function testPostRequestIsRejected() {
		$this->expectException( MethodNotAllowedException::class );

		$fauxRequest = new FauxRequest( [ 'id' => static::WIKI_ID ], true );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->wikiFounderIpController->init();
		$this->wikiFounderIpController->getIp();
	}

	public function testWikiIdIsRequired() {
		$fauxRequest = new FauxRequest( [] );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->wikiFounderIpController->init();
		$this->wikiFounderIpController->getIp();

		$this->assertEquals( 400, $this->wikiFounderIpController->getResponse()->getCode() );
	}

	public function testInternalHeaderAbsence() {
		$this->expectException( ForbiddenException::class );

		$this->requestContext->setRequest( new FauxRequest( [ 'wikiId' => static::WIKI_ID ] ) );

		$this->wikiFounderIpController->init();
	}

	public function testGetWikiIp() {
		$fauxRequest = new FauxRequest( [ 'wikiId' => static::WIKI_ID ] );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$wikiId = $fauxRequest->getVal( 'wikiId' );
		self::assertThat( $wikiId, self::equalTo( static::WIKI_ID ) );

		$this->wikiFounderIpController->init();
		$this->wikiFounderIpController->getIp();

		$this->assertEquals( WikiaResponse::FORMAT_JSON,
			$this->wikiFounderIpController->getResponse()->getFormat() );
		$this->assertEquals( 200, $this->wikiFounderIpController->getResponse()->getCode() );
		$this->assertEquals( "149.6.28.163",
			$this->wikiFounderIpController->getResponse()->getVal( "wikiIp" ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/ip.yaml' );
	}
}
