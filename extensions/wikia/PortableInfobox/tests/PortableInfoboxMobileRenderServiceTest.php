<?php

class PortableInfoboxMobileRenderServiceTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	private function mockInfoboxImagesHelper( $input ) {
		$extendImageData = isset( $input['extendImageData'] ) ? $input['extendImageData'] : null;

		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper' )
			->setMethods( [ 'extendImageData', 'getFileWidth' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'extendImageData' )
			->will( $this->returnValue( $extendImageData ) );
		$mock->expects( $this->any() )
			->method( 'getFileWidth' )
			->will( $this->returnValue( $extendImageData['width'] ) );

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

	/**
	 * @dataProvider renderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description, $mockParams ) {
		$wrapper = new \Wikia\Util\GlobalStateWrapper( [ 'wgArticleAsJson' => $mockParams['isMercury'] ?? true ] );
		$this->mockInfoboxImagesHelper( $mockParams );

		$infoboxRenderService = new PortableInfoboxMobileRenderService();
		$actualOutput = $wrapper->wrap( function () use ( $infoboxRenderService, $input ) {
			return $infoboxRenderService->renderInfobox( $input, '', '', '', '' );
		} );
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
				'mockParams' => [ ]
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
				'mockParams' => [ ]
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
				'mockParams' => [ ]
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
				'mockParams' => [ ]
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
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test Title</h2>
									</hgroup>
									<figure data-component="portable-infobox-hero-image" data-attrs="">
										<a href="http://image.jpg">
										<img class="article-media-placeholder" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\' viewBox%3D\'0 0 400 200\'%2F%3E" alt="" width="400" height="200"/>
										<noscript>
											<img src="http://image.jpg" alt="image alt" width="400" height="200"/>
										</noscript>
										</a>
									</figure>
								</div>
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
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 1,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
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
				'description' => 'Simple infobox with title, INVALID image and key-value pair',
				'mockParams' => [ ]
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
				'mockParams' => [ ]
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
				'mockParams' => [ ]
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
				'description' => 'Infobox with navigation',
				'mockParams' => [ ]
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							[
								'alt' => 'image alt',
								'url' => 'http://image.jpg',
								'ref' => 1,
								'name' => 'test1',
								'key' => 'test1',
								'isVideo' => false
							]
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
					'isMercury' => false,
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 1,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
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
							[
								'url' => 'http://image.jpg',
								'name' => 'test1',
								'key' => 'test1',
								'ref' => 44,
								'isVideo' => false
							]
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
					'isMercury' => false,
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
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
							[
								'alt' => 'image alt',
								'url' => 'http://image.jpg',
								'ref' => 1,
								'name' => 'test1',
								'key' => 'test1',
								'isVideo' => false
							]
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
					'extendImageData' => [
						'alt' => 'image alt',
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 1,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
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
							[
								'url' => 'http://image.jpg',
								'name' => 'test1',
								'key' => 'test1',
								'ref' => 44,
								'isVideo' => false
							]
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
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
						'media-type' => 'image',
						'mercuryComponentAttrs' => json_encode( [
							'itemContext' => 'portable-infobox',
							'ref' => 44
						] )
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'Test 1',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>'
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
										'label' => 'Test 2',
										'value' => 'test value 2'
									]
								],
								[
									'type' => 'image',
									'data' => [
										[
											'url' => 'http://image.jpg',
											'name' => 'test1',
											'key' => 'test1',
											'ref' => 44,
											'isVideo' => false
										]
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3'
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => null
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
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">Test 1</h3>
									<div class="pi-data-value pi-font">test value 1</div>
								</div>
								<section class="pi-item pi-group pi-border-color">
									<h2 class="pi-item pi-header pi-secondary-font pi-item-spacing pi-secondary-background">Test Header</h2>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">Test 2</h3>
										<div class="pi-data-value pi-font">test value 2</div>
									</div>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">Test 3</h3>
										<div class="pi-data-value pi-font">test value 3</div>
									</div>
								</section>
							</aside>',
				'description' => 'Mercury: Infobox with valid hero data partially nested in group',
				'mockParams' => [
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
						'media-type' => 'image',
						'mercuryComponentAttrs' => json_encode( [
							'itemContext' => 'portable-infobox',
							'ref' => 44
						] )
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'Test 1',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>'
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
										'label' => 'Test 2',
										'value' => 'test value 2'
									]
								],
								[
									'type' => 'image',
									'data' => [
										[
											'url' => 'http://image.jpg',
											'name' => 'test1',
											'key' => 'test1',
											'ref' => 44,
											'isVideo' => false
										]
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3'
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => null
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
											<img class="article-media-placeholder" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D\'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg\' viewBox%3D\'0 0 200 200\'%2F%3E" alt="" width="200" height="200"/>
											<noscript>
												<img src="http://image.jpg" alt="" width="200" height="200"/>
											</noscript>
										</a>
									</figure>
								</div>
								<div class="pi-item pi-data pi-item-spacing pi-border-color">
									<h3 class="pi-data-label pi-secondary-font">Test 1</h3>
									<div class="pi-data-value pi-font">test value 1</div>
								</div>
								<section class="pi-item pi-group pi-border-color">
									<h2 class="pi-item pi-header pi-secondary-font pi-item-spacing pi-secondary-background">Test Header</h2>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">Test 2</h3>
										<div class="pi-data-value pi-font">test value 2</div>
									</div>
									<div class="pi-item pi-data pi-item-spacing pi-border-color">
										<h3 class="pi-data-label pi-secondary-font">Test 3</h3>
										<div class="pi-data-value pi-font">test value 3</div>
									</div>
								</section>
							</aside>',
				'description' => 'Mercury: Infobox with invalid hero data partially nested in group',
				'mockParams' => [
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'name' => 'test1',
						'key' => 'test1',
						'ref' => 44,
						'width' => '200',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
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
