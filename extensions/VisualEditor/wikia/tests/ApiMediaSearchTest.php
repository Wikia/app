<?php
require_once __DIR__ . '/../ApiMediaSearch.php';

class ApiMediaSearchTest extends WikiaBaseTest {

	protected function setupMock( $methods = null ) {
		return $this->getMockBuilder( 'ApiMediaSearch' )
		               ->disableOriginalConstructor()
		               ->setMethods( $methods )
		               ->getMock();
	}

	/* Tests */

	public function testQuery() {
		$mockSearch = $this->setupMock();

		$this->assertEquals( 'cockroach', $mockSearch->getQuery( ['query' => 'cockroach'] ) );
	}

	public function testBatch() {
		$mockSearch = $this->setupMock();

		$this->assertEquals( 1, $mockSearch->getBatch( ['batch' => 1] ) );
		$this->assertNotEquals( 1, $mockSearch->getBatch( ['batch' => 10] ) );
	}

	public function testLimit() {
		$mockSearch = $this->setupMock();

		$this->assertEquals( 50, $mockSearch->getLimit( ['limit' => 50] ) );
		$this->assertNotEquals( 50, $mockSearch->getLimit( ['limit' => 100] ) );
	}

	public function testMixed() {
		$mockSearch = $this->setupMock();

		$this->assertTrue( $mockSearch->getMixed( ['mixed' => 'true'] ) );
		$this->assertFalse( $mockSearch->getMixed( ['mixed' => 'false'] ) );
	}

	public function testVideo() {
		$mockSearch = $this->setupMock();

		$this->assertTrue( $mockSearch->getVideo( ['type' => 'video'] ) );
		$this->assertTrue( $mockSearch->getVideo( ['type' => 'image|video|donkey'] ) );
		$this->assertFalse( $mockSearch->getVideo( ['type' => 'image|donkey'] ) );
	}

	public function testimage() {
		$mockSearch = $this->setupMock();

		$this->assertTrue( $mockSearch->getimage( ['type' => 'image'] ) );
		$this->assertTrue( $mockSearch->getimage( ['type' => 'image|video|donkey'] ) );
		$this->assertFalse( $mockSearch->getimage( ['type' => 'video|donkey'] ) );
	}

	public function testGetResultsVideo() {
		$query = 'cool';
		$limit = 50;
		$batch = 1;
		$video = true;
		$image = false;
		$mixed = false;

		$getSearchResults = [
			"total" => 1,
			"batches" => 1,
			"currentBatch" => 1,
			"next" => 50,
			"items" => [
				[ "title" => "File:Cool video" ]
			]
		];

		$expectedResponse = '{"video":{"total":1,"batches":1,"currentBatch":1,"next":50,"items":[{"title":"File:Cool video"}]}}';

		$mockSearch = $this->setupMock( ['getSearchResults'] );

		$mockSearch->expects( $this->any() )
		       ->method ( 'getSearchResults' )
		       ->with   ( $query, $limit, $batch, $video, $image )
		       ->will   ( $this->returnValue( $getSearchResults ) );

		$this->assertEquals( $expectedResponse, json_encode( $mockSearch->getResults( $query, $limit, $batch, $video, $image, $mixed ) ) );
	}

	public function testGetResultsimage() {
		$query = 'cool';
		$limit = 50;
		$batch = 1;
		$video = false;
		$image = true;
		$mixed = false;

		$getSearchResults = [
			"total" => 1,
			"batches" => 1,
			"currentBatch" => 1,
			"next" => 50,
			"items" => [
				[ "title" => "File:Cool image.jpg" ]
			]
		];

		$expectedResponse = '{"image":{"total":1,"batches":1,"currentBatch":1,"next":50,"items":[{"title":"File:Cool image.jpg"}]}}';

		$mockSearch = $this->setupMock( ['getSearchResults'] );

		$mockSearch->expects( $this->any() )
		       ->method ( 'getSearchResults' )
		       ->with   ( $query, $limit, $batch, $video, $image )
		       ->will   ( $this->returnValue( $getSearchResults ) );

		$this->assertEquals( $expectedResponse, json_encode( $mockSearch->getResults( $query, $limit, $batch, $video, $image, $mixed ) ) );
	}

	public function testGetResultsimageAndVideoSeparate() {
		$query = 'cool';
		$limit = 50;
		$batch = 1;
		$video = true;
		$image = true;
		$mixed = false;

		$getSearchResultsVideo = [
			"total" => 1,
			"batches" => 1,
			"currentBatch" => 1,
			"next" => 50,
			"items" => [
				[ "title" => "File:Cool video" ]
			]
		];
		$getSearchResultsimage = [
			"total" => 1,
			"batches" => 1,
			"currentBatch" => 1,
			"next" => 50,
			"items" => [
				[ "title" => "File:Cool image.jpg" ]
			]
		];

		$expectedResponse = '{"video":{"total":1,"batches":1,"currentBatch":1,"next":50,"items":[{"title":"File:Cool video"}]},"image":{"total":1,"batches":1,"currentBatch":1,"next":50,"items":[{"title":"File:Cool image.jpg"}]}}';

		$mockSearch = $this->setupMock( ['getSearchResults'] );

		$mockSearch->expects( $this->at(0) )
		       ->method ( 'getSearchResults' )
		       ->with   ( $query, $limit, $batch, true, false )
		       ->will   ( $this->returnValue( $getSearchResultsVideo ) );

		$mockSearch->expects( $this->at(1) )
		       ->method ( 'getSearchResults' )
		       ->with   ( $query, $limit, $batch, false, true )
		       ->will   ( $this->returnValue( $getSearchResultsimage ) );

		$this->assertEquals( $expectedResponse, json_encode( $mockSearch->getResults( $query, $limit, $batch, $video, $image, $mixed ) ) );
	}

	public function testGetResultsimageAndVideoMixed() {
		$query = 'cool';
		$limit = 50;
		$batch = 1;
		$video = false;
		$image = false;
		$mixed = true;

		$getSearchResults = [
			"total" => 2,
			"batches" => 1,
			"currentBatch" => 1,
			"next" => 50,
			"items" => [
				[ "title" => "File:Cool video" ],
				[ "title" => "File:Cool image.jpg" ]
			]
		];

		$expectedResponse = '{"mixed":{"total":2,"batches":1,"currentBatch":1,"next":50,"items":[{"title":"File:Cool video"},{"title":"File:Cool image.jpg"}]}}';

		$mockSearch = $this->setupMock( ['getSearchResults'] );

		$mockSearch->expects( $this->any() )
		       ->method ( 'getSearchResults' )
		       ->with   ( $query, $limit, $batch, $video, $image )
		       ->will   ( $this->returnValue( $getSearchResults ) );

		$this->assertEquals( $expectedResponse, json_encode( $mockSearch->getResults( $query, $limit, $batch, $video, $image, $mixed ) ) );
	}

}
