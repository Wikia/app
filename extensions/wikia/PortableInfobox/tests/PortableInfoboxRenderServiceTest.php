<?php

class PortableInfoboxRenderServiceTest extends PHPUnit_Framework_TestCase {
	private $infoboxRenderService;

	public function setUp() {
		parent::setUp();
		require_once( dirname( __FILE__ ) . '/../PortableInfobox.setup.php' );

		$this->infoboxRenderService = new PortableInfoboxRenderService();
	}

	/**
	 * @param $input
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $expectedOutput, $description ) {
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
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox"><div class="portable-infobox-item item-type-title portable-infobox-item-margins"><h2 class="portable-infobox-title">Test Title</h2></div></aside>',
				'description' => 'Only title'
			],
			[
				'input' => [
					[
						'type' => 'footer',
						'data' => [
							'value' => 'Footer value',
							'isEmpty' => false
						]
					]
				],
				'output' => '<aside class="portable-infobox"><footer class="portable-infobox-footer portable-infobox-item-margins portable-infobox-header-background portable-infobox-header-font">Footer value</footer></aside>',
				'description' => 'Footer only'
			],
			[
				'input' => [
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox"><div class="portable-infobox-item item-type-image no-margins"><figure><img class="portable-infobox-image" alt="image alt" data-url="http://image.jpg"/></figure></div></aside>',
				'description' => 'Only image'
			],
			[
				'input' => [
					[
						'type' => 'pair',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox"><div class="portable-infobox-item item-type-key-val portable-infobox-item-margins"><h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3><div class="portable-infobox-item-value">test value</div></div></aside>',
				'description' => 'Only pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						],
						'isEmpty' => false
					],
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						],
						'isEmpty' => false
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox"><div class="portable-infobox-item item-type-title portable-infobox-item-margins"><h2 class="portable-infobox-title">Test Title</h2></div><div class="portable-infobox-item item-type-image no-margins"><figure><img class="portable-infobox-image" alt="image alt" data-url="http://image.jpg"/></figure></div><div class="portable-infobox-item item-type-key-val portable-infobox-item-margins"><h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3><div class="portable-infobox-item-value">test value</div></div></aside>',
				'description' => 'Simple infobox with title, image and key-value pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						],
						'isEmpty' => false
					],
					[
						'type' => 'image',
						'data' => [],
						'isEmpty' => true
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox"><div class="portable-infobox-item item-type-title portable-infobox-item-margins"><h2 class="portable-infobox-title">Test Title</h2></div><div class="portable-infobox-item item-type-key-val portable-infobox-item-margins"><h3 class="portable-infobox-item-label portable-infobox-header-font">test label</h3><div class="portable-infobox-item-value">test value</div></div></aside>',
				'description' => 'Simple infobox with title, empty image and key-value pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						],
						'isEmpty' => false
					],
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						],
						'isEmpty' => false
					],
					[
						'type' => 'pair',
						'data' => [],
						'isEmpty' => true
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-image no-margins">
									<figure>
										<img class="portable-infobox-image" alt="image alt" data-url="http://image.jpg"/>
									</figure>
								</div>
							</aside>',
				'description' => 'Simple infobox with title, image and empty key-value pair'
			],
			[
				'input' => [
					[
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						],
						'isEmpty' => false
					],
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						],
						'isEmpty' => false
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header'
									],
									'isEmpty' => false
								],
								[
									'type' => 'pair',
									'data' => [
										'label' => 'test label',
										'value' => 'test value'
									],
									'isEmpty' => false,
								],
								[
									'type' => 'pair',
									'data' => [
										'label' => 'test label',
										'value' => 'test value'
									],
									'isEmpty' => false
								]
							]
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-image no-margins">
									<figure>
										<img class="portable-infobox-image" alt="image alt" data-url="http://image.jpg"/>
									</figure>
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
						'type' => 'title',
						'data' => [
							'value' => 'Test Title'
						],
						'isEmpty' => false
					],
					[
						'type' => 'image',
						'data' => [
							'alt' => 'image alt',
							'value' => 'http://image.jpg'
						],
						'isEmpty' => false
					],
					[
						'type' => 'group',
						'data' => [
							'value' => [
								[
									'type' => 'header',
									'data' => [
										'value' => 'Test Header'
									],
									'isEmpty' => false
								],
							]
						],
						'isEmpty' => true
					]
				],
				'output' => '<aside class="portable-infobox">
								<div class="portable-infobox-item item-type-title portable-infobox-item-margins">
									<h2 class="portable-infobox-title">Test Title</h2>
								</div>
								<div class="portable-infobox-item item-type-image no-margins">
									<figure>
										<img class="portable-infobox-image" alt="image alt" data-url="http://image.jpg"/>
									</figure>
								</div>
							</aside>',
				'description' => 'Infobox with title, image and empty group with header'
			],
			[
				'input' => [
					[
						'type' => 'comparison',
						'data' => [
							'value' => [
								[
									'type' => 'set',
									'data' => [],
									'isEmpty' => true
								],
								[
									'type' => 'set',
									'data' => [],
									'isEmpty' => true
								],
							],
						],
						'isEmpty' => true
					]
				],
				'output' => '',
				'description' => 'Infobox with empty comparison'
			],
			[
				'input' => [
					[
						'type' => 'comparison',
						'data' => [
							'value' => [
								[
									'type' => 'set',
									'data' => [],
									'isEmpty' => true
								],
								[
									'type' => 'set',
									'data' => [
										'value' => [
											[
												'type' => 'header',
												'data' => [
													'value' => 'Test Header'
												],
												'isEmpty' => false
											],
											[
												'type' => 'pair',
												'data' => [
													'label' => 'test label',
													'value' => 'test value'
												],
												'isEmpty' => false,
											],
											[
												'type' => 'pair',
												'data' => [
													'label' => 'test label',
													'value' => 'test value'
												],
												'isEmpty' => false
											]
										]
									],
									'isEmpty' => false
								],
							],
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox">
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
						'data' => [],
						'isEmpty' => true
					]
				],
				'output' => '',
				'description' => 'Infobox with empty footer'
			],
			[
				'input' => [
					[
						'type' => 'footer',
						'data' => [
							'links' => '<p>Links</p>'
						],
						'isEmpty' => false
					]
				],
				'output' => '<aside class="portable-infobox">
								<footer class="portable-infobox-footer portable-infobox-item-margins portable-infobox-header-background
portable-infobox-header-font">
									<p>Links</p>
								</footer>
							</aside>',
				'description' => 'Infobox with footer'
			]
		];
	}
}
