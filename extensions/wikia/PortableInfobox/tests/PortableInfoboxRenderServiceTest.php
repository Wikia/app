<?php

class PortableInfoboxRenderServiceTest extends PHPUnit_Framework_TestCase {
	private $infoboxRenderService;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$mock = $this->getMock( 'PortableInfoboxRenderService', [ 'getThumbnailUrl' ] );
		$mock->expects( $this->any() )->method( 'getThumbnailUrl' )->will( $this->returnValue( 'http://image.jpg' ) );

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
				'output' => '<aside class="portable-infobox ">
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
									<figure>
										<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
											<img src="http://image.jpg" class="portable-infobox-image" alt="image alt" data-image-key="" data-image-name=""/>
										</a>
										<figcaption class="portable-infobox-item-margins portable-infobox-image-caption">Lorem ipsum dolor</figcaption>
									</figure>
								</div>
							</aside>',
				'description' => 'Only image for mobile'
			],
			[
				'input' => [
					[
						'type' => 'footer',
						'data' => [
							'value' => 'Footer value',
						]
					]
				],
				'output' => '<aside class="portable-infobox ">
								<footer class="portable-infobox-footer portable-infobox-item-margins portable-infobox-header-background portable-infobox-header-font">Footer value</footer>
							</aside>',
				'description' => 'Footer only'
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'url' => 'http://image.jpg'
						]
					]
				],
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="http://image.jpg" class="image image-thumbnail" title="image alt">
											<img src="http://image.jpg" class="portable-infobox-image" alt="image alt" data-image-key="" data-image-name=""/>
										</a>
									</figure>
								</div>
							</aside>',
				'description' => 'Only image'
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
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
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
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-image no-margins">
									<figure class="portable-infobox-image-wrapper">
										<a href="" class="image image-thumbnail" title="image alt">
											<img src="http://image.jpg" class="portable-infobox-image" alt="image alt" data-image-key="" data-image-name=""/>
										</a>
									</figure>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
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
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
									<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
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
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<section class="portable-infobox-item item-type-group">
									<div class="portable-infobox-item item-type-header portable-infobox-item-margins portable-infobox-header-background">
										<h2 class="portable-infobox-header portable-infobox-header-font">Test Header</h2>
									</div>
									<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
										<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
										<div class="portable-infobox-item-value">test value</div>
									</div>
									<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
										<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
										<div class="portable-infobox-item-value">test value</div>
									</div>
								</section>
							</aside>',
				'description' => 'Infobox with title, image and group with header two key-value pairs'
			],
			[
				'input' => [
					[
						'type' => 'comparison',
						'data' => [
							'value' => [
								[
									'type' => 'set',
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
								],
							],
						]
					]
				],
				'output' => '<aside class="portable-infobox ">
								<div class="portable-infobox-item item-type-comparison">
									<table class="portable-infobox-comparison">
										<tbody>
											<tr class="portable-infobox-comparison-set">
												<th class="portable-infobox-comparison-set-header">
													<div class="portable-infobox-item item-type-header portable-infobox-item-margins portable-infobox-header-background">
														<h2 class="portable-infobox-header portable-infobox-header-font">Test Header</h2>
													</div>
												</th>
												<td class="portable-infobox-comparison-item">
													<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
														<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
														<div class="portable-infobox-item-value">test value</div>
													</div>
												</td>
												<td class="portable-infobox-comparison-item">
													<div class="portable-infobox-item item-type-key-val portable-infobox-item-margins">
														<h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3>
														<div class="portable-infobox-item-value">test value</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</aside>',
				'description' => 'Infobox with comparison with two sets of which one is empty'
			],
			[
				'input' => [
					[
						'type' => 'footer',
						'data' => [
							'value' => '<p>Links</p>'
						]
					]
				],
				'output' => '<aside class="portable-infobox ">
								<footer class="portable-infobox-footer portable-infobox-item-margins portable-infobox-header-background portable-infobox-header-font">
									<p>Links</p>
								</footer>
							</aside>',
				'description' => 'Infobox with footer'
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
}
