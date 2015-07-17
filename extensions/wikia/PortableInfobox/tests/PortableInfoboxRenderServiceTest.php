<?php

class PortableInfoboxRenderServiceTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @param $isWikiaMobile
	 * @param $input to check presence of 'invalidImage' field
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getInfoboxRenderServiceMock( $input )
	{
		$isInvalidImage = isset( $input[ 'isInvalidImage' ] ) && $input[ 'isInvalidImage' ];
		$isWikiaMobile = isset( $input[ 'isWikiaMobile' ] ) && $input[ 'isWikiaMobile' ];
		$mockThumbnailImage = $isInvalidImage ? false : $this->getThumbnailImageMock( $input );

		$mock = $this->getMockBuilder( 'PortableInfoboxRenderService' )
			->setMethods( [ 'getThumbnail', 'isWikiaMobile' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'isWikiaMobile' )
			->will( $this->returnValue( $isWikiaMobile ) );
		$mock->expects( $this->any() )
			->method( 'getThumbnail' )
			->will( $this->returnValue( $mockThumbnailImage ) );

		return $mock;
	}

	/**
	 * @desc Returns the ThumbnailImage with hardcoded values returned by
	 * 'getUrl', 'getWidth' and 'getHeight' functions. In case of small image return small image sizes.
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getThumbnailImageMock( $input ) {
		$isSmallImage = isset( $input[ 'isSmallImage' ] ) && $input[ 'isSmallImage' ];

		$mockThumbnailImage = $this->getMockBuilder( 'ThumbnailImage' )
			->setMethods( [ 'getUrl', 'getWidth', 'getHeight' ] )
			->getMock();
		$mockThumbnailImage->expects( $this->any() )
			->method( 'getUrl' )
			->will( $this->returnValue( 'http://image.jpg' ) );

		if ( $isSmallImage ) {
			$mockThumbnailImage->expects( $this->any() )
				->method( 'getWidth' )
				->will( $this->returnValue( 100 ) );
			$mockThumbnailImage->expects( $this->any() )
				->method( 'getHeight' )
				->will( $this->returnValue( 100 ) );
		} else {
			$mockThumbnailImage->expects( $this->any() )
				->method( 'getWidth' )
				->will( $this->returnValue( 400 ) );
			$mockThumbnailImage->expects( $this->any() )
				->method( 'getHeight' )
				->will( $this->returnValue( 200 ) );
		}


		return $mockThumbnailImage;
	}

	/**
	 * @param $html
	 * @return string
     */
	private function normalizeHTML( $html ) {
		$DOM = new DOMDocument('1.0');
		$DOM->formatOutput = true;
		$DOM->preserveWhiteSpace = false;
		$DOM->loadXML( $html );

		return $DOM->saveXML();
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description ) {
		$infoboxRenderService = $this->getInfoboxRenderServiceMock( $input );
		$actualOutput = $infoboxRenderService->renderInfobox( $input );

		$expectedHtml = $this->normalizeHTML( $expectedOutput) ;
		$actualHtml = $this->normalizeHTML( $actualOutput );

		$this->assertEquals( $expectedHtml, $actualHtml, $description );
	}

	public function testRenderInfoboxDataProvider() {
		return [
			[
				'input' => [],
				'output' => '',
				'description' => 'Empty data should yield no infobox markup'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
							</aside>',
				'description' => 'Only title'
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'caption' => 'Lorem ipsum dolor'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
											<img src="http://image.jpg" class="portable-infobox-image" alt="image alt" width="400" height="200" data-image-key="" data-image-name=""/>
										</a>
										<figcaption class="portable-infobox-item-margins portable-infobox-image-caption">Lorem ipsum dolor</figcaption>
									</figure>
								</div>
							</aside>',
				'description' => 'Only image'
			],
			[
				'input' => [
					[
						'type' => 'navigation',
						'data' => [
							'value' => 'navigation value',
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<nav class="portable-infobox-navigation portable-infobox-item-margins portable-infobox-secondary-background portable-infobox-secondary-font">navigation value</nav>
							</aside>',
				'description' => 'navigation only'
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
								</div>
							</aside>',
				'description' => 'Only pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					],
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="" class="image image-thumbnail" title="image alt">
											<img src="http://image.jpg" class="portable-infobox-image" alt="image alt" width="400" height="200" data-image-key="" data-image-name=""/>
										</a>
									</figure>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
									</div>
							</aside>',
				'description' => 'Simple infobox with title, image and key-value pair'
			],
			[
				'input' => [
					'isInvalidImage' => true,
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					],
					[
						'type' => 'image',
						'data' => []
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
									</div>
							</aside>',
				'description' => 'Simple infobox with title, INVALID image and key-value pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
								</div>
							</aside>',
				'description' => 'Simple infobox with title, empty image and key-value pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value'
									]
								]
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<section class="portable-infobox-item item-type-group">
									<div class="portable-infobox-item item-type-header portable-infobox-item-margins portable-infobox-secondary-background">
										<h2 class="portable-infobox-header portable-infobox-secondary-font">Test Header</h2>
									</div>
									<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
										<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
										<div class="portable-infobox-item-value">test value</div>
									</div>
									<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
										<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
										<div class="portable-infobox-item-value">test value</div>
									</div>
								</section>
							</aside>',
				'description' => 'Infobox with title, image and group with header two key-value pairs'
			],
			[
				'input' => [
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value'
									]
								]
							],
							'layout' => 'horizontal'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<section class="portable-infobox-item item-type-group group-layout-horizontal">
									<div class="portable-infobox-item item-type-header portable-infobox-item-margins portable-infobox-secondary-background">
										<h2 class="portable-infobox-header portable-infobox-secondary-font">Test Header</h2>
									</div>
									<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
										<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
										<div class="portable-infobox-item-value">test value</div>
									</div>
								</section>
							</aside>',
				'description' => 'Infobox with title, image and horizontal group'
			],
			[
				'input' => [
					[
						'type' => 'navigation',
						'data' => [
							'value' => '<p>Links</p>'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<nav class="portable-infobox-navigation portable-infobox-item-margins portable-infobox-secondary-background portable-infobox-secondary-font">
									<p>Links</p>
								</nav>
							</aside>',
				'description' => 'Infobox with navigation'
			],
			[
				'input' => [
					'isWikiaMobile' => true,
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'thumbnail' => 'thumbnail.jpg',
							'ref' => 1,
							'name' => 'test1',
							'width' => 450,
							'height' => 600
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-hero">
									<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="http://image.jpg" class="portable-infobox-image lazy media article-media" alt="image alt"  data-image-key="test1" data-image-name="test1" data-ref="1" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'Mobile: Only image. Image is not small- should render hero.'
			],
			[
				'input' => [
					'isWikiaMobile' => true,
					'isSmallImage' => true,
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'thumbnail' => 'thumbnail.jpg',
							'ref' => 1,
							'name' => 'test1',
							'width' => 100,
							'height' => 100
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-image no-margins">
									<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="http://image.jpg" class="portable-infobox-image lazy media article-media" alt="image alt"  data-image-key="test1" data-image-name="test1" data-ref="1" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'Mobile: Only a small image. Should not render hero'
			],
			[
				'input' => [
					'isInvalidImage' => true,
					'isWikiaMobile' => true,
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						]
					],
					[
						'type' => 'image',
						'data' => []
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
									</div>
							</aside>',
				'description' => 'Mobile: Simple infobox with title, INVALID image and key-value pair'
			]
		];
	}
}
