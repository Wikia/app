<?php
/**
 * Created by adam
 * Date: 28.11.13
 */

class ArticlesApiControllerTest extends \WikiaBaseTest {

	/**
	 * @covers       ArticlesApiController::reorderForLinks
	 * @dataProvider reorderForLinksDataProvider
	 */
	public function testReorderForLinks( $popular, $links, $reordered ) {
		$reorderForLinks = self::getFn( new ArticlesApiController(), 'reorderForLinks' );
		$this->assertEquals( $reordered, $reorderForLinks( $popular, $links ) );
	}

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
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => null ] ]
			],
			[
				[ '1' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ],
				[ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => null ] ]
			],
			[
				[ '1' ],
				[],
				[ '1' => [ 'thumbnail' => null, 'original_dimensions' => null ] ]
			],
			[
				[ '1', '2' ],
				[
					'1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ] ],
					'2' => [ [ 'url' => 'http://fake2.url', 'original_dimensions' => null ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => null ],
					'2' => [ 'thumbnail' => 'http://fake2.url', 'original_dimensions' => null ] ]
			],
			[
				[ '1', '2' ],
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ] ] ],
				[
					'1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => null ],
					'2' => [ 'thumbnail' => null, 'original_dimensions' => null ] ]
			],
			[
				'1',
				[ '1' => [ [ 'url' => 'http://fake.url', 'original_dimensions' => null, 'other' => 2 ] ] ],
				[ '1' => [ 'thumbnail' => 'http://fake.url', 'original_dimensions' => null ] ]
			]
		];
	}

	public function reorderForLinksDataProvider() {
		return [
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				[ '3', '4', '5' ],
				[ [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ], [ 'url' => '1' ], [ 'url' => '2' ] ]
			],
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				[ '2', '4' ],
				[ [ 'url' => '2' ], [ 'url' => '4' ], [ 'url' => '1' ], [ 'url' => '3' ], [ 'url' => '5' ] ]
			],
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				[ '2', '200', '4', '100' ],
				[ [ 'url' => '2' ], [ 'url' => '4' ], [ 'url' => '1' ], [ 'url' => '3' ], [ 'url' => '5' ] ]
			],
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				[ '200', '100' ],
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ]
			],
			[
				[ ],
				[ '1', '2', '3' ],
				[ ]
			],
			[
				null,
				[ '1', '2', '3' ],
				[ ]
			],
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				[ ],
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ]
			],
			[
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ],
				null,
				[ [ 'url' => '1' ], [ 'url' => '2' ], [ 'url' => '3' ], [ 'url' => '4' ], [ 'url' => '5' ] ]
			],
		];
	}

	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}
}
