<?php


class WdsLineImageTest extends WikiaBaseTest {
	/**
	 * @param $imageKey
	 * @param $title
	 * @param $subtitle
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getDataProvider
	 */
	public function testGet( $imageKey, $title, $subtitle, $label, $expected ) {
		$linkImage = (new WdsLineImage())
			->setSvgImageData($imageKey)
			->setTitle( $title )
			->setSubtitle( $subtitle )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkImage->get() );
	}

	public function getDataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'subtitle' => 'subtitle',
				'label' => 'label',
				'expected' => [
					'type' => 'line-image',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'subtitle' => [
						'type' => 'text',
						'value' => 'subtitle'
					],
					'tracking_label' => 'label'
				]
			]
		];
	}

	/**
	 * @param $imageKey
	 * @param $title
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider getWithoutSubtitleProvider
	 */
	public function testGetWithoutSubtitle( $imageKey, $title, $label, $expected ) {
		$linkImage = (new WdsLineImage())
			->setSvgImageData($imageKey)
			->setTitle( $title )
			->setTrackingLabel( $label );
		$this->assertEquals( $expected, $linkImage->get() );
	}

	public function getWithoutSubtitleProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'label' => 'label',
				'expected' => [
					'type' => 'line-image',
					'image' => 'some-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'tracking_label' => 'label'
				]
			]
		];
	}
}