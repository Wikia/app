<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once dirname(__FILE__) . '/commandLine.inc';

/**
 * MapsDistanceParser test case.
 * 
 * @ingroup Maps
 * @since 0.6.5
 * @author Jeroen De Dauw
 */
class MapsDistanceParserTest extends PHPUnit_Framework_TestCase {
	
	public static $distances = array(
		'1' => 1,
		'1m' => 1,
		'1 m' => 1,
		'   1   	  m ' => 1,
		'1.1' => 1.1,
		'1,1' => 1.1,
		'1 km' => 1000,
		'42 km' => 42000,
		'4.2 km' => 4200,
		'4,20km' => 4200,
		'1 mile' => 1609.344,
		'10 nauticalmiles' => 18520,
		'1.0nautical mile' => 1852,
	);
	
	public static $formatTests = array(
		'm' => array(
			'1 m' => 1,
			'1000 m' => 1000.00,
			'42.42 m' => 42.42,
			'42.42 m' => 42.4242,
		),		
		'km' => array(
			'0.001 km' => 1,
			'1 km' => 1000,
			'4,24 km' => 4242,
		),
		'kilometers' => array(
			'0.001 kilometers' => 1,
			'1 kilometers' => 1000,
			'4,24 kilometers' => 4242,
		),
	);
	
	/**
	 * Invalid distances.
	 * 
	 * @var array
	 */	
	public static $fakeDistances = array(	
		'IN YOUR CODE, BEING TOTALLY REDICULOUSE',
		'0x20 km',
		'km 42',
		'42 42 km',
		'42 km km',
		'42 foo',
		'3.4.2 km'
	);
	
	/**
	 * @var MapsDistanceParser
	 */
	private $MapsDistanceParser;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$this->MapsDistanceParser = new MapsDistanceParser(/* parameters */);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->MapsDistanceParser = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Tests MapsDistanceParser::parseDistance()
	 */
	public function testParseDistance() {
		foreach ( self::$distances as $rawValue => $parsedValue ) {
			$this->assertEquals( $parsedValue, MapsDistanceParser::parseDistance( $rawValue ), "'$rawValue' was not parsed to '$parsedValue':" );
		}
		
		foreach ( self::$fakeDistances as $fakeDistance ) {
			$this->assertFalse( MapsDistanceParser::parseDistance( $fakeDistance ), "'$fakeDistance' should not be recognized:" );
		}
	}
	
	/**
	 * Tests MapsDistanceParser::formatDistance()
	 */
	public function testFormatDistance() {
			foreach ( self::$distances['km'] as $rawValue => $parsedValue ) {
			$this->assertEquals( $rawValue, MapsDistanceParser::formatDistance( $parsedValue, 'km' ), "'$parsedValue' was not formatted to '$rawValue':" );
		}
	}
	
	/**
	 * Tests MapsDistanceParser::parseAndFormat()
	 */
	public function testParseAndFormat() {
		// TODO Auto-generated MapsDistanceParserTest::testParseAndFormat()
		$this->markTestIncomplete ( "parseAndFormat test not implemented" );
		
		MapsDistanceParser::parseAndFormat(/* parameters */);
	
	}
	
	/**
	 * Tests MapsDistanceParser::isDistance()
	 */
	public function testIsDistance() {
		foreach ( self::$fakeDistances as $fakeDistance ) {
			$this->assertFalse( MapsDistanceParser::isDistance( $fakeDistance ), "'$fakeDistance' should not be recognized:" );
		}
		
		foreach ( self::$distances as $distance ) {
			$this->assertTrue( MapsDistanceParser::isDistance( $distance ), "'$distance' was not be recognized:" );
		}		
	}
	
	/**
	 * Tests MapsDistanceParser::getUnitRatio()
	 */
	public function testGetUnitRatio() {
		// TODO Auto-generated MapsDistanceParserTest::testGetUnitRatio()
		$this->markTestIncomplete ( "getUnitRatio test not implemented" );
		
		MapsDistanceParser::getUnitRatio(/* parameters */);
	
	}
	
	/**
	 * Tests MapsDistanceParser::getValidUnit()
	 */
	public function testGetValidUnit() {
		// TODO Auto-generated MapsDistanceParserTest::testGetValidUnit()
		$this->markTestIncomplete ( "getValidUnit test not implemented" );
		
		MapsDistanceParser::getValidUnit(/* parameters */);
	
	}
	
	/**
	 * Tests MapsDistanceParser::getUnits()
	 */
	public function testGetUnits() {
		// TODO Auto-generated MapsDistanceParserTest::testGetUnits()
		$this->markTestIncomplete ( "getUnits test not implemented" );
		
		MapsDistanceParser::getUnits(/* parameters */);
	
	}

}
