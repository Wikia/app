<?php
//
//class CollectionViewRenderServiceTest extends PHPUnit_Framework_TestCase {
//	private $collectionViewRenderService;
//
//	public function setUp() {
//		require_once( dirname(__FILE__) . '/../services/CollectionViewRenderService.class.php');
//		$this->collectionViewRenderService = new CollectionViewRenderService();
//	}
//
//	/**
//	 * @param $input
//	 * @param $output
//	 * @dataProvider testRenderCollectionViewDataProvider
//	 */
//	public function testRenderInfobox( $input, $output ) {
//
//		$realOutput = $this->collectionViewRenderService->renderCollectionView( $input );
//		$dom = DOMDocument::loadHTML($realOutput);
//		$xpath = new DOMXPath($dom);
//
//		$h2 = '//aside[@class="collection-view"]/div[@class="item-type-title"]/h2[text()="Test Title"]';
//		$nodes = $xpath->query($h2);
//
//		$this->assertTrue(count($nodes) == 1);
//
//
//	}
//
//	public function testRenderCollectionViewDataProvider() {
//		return [
//			[
//				'input' => [
//					[
//						'type' => 'title',
//						'data' => [
//							'value' => 'Test Title'
//						]
//					],
//					[
//						'type' => 'image',
//						'data' => [
//							'alt' => 'image alt',
//							'value' => 'http://image.jpg'
//						]
//					],
//					[
//						'type' => 'keyVal',
//						'data' => [
//							'label' => 'test label',
//							'value' => 'test value'
//						]
//					]
//				],
//				'output' => '<aside class="portable-infobox"><div class="infobox-item item-type-title"><h2 class=”infobox-title”>Test Title</h2></div><div class="infobox-item item-type-image"><figure><img alt="image alt" data-url="http://image.jpg" /></figure></div><div class="infobox-item item-type-key-val"><h3 class=”infobox-item-label”>test label</h3><div class=”infobox-item-value”>test value</div></div></aside>'
//			]
//		];
//	}
//}
