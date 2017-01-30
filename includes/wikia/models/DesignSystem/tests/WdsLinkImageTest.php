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
	 * @dataProvider withTextObjectDataProvider
	 */
	public function testWithTextObject( $imageKey, $title, $href, $label, $expected ) {
		$linkImage = (new WdsLinkImage())
			->setSvgImageData($imageKey)
			->setTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkImage ) );
	}

	public function withTextObjectDataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-image',
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
				]
			]
		];
	}


	/**
	 * @param $imageUrl
	 * @param $title
	 * @param $href
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider withExternalImageDataProvider()
	 */
	public function testWithExternalImage( $imageUrl, $title, $href, $label, $expected ) {
		$linkImage = (new WdsLinkImage())
			->setExternalImageData( $imageUrl )
			->setTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkImage ) );
	}

	public function withExternalImageDataProvider() {
		return [
			[
				'imageUrl' => 'some.image.url',
				'title' => 'some title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-image',
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label',
					'image' => null,
					'image-data' => [
						'type' => 'image-external',
						'url' => 'some.image.url',
					],
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
	 * @dataProvider withTranslatableTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $imageKey, $title, $href, $label, $expected ) {
		$linkImage = (new WdsLinkImage())
			->setSvgImageData($imageKey)
			->setTranslatableTitle( $title )
			->setHref( $href )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkImage ) );
	}

	public function withTranslatableTextObjectDataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some-title',
				'href' => 'some.href.com',
				'label' => 'label',
				'expected' => [
					'type' => 'link-image',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'some-title'
					],
					'href' => 'some.href.com',
					'tracking_label' => 'label',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
				]
			]
		];
	}
}
