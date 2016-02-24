<?php

class MercuryApiModelTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getSiteMessageDataProvider
	 *
	 * @param $expected
	 * @param $isDisabled
	 * @param $siteMessageMock
	 * @param $wgSitenameMock
	 */
	public function testGetSiteMessage( $expected, $isDisabled, $siteMessageMock, $wgSitenameMock ) {
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( [ 'inContentLanguage', 'isDisabled', 'text' ] )
			->getMock();

		$messageMock->expects( $this->once() )
			->method( 'isDisabled' )
			->willReturn( $isDisabled );

		$messageMock->expects( $this->any() )
			->method( 'text' )
			->willReturn( $siteMessageMock );

		$messageMock->expects( $this->once() )
			->method( 'inContentLanguage' )
			->willReturn( $messageMock );

		$this->mockGlobalVariable( 'wgSitename', $wgSitenameMock );
		$this->mockGlobalFunction( 'wfMessage', $messageMock );

		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getSiteMessage() );
	}

	public function getSiteMessageDataProvider() {
		return [
			[
				'$expected' => 'Test Wiki',
				'$isDisabled' => false,
				'$siteMessageMock' => 'Test Wiki'
			],
			[
				'$expected' => false,
				'$isDisabled' => true,
				'$siteMessageMock' => 'Test Wiki',
			],
			[
				'$expected' => false,
				'$isDisabled' => false,
				'$siteMessageMock' => '',
			]
		];
	}

	/**
	 * @dataProvider getCuratedContentSectionsDataProvider
	 *
	 * @param $expected
	 * @param $data
	 */
	public function testGetCuratedContentSections( $expected, $data ) {
		$mercuryApi = new MercuryApi();
		$this->assertEquals( $expected, $mercuryApi->getCuratedContentSections( $data ) );
	}

	public function getCuratedContentSectionsDataProvider() {
		return [
			[
				'$expected' => [ ],
				'$data' => [ ]
			],
			[
				'$expected' => [
					[
						'title' => 'Curated Content Section',
						'image_id' => 1024,
						'image_url' => 'image_url_0',
						'type' => 'section',
					],
					[
						'title' => 'Another Curated Content Section',
						'image_id' => 2048,
						'image_url' => 'image_url_2',
						'type' => 'section',
					],
				],
				'$data' => [
					'sections' => [
						[
							'title' => 'Curated Content Section',
							'image_id' => 1024,
							'image_url' => 'image_url_0',
						],
						[
							'title' => 'Another Curated Content Section',
							'image_id' => 2048,
							'image_url' => 'image_url_2',
						],
					],
					'items' => [
						[
							'title' => 'Category:Category_name_0',
							'label' => 'Category Name Zero',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_3',
						],
						[
							'title' => 'Category:Category_name_1',
							'label' => 'Category Name One',
							'image_id' => 8192,
							'article_id' => 512,
							'type' => 'category',
							'image_url' => 'image_url_4',
						],
					],
					'featured' => [
						[
							'title' => 'Article_title',
							'label' => 'Article label',
							'image_id' => 256,
							'article_id' => 128,
							'type' => 'article',
							'image_url' => 'image_url_5',
						],
						[
							'title' => 'User_blog:Warkot/Such_Post',
							'label' => 'Awesome blog post',
							'image_id' => 64,
							'article_id' => 32,
							'type' => 'blog',
							'image_url' => 'image_url_6',
						],
					]
				]
			],
			[
				'$expected' => [ ],
				'$data' => [
					'items' => [
						[
							'title' => 'Category:Category_name_2',
							'label' => 'Category Name Two',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_6',
						],
					],
				]
			]
		];
	}

	/**
	 * @dataProvider getCuratedContentItemsDataProvider
	 *
	 * @param $expected
	 * @param $data
	 * @param $itemData
	 */
	public function testGetCuratedContentItems( $expected, $data, $itemData ) {
		/* @var MercuryApi|PHPUnit_Framework_MockObject_MockObject $mercuryApiMock */
		$mercuryApiMock = $this->getMockBuilder( 'MercuryApi' )
			->setMethods( [ 'processCuratedContentItem' ] )
			->getMock();

		if ( empty( $data ) ) {
			$map = [ $data, null ];
		} else {
			$map = array_map( null, $data, $itemData );
		}

		$mercuryApiMock->expects( $this->any() )
			->method( 'processCuratedContentItem' )
			->will( $this->returnValueMap( $map ) );

		$this->assertEquals( $expected, $mercuryApiMock->getCuratedContentItems( $data ) );
	}

	public function getCuratedContentItemsDataProvider() {
		return [
			[
				'$expected' => [ ],
				'$data' => [ ],
				'$processCuratedContentItemData' => null
			],
			[
				'$expected' => [
					[
						'title' => 'Category:Category_name_0',
						'label' => 'Category Name Zero',
						'image_id' => 4096,
						'article_id' => 0,
						'type' => 'category',
						'image_url' => 'image_url_3',
						'article_local_url' => '/wiki/Category:Category_name_0'
					],
					[
						'title' => 'Category:Category_name_1',
						'label' => 'Category Name One',
						'image_id' => 8192,
						'article_id' => 512,
						'type' => 'category',
						'image_url' => 'image_url_4',
						'article_local_url' => '/wiki/Category:Category_name_1'
					]
				],
				'$data' => [
					[
						'title' => 'Category:Category_name_0',
						'label' => 'Category Name Zero',
						'image_id' => 4096,
						'article_id' => 0,
						'type' => 'category',
						'image_url' => 'image_url_3',
					],
					[
						'title' => 'Category:Category_name_1',
						'label' => 'Category Name One',
						'image_id' => 8192,
						'article_id' => 512,
						'type' => 'category',
						'image_url' => 'image_url_4',
					]
				],
				'$processCuratedContentItemData' => [
					[
						'title' => 'Category:Category_name_0',
						'label' => 'Category Name Zero',
						'image_id' => 4096,
						'article_id' => 0,
						'type' => 'category',
						'image_url' => 'image_url_3',
						'article_local_url' => '/wiki/Category:Category_name_0'
					],
					[
						'title' => 'Category:Category_name_1',
						'label' => 'Category Name One',
						'image_id' => 8192,
						'article_id' => 512,
						'type' => 'category',
						'image_url' => 'image_url_4',
						'article_local_url' => '/wiki/Category:Category_name_1'
					]
				]
			],
			[
				'$expected' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
						'article_local_url' => '/Article_title'
					],
					[
						'title' => 'User_blog:Warkot/Such_Post',
						'label' => 'Awesome blog post',
						'image_id' => 64,
						'article_id' => 32,
						'type' => 'blog',
						'image_url' => 'image_url_6',
						'article_local_url' => '/User_blog:Warkot/Such_Post'
					]
				],
				'$data' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
					],
					[
						'title' => 'User_blog:Warkot/Such_Post',
						'label' => 'Awesome blog post',
						'image_id' => 64,
						'article_id' => 32,
						'type' => 'blog',
						'image_url' => 'image_url_6',
					]
				],
				'$processCuratedContentItemData' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
						'article_local_url' => '/Article_title'
					],
					[
						'title' => 'User_blog:Warkot/Such_Post',
						'label' => 'Awesome blog post',
						'image_id' => 64,
						'article_id' => 32,
						'type' => 'blog',
						'image_url' => 'image_url_6',
						'article_local_url' => '/User_blog:Warkot/Such_Post'
					]
				]
			],
			[
				'$expected' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
						'article_local_url' => '/Article_title'
					]
				],
				'$data' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
					],
					[
						'article_id' => null
					]
				],
				'$processCuratedContentItemData' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
						'article_local_url' => '/Article_title'
					],
					null
				]
			]
		];
	}

	/**
	 * @dataProvider processCuratedContentItemDataProvider
	 *
	 * @param $expected
	 * @param $item
	 * @param $wgArticlePath
	 * @param $getLocalURL
	 */
	public function testProcessCuratedContentItem( $expected, $item, $wgArticlePath, $getLocalURL ) {
		$mercuryApi = new MercuryApi();

		$titleMock = $this->getMockBuilder( 'Title' )
			->setMethods( [ 'getLocalURL' ] )
			->getMock();

		$titleMock->expects( $this->any() )
			->method( 'getLocalURL' )
			->willReturn( $getLocalURL );

		$this->getStaticMethodMock( 'Title', 'newFromID' )
			->expects( $this->any() )
			->method( 'newFromID' )
			->will( $this->returnValueMap( [
				[ 0, null ],
				[ $item['article_id'], $titleMock ]
			] ) );

		$this->mockGlobalVariable( 'wgArticlePath', $wgArticlePath );

		$this->assertEquals( $expected, $mercuryApi->processCuratedContentItem( $item ) );
	}

	public function processCuratedContentItemDataProvider() {
		return [
			[
				'$expected' => null,
				'$item' => [ ],
				'$wgArticlePath' => '',
				'$getLocalURL' => ''
			],
			[
				'$expected' => null,
				'$item' => [
					'article_id' => null
				],
				'$wgArticlePath' => '',
				'$getLocalURL' => ''
			],
			[
				'$expected' => [
					'title' => 'Category:Category_name_0',
					'label' => 'Category Name Zero',
					'image_id' => 4096,
					'article_id' => 0,
					'type' => 'category',
					'image_url' => 'image_url_3',
					'article_local_url' => '/wiki/Category:Category_name_0'
				],
				'$item' => [
					'title' => 'Category:Category_name_0',
					'label' => 'Category Name Zero',
					'image_id' => 4096,
					'article_id' => 0,
					'type' => 'category',
					'image_url' => 'image_url_3',
				],
				'$wgArticlePath' => '/wiki/$1',
				'$getLocalURL' => ''
			],
			[
				'$expected' => [
					'title' => 'Category:Category_name_0',
					'label' => 'Category Name Zero',
					'image_id' => 4096,
					'article_id' => 0,
					'type' => 'category',
					'image_url' => 'image_url_3',
					'article_local_url' => '/Category:Category_name_0'
				],
				'$item' => [
					'title' => 'Category:Category_name_0',
					'label' => 'Category Name Zero',
					'image_id' => 4096,
					'article_id' => 0,
					'type' => 'category',
					'image_url' => 'image_url_3',
				],
				'$wgArticlePath' => '/$1',
				'$getLocalURL' => ''
			],
			[
				'$expected' => [
					'title' => 'Category:Category_name_1',
					'label' => 'Category Name One',
					'image_id' => 8192,
					'article_id' => 512,
					'type' => 'category',
					'image_url' => 'image_url_4',
					'article_local_url' => '/wiki/Category:Category_name_1'
				],
				'$item' => [
					'title' => 'Category:Category_name_1',
					'label' => 'Category Name One',
					'image_id' => 8192,
					'article_id' => 512,
					'type' => 'category',
					'image_url' => 'image_url_4',
				],
				'$wgArticlePath' => '',
				'$getLocalURL' => '/wiki/Category:Category_name_1'
			]
		];
	}

	/**
	 * @dataProvider processCuratedContentDataProvider
	 *
	 * @param $expected
	 * @param $data
	 * @param $sectionsData
	 * @param $itemsData
	 * @param $featuredData
	 */
	public function testProcessCuratedContent( $expected, $data, $sectionsData, $itemsData, $featuredData ) {
		/* @var MercuryApi|PHPUnit_Framework_MockObject_MockObject $mercuryApiMock */
		$mercuryApiMock = $this->getMockBuilder( 'MercuryApi' )
			->setMethods( [ 'getCuratedContentSections', 'getCuratedContentItems' ] )
			->getMock();

		$mercuryApiMock->expects( $this->any() )
			->method( 'getCuratedContentSections' )
			->willReturn( $sectionsData );

		$mercuryApiMock->expects( $this->any() )
			->method( 'getCuratedContentItems' )
			->will( $this->returnValueMap( [
				[ [ ], [ ] ],
				[ $data['items'], $itemsData ],
				[ $data['featured'], $featuredData ]
			] ) );

		$this->assertEquals( $expected, $mercuryApiMock->processCuratedContent( $data ) );
	}

	public function processCuratedContentDataProvider() {
		return [
			[
				'$expected' => null,
				'$data' => [ ],
				'$sectionsData' => [ ],
				'$itemsData' => [ ],
				'$featuredData' => [ ]
			],
			[
				'$expected' => [
					'items' => [ 'A', 'B', 'C', 'P', 'Q', 'R' ],
					'featured' => [ 'X', 'Y', 'Z' ]
				],
				'$data' => [
					'sections' => [ 'a', 'b', 'c' ],
					'items' => [ 'p', 'q', 'r' ],
					'featured' => [ 'x', 'y', 'z' ]
				],
				'$sectionsData' => [ 'A', 'B', 'C' ],
				'$itemsData' => [ 'P', 'Q', 'R' ],
				'$featuredData' => [ 'X', 'Y', 'Z' ]
			],
			[
				'$expected' => [
					'items' => [
						[
							'title' => 'Curated Content Section',
							'image_id' => 1024,
							'image_url' => 'image_url_0',
							'type' => 'section',
						],
						[
							'title' => 'Another Curated Content Section',
							'image_id' => 2048,
							'image_url' => 'image_url_2',
							'type' => 'section',
						],
						[
							'title' => 'Category:Category_name_0',
							'label' => 'Category Name Zero',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_3',
							'article_local_url' => '/wiki/Category:Category_name_0'
						],
						[
							'title' => 'Category:Category_name_1',
							'label' => 'Category Name One',
							'image_id' => 8192,
							'article_id' => 512,
							'type' => 'category',
							'image_url' => 'image_url_4',
							'article_local_url' => '/wiki/Category:Category_name_1'
						],
					],
					'featured' => [
						[
							'title' => 'Article_title',
							'label' => 'Article label',
							'image_id' => 256,
							'article_id' => 128,
							'type' => 'article',
							'image_url' => 'image_url_5',
							'article_local_url' => '/Article_title'
						],
						[
							'title' => 'User_blog:Warkot/Such_Post',
							'label' => 'Awesome blog post',
							'image_id' => 64,
							'article_id' => 32,
							'type' => 'blog',
							'image_url' => 'image_url_6',
							'article_local_url' => '/User_blog:Warkot/Such_Post'
						]
					],
				],
				'$data' => [
					'sections' => [
						[
							'title' => 'Curated Content Section',
							'image_id' => 1024,
							'image_url' => 'image_url_0',
							'type' => 'section',
						],
						[
							'title' => 'Another Curated Content Section',
							'image_id' => 2048,
							'image_url' => 'image_url_2',
							'type' => 'section',
						]
					],
					'items' => [
						[
							'title' => 'Category:Category_name_0',
							'label' => 'Category Name Zero',
							'image_id' => 4096,
							'article_id' => 0,
							'type' => 'category',
							'image_url' => 'image_url_3',
						],
						[
							'title' => 'Category:Category_name_1',
							'label' => 'Category Name One',
							'image_id' => 8192,
							'article_id' => 512,
							'type' => 'category',
							'image_url' => 'image_url_4',
						]
					],
					'featured' => [
						[
							'title' => 'Article_title',
							'label' => 'Article label',
							'image_id' => 256,
							'article_id' => 128,
							'type' => 'article',
							'image_url' => 'image_url_5',
						],
						[
							'title' => 'User_blog:Warkot/Such_Post',
							'label' => 'Awesome blog post',
							'image_id' => 64,
							'article_id' => 32,
							'type' => 'blog',
							'image_url' => 'image_url_6',
						]
					]
				],
				'$sectionsData' => [
					[
						'title' => 'Curated Content Section',
						'image_id' => 1024,
						'image_url' => 'image_url_0',
						'type' => 'section',
					],
					[
						'title' => 'Another Curated Content Section',
						'image_id' => 2048,
						'image_url' => 'image_url_2',
						'type' => 'section',
					]
				],
				'$itemsData' => [
					[
						'title' => 'Category:Category_name_0',
						'label' => 'Category Name Zero',
						'image_id' => 4096,
						'article_id' => 0,
						'type' => 'category',
						'image_url' => 'image_url_3',
						'article_local_url' => '/wiki/Category:Category_name_0'
					],
					[
						'title' => 'Category:Category_name_1',
						'label' => 'Category Name One',
						'image_id' => 8192,
						'article_id' => 512,
						'type' => 'category',
						'image_url' => 'image_url_4',
						'article_local_url' => '/wiki/Category:Category_name_1'
					],
				],
				'$featuredData' => [
					[
						'title' => 'Article_title',
						'label' => 'Article label',
						'image_id' => 256,
						'article_id' => 128,
						'type' => 'article',
						'image_url' => 'image_url_5',
						'article_local_url' => '/Article_title'
					],
					[
						'title' => 'User_blog:Warkot/Such_Post',
						'label' => 'Awesome blog post',
						'image_id' => 64,
						'article_id' => 32,
						'type' => 'blog',
						'image_url' => 'image_url_6',
						'article_local_url' => '/User_blog:Warkot/Such_Post'
					]
				]
			],
		];
	}

	/**
	 * @dataProvider processTrendingArticlesDataDataProvider
	 *
	 * @param $expected
	 * @param $data
	 */
	public function testProcessTrendingArticlesData( $expected, $data ) {
		/* @var MercuryApi|PHPUnit_Framework_MockObject_MockObject $mercuryApiMock */
		$mercuryApiMock = $this->getMockBuilder( 'MercuryApi' )
			->setMethods( [ 'processTrendingArticlesItem' ] )
			->getMock();

		$mercuryApiMock->expects( $this->any() )
			->method( 'processTrendingArticlesItem' )
			->will( $this->returnCallback( function ( $item ) {
				return $item . ' processed';
			} ) );

		$this->assertEquals( $expected, $mercuryApiMock->processTrendingArticlesData( $data ) );
	}

	public function processTrendingArticlesDataDataProvider() {
		return [
			[
				'$expected' => null,
				'$data' => null
			],
			[
				'$expected' => null,
				'$data' => [
					'whatever' => []
				]
			],
			[
				'$expected' => null,
				'$data' => [
					'items' => 'error string'
				]
			],
			[
				'$expected' => [],
				'$data' => [
					'items' => []
				]
			],
			[
				'$expected' => [
					'Item 1 processed'
				],
				'$data' => [
					'items' => [
						'Item 1'
					]
				]
			],
			[
				'$expected' => [
					'Item 1 processed',
					'Item 2 processed'
				],
				'$data' => [
					'items' => [
						'Item 1',
						'Item 2'
					]
				]
			]
		];
	}

	/**
	 * @dataProvider processTrendingVideoDataDataProvider
	 *
	 * @param $expected
	 * @param $data
	 */
	public function testProcessTrendingVideoData( $expected, $data ) {
		$mercuryApi = new MercuryApi();

		$this->getStaticMethodMock( 'Title', 'newFromText' )
			->expects( $this->any() )
			->method( 'newFromText' )
			->will( $this->returnArgument( 0 ) );

		$this->getStaticMethodMock( 'WikiaFileHelper', 'getMediaDetail' )
			->expects( $this->any() )
			->method( 'getMediaDetail' )
			->will( $this->returnCallback( function ( $title ) {
				return [
					'type' => 'video',
					'title' => $title
				];
			} ) );

		$this->getStaticMethodMock( 'ArticleAsJson', 'createMediaObject' )
			->expects( $this->any() )
			->method( 'createMediaObject' )
			->will( $this->returnCallback( function ( $mediaDetail, $title ) {
				return [
					'type' => $mediaDetail['type'],
					'title' => $title
				];
			} ) );

		$this->assertEquals( $expected, $mercuryApi->processTrendingVideoData( $data ) );
	}

	public function processTrendingVideoDataDataProvider() {
		return [
			[
				'$expected' => null,
				'$data' => [
					'videos' => 'strange error'
				]
			],
			[
				'$expected' => null,
				'$data' => [
					'items' => []
				]
			],
			[
				'$expected' => [],
				'$data' => [
					'videos' => []
				]
			],
			[
				'$expected' => [
					[
						'title' => 'Video 1',
						'type' => 'video'
					]
				],
				'$data' => [
					'videos' => [
						[
							'title' => 'Video 1'
						]
					]
				]
			],
			[
				'$expected' => [
					[
						'title' => 'Video 1',
						'type' => 'video'
					],
					[
						'title' => 'Video 2',
						'type' => 'video'
					]
				],
				'$data' => [
					'videos' => [
						[
							'title' => 'Video 1'
						],
						[
							'title' => 'Video 2'
						]
					]
				]
			]
		];
	}
}
