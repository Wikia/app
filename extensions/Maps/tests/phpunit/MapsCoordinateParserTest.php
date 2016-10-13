<?php

namespace Maps\Test;
use MapsCoordinateParser;

/**
 * Tests for the MapsCoordinateParser class.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @since 0.6.5
 *
 * @ingroup Maps
 * @ingroup Test
 *
 * @group Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsCoordinateParserTest extends \MediaWikiTestCase {
	
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
	 * Invalid coordinates.
	 * 
	 * @var array
	 */	
	public static $fakeCoordinates = array(
		'IN YOUR CODE, BEING TOTALLY RIDICULOUS',
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
	 * Tests MapsCoordinateParser::parseCoordinates()
	 */
	public function testParseCoordinates() {
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
	
	/**
	 * Tests MapsCoordinateParser::areCoordinates()
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
