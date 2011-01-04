<?php

require_once 'PHPUnit/Framework/TestSuite.php';

/**
 * Static test suite.
 * 
 * @ingroup Maps
 * @since 0.6.5
 * @author Jeroen De Dauw
 */
class MapsTestSuite extends PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'MapsTestSuite' );
		
		$this->addTestSuite ( 'MapsCoordinateParserTest' );
		
		$this->addTestSuite ( 'MapsDistanceParserTest' );
	
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}

