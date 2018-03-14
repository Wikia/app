<?php

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use PHPUnit\Framework\TestCase;
use Wikia\Factory\ServiceFactory;
use Wikia\Tracer\WikiaTracer;

/**
 * @group Integration
 */
class TemplateClassificationServiceIntegrationTest extends TestCase {
	use HttpIntegrationTest;

	/** @var int $wikiId */
	private $wikiId = 123;

	/** @var int $pageId */
	private $pageId = 456;

	/** @var TemplateClassificationService $templateClassificationService */
	private $templateClassificationService;

	protected function setUp() {
		parent::setUp();

		ServiceFactory::clearState();

		ServiceFactory::instance()->providerFactory()->setUrlProvider( $this->getMockUrlProvider() );

		$this->templateClassificationService = new TemplateClassificationService();
	}

	public function testGetType() {
		$theRequest = A::getRequest()
			->andUrl( Is::equalTo( "/{$this->wikiId}/{$this->pageId}" ) )
			->andHeader( WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, Is::equalTo( WikiaTracer::INTERNAL_REQUEST_HEADER_VALUE ) );

		$exp = Phiremock::on( $theRequest )->thenRespond( 200, '{ "type": "infobox" }' );

		$this->getMockServer()->createExpectation( $exp );

		$type = $this->templateClassificationService->getType( $this->wikiId, $this->pageId );

		$this->assertEquals( 'infobox', $type );
	}

	public function testGetDetails() {
		$theRequest = A::getRequest()
			->andUrl( Is::equalTo( "/{$this->wikiId}/{$this->pageId}/providers" ) )
			->andHeader( WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, Is::equalTo( WikiaTracer::INTERNAL_REQUEST_HEADER_VALUE ) );

		$exp = Phiremock::on( $theRequest )->thenRespond( 200, file_get_contents( __DIR__ . '/_fixtures/tcs_details_response.json' ) );

		$this->getMockServer()->createExpectation( $exp );

		$details = $this->templateClassificationService->getDetails( $this->wikiId, $this->pageId );

		$this->assertEquals( 'auto_type_matcher', $details['auto_type_matcher']['provider'] );
		$this->assertEquals( '1.0', $details['auto_type_matcher']['origin'] );
		$this->assertEquals( [ 'infobox' ], $details['auto_type_matcher']['types'] );

		$this->assertEquals( 'user', $details['user']['provider'] );
		$this->assertEquals( '826221', $details['user']['origin'] );
		$this->assertEquals( [ 'infobox' ], $details['user']['types'] );
	}

	public function testGetTemplatesOnWiki() {
		$theRequest = A::getRequest()
			->andUrl( Is::equalTo( "/{$this->wikiId}" ) )
			->andHeader( WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, Is::equalTo( WikiaTracer::INTERNAL_REQUEST_HEADER_VALUE ) );

		$exp = Phiremock::on( $theRequest )->thenRespond( 200, file_get_contents( __DIR__ . '/_fixtures/tcs_templates_response.json' ) );

		$this->getMockServer()->createExpectation( $exp );

		$templates = $this->templateClassificationService->getTemplatesOnWiki( $this->wikiId );

		$this->assertEquals( 'infobox', $templates[5] );
		$this->assertEquals( 'navbox', $templates[6] );
	}

	public function testDeleteTemplateInformation() {
		$theRequest = A::deleteRequest()
			->andUrl( Is::equalTo( "/{$this->wikiId}/{$this->pageId}" ) )
			->andHeader( WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, Is::equalTo( WikiaTracer::INTERNAL_REQUEST_HEADER_VALUE ) );

		$exp = Phiremock::on( $theRequest )->thenRespond( 202, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->templateClassificationService->deleteTemplateInformation( $this->wikiId, $this->pageId );

		$this->assertEquals( 1, $this->getMockServer()->countExecutions( $theRequest ) );
	}

	public function testDeleteTemplateInformationForWiki() {
		$theRequest = A::deleteRequest()
			->andUrl( Is::equalTo( "/{$this->wikiId}" ) )
			->andHeader( WikiaTracer::INTERNAL_REQUEST_HEADER_NAME, Is::equalTo( WikiaTracer::INTERNAL_REQUEST_HEADER_VALUE ) );

		$exp = Phiremock::on( $theRequest )->thenRespond( 202, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->templateClassificationService->deleteTemplateInformationForWiki( $this->wikiId);

		$this->assertEquals( 1, $this->getMockServer()->countExecutions( $theRequest ) );
	}

	protected function tearDown() {
		parent::tearDown();

		$this->getMockServer()->clearExpectations();
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();

		ServiceFactory::clearState();
	}
}
