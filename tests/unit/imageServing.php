<?php

class imageServingTest extends PHPUnit_Framework_TestCase {
	var $is;

	function setUp() {
		global $IP;
		require_once("$IP/extensions/wikia/ImageServing/imageServing.class.php");
		$this->is = new imageServing(array(1), 100, array("w" => 1, "h" => 1), new DBfakeImageServingTest()); 
	}

	function testSize() {
		global $IP;
	
		$this->assertEquals( '100px-56,237,0,180', $this->is->getCut( 290, 180 ) );
		$this->assertEquals( '100px-68,285,0,216', $this->is->getCut( 350, 216 ) );
		
		$this->assertEquals( '270px-0,428,57,200', $this->is->getCut( 800, 533 ) );
		$this->assertEquals( '270px-0,669,119,342', $this->is->getCut( 669, 593 ) );
		
		$this->assertEquals( '200px-0,314,65,222', $this->is->getCut( 314, 654 ) );
		$this->assertEquals( '200px-0,572,36,322', $this->is->getCut( 276, 163 ) );
	
	}
}


?>