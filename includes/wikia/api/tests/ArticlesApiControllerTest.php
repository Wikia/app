<?php
/**
 * Created by adam
 * Date: 28.11.13
 */

class ArticlesApiControllerTest extends \WikiaBaseTest {

	/**
	 * @covers ArticlesApiController::getArticlesThumbnails
	 * @dataProvider imagesDataProvider
	 */
	public function testGetThumbnails( $articles, $data, $expected ) {
		$isMock = $this->getMockBuilder( 'ImageServing' )
			->disableOriginalConstructor()
			->setMethods( [ 'getImages' ] )
			->getMock();

		$isMock->expects( $this->any() )
			->method( 'getImages' )
			->with( 1 )
			->will( $this->returnValue( $data ) );

		$apiMock = $this->getMockBuilder( 'ArticlesApiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getImageServing' ] )
			->getMock();

		$apiMock->expects( $this->any() )
			->method( 'getImageServing' )
			->will( $this->returnValue( $isMock ) );

		$method = new ReflectionMethod( 'ArticlesApiController', 'getArticlesThumbnails' );
		$method->setAccessible( true );

		$images = $method->invoke( $apiMock, $articles );
		$this->assertEquals( $expected, $images );
	}

	/**
	 * @covers ArticlesApiController::getArticlesThumbnails
	 */
	public function testBadParamsGetThumbnails() {
		$articles = [ '1' ];
		$isMock = $this->getMockBuilder( 'ImageServing' )
			->disableOriginalConstructor()
			->setMethods( [ 'getImages' ] )
			->getMock();

		$isMock->expects( $this->any() )
			->method( 'getImages' )
			->with( 1 )
			->will( $this->returnValue( [] ) );

		$apiMock = $this->getMockBuilder( 'ArticlesApiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getImageServing' ] )
			->getMock();

		$apiMock->expects( $this->any() )
			->method( 'getImageServing' )
			->will( $this->returnValue( $isMock ) );

		$method = new ReflectionMethod( 'ArticlesApiController', 'getArticlesThumbnails' );
		$method->setAccessible( true );

		$images = $method->invoke( $apiMock, $articles, 0 );
		$this->assertEquals( [], $images );

		$images = $method->invoke( $apiMock, $articles, 0, 0 );
		$this->assertEquals( [], $images );
	}

	public function imagesDataProvider() {
		return [
			[
				[ '1' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => 1 ] ]
			],
			[
				[ '1' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ],
					[ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => 1 ] ]
			],
			[
				[ '1' ],
				[],
				[ '1' => [ 'thumbnail' => null, 'original_dimensions' => null ] ]
			],
			[
				[ '1', '2' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ] ],
					'2' => [ [ 'url' => 'http://fake2.url', 'original_dimensions' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => 1 ],
					'2' => [ 'thumbnail' => 'http://fake2.url', 'original_dimensions' => 2 ] ]
			],
			[
				[ '1', '2' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => 1 ],
					'2' => [ 'thumbnail' => null, 'original_dimensions' => null ] ]
			],
			[
				'1',
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => 1, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => 1 ] ]
			]
		];
	}

}
