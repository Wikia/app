<?php

class PortableInfoboxRenderServiceTest extends WikiaBaseTest {
	//todo: https://wikia-inc.atlassian.net/browse/DAT-3076
	//todo: we are testing a lot of functionality and have issues with mocking
	//todo: we should move all render service test to API tests

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @param $input to check presence of some additional config fields. Possible fields:
	 * 'isInvalidImage' - bool - if getThumbnail should return false
	 * 'isMobile' - bool - if we want to test mobile env
	 * 'isMercury' - bool - if we want to test Mercury skin
	 * 'isMercuryExperimentalMarkupEnabled' - bool
	 * 'smallImageDimensions' - integer - size of small image (both width and height)
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function mockInfoboxRenderServiceHelper( $input ) {
		$isValidHeroDataItem = isset( $input[ 'isValidHeroDataItem' ] ) && $input[ 'isValidHeroDataItem' ];
		$isMobile = isset( $input[ 'isMobile' ] ) && $input[ 'isMobile' ];
		$isMercury = isset( $input[ 'isMercury' ] ) && $input[ 'isMercury' ];

		$createHorizontalGroupData = isset( $input[ 'createHorizontalGroupData' ] ) ?
			$input[ 'createHorizontalGroupData' ] : null;
		$extendImageData = isset( $input[ 'extendImageData' ] ) ? $input[ 'extendImageData' ] : null;

		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' )
			->setMethods( [ 'isValidHeroDataItem', 'validateType', 'isMobile', 'isMercury',
							'isMercuryExperimentalMarkupEnabled', 'createHorizontalGroupData', 'extendImageData' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'isValidHeroDataItem' )
			->will( $this->returnValue( $isValidHeroDataItem ) );
		$mock->expects( $this->any() )
			->method( 'validateType' )
			->will( $this->returnValue( true ) );
		$mock->expects( $this->any() )
			->method( 'isMobile' )
			->will( $this->returnValue( $isMobile ) );
		$mock->expects( $this->any() )
			->method( 'isMercury' )
			->will( $this->returnValue( $isMercury ) );
		$mock->expects( $this->any() )
			->method( 'createHorizontalGroupData' )
			->will( $this->returnValue( $createHorizontalGroupData ) );
		$mock->expects( $this->any() )
			->method( 'extendImageData' )
			->will( $this->returnValue( $extendImageData ) );

		$this->mockClass( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper', $mock );
	}

	/**
	 * @param $html
	 * @return string
	 */
	private function normalizeHTML( $html ) {
		$DOM = new DOMDocument( '1.0' );
		$DOM->formatOutput = true;
		$DOM->preserveWhiteSpace = false;
		$DOM->loadXML( $html );

		return $DOM->saveXML();
	}

	public function testEuropaThemeEnabled() {
		$wrapper = new \Wikia\Util\GlobalStateWrapper( [ 'wgEnablePortableInfoboxEuropaTheme' => true ] );

		$infoboxRenderService = new PortableInfoboxRenderService();
		$output = $wrapper->wrap( function () use ( $infoboxRenderService ) {
			return $infoboxRenderService->renderInfobox(
				[ [ 'type' => 'title', 'data' => [ 'value' => 'Test' ] ] ], '', '' );
		} );

		$expected = $this->normalizeHTML( '<aside class="portable-infobox pi-background pi-europa">
								<h2 class="pi-item pi-item-spacing pi-title">Test</h2>
							</aside>' );
		$result = $this->normalizeHTML( $output );
		$this->assertEquals( $expected, $result );
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @param $mockParams
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description, $mockParams ) {
		$this->markTestSkipped(__METHOD__);

		$this->mockInfoboxRenderServiceHelper( $mockParams );

		$infoboxRenderService = new PortableInfoboxRenderService();
		$actualOutput = $infoboxRenderService->renderInfobox( $input, '', '' );
		$expectedHtml = $this->normalizeHTML( $expectedOutput );
		$actualHtml = $this->normalizeHTML( $actualOutput );

		$this->assertEquals( $expectedHtml, $actualHtml, $description );
	}

	public function testRenderInfoboxDataProvider() {
		return [
			[
				'input' => [ ],
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
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
							</aside>',
				'description' => 'Only title'
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							[
								'alt' => 'image alt',
								'url' => 'http://image.jpg',
								'name' => 'image',
								'key' => 'image',
								'caption' => 'Lorem ipsum dolor',
								'isVideo' => false
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<figure class="pi-item pi-image">
									<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
										<img src="http://thumbnail.jpg" class="pi-image-thumbnail" alt="image alt"
										width="400" height="200" data-image-key="image" data-image-name="image"/>
									</a>
									<figcaption class="pi-item-spacing pi-caption">Lorem ipsum dolor</figcaption>
								</figure>
							</aside>',
				'description' => 'Only image',
				'mockParams' => [
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'caption' => 'Lorem ipsum dolor',
						'name' => 'image',
						'key' => 'image',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://thumbnail.jpg',
						'media-type' => 'image',
						'isVideo' => false
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							[
								'alt' => 'image alt',
								'url' => 'http://image.jpg',
								'caption' => 'Lorem ipsum dolor',
								'isVideo' => true,
								'duration' => '1:20',
								'name' => 'test',
								'key' => 'test'
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<figure class="pi-item pi-image">
									<a href="http://image.jpg"
									class="image image-thumbnail video video-thumbnail small"
									title="image alt">
										<img src="http://thumbnail.jpg" class="pi-image-thumbnail"
										alt="image alt" width="400" height="200" data-video-key="image"
										data-video-name="image"/>
										<span class="duration" itemprop="duration">1:20</span>
										<span class="play-circle"></span>
									</a>
									<figcaption class="pi-item-spacing pi-caption">Lorem ipsum dolor</figcaption>
								</figure>
							</aside>',
				'description' => 'Only video',
				'mockParams' => [
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'caption' => 'Lorem ipsum dolor',
						'name' => 'image',
						'key' => 'image',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://thumbnail.jpg',
						'media-type' => 'video',
						'isVideo' => true,
						'duration' => '1:20'
					]
				]
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
				'output' => '<aside class="portable-infobox pi-background">
								<nav class="pi-navigation pi-item-spacing pi-secondary-background pi-secondary-font">navigation value</nav>
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
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">test label</h3>
									<div class="pi-data-value pi-font">test value</div>
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
							[
								'alt' => 'image alt',
								'url' => 'http://image.jpg',
								'name' => 'image',
								'key' => 'image',
								'isVideo' => false
							]
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
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
								<figure class="pi-item pi-image">
									<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
										<img src="http://thumbnail.jpg" class="pi-image-thumbnail" alt="image alt"
										width="400" height="200" data-image-key="image" data-image-name="image"/>
									</a>
								</figure>
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">test label</h3>
									<div class="pi-data-value pi-font">test value</div>
									</div>
							</aside>',
				'description' => 'Simple infobox with title, image and key-value pair',
				'mockParams' => [
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'name' => 'image',
						'key' => 'image',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://thumbnail.jpg',
						'media-type' => 'image',
						'isVideo' => false
					]
				]
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
						'data' => [ ]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">test label</h3>
									<div class="pi-data-value pi-font">test value</div>
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
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">test label</h3>
									<div class="pi-data-value pi-font">test value</div>
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
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
								<section class="pi-item pi-group pi-border-color">
									<h2 class="pi-item pi-header pi-secondary-font pi-item-spacing pi-secondary-background">Test Header</h2>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">test label</h3>
										<div class="pi-data-value pi-font">test value</div>
									</div>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">test label</h3>
										<div class="pi-data-value pi-font">test value</div>
									</div>
								</section>
							</aside>',
				'description' => 'Infobox with title, group with header and two key-value pairs'
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
										'value' => 'Test header'
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
							],
							'layout' => 'horizontal'
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group">
										<caption
										class="pi-header pi-secondary-font pi-secondary-background pi-item-spacing">Test header</caption>
										<thead>
											<tr>
												<th
												class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing">test label</th>
												<th
												class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing">test label</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td
												class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value</td>
												<td
												class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Infobox with horizontal group',
				'mockParams' => [
					'createHorizontalGroupData' => [
						'header' => 'Test header',
						'labels' => [ 'test label', 'test label' ],
						'values' => [ 'test value', 'test value' ],
						'renderLabels' => true
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'data',
									'data' => [
										'label' => '',
										'value' => 'test value'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => '',
										'value' => 'test value'
									]
								]
							],
							'layout' => 'horizontal'
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group pi-horizontal-group-no-labels">
										<tbody>
											<tr>
												<td
												class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value</td>
												<td
												class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Infobox with horizontal group without header and labels',
				'mockParams' => [
					'createHorizontalGroupData' => [
						'labels' => [ '', '' ],
						'values' => [ 'test value', 'test value' ],
						'renderLabels' => false
					]
				]
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
				'output' => '<aside class="portable-infobox pi-background">
								<nav class="pi-navigation pi-item-spacing pi-secondary-background pi-secondary-font">
									<p>Links</p>
								</nav>
							</aside>',
				'description' => 'Infobox with navigation'
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'ref' => 1,
							'name' => 'test1',
							'key' => 'test1',
							'isVideo' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-hero">
									<img
									src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="http://image.jpg" class="pi-image-thumbnail lazy media article-media" alt="image alt"  data-image-key="test1" data-image-name="test1" data-ref="1" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'WikiaMobile: Only image. Image is not small- should render hero.',
				'mockParams' => [
					'isMobile' => true,
					'isMercury' => false,
					'isValidHeroDataItem' => true,
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 1,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'media-type' => 'image',
						'isVideo' => false
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>'
						]
					],
					[
						'type' => 'image',
						'data' => [
							'url' => 'http://image.jpg',
							'name' => 'test1',
							'key' => 'test1',
							'ref' => 44,
							'isVideo' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test <a href="example.com">Title</a></h2>
									</hgroup>
									<img
									src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="thumbnail.jpg" class="pi-image-thumbnail lazy media article-media" alt="" data-image-key="test1" data-image-name="test1" data-ref="44" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\'/>
								</div>
							</aside>',
				'description' => 'WikiaMobile: Infobox with full hero module with title with HTML tags',
				'mockParams' => [
					'isValidHeroDataItem' => true,
					'isMobile' => true,
					'isMercury' => false,
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'isVideo' => false,
						'media-type' => 'image'
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'ref' => 1,
							'name' => 'test1',
							'key' => 'test1',
							'isVideo' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-hero">
									<figure data-component="portable-infobox-hero-image" data-attrs="{&quot;itemContext&quot;:&quot;portable-infobox&quot;,&quot;ref&quot;:1}">
										<a href="http://image.jpg">
											<img class="article-media-placeholder" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\' viewBox%3D\'0 0 400 200\'%2F%3E" alt="" width="400" height="200"/>
											<noscript>
												<img src="http://image.jpg" alt="image alt" width="400" height="200"/>
											</noscript>
										</a>
									</figure>
								</div>
							</aside>',
				'description' => 'Mercury: Only image. Image is not small- should render hero.',
				'mockParams' => [
					'isMobile' => true,
					'isMercury' => true,
					'isMercuryExperimentalMarkupEnabled' => true,
					'isValidHeroDataItem' => true,
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 1,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'media-type' => 'image',
						'isVideo' => false,
						'mercuryComponentAttrs' => json_encode( [
							'itemContext' => 'portable-infobox',
							'ref' => 1
						] )
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>'
						]
					],
					[
						'type' => 'image',
						'data' => [
							'url' => 'http://image.jpg',
							'name' => 'test1',
							'key' => 'test1',
							'ref' => 44,
							'isVideo' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test <a href="example.com">Title</a></h2>
									</hgroup>
									<figure data-component="portable-infobox-hero-image" data-attrs="{&quot;itemContext&quot;:&quot;portable-infobox&quot;,&quot;ref&quot;:44}">
										<a href="http://image.jpg">
											<img class="article-media-placeholder" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\' viewBox%3D\'0 0 400 200\'%2F%3E" alt="" width="400" height="200"/>
											<noscript>
												<img src="http://image.jpg" alt="" width="400" height="200"/>
											</noscript>
										</a>
									</figure>
								</div>
							</aside>',
				'description' => 'Mercury: Infobox with full hero module with title with HTML tags',
				'mockParams' => [
					'isValidHeroDataItem' => true,
					'isMobile' => true,
					'isMercury' => true,
					'isMercuryExperimentalMarkupEnabled' => true,
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'isVideo' => false,
						'media-type' => 'image',
						'mercuryComponentAttrs' => json_encode( [
							'itemContext' => 'portable-infobox',
							'ref' => 44
						] )
					]
				]
			]
		];
	}
}
