<?php

class PortableInfoboxRenderServiceTest extends PHPUnit_Framework_TestCase {
	private $infoboxRenderService;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

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

		$this->assertEquals( $expectedDOM->saveXML(), $actualDOM->saveXML(), $description );
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
			]
		];
	}
}
