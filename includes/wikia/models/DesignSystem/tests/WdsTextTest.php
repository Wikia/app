<?php

class WdsTextTest extends WikiaBaseTest {
	public function test() {
		$text = new WdsText( 'some value' );
		$expected = [
			'type' => 'text',
			'value' => 'some value'
		];

		$this->assertEquals( json_encode( $expected ), json_encode( $text ) );
	}
}
