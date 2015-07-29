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
	 * 'isWikiaMobile' - bool - if we want to test mobile env
	 * 'smallImageDimensions' - integer - size of small image (both width and height)
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function mockInfoboxRenderServiceHelper( $input ) {
		$isValidHeroDataItem = isset( $input[ 'isValidHeroDataItem' ] ) && $input[ 'isValidHeroDataItem' ];
		$isWikiaMobile = isset( $input[ 'isWikiaMobile' ] ) && $input[ 'isWikiaMobile' ];
		$createHorizontalGroupData = isset( $input[ 'createHorizontalGroupData' ] ) ?
			$input[ 'createHorizontalGroupData' ] : null;
		$extendImageData = isset( $input[ 'extendImageData' ] ) ? $input[ 'extendImageData' ] : null;

		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' )
			->setMethods( [ 'isValidHeroDataItem', 'validateType', 'isWikiaMobile',
				'createHorizontalGroupData', 'extendImageData' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'isValidHeroDataItem' )
			->will( $this->returnValue( $isValidHeroDataItem ) );
		$mock->expects( $this->any() )
			->method( 'validateType' )
			->will( $this->returnValue( true ) );
		$mock->expects( $this->any() )
			->method( 'isWikiaMobile' )
			->will( $this->returnValue( $isWikiaMobile ) );
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
	public function testRenderInfobox( $input, $expectedOutput, $description, $mockParams ) {
		$this->mockInfoboxRenderServiceHelper( $mockParams );

		$infoboxRenderService = new PortableInfoboxRenderService();
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
							'name' => 'image',
							'key' => 'image',
							'caption' => 'Lorem ipsum dolor',
							'isVideo' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
											<img src="http://thumbnail.jpg" class="portable-infobox-image" alt="image alt" width="400" height="200" data-image-key="image" data-image-name="image"/>
										</a>
										<figcaption class="portable-infobox-item-margins portable-infobox-image-caption">Lorem ipsum dolor</figcaption>
									</figure>
								</div>
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
							'alt' => 'image alt',
							'url' => 'http://image.jpg',
							'caption' => 'Lorem ipsum dolor',
							'isVideo' => true,
							'duration' => '1:20',
							'name' => 'test',
							'key' => 'test'
						]
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="http://image.jpg"
										class="image image-thumbnail video video-thumbnail small"
										title="image alt">
											<img src="http://thumbnail.jpg" class="portable-infobox-image"
											alt="image alt" width="400" height="200" data-video-key="image"
											data-video-name="image"/>
											<span class="duration" itemprop="duration">1:20</span>
											<span class="play-circle"></span>
										</a>
										<figcaption class="portable-infobox-item-margins portable-infobox-image-caption">Lorem ipsum dolor</figcaption>
									</figure>
								</div>
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
							'url' => 'http://image.jpg',
							'name' => 'image',
							'key' => 'image',
							'isVideo' => false
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
										<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
											<img src="http://thumbnail.jpg" class="portable-infobox-image" alt="image alt" width="400" height="200" data-image-key="image" data-image-name="image"/>
										</a>
									</figure>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-secondary-font">test label</h3>
									<div class="portable-infobox-item-value">test value</div>
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
				'output' => '<aside class="portable-infobox">
								<section class="portable-infobox-item item-type-group group-layout-horizontal">
									<table class="portable-infobox-horizontal-group-content">
										<caption
										class="portable-infobox-header portable-infobox-secondary-font portable-infobox-secondary-background">Test header</caption>
										<thead>
											<tr>
												<th
												class="portable-infobox-horizontal-group-item portable-infobox-item-label portable-infobox-secondary-font">test label</th>
												<th
												class="portable-infobox-horizontal-group-item portable-infobox-item-label portable-infobox-secondary-font">test label</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="portable-infobox-horizontal-group-item portable-infobox-item-value">test value</td>
												<td class="portable-infobox-horizontal-group-item portable-infobox-item-value">test value</td>
											</tr>
										</tbody>
									</table>
								</section>
							</aside>',
				'description' => 'Infobox with title and horizontal group',
				'mockParams' => [
					'createHorizontalGroupData' => [
						'header' => 'Test header',
						'labels' => ['test label', 'test label'],
						'values' => ['test value', 'test value'],
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
				'output' => '<aside class="portable-infobox">
								<nav class="portable-infobox-navigation portable-infobox-item-margins portable-infobox-secondary-background portable-infobox-secondary-font">
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
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-hero">
									<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="http://image.jpg" class="portable-infobox-image lazy media article-media" alt="image alt"  data-image-key="test1" data-image-name="test1" data-ref="1" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\' />
								</div>
							</aside>',
				'description' => 'Mobile: Only image. Image is not small- should render hero.',
				'mockParams' => [
					'isWikiaMobile' => true,
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
				'output' => '<aside class="portable-infobox">
							<div class="portable-infobox-item item-type-hero">
								<hgroup class="portable-infobox-hero-title-wrapper portable-infobox-item-margins">
									<h2 class="portable-infobox-hero-title">Test Title</h2>
								</hgroup>
								<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" data-src="thumbnail.jpg" class="portable-infobox-image lazy media article-media" alt="" data-image-key="test1" data-image-name="test1" data-ref="44" data-params=\'[{"name":"test1", "full":"http://image.jpg"}]\'/>
							</div>
						</aside>',
				'description' => 'Mobile: Infobox with full hero module with title with HTML tags',
				'mockParams' => [
					'isValidHeroDataItem' => true,
					'isWikiaMobile' => true,
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
			]
		];
	}
}
