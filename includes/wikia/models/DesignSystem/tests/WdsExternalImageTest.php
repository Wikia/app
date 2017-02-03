<?php

class WdsExternalImageTest extends WikiaBaseTest {
	public function test() {
		$wdsSvg = new WdsExternalImage( 'some.url.com' );
		$expected = [
			'type' => 'image-external',
			'url' => 'some.url.com'
		];

		$this->assertEquals( json_encode($expected), json_encode( $wdsSvg ) );
	}
}
