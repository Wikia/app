<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 27/01/2017
 * Time: 12:33
 */
class WdsLinkBrandedTest extends WikiaBaseTest {

	/**
	 * @param $brand
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithTranslatableTextObjectDataProvider
	 */
	public function testGetWithTranslatableTextObject( $brand, $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkBranded())
			->setBrand( $brand )
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkText->get() );
	}

	public function getWithTranslatableTextObjectDataProvider() {
		return [
			[
				'brand' => 'brand',
				'title' => 'some-title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-branded',
					'brand' => 'brand',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'some-title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label'
				]
			]
		];
	}
}
