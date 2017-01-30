<?php


class WdsLineImageTest extends WikiaBaseTest {
	/**
	 * @param $imageKey
	 * @param $title
	 * @param $subtitle
	 * @param $label
	 * @param $expected
	 *
	 * @dataProvider dataProvider
	 */
	public function test( $imageKey, $title, $subtitle, $label, $expected ) {
		$linkImage = (new WdsLineImage() )
			->setSvgImageData($imageKey)
			->setTitle( $title )
			->setSubtitle( $subtitle )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkImage ) );
	}

	public function dataProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'subtitle' => 'subtitle',
				'label' => 'label',
				'expected' => [
					'type' => 'line-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'tracking_label' => 'label',
					'image' => 'some-image',
					'subtitle' => [
						'type' => 'text',
						'value' => 'subtitle'
					]
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
	 * @dataProvider withoutSubtitleProvider
	 */
	public function testWithoutSubtitle( $imageKey, $title, $label, $expected ) {
		$linkImage = (new WdsLineImage() )
			->setSvgImageData( $imageKey )
			->setTitle( $title )
			->setTrackingLabel( $label );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkImage ) );
	}

	public function withoutSubtitleProvider() {
		return [
			[
				'imageKey' => 'some-image',
				'title' => 'some title',
				'label' => 'label',
				'expected' => [
					'type' => 'line-image',
					'image-data' => [
						'type' => 'wds-svg',
						'name' => 'some-image',
					],
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'tracking_label' => 'label',
					'image' => 'some-image',
				]
			]
		];
	}
}
