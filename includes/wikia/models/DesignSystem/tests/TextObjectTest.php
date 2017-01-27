<?php

class TextObjectTest extends WikiaBaseTest {
	public function testGet() {
		$text = new TextObject( 'some value' );
		$expected = [
			'type' => 'text',
			'value' => 'some value'
		];

		$this->assertEquals( $expected, $text->get() );
	}
}