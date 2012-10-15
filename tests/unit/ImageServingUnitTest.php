<?php

class ImageServingUnitTest extends WikiaBaseTest {

	function setUp() {
		global $IP;
		require_once("$IP/extensions/wikia/ImageServing/imageServing.class.php");
	}

	function testSize() {
		global $IP;
		
		$is = new ImageServing(array(1), 100, array("w" => 1, "h" => 1));
		$this->assertEquals( '100px-56,237,0,180', $is->getCut( 290, 180 ) );
		$this->assertEquals( '100px-68,285,0,216', $is->getCut( 350, 216 ) );
		
		$is = new ImageServing(array(1), 270, array("w" => 3, "h" => 1));
		$this->assertEquals( '270px-0,428,57,200', $is->getCut( 428, 285 ) );
		$this->assertEquals( '270px-0,669,119,342', $is->getCut( 669, 593 ) );
		
		$is = new ImageServing(array(1), 200, array("w" => 2, "h" => 1));
		$this->assertEquals( '200px-0,314,65,222', $is->getCut( 314, 654 ) );
		$this->assertEquals( '200px-0,572,36,322', $is->getCut( 572, 355 ) );
	
	}
}