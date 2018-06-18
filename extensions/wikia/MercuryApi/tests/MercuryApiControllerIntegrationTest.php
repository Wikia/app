<?php

/**
 * @group Integration
 */
class MercuryApiControllerIntegrationTest extends WikiaDatabaseTest {

	const PAGE_WITH_COMMENTS_ID = 1;
	const PAGE_WITH_BROKEN_COMMENT_ID = 4;

	public function testLoadArticleComments() {
		$response = F::app()->sendExternalRequest(
			MercuryApiController::class,
			'getArticleComments',
			[ 'id' => static::PAGE_WITH_COMMENTS_ID ]
		);

		$data = $response->getData();

		$this->assertEquals( WikiaResponse::FORMAT_JSON, $response->getFormat() );
		$this->assertEquals( 1, $data['pagesCount'] );

		$this->assertArrayHasKey( 'TesztJózsef', $data['payload']['users'] );
		$this->assertArrayHasKey( 'TesztBéla', $data['payload']['users'] );

		$this->assertCount( 2, $data['payload']['comments'] );

		$this->assertEquals( 'TesztBéla', $data['payload']['comments'][0]['userName'] );
		$this->assertEquals( 'TesztJózsef', $data['payload']['comments'][1]['userName'] );

		$this->assertEquals( 3, $data['payload']['comments'][0]['id'] );
		$this->assertEquals( 2, $data['payload']['comments'][1]['id'] );
	}

	public function testCommentsWithMissingDataAreExcluded() {
		$response = F::app()->sendExternalRequest(
			MercuryApiController::class,
			'getArticleComments',
			[ 'id' => static::PAGE_WITH_BROKEN_COMMENT_ID ]
		);

		$data = $response->getData();

		$this->assertEquals( WikiaResponse::FORMAT_JSON, $response->getFormat() );
		$this->assertEquals( 1, $data['pagesCount'] );

		$this->assertCount( 1, $data['payload']['comments'] );

		foreach ( $data['payload']['comments'] as $comment ) {
			$this->assertNotNull( $comment );
		}
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__  . '/fixtures/mercury_api_controller_integration.yaml');
	}
}
