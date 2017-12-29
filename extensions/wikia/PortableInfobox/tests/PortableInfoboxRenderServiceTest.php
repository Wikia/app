<?php

class PortableInfoboxRenderServiceTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	private function mockInfoboxRenderServiceHelper( $input ) {
		$extendImageData = isset( $input['extendImageData'] ) ? $input['extendImageData'] : null;

		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper' )
			->setMethods( [ 'extendImageData' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'extendImageData' )
			->will( $this->returnValue( $extendImageData ) );

		$this->mockClass( 'Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper', $mock );
	}

	/**
	 * @param $html
	 * @return string
	 */
	private function normalizeHTML( $html ) {
		if ( empty( $html ) ) {
			return '';
		}

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
				[ [ 'type' => 'title', 'data' => [ 'value' => 'Test' ] ] ], '', '', '', '' );
		} );

		$expected = $this->normalizeHTML( '<aside class="portable-infobox pi-background pi-europa">
								<h2 class="pi-item pi-item-spacing pi-title">Test</h2>
							</aside>' );
		$result = $this->normalizeHTML( $output );
		$this->assertEquals( $expected, $result );
	}


	/**
	 * @param $data
	 * @param $expected
	 *
	 * @dataProvider filterImagesDataProvider
	 */
	public function testFilterImages( $data, $expected ) {
		$method = ( new ReflectionClass( 'PortableInfoboxRenderService' ) )->getMethod( 'filterImageData' );
		$method->setAccessible( true );

		$renderService = new PortableInfoboxRenderService();

		$this->assertEquals( $expected, $method->invokeArgs( $renderService, [ $data ] ) );
	}

	public function filterImagesDataProvider() {
		return [
			[
				'data' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => 'caption1',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => 'caption2',
						'isVideo' => false,
					],
				],
				'expected' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => 'caption1',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => 'caption2',
						'isVideo' => false,
					],
				]
			],
			[
				'data' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => '',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => 'caption2',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name3',
						'key' => 'key3',
						'alt' => 'alt3',
						'caption' => 'caption3',
						'isVideo' => false,
					],
				],
				'expected' => [
					1 => [
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => 'caption2',
						'isVideo' => false,
					],
					2 => [
						'url' => 'some.url.com',
						'name' => 'name3',
						'key' => 'key3',
						'alt' => 'alt3',
						'caption' => 'caption3',
						'isVideo' => false,
					]
				]
			],
			[
				'data' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => 'caption1',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => '',
						'isVideo' => false,
					],
				],
				'expected' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => 'caption1',
						'isVideo' => false,
					],
				],
			],
			[
				'data' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => '',
						'isVideo' => false,
					],
					[
						'url' => 'some.url.com',
						'name' => 'name2',
						'key' => 'key2',
						'alt' => 'alt2',
						'caption' => '',
						'isVideo' => false,
					],
				],
				'expected' => [
					[
						'url' => 'some.url.com',
						'name' => 'name1',
						'key' => 'key1',
						'alt' => 'alt1',
						'caption' => '',
						'isVideo' => false,
					],
				]
			],
		];
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @param $mockParams
	 * @param $accentColor
	 * @param $accentColorText
	 * @dataProvider renderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description, $mockParams, $accentColor, $accentColorText ) {
		$this->mockInfoboxRenderServiceHelper( $mockParams );

		$infoboxRenderService = new PortableInfoboxRenderService();
		$actualOutput = $infoboxRenderService->renderInfobox( $input, '', '', $accentColor, $accentColorText );
		$expectedHtml = $this->normalizeHTML( $expectedOutput );
		$actualHtml = $this->normalizeHTML( $actualOutput );

		$this->assertEquals( $expectedHtml, $actualHtml, $description );
	}

	public function renderInfoboxDataProvider() {
		return [
			[
				'input' => [ ],
				'output' => '',
				'description' => 'Empty data should yield no infobox markup',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'Only title',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
								<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#FFF;color:#000;">Test Title</h2>
							</aside>',
				'description' => 'Only title with custom colors',
				'mockParams' => [ ],
				'accentColor' => '#FFF',
				'accentColorText' => '#000'
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
										<img src="http://thumbnail.jpg" srcset="http://thumbnail.jpg 1x, http://thumbnail2x.jpg 2x" class="pi-image-thumbnail" alt="image alt"
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
						'thumbnail2x' => 'http://thumbnail2x.jpg',
						'media-type' => 'image',
						'isVideo' => false
					]
				],
				'accentColor' => '',
				'accentColorText' => ''
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
										<img src="http://thumbnail.jpg" srcset="http://thumbnail.jpg 1x, http://thumbnail2x.jpg 2x" class="pi-image-thumbnail"
										alt="image alt" width="400" height="200" data-video-key="image"
										data-video-name="image"/>
										<span class="thumbnail-play-icon-container">
											<svg class="thumbnail-play-icon" viewBox="0 0 180 180" width="100%" height="100%">
												<g fill="none" fill-rule="evenodd">
													<g opacity=".9" transform="rotate(90 75 90)">
														<g fill="#000" filter="url(#a)"><rect id="b" width="150" height="150" rx="75"></rect></g>
														<g fill="#FFF"><rect id="b" width="150" height="150" rx="75"></rect></g>
													</g>
													<path fill="#00D6D6" fill-rule="nonzero" d="M80.87 58.006l34.32 25.523c3.052 2.27 3.722 6.633 1.496 9.746a6.91 6.91 0 0 1-1.497 1.527l-34.32 25.523c-3.053 2.27-7.33 1.586-9.558-1.527A7.07 7.07 0 0 1 70 114.69V63.643c0-3.854 3.063-6.977 6.84-6.977 1.45 0 2.86.47 4.03 1.34z"></path>
												</g>
											</svg>
										</span>
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
						'thumbnail2x' => 'http://thumbnail2x.jpg',
						'media-type' => 'video',
						'isVideo' => true,
						'duration' => '1:20'
					]
				],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'navigation only',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'Only pair',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										<img src="http://thumbnail.jpg" srcset="http://thumbnail.jpg 1x, http://thumbnail2x.jpg 2x" class="pi-image-thumbnail" alt="image alt"
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
						'thumbnail2x' => 'http://thumbnail2x.jpg',
						'media-type' => 'image',
						'isVideo' => false
					]
				],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'Simple infobox with title, INVALID image and key-value pair',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'Simple infobox with title, empty image and key-value pair',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
							],
							'layout' => 'default',
							'collapse' => null,
							'row-items' => null
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
				'description' => 'Infobox with title, group with header and two key-value pairs',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
							],
							'layout' => 'default',
							'collapse' => null,
							'row-items' => null
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<h2 class="pi-item pi-item-spacing pi-title" style="background-color:#FFF;color:#000;">Test Title</h2>
								<section class="pi-item pi-group pi-border-color">
									<h2 class="pi-item pi-header pi-secondary-font pi-item-spacing pi-secondary-background" style="background-color:#FFF;color:#000;">Test Header</h2>
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
				'description' => 'Infobox with title, group with header and two key-value pairs, custom accent color and accent text color',
				'mockParams' => [ ],
				'accentColor' => '#FFF',
				'accentColorText' => '#000'
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
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null
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
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null
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
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
				'description' => 'Infobox with navigation',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
			],
			// horizontal group tests
			[
				'input' => [
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label 1',
										'value' => 'test value 1'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label 2',
										'value' => 'test value 2'
									]
								]
							],
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group">
										<thead>
											<tr>
												<th class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing">test label 1</th>
												<th class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing">test label 2</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 1</td>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 2</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Horizontal group data without header',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'value' => 'test header'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => '',
										'value' => 'test value 1'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label 2',
										'value' => 'test value 2'
									]
								]
							],
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group">
										<caption class="pi-header pi-secondary-font pi-secondary-background pi-item-spacing">test header</caption>
										<thead>
											<tr>
												<th class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing"/>
												<th class="pi-horizontal-group-item pi-data-label pi-secondary-font pi-border-color pi-item-spacing">test label 2</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 1</td>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 2</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Horizontal group data with empty label',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'value' => 'test value 1'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => '',
										'value' => 'test value 2'
									]
								]
							],
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group pi-horizontal-group-no-labels">
										<tbody>
											<tr>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 1</td>
												<td class="pi-horizontal-group-item pi-data-value pi-font pi-border-color pi-item-spacing">test value 2</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Horizontal group data with empty label',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 4',
										'value' => 'test value 4',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 5',
										'value' => 'test value 5',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 1</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 2</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 3</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 1</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 2</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 3</div>
										</section>
									</section>
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 4</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 5</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 4</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 5</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 5 elements with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 4',
										'value' => 'test value 4',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 1</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 2</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 3</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 1</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 2</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 3</div>
										</section>
									</section>
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">Test 4</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">test value 4</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 4 elements with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">Test 1</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">test value 1</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of a single element with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 2,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(2 / 3 * 100%);">Test 1</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 2</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(2 / 3 * 100%);">test value 1</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 2</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 2 + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 2,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 7
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(2 / 3 * 100%);">Test 1</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 2</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(2 / 3 * 100%);">test value 1</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 2</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 2 + 1 with row size 7',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 2,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 2,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 2,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">Test 1</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">test value 1</div>
										</section>
									</section>
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">Test 2</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">test value 2</div>
										</section>
									</section>
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">Test 3</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(2 / 2 * 100%);">test value 3</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 2 + 2 + 2 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => null,
										'layout' => 'default'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 4',
										'value' => 'test value 4',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 5',
										'value' => 'test value 5',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 6',
										'value' => 'test value 6',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<section class="pi-item pi-group pi-border-color">
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 1</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 2</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 1</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 2</div>
										</section>
									</section>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">Test 3</h3>
										<div class="pi-data-value pi-font">test value 3</div>
									</div>
									<section class="pi-item pi-smart-group pi-border-color">
										<section class="pi-smart-group-head">
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 4</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 5</h3>
											<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 6</h3>
										</section>
										<section class="pi-smart-group-body">
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 4</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 5</div>
											<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 6</div>
										</section>
									</section>
								</section>
							</aside>',
				'description' => 'Flex wrapped group of 1 + 1 + default + 1 + 1 + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 4',
										'value' => 'test value 4',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 5',
										'value' => 'test value 5',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 6',
										'value' => 'test value 6',
										'span' => null,
										'layout' => 'default'
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
							  	<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 1</h3>
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 2</h3>
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">Test 3</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 1</div>
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 2</div>
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 3 * 100%);">test value 3</div>
									</section>
								</section>
								<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 4</h3>
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 5</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 4</div>
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 5</div>
									</section>
								</section>
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">Test 6</h3>
									<div class="pi-data-value pi-font">test value 6</div>
								</div>
							  </section>
							</aside>',
				'description' => 'Flex wrapped group of 1 + 1 + 1 + 1 + 1 + default with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 40,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
							  	<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(40 / 40 * 100%);">Test 1</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(40 / 40 * 100%);">test value 1</div>
									</section>
								</section>
								<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 2</h3>
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 3</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 2</div>
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 3</div>
									</section>
								</section>
							  </section>
							</aside>',
				'description' => 'Flex wrapped group of 40 + 1 + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 40,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
							  	<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">Test 1</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">test value 1</div>
									</section>
								</section>
								<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(40 / 40 * 100%);">Test 2</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(40 / 40 * 100%);">test value 2</div>
									</section>
								</section>
								<section class="pi-item pi-smart-group pi-border-color">
									<section class="pi-smart-group-head">
										<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">Test 3</h3>
									</section>
									<section class="pi-smart-group-body">
										<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">test value 3</div>
									</section>
								</section>
							  </section>
							</aside>',
				'description' => 'Flex wrapped group of 1 + 40 + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => 'Test 1',
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'title',
									'data' => [
										'value' => 'title value'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
								<section class="pi-item pi-smart-group pi-border-color">
								  <section class="pi-smart-group-head">
									<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 1</h3>
									<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 2</h3>
								  </section>
								  <section class="pi-smart-group-body">
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 1</div>
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 2</div>
								  </section>
								</section>
								<h2 class="pi-item pi-item-spacing pi-title">title value</h2>
								<section class="pi-item pi-smart-group pi-border-color">
								  <section class="pi-smart-group-head">
									<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">Test 3</h3>
								  </section>
								  <section class="pi-smart-group-body">
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 1 * 100%);">test value 3</div>
								  </section>
								</section>
							  </section>
							</aside>',
				'description' => 'Flex wrapped group of 1 + 1 + title + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
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
										'label' => null,
										'value' => 'test value 1',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => null,
										'value' => 'test value 2',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'title',
									'data' => [
										'value' => 'title value'
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => null,
										'value' => 'test value 3',
										'span' => 1,
										'layout' => null
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 4',
										'value' => 'test value 4',
										'span' => 1,
										'layout' => null
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => 3
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
							  <section class="pi-item pi-group pi-border-color">
								<section class="pi-item pi-smart-group pi-border-color">
								  <section class="pi-smart-group-body">
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 1</div>
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 2</div>
								  </section>
								</section>
								<h2 class="pi-item pi-item-spacing pi-title">title value</h2>
								<section class="pi-item pi-smart-group pi-border-color">
								  <section class="pi-smart-group-head">
									<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);"></h3>
									<h3 class="pi-smart-data-label pi-data-label pi-secondary-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">Test 4</h3>
								  </section>
								  <section class="pi-smart-group-body">
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 3</div>
									<div class="pi-smart-data-value pi-data-value pi-font pi-item-spacing" style="width: calc(1 / 2 * 100%);">test value 4</div>
								  </section>
								</section>
							  </section>
							</aside>',
				'description' => 'Flex wrapped group of 1 (no label) + 1 (no label) + title + 1 (no label) + 1 with row size 3',
				'mockParams' => [ ],
				'accentColor' => '',
				'accentColorText' => ''
			],
		];
	}
}
