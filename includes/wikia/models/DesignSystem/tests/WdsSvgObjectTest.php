<?php

class WdsSvgObjectTest extends WikiaBaseTest {
	public function testGet() {
		$wdsSvg = new WdsSvgObject( 'some-name' );
		$expected = [
			'type' => 'wds-svg',
			'name' => 'some-name'
		];

		$this->assertEquals( $expected, $wdsSvg->get() );
	}
}