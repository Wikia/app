<?php

class WdsLineTextTest extends WikiaBaseTest {
	/**
	 * @param $title
	 * @param $expected
	 *
	 * @dataProvider getWithTranslatableTextObjectDataProvider
	 */
	public function testGetWithTranslatableTextObject( $title, $expected ) {
		$linkText = ( new WdsLineText() )->setTranslatableTitle( $title );
		$this->assertEquals( $expected, $linkText->get() );
	}

	public function getWithTranslatableTextObjectDataProvider() {
		return [
			[
				'title' => 'some-title',
				'expected' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'some-title'
					]
				]
			]
		];
	}

	/**
	 * @param $title
	 * @param $trackingLabel
	 * @param $expected
	 *
	 * @dataProvider getWithTextObjectDataProvider
	 */
	public function testGetWithTrackingLabel( $title, $trackingLabel, $expected ) {
		$linkText = ( new WdsLineText() )->setTitle( $title )->setTrackingLabel( $trackingLabel );
		$this->assertEquals( $expected, $linkText->get() );
	}

	public function getWithTextObjectDataProvider() {
		return [
			[
				'title' => 'some title',
				'trackingLabel' => 'label',
				'expected' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					],
					'tracking_label' => 'label'
				]
			],
			[
				'title' => 'some title',
				'trackingLabel' => null,
				'expected' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'text',
						'value' => 'some title'
					]
				]
			]

		];
	}
}
