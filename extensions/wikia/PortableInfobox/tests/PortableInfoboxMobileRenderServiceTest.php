<?php

class PortableInfoboxMobileRenderServiceTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		if ( !extension_loaded( 'mustache' ) ) {
			$this->markTestSkipped( '"mustache" PHP extension needs to be loaded!' );
		}
	}

	private function mockInfoboxImagesHelper( $input ) {
		$extendImageData = isset( $input['extendImageData'] ) ? $input['extendImageData'] : null;

		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper' )
			->setMethods( [ 'extendMobileImageDataScaleToWidth', 'extendMobileImageData', 'getFileWidth' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'extendMobileImageDataScaleToWidth' )
			->will( $this->returnValue( $extendImageData ) );
		$mock->expects( $this->any() )
			->method( 'extendMobileImageData' )
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

		$config = [
			'indent'         => true,
			'output-xhtml'   => false
		];
		$tidy = new tidy();
		$tidy->parseString($html, $config);
		$tidy->cleanRepair();

		return preg_replace( '/>\s+/', '>', (string) $tidy );
	}

	/**
	 * @dataProvider renderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description, $mockParams ) {
		$wrapper = new \Wikia\Util\GlobalStateWrapper( [ 'wgArticleAsJson' => $mockParams['isMercury'] ?? true ] );
		$this->mockInfoboxImagesHelper( $mockParams );

		$infoboxRenderService = new PortableInfoboxMobileRenderService();
		$actualOutput = $wrapper->wrap( function () use ( $infoboxRenderService, $input ) {
			return $infoboxRenderService->renderInfobox( $input, '', '', '', '', null, null );
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
							'value' => 'Test Title',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'value' => 'test value',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'value' => 'Test Title',
							'source' => null,
							'item-name' => null,
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
								'isVideo' => false,
								'source' => null,
								'item-name' => null,
							]
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test Title</h2>
									</hgroup>
									<figure data-attrs="" data-file="">
										<a href="http://image.jpg">
										<img class="article-media-placeholder lazyload" src="data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'-12 -12 48 48\' fill=\'%23fff\' width=\'400\' height=\'200\'%3e%3cg fill-rule=\'evenodd\'%3e%3cpath d=\'M3 4h18v8.737l-3.83-3.191a.916.916 0 0 0-1.282.108l-4.924 5.744-3.891-3.114a.92.92 0 0 0-1.146 0L3 14.626V4zm19-2H2a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z\'/%3e%3cpath d=\'M9 10c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2\'/%3e%3c/g%3e%3c/svg%3e" data-src="http://image.jpg" data-srcset="http://image.jpg, http://image2x.jpg 2x" data-sizes="auto" alt="" width="400" height="200"/><noscript>
											<img src="http://image.jpg" alt="" width="400" height="200"/>
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
						'url' => 'http://image.jpg',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
						'isVideo' => false
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'image',
						'data' => [ ],
						'source' => null,
						'item-name' => null,
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'value' => 'Test Title',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'value' => 'Test Title',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								]
							],
							'layout' => 'default',
							'collapse' => null,
							'row-items' => null,
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<h2 class="pi-item pi-item-spacing pi-title">Test Title</h2>
								<section class="pi-item pi-group pi-border-color">
									<div class="pi-header-wrapper pi-item-spacing">
										<h2 class="pi-item pi-header pi-secondary-font pi-secondary-background">Test Header</h2>
									</div>
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
										'value' => 'Test header',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'test label',
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								]
							],
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null,
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<section class="pi-item pi-group pi-border-color">
									<table class="pi-horizontal-group">
										<caption
										class="pi-secondary-font pi-secondary-background pi-item-spacing"><span class="pi-header">Test header</span></caption>
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
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => '',
										'value' => 'test value',
										'source' => null,
										'item-name' => null,
									]
								]
							],
							'layout' => 'horizontal',
							'collapse' => null,
							'row-items' => null,
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
							'value' => '<p>Links</p>',
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
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
								'isVideo' => false,
								'source' => null,
								'item-name' => null,
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background">
								<div class="pi-item pi-hero">
									<img
									src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="http://image.jpg" class="pi-image-thumbnail lazy media article-media" alt="somefile.jpg"  data-image-key="somefile.jpg" data-image-name="somefile.jpg" data-params=\'[{"name":"somefile.jpg", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'WikiaMobile: Only image. Image is not small- should render hero.',
				'mockParams' => [
					'isMercury' => false,
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'fileName' => 'somefile.jpg',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
						'isVideo' => false,
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
								'isVideo' => false,
								'source' => null,
								'item-name' => null,
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
									src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="thumbnail.jpg" class="pi-image-thumbnail lazy media article-media" alt="somefile.jpg" data-image-key="somefile.jpg" data-image-name="somefile.jpg" data-params=\'[{"name":"somefile.jpg", "full":"http://image.jpg"}]\'/>
								</div>
							</aside>',
				'description' => 'WikiaMobile: Infobox with full hero module with title with HTML tags',
				'mockParams' => [
					'isMercury' => false,
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'fileName' => 'somefile.jpg',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
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
								'isVideo' => false,
								'source' => null,
								'item-name' => null,
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<div class="pi-item pi-hero">
									<figure data-attrs="" data-file="">
										<a href="http://image.jpg">
											<img class="article-media-placeholder lazyload" src="data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'-12 -12 48 48\' fill=\'%23fff\' width=\'400\' height=\'200\'%3e%3cg fill-rule=\'evenodd\'%3e%3cpath d=\'M3 4h18v8.737l-3.83-3.191a.916.916 0 0 0-1.282.108l-4.924 5.744-3.891-3.114a.92.92 0 0 0-1.146 0L3 14.626V4zm19-2H2a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z\'/%3e%3cpath d=\'M9 10c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2\'/%3e%3c/g%3e%3c/svg%3e" data-src="http://image.jpg" data-srcset="http://image.jpg, http://image2x.jpg 2x" data-sizes="auto" alt="" width="400" height="200"/><noscript>
												<img src="http://image.jpg" alt="" width="400" height="200"/>
											</noscript>
										</a>
									</figure>
								</div>
							</aside>',
				'description' => 'Mercury: Only image. Image is not small- should render hero.',
				'mockParams' => [
					'extendImageData' => [
						'url' => 'http://image.jpg',
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'http://image.jpg',
						'thumbnail2x' => 'http://image2x.jpg',
						'isVideo' => false
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>',
							'source' => null,
							'item-name' => null,
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
								'isVideo' => false,
								'source' => null,
								'item-name' => null,
							]
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test <a href="example.com">Title</a></h2>
									</hgroup>
									<figure data-attrs="" data-file="">
										<a href="http://image.jpg">
											<img class="article-media-placeholder lazyload" src="data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'-12 -12 48 48\' fill=\'%23fff\' width=\'400\' height=\'200\'%3e%3cg fill-rule=\'evenodd\'%3e%3cpath d=\'M3 4h18v8.737l-3.83-3.191a.916.916 0 0 0-1.282.108l-4.924 5.744-3.891-3.114a.92.92 0 0 0-1.146 0L3 14.626V4zm19-2H2a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z\'/%3e%3cpath d=\'M9 10c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2\'/%3e%3c/g%3e%3c/svg%3e" data-src="thumbnail.jpg" data-srcset="thumbnail.jpg, thumbnail2x.jpg 2x" data-sizes="auto" alt="" width="400" height="200"/><noscript>
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
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'Test 1',
							'value' => 'test value 1',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'source' => null,
										'item-name' => null,
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
											'isVideo' => false,
											'source' => null,
											'item-name' => null,
										]
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'source' => null,
										'item-name' => null,
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => null,
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test <a href="example.com">Title</a></h2>
									</hgroup>
									<figure data-attrs="" data-file="">
										<a href="http://image.jpg">
											<img class="article-media-placeholder lazyload" src="data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'-12 -12 48 48\' fill=\'%23fff\' width=\'400\' height=\'200\'%3e%3cg fill-rule=\'evenodd\'%3e%3cpath d=\'M3 4h18v8.737l-3.83-3.191a.916.916 0 0 0-1.282.108l-4.924 5.744-3.891-3.114a.92.92 0 0 0-1.146 0L3 14.626V4zm19-2H2a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z\'/%3e%3cpath d=\'M9 10c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2\'/%3e%3c/g%3e%3c/svg%3e" data-src="thumbnail.jpg" data-srcset="thumbnail.jpg, thumbnail2x.jpg 2x" data-sizes="auto" alt="" width="400" height="200"/><noscript>
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
									<div class="pi-header-wrapper pi-item-spacing">
										<h2 class="pi-item pi-header pi-secondary-font pi-secondary-background">Test Header</h2>
									</div>
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
						'width' => '400',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
					]
				]
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'Test 1',
							'value' => 'test value 1',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test <img /><a href="example.com">Title</a>',
							'source' => null,
							'item-name' => null,
						]
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header',
										'source' => null,
										'item-name' => null,
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 2',
										'value' => 'test value 2',
										'source' => null,
										'item-name' => null,
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
											'isVideo' => false,
											'source' => null,
											'item-name' => null,
										]
									]
								],
								[
									'type' => 'data',
									'data' => [
										'label' => 'Test 3',
										'value' => 'test value 3',
										'source' => null,
										'item-name' => null,
									]
								]
							],
							'layout' => null,
							'collapse' => null,
							'row-items' => null,
							'source' => null,
							'item-name' => null,
						]
					]
				],
				'output' => '<aside class="portable-infobox pi-background pi">
								<div class="pi-item pi-hero">
									<hgroup class="pi-hero-title-wrapper pi-item-spacing">
										<h2 class="pi-hero-title">Test <a href="example.com">Title</a></h2>
									</hgroup>
									<figure data-attrs="" data-file="">
										<a href="http://image.jpg">
											<img class="article-media-placeholder lazyload" src="data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'-12 -12 48 48\' fill=\'%23fff\' width=\'200\' height=\'200\'%3e%3cg fill-rule=\'evenodd\'%3e%3cpath d=\'M3 4h18v8.737l-3.83-3.191a.916.916 0 0 0-1.282.108l-4.924 5.744-3.891-3.114a.92.92 0 0 0-1.146 0L3 14.626V4zm19-2H2a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h20a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z\'/%3e%3cpath d=\'M9 10c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2\'/%3e%3c/g%3e%3c/svg%3e" data-src="thumbnail.jpg" data-srcset="thumbnail.jpg, thumbnail2x.jpg 2x" data-sizes="auto" alt="" width="200" height="200"/><noscript>
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
									<div class="pi-header-wrapper pi-item-spacing">
										<h2 class="pi-item pi-header pi-secondary-font pi-secondary-background">Test Header</h2>
									</div>
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
						'width' => '200',
						'height' => '200',
						'thumbnail' => 'thumbnail.jpg',
						'thumbnail2x' => 'thumbnail2x.jpg',
						'isVideo' => false,
					]
				]
			]
		];
	}
}
