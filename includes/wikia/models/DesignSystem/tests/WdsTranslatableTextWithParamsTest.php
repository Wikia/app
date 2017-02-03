<?php

class WdsTranslatableTextWithParamsTest extends WikiaBaseTest {
	/**
	 * @param $key
	 * @param $params
	 * @param $expected
	 *
	 * @dataProvider dataProvider
	 */
	public function test( $key, $params, $expected ) {
		$this->assertEquals( json_encode( $expected ), json_encode( new WdsTranslatableTextWithParams( $key, $params ) ) );
	}

	public function dataProvider() {
		return [
			[
				'key' => 'some-key',
				'params' => null,
				'expected' => [
					'params' => null,
					'type' => 'translatable-text',
					'key' => 'some-key',
				]
			],
			[
				'key' => 'some-key',
				'params' => [ 'a', 'b', 'c' ],
				'expected' => [
					'params' => [ 'a', 'b', 'c' ],
					'type' => 'translatable-text',
					'key' => 'some-key',
				]
			]
		];
	}
}
