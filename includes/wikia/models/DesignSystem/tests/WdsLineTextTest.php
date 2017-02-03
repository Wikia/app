<?php

class WdsLineTextTest extends WikiaBaseTest {
	/**
	 * @param $title
	 * @param $expected
	 *
	 * @dataProvider withTranslatableTextObjectDataProvider
	 */
	public function testWithTranslatableTextObject( $title, $expected ) {
		$linkText = ( new WdsLineText() )->setTranslatableTitle( $title );
		$this->assertEquals( json_encode( $expected ), json_encode( $linkText ) );
	}

	public function withTranslatableTextObjectDataProvider() {
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
}
