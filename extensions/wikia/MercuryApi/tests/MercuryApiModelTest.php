<?php

class MercuryApiModelTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * @dataProvider getSiteMessageDataProvider
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
					],
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
	 */
	public function testGetCuratedContentItems( $expected, $data, $itemData ) {
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
	 */
	public function testProcessCuratedContent( $expected, $data, $sectionsData, $itemsData, $featuredData ) {
		$mercuryApiMock = $this->getMockBuilder( 'MercuryApi' )
			->setMethods( [ 'getCuratedContentSections', 'getCuratedContentItems' ] )
			->getMock();

		$mercuryApiMock->expects( $this->any() )
			->method( 'getCuratedContentSections' )
			->willReturn( $sectionsData );

		$mercuryApiMock->expects( $this->any() )
			->method( 'processCuratedContentItems' )
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
		];
	}
}
