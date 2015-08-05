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

	public function getSectionNumbersArrayDataProvider() {
		return [
			// get specified sections
			[
				'0,1,2',
				4,
				[0, 1, 2]
			],
			// different spacing
			[
				'0, 1, 2',
				2,
				[0, 1, 2]
			],
			// url encoded input
			[
				'1%2C%202%2C%203',
				5,
				[1,2,3]
			],
			// url encoded input
			[
				'4%2C5%2C6',
				5,
				[4,5,6]
			]
		];
	}

	/**
	 * @dataProvider getSectionNumbersArrayDataProvider
	 */
	public function testGetSectionNumbersArray( $sectionsToGet, $sectionCount, $sectionsArray ) {
		$getSectionNumbersArray = self::getFn( new ArticlesApiController(), 'getSectionNumbersArray' );
		$this->assertEquals( $sectionsArray, $getSectionNumbersArray( $sectionsToGet, $sectionCount ) );
	}

	public function splitArticleIntoSectionsDataProvider() {
		return [
			// real article output
			[
				'<p>Section 0 text </p><p><br /> </p> <h2 id=\'Section_1_heading\' section=\'1\' >Section 1 heading</h2> <p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'0\' width=\'800\' height=\'600\' /> Section 1 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p> <h3 id=\'Section_1.1_heading\' section=\'2\' >Section 1.1 heading</h3> <p>Section1.1 text </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'960\' height=\'640\' /> </p> <h2 id=\'Section_2_heading\' section=\'3\' >Section 2 heading</h2> <p>Section 2 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p> <h2 id=\'Section_3_heading\' section=\'4\' >Section 3 heading</h2> <p>Section 3 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'2\' width=\'506\' height=\'506\' /> </p> <h2 id=\'Test_4th_Section\' section=\'\' >Test 4th Section</h2> <p>Test 4th section text. </p>',
				[
					'<p>Section 0 text </p><p><br /> </p> ',
					'<h2 id=\'Section_1_heading\' section=\'1\' >Section 1 heading</h2> <p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'0\' width=\'800\' height=\'600\' /> Section 1 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p> <h3 id=\'Section_1.1_heading\' section=\'2\' >Section 1.1 heading</h3> <p>Section1.1 text </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'960\' height=\'640\' /> </p> ',
					'<h2 id=\'Section_2_heading\' section=\'3\' >Section 2 heading</h2> <p>Section 2 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p> ',
					'<h2 id=\'Section_3_heading\' section=\'4\' >Section 3 heading</h2> <p>Section 3 text <a rel="nofollow" class="external text exitstitial" href="http://www.google.com">Foo</a> </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'2\' width=\'506\' height=\'506\' /> </p> ',
					'<h2 id=\'Test_4th_Section\' section=\'\' >Test 4th Section</h2> <p>Test 4th section text. </p>',
				]
			],
			// h2 without a section attribute
			[
				'<h2>Foo bar</h2> Foo bar baz qux <h2 section="2">Section with attribute</h2>',
				[
					'<h2>Foo bar</h2> Foo bar baz qux ',
					'<h2 section="2">Section with attribute</h2>'
				]
			],
			// empty article
			[
				'',
				[]
			],
			// article without section 0
			[
				'<h2 id=\'Section_1_heading\' section=\'1\' >Section 1 heading</h2> <p>Section 1 text <a href="http://www.google.com">Foo</a> </p> <h2 id=\'Section_1.1_heading\' section=\'2\' >Section 1.1 heading</h2> <p>Section1.1 text </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'960\' height=\'640\' /> </p> ',
				[
					'<h2 id=\'Section_1_heading\' section=\'1\' >Section 1 heading</h2> <p>Section 1 text <a href="http://www.google.com">Foo</a> </p> ',
					'<h2 id=\'Section_1.1_heading\' section=\'2\' >Section 1.1 heading</h2> <p>Section1.1 text </p><p><img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'960\' height=\'640\' /> </p> '
				]
			]
		];
	}

	/**
	 * @dataProvider splitArticleIntoSectionsDataProvider
	 */
	public function testSplitArticleIntoSections( $content, $contentArray ) {
		$splitArticleIntoSections = self::getFn( new ArticlesApiController(), 'splitArticleIntoSections' );
		$this->assertEquals( $contentArray, $splitArticleIntoSections( $content ) );
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
