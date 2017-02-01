<?php

class WdsLinkBrandedTest extends WikiaBaseTest {

	/**
	 * @param $brand
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider withTranslatableTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $brand, $title, $href, $label, $expected ) {
		$linkText = (new WdsLinkBranded())
			->setBrand( $brand )
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkText ) );
	}

	public function withTranslatableTextObjectDataProvider() {
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
