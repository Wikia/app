<?php

class WdsSvgTest extends WikiaBaseTest {
	public function test() {
		$wdsSvg = new WdsSvg( 'some-name' );
		$expected = [
			'type' => 'wds-svg',
			'name' => 'some-name'
		];

		$this->assertEquals( json_encode( $expected ), json_encode( $wdsSvg ) );
	}
}
