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
		$this->assertEquals( '100px-925,1075,0,150', $this->is->getCut( 2000, 150 ) );
		$this->assertEquals( '100px-0,150,0,150', $this->is->getCut( 150, 2000 ) );
	}
	
	function testFilter() {
		$out = $this->is->getImages(5);
		$this->assertEquals( $out[1][0]['name'], 'Test2.jpg' ); 
	}
}


/* fake data class */

class DBfakeImageServingTest {
	public function addQuotes($in) {
		return $in;
	}
	public function select($in) {
		if($in[0] == 'page_wikia_props' ) {
			return $props = array(array(
				'page_id' => 1,
				'props' => serialize(
					array( 
					"Test1.jpg",
					"Test2.jpg",
					"Test3.jpg"
				)) 
			));	
		}

		return array(
			array(
				'cnt' => 1,
				'il_to' => 'Test2.jpg',
				'img_width' => 750,
				'img_height' => 100,
				'img_minor_mime' => "png"
			)
			
		);
		
	}
	
	public function fetchRow(&$stack) {
		return array_pop($stack);
	}
}

?>