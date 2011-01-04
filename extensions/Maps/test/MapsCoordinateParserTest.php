<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once dirname(__FILE__) . '/commandLine.inc';

/**
 * MapsCoordinateParser test case.
 * 
 * @ingroup Maps
 * @since 0.6.5
 * @author Jeroen De Dauw
 */
class MapsCoordinateParserTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Valid coordinates.
	 * 
	 * @var array
	 */
	public static $coordinates = array(
		'float' => array(
			'55.7557860 N, 37.6176330 W',
			'55.7557860, -37.6176330',
			'55 S, 37.6176330 W',
			'-55, -37.6176330',
			'5.5S,37W ',
			'-5.5,-37 '
		),
		'dd' => array(
			'55.7557860° N, 37.6176330° W',
			'55.7557860°, -37.6176330°',
			'55° S, 37.6176330 ° W',
			'-55°, -37.6176330 °',
			'5.5°S,37°W ',
			'-5.5°,-37° '
		),
		'dm' => array(
			"55° 45.34716' N, 37° 37.05798' W",
			"55° 45.34716', -37° 37.05798'",
			"55° S, 37° 37.05798'W",
			"-55°, -37° 37.05798'",
			"55°S, 37°37.05798'W ",
			"-55°, 37°37.05798' "
		),
		'dms' => array(
			"55° 45' 21\" N, 37° 37' 3\" W",
			"55° 45' 21\", -37° 37' 3\"",
			"55° 45' S, 37° 37' 3\"W",
			"-55°, -37° 37' 3\"",
			"55°45'S,37°37'3\"W ",
			"-55°,-37°37'3\" "
		),
	);
	
	/**
	 * Mappings between coordinate notations.
	 * 
	 * Expected result => array( everything that should lead to it )
	 * 
	 * @var array
	 */	
	public static $coordinateMappings = array(
		// Float to non-directional DMS
		'float-dms' => array(
			'42° 30\' 0", -42° 30\' 0"' => array( '42.5, -42.5', '42.5 N, 42.5 W' ),
			'-42° 30\' 0", 42° 30\' 0"' => array( '-42.5, 42.5', '42.5 S, 42.5 E' ),
			'42° 25\' 27", 42° 25\' 27"' => array( '42.4242, 42.4242', '42.4242 N, 42.4242 E' ),
		),
		// DMS to directional Float
		'dms-float-directional' => array(
			'42.5 N, 42.5 W' => array( '42° 30\' 0", -42° 30\' 0"', '42° 30\' 0" N, 42° 30\' 0" W' ),
			'42.5 S, 42.5 E' => array( '-42° 30\' 0", 42° 30\' 0"', '42° 30\' 0" S, 42° 30\' 0" E' ),
			//'42.4242 N, 42.4242 E' => array( '42° 25\' 27", 42° 25\' 27"', '42° 25\' 27" N, 42° 25\' 27" E' )
		),	
	);
	
	/**
	 * Parsing tests.
	 * 
	 * @var array
	 */
	public static $parsingTests = array(
		'42.5, -42.5' => array( 'lat' => '42.5', 'lon' => '-42.5' ),
		'42° 30\' 0" N, 42° 30\' 0" W' => array( 'lat' => '42.5', 'lon' => '-42.5' ),
	);
	
	/**
	 * Formatting tests.
	 * 
	 * @var array
	 */
	public static $formattingTests = array(
		
	);	
	
	/**
	 * Invalid coordinates.
	 * 
	 * @var array
	 */	
	public static $fakeCoordinates = array(
		'IN YOUR CODE, BEING TOTALLY REDICULOUSE',
		'55.7557860 E, 37.6176330 W',
		'55.7557860 N, 37.6176330 N',
		'55.7557860 S, 37.6176330 N',
		'55.7557860 N, 37.6176330 S',
		'42.5, -42.5.5',
		'42.5, --42.5',
		'42.5-, 42.5',
		'42.5, 42 -5',
		'9342.5, -42.5'
	);
	
	/**
	 * @var MapsCoordinateParser
	 */
	private $MapsCoordinateParser;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->MapsCoordinateParser = new MapsCoordinateParser(/* parameters */);
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->MapsCoordinateParser = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
	}
	
	/**
	 * Tests MapsCoordinateParser::parseCoordinates()
	 */
	public function testParseCoordinates() {
		// TODO Auto-generated MapsCoordinateParserTest::testParseCoordinates()
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::parseCoordinates( $coord ), "parseCoordinates did not return false for $coord." );
		}
		
		foreach ( self::$parsingTests as $coord => $destination ) {
			$this->assertEquals( $destination, MapsCoordinateParser::parseCoordinates( $coord ), "Parsing test failed at " . __METHOD__ );
		}
	}
	
	/**
	 * Tests MapsCoordinateParser::getCoordinatesType()
	 */
	public function testGetCoordinatesType() {
		foreach( self::$coordinates['float'] as $coord ) {
			$this->assertEquals( Maps_COORDS_FLOAT, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as float." );
		}

		foreach( self::$coordinates['dd'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DD, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dd." );
		}
		
		foreach( self::$coordinates['dm'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DM, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dm." );
		}

		foreach( self::$coordinates['dms'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DMS, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dms." );
		}
				
	}
	
	/*
	public function coordinatesProvider() {
		die(__METHOD__);
		$coords = array();
		
		foreach( self::$coordinates as $coordsOfType ) {
			foreach( $coordsOfType as $coord ) {
				$coords[] = array( $coord );
			}			
		}		
		return $coords;
	}
	*/
	
	/**
	 * @dataProvider coordinatesProvider
	 */
	public function testAreCoordinates() {
		foreach( self::$coordinates as $coordsOfType ) {
			foreach( $coordsOfType as $coord ) {	
				$this->assertTrue( MapsCoordinateParser::areCoordinates( $coord ), "$coord not recognized as coordinate." );
			}	
		}
		
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::areCoordinates( $coord ), "$coord was recognized as coordinate." );
		}
	}
	
	/**
	 * Tests MapsCoordinateParser::formatCoordinates()
	 */
	public function testFormatCoordinates() {
		// TODO Auto-generated MapsCoordinateParserTest::testFormatCoordinates()
		$this->markTestIncomplete ( "formatCoordinates test not implemented" );
		
		MapsCoordinateParser::formatCoordinates(/* parameters */);
	
	}
	
	/**
	 * Tests MapsCoordinateParser::formatToArray()
	 */
	public function testFormatToArray() {
		// TODO Auto-generated MapsCoordinateParserTest::testFormatToArray()
		$this->markTestIncomplete ( "formatToArray test not implemented" );
		
		MapsCoordinateParser::formatToArray(/* parameters */);
	
	}
	
	/**
	 * Tests MapsCoordinateParser::areFloatCoordinates()
	 */
	public function testAreFloatCoordinates() {
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::areFloatCoordinates( $coord ), "$coord was recognized as float." );
		}
		foreach( self::$coordinates['float'] as $coord ) {
			$this->assertEquals( Maps_COORDS_FLOAT, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as float." );
		}		
	}
	
	/**
	 * Tests MapsCoordinateParser::areDMSCoordinates()
	 */
	public function testAreDMSCoordinates() {
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::areFloatCoordinates( $coord ), "$coord was recognized as dms." );
		}
		foreach( self::$coordinates['dms'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DMS, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dms." );
		}		
	}
	
	/**
	 * Tests MapsCoordinateParser::areDDCoordinates()
	 */
	public function testAreDDCoordinates() {
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::areFloatCoordinates( $coord ), "$coord was recognized as dd." );
		}
		foreach( self::$coordinates['dd'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DD, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dd." );
		}	
	}
	
	/**
	 * Tests MapsCoordinateParser::areDMCoordinates()
	 */
	public function testAreDMCoordinates() {
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::areFloatCoordinates( $coord ), "$coord was recognized as dm." );
		}
		foreach( self::$coordinates['dm'] as $coord ) {
			$this->assertEquals( Maps_COORDS_DM, MapsCoordinateParser::getCoordinatesType( $coord ), "$coord not recognized as dm." );
		}		
	}
	
	/**
	 * Tests MapsCoordinateParser::parseAndFormat()
	 */
	public function testParseAndFormat() {
		// TODO Auto-generated MapsCoordinateParserTest::testParseAndFormat()
		foreach ( self::$fakeCoordinates as $coord ) {
			$this->assertFalse( MapsCoordinateParser::parseAndFormat( $coord ), "parseAndFormat did not return false for $coord." );
		}
		
		foreach ( self::$coordinateMappings['float-dms'] as $destination => $sources ) {
			foreach ( $sources as $source ) {
				$result = MapsCoordinateParser::parseAndFormat( $source, Maps_COORDS_DMS, false );
				$this->assertEquals( 
					$destination,
					$result,
					"$source parsed to \n$result, not \n$destination."
				);
			}
		}
		
		foreach ( self::$coordinateMappings['dms-float-directional'] as $destination => $sources ) {
			foreach ( $sources as $source ) {
				$result = MapsCoordinateParser::parseAndFormat( $source, Maps_COORDS_FLOAT, true );
				$this->assertEquals( 
					$destination,
					$result,
					"$source parsed to \n$result, not \n$destination."
				);
			}
		}		
	}

}
