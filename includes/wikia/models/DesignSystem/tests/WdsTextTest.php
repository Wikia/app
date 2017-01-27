<?php

class WdsTextTest extends WikiaBaseTest {
	public function testGet() {
		$text = new WdsText( 'some value' );
		$expected = [
			'type' => 'text',
			'value' => 'some value'
		];

		$this->assertEquals( $expected, $text->get() );
	}
}
