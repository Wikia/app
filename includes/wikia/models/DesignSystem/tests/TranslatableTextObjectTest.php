<?php


class TranslatableTextObjectTest extends WikiaBaseTest {

	/**
	 * @param $key
	 * @param $params
	 * @param $expected
	 *
	 * @dataProvider dataProvider
	 */
	public function testGet( $key, $params, $expected ) {
		$this->assertEquals( $expected, ( new TranslatableTextObject( $key, $params ) )->get() );
	}

	public function dataProvider() {
		return [
			[
				'key' => 'some-key',
				'params' => null,
				'expected' => [
					'type' => 'translatable-text',
					'key' => 'some-key'
				]
			],
			[
				'key' => 'some-key',
				'params' => [ 'a', 'b', 'c' ],
				'expected' => [
					'type' => 'translatable-text',
					'key' => 'some-key',
					'params' => [ 'a', 'b', 'c' ]
				]
			]
		];
	}
}