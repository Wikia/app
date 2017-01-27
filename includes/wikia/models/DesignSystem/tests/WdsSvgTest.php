<?php

class WdsSvgTest extends WikiaBaseTest {
	public function testGet() {
		$wdsSvg = new WdsSvg( 'some-name' );
		$expected = [
			'type' => 'wds-svg',
			'name' => 'some-name'
		];

		$this->assertEquals( $expected, $wdsSvg->get() );
	}
}
