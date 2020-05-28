<?php

use PHPUnit\Framework\TestCase;

class RecommendationTileApiControllerTest extends TestCase
{
	protected function setUp()
	{
		parent::setUp();
		require_once __DIR__ . '/../WikisApiController.class.php';
		require_once __DIR__ . '/../RecommendationTileApiController.class.php';
	}

	private function getTestImageIds() {
		$ids = [1, 2];
		$images = [];

		foreach ( $ids as $id ) {
			$images[$id] = [[
				'url' => 'image_url_' . $id
			]];
		}

		return $images;
	}

	private function getArticleTitles() {
		foreach ( [1, 8] as $id ) {
			$t = new Title();
			$t->mNamespace = 0;
			$t->mArticleID = $id;
			$t->mUrlform = 'article_url';
			$t->mTextform = 'title_' . $id;
			yield $t;
		}
	}

	public function testRecommendationTileShouldReturnTheSameNumberOfValuesAsRequested()
	{
		// mocks
		$imageServingStub = $this->getMockBuilder( ImageServing::class )->setMethods( ['getImages'] )->getMock();
		$imageServingStub->method( 'getImages' )->willReturn( $this->getTestImageIds() );

		// object under test
		$objectUnderTest = $this
			->getMockBuilder( RecommendationTileApiController::class )
			->setMethods( ['getImageServing', 'getArticleProperties', 'getWikiId', 'getWikiName', 'getFeaturedVideos'] )
			->getMock();
		$objectUnderTest->method( 'getImageServing' )->willReturn( $imageServingStub );
		$objectUnderTest->method( 'getArticleProperties' )->willReturn( $this->getArticleTitles() );
		$objectUnderTest->method( 'getWikiId' )->willReturn( 123 );
		$objectUnderTest->method( 'getWikiName' )->willReturn( 'test_wiki_name' );
		$objectUnderTest->method( 'getFeaturedVideos' )->willReturnOnConsecutiveCalls( '123', '' );

		// given
		$requestedIds = '1,8';

		$request = new WikiaRequest( [
			WikisApiController::PARAMETER_WIKI_IDS => $requestedIds
		] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );

		$objectUnderTest->setRequest( $request );
		$objectUnderTest->setResponse( $response );

		// when
		$objectUnderTest->getDetails();

		// then
		$responseItems = $response->getVal( 'items' );
		$responseItems = (array)$responseItems;

		$first = $responseItems['123_1'];
		$this->assertEquals( 'title 1', $first['title'] );
		$this->assertEquals( 'test_wiki_name', $first['wikiName'] );
		$this->assertEquals( 'image_url_1', $first['thumbnail'] );
		$this->assertEquals( true, $first['hasVideo'] );

		$second = $responseItems['123_8'];
		$this->assertEquals( 'title 8', $second['title'] );
		$this->assertEquals( 'test_wiki_name', $second['wikiName'] );
		$this->assertEquals( null, $second['thumbnail'] );
		$this->assertEquals( false, $second['hasVideo'] );
	}
}
