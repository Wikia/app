<?php

class PortableInfoboxRenderServiceTest extends PHPUnit_Framework_TestCase {
	private $infoboxRenderService;

	public function setUp() {
		require_once( dirname(__FILE__) . '/../services/PortableInfoboxRenderService.class.php');
		$this->infoboxRenderService = new PortableInfoboxRenderService();
	}

	/**
	 * @param $input
	 * @param $output
	 * @dataProvider testRenderInfoboxDataProvider
	 */
	public function testRenderInfobox( $input, $output ) {

		$realOutput = $this->infoboxRenderService->renderInfobox( $input );
		$dom = DOMDocument::loadHTML($realOutput);
		$xpath = new DOMXPath($dom);

		$h2 = '//aside[@class="portable-infobox"]/div[@class="item-type-title"]/h2[text()="Test Title"]';
		$nodes = $xpath->query($h2);

		$this->assertTrue(count($nodes) == 1);


	}

	public function testRenderInfoboxDataProvider() {
		return [
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
						]
					],
					[
						'type' => 'keyVal',
						'data' => [
							'label' => 'test label',
							'value' => 'test value'
						]
					]
				],
				'output' => '<aside class="portable-infobox"><div class="infobox-item item-type-title"><h2 class=”infobox-title”>Test Title</h2></div><div class="infobox-item item-type-image"><figure><img alt="image alt" data-url="http://image.jpg" /></figure></div><div class="infobox-item item-type-key-val"><h3 class=”infobox-item-label”>test label</h3><div class=”infobox-item-value”>test value</div></div></aside>'
			]
		];
	}
}
