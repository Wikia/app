<?php

/**
 * @group Integration
 */
class MarkWikiAsClosedControllerTest extends WikiaDatabaseTest {
	const CITY_ID = 1;
	const REASON = 'test';

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var MarkWikiAsClosedController $markWikiAsClosedController */
	private $markWikiAsClosedController;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();

		$this->markWikiAsClosedController = new MarkWikiAsClosedController();
		$this->markWikiAsClosedController->setContext( $this->requestContext );
		$this->markWikiAsClosedController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_INVALID ) );
	}

	public function testGetRequestIsRejected() {
		$this->expectException( MethodNotAllowedException::class );

		$fauxRequest =
			new FauxRequest( [ 'wikiId' => static::CITY_ID, 'reason' => static::REASON ] );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->markWikiAsClosedController->init();
		$this->markWikiAsClosedController->markWikiAsClosed();
	}

	public function testWikiIdIsRequired() {
		$fauxRequest = new FauxRequest( [], true );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->markWikiAsClosedController->init();
		$this->markWikiAsClosedController->markWikiAsClosed();

		$this->assertEquals( 400, $this->markWikiAsClosedController->getResponse()->getCode() );
	}

	public function testWikiIsClosed() {
		$fauxRequest =
			new FauxRequest( [ 'wikiId' => static::CITY_ID, 'reason' => static::REASON ], true );
		$fauxRequest->setHeader( \Wikia\Tracer\WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, 1 );
		$this->requestContext->setRequest( $fauxRequest );

		$this->markWikiAsClosedController->init();
		$this->markWikiAsClosedController->markWikiAsClosed();

		$this->assertEquals( 200, $this->markWikiAsClosedController->getResponse()->getCode() );
		$this->assertEquals( WikiaResponse::FORMAT_JSON,
			$this->markWikiAsClosedController->getResponse()->getFormat() );

		$this->assertFalse( WikiFactory::isPublic( static::CITY_ID ) );
	}

	public function testWikiIsNotCloseInternalHeaderAbsence() {
		$this->expectException( ForbiddenException::class );

		$this->requestContext->setRequest( new FauxRequest( [
			'wikiId' => static::CITY_ID,
			'reason' => static::REASON,
		], true ) );

		$this->markWikiAsClosedController->init();
		$this->markWikiAsClosedController->markWikiAsClosed();

	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/mark_wiki_closed.yaml' );
	}
}