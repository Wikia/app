<?php

class WdsLineTextTrackableTest extends WikiaBaseTest {
	/**
	 * @param $title
	 * @param $trackingLabel
	 * @param $expected
	 *
	 * @dataProvider withTextObjectDataProvider
	 */
	public function test( $title, $trackingLabel, $expected ) {
		$linkText = ( new WdsLineTextTrackable() )->setTitle( $title )->setTrackingLabel( $trackingLabel );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkText ) );
	}

	public function withTextObjectDataProvider() {
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
					],
					'tracking_label' => null,
				]
			]

		];
	}
}