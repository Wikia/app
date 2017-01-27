<?php

class WdsExternalImageTest extends WikiaBaseTest {
	public function testGet() {
		$wdsSvg = new WdsExternalImage( 'some.url.com' );
		$expected = [
			'type' => 'image-external',
			'url' => 'some.url.com'
		];

		$this->assertEquals( $expected, $wdsSvg->get() );
	}
}