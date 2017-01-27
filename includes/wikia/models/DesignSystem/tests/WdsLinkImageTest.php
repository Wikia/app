<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 27/01/2017
 * Time: 12:52
 */
class WdsLinkImageTest extends WikiaBaseTest {
	/**
	 * @param $imageKey
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithTextObjectDataProvider
	 */
	public function testGetWithTextObject( $imageKey, $title, $href, $label, $expected ) {
		$linkImage = (new WdsLinkImage())
			->setImageData($imageKey)
			->setTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkImage->get() );
	}

	public function getWithTextObjectDataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-image',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label'
				]
			]
		];
	}


	/**
	 * @param $imageKey
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithTranslatableTextObjectDataProvider
	 */
	public function testGetWithTranslatableTextObject( $imageKey, $title, $href, $label, $expected ) {
		$linkImage = (new WdsLinkImage())
			->setImageData($imageKey)
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkImage->get() );
	}

	public function getWithTranslatableTextObjectDataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some-title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-image',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
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