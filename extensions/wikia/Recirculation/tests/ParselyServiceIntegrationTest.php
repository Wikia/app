<?php

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use PHPUnit\Framework\TestCase;

/** @group Integration */
class ParselyServiceIntegrationTest extends TestCase {
	use HttpIntegrationTest;

	const API_KEY = 'api-key';
	const API_SECRET = 'api-secret';

	/** @var ParselyService $parselyService */
	private $parselyService;

	protected function setUp() {
		parent::setUp();

		$this->parselyService = new ParselyService(
			$this->getMockServerBaseUrl(),
			static::API_KEY,
			static::API_SECRET
		);
	}

	public function testShouldReturnMaxLimitUniqueResults() {
		$limit = 10;

		$exp = $this->createParselySpecification( $limit )
			->then( Respond::withStatusCode( 200 )
				->andHeader( 'Content-Type', 'application/json' )
				->andBody( file_get_contents( __DIR__ . '/fixtures/parsely_response.json' ) )
			);

		$this->getMockServer()->createExpectation( $exp );

		$articles = $this->parselyService->getTrendingFandomArticles( $limit );

		$this->assertCount( $limit, $articles );

		$titles = [];

		foreach ( $articles as $data ) {
			$title = $data['title'];
			$this->assertNotContains( $title, $titles, "Duplicate title: $title" );

			$titles[] = $title;

			$this->assertNotEmpty( $data['thumbnail'] );
			$this->assertNotEmpty( $data['url'] );
		}
	}

	private function createParselySpecification( int $limit ) {
		$query = [
			'limit' => $limit + ParselyService::EXTRA_POSTS_TO_FETCH,
			'apikey' => static::API_KEY,
			'secret' => static::API_SECRET,
			'section' => 'articles',
			'pub_date_start' => '30d'
		];

		// force deterministic ordering of parameters, for easy testing
		ksort( $query );

		$qs = http_build_query( $query );

		return Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/analytics/posts?$qs" ) ) );
	}

	protected function tearDown() {
		parent::tearDown();
		$this->getMockServer()->clearExpectations();
	}
}
