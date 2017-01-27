<?php

class LineTextObjectTest extends WikiaBaseTest {
	/**
	 * @param $title
	 * @param $expected
	 *
	 * @dataProvider getWithTranslatableTextObjectDataProvider
	 */
	public function testGetWithTranslatableTextObject( $title, $expected ) {
		$linkText = (new LineTextObject())
			->setTranslatableTitle( $title );
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
}