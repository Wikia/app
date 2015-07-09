<?php

class PortableInfoboxRenderServiceTest extends WikiaBaseTest {
	private $infoboxRenderService;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$mockThumbnailImage = $this->getMockBuilder( 'ThumbnailImage' )
			->setMethods( [ 'getUrl', 'getWidth', 'getHeight' ] )
			->getMock();

		$mock = $this->getMockBuilder( 'PortableInfoboxRenderService' )
			->setMethods( [ 'getThumbnail' ] )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'getThumbnail' )
			->will( $this->returnValue( $mockThumbnailImage ) );
		$mockThumbnailImage->expects( $this->any() )
			->method( 'getUrl' )
			->will( $this->returnValue( 'http://image.jpg' ) );
		$mockThumbnailImage->expects( $this->any() )
			->method( 'getWidth' )
			->will( $this->returnValue( 400 ) );
		$mockThumbnailImage->expects( $this->any() )
			->method( 'getHeight' )
			->will( $this->returnValue( 200 ) );

		$this->infoboxRenderService = $mock;
	}

	private function setWikiaMobileSkin($bool) {
		$this->infoboxRenderService->expects( $this->any() )->method( 'isWikiaMobile' )->will( $this->returnValue
		($bool) );
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description ) {
		$this->setWikiaMobileSkin(false);

		$actualOutput = $this->infoboxRenderService->renderInfobox( $input );

		$actualDOM = new DOMDocument('1.0');
		$expectedDOM = new DOMDocument('1.0');
		$actualDOM->formatOutput = true;
		$actualDOM->preserveWhiteSpace = false;
		$expectedDOM->formatOutput = true;
		$expectedDOM->preserveWhiteSpace = false;
		$actualDOM->loadXML($actualOutput);
		$expectedDOM->loadXML($expectedOutput);

		$expectedHtml = $expectedDOM->saveXML();
		$actualHtml = $actualDOM->saveXML();

		$this->assertEquals( $expectedHtml, $actualHtml, $description );
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderMobileInfobox( $input, $expectedOutput, $description ) {
		$this->setWikiaMobileSkin(true);
		$actualOutput = $this->infoboxRenderService->renderInfobox( $input );

		$actualDOM = new DOMDocument('1.0');
		$expectedDOM = new DOMDocument('1.0');
		$actualDOM->formatOutput = true;
		$actualDOM->preserveWhiteSpace = false;
		$expectedDOM->formatOutput = true;
		$expectedDOM->preserveWhiteSpace = false;
		$actualDOM->loadXML($actualOutput);
		$expectedDOM->loadXML($expectedOutput);

		$expectedHtml = $expectedDOM->saveXML();
		$actualHtml = $actualDOM->saveXML();

		$this->assertEquals( $expectedHtml, $actualHtml, $description );
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @desc Case when the getThumbnail method will not return false due to
	 * some image thumbnail error
	 * @dataProvider testRenderInfoboxDataProviderThumbnailError
	 */
	public function testRenderMobileInfoboxThumbnailError( $input, $expectedOutput, $description ) {
		$this->setWikiaMobileSkin(false);

		$mock = $this->getMockBuilder( 'PortableInfoboxRenderService' )
			->setMethods( [ 'getThumbnail' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'getThumbnail' )
			->will( $this->returnValue( false ) );
		$this->infoboxRenderServiceThumbnailError = $mock;

		$actualOutput = $this->infoboxRenderServiceThumbnailError->renderInfobox( $input );

		$actualDOM = new DOMDocument('1.0');
		$expectedDOM = new DOMDocument('1.0');
		$actualDOM->formatOutput = true;
		$actualDOM->preserveWhiteSpace = false;
		$expectedDOM->formatOutput = true;
		$expectedDOM->preserveWhiteSpace = false;
		$actualDOM->loadXML($actualOutput);
		$expectedDOM->loadXML($expectedOutput);

		$expectedHtml = $expectedDOM->saveXML();
		$actualHtml = $actualDOM->saveXML();

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
			]
		];
	}

	public function testRenderMobileInfoboxDataProvider() {
		return [
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'thumbnail' => 'thumbnail.jpg',
							'ref' => 1,
							'name' => 'test1'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-image no-margins">
									<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="portable-infobox-image lazy media article-media" alt="image alt"  data-image-key="test1" data-image-name="test1" data-ref="1" data-src="thumbnail.jpg" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'Only image for mobile'
			]
		];
	}

	public function testRenderInfoboxDataProviderThumbnailError() {
		return [
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
											<img src="" class="portable-infobox-image" alt="image alt" width="" height="" data-image-key="" data-image-name=""/>
										</a>
										<figcaption class="portable-infobox-item-margins portable-infobox-image-caption">Lorem ipsum dolor</figcaption>
									</figure>
								</div>
							</aside>',
				'description' => 'Image with invalid thumb. Thumbnail and dimensions should be empty'
			]
		];
	}
}
