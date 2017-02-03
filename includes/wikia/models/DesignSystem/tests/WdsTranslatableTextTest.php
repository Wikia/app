<?php

class WdsTranslatableTextTest extends WikiaBaseTest {

	/**
	 * @param $key
	 * @param $expected
	 *
	 * @dataProvider dataProvider
	 */
	public function test( $key, $expected ) {
		$this->assertEquals( json_encode( $expected ), json_encode( new WdsTranslatableText( $key ) ) );
	}

	public function dataProvider() {
		return [
			[
				'key' => 'some-key',
				'expected' => [
					'type' => 'translatable-text',
					'key' => 'some-key'
				]
			]
		];
	}
}
