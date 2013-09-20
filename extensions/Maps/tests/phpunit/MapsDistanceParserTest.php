<?php

namespace Maps\Test;
use MapsDistanceParser;

/**
 * Tests for the MapsCoordinates class.
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
class MapsDistanceParserTest extends \MediaWikiTestCase {
	
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
			'42.4242 m' => 42.4242,
		),		
		'km' => array(
			//'0.001 km' => 1,
			'1 km' => 1000,
			'4.24 km' => 4242,
		),
		'kilometers' => array(
			'0.001 kilometers' => 1,
			'1 kilometers' => 1000,
			'4.24 kilometers' => 4242,
		),
	);
	
	/**
	 * Invalid distances.
	 * 
	 * @var array
	 */	
	public static $fakeDistances = array(	
		'IN YOUR CODE, BEING TOTALLY RIDICULOUS',
		'0x20 km',
		'km 42',
		'42 42 km',
		'42 km km',
		'42 foo',
		'3.4.2 km'
	);
	
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
		foreach ( self::$formatTests['km'] as $rawValue => $parsedValue ) {
			$this->assertEquals( $rawValue, MapsDistanceParser::formatDistance( $parsedValue, 'km' ), "'$parsedValue' was not formatted to '$rawValue':" );
		}
	}
	
	/**
	 * Tests MapsDistanceParser::parseAndFormat()
	 */
	public function testParseAndFormat() {
		$conversions = array(
			'42 km' => '42000 m'
		);
		
		foreach( array_merge( $conversions, array_reverse( $conversions ) ) as $source => $target ) {
			global $wgContLang;
			$unit = explode( ' ', $target, 2 );
			$unit = $unit[1];
			$this->assertEquals( $wgContLang->formatNum( $target ), MapsDistanceParser::parseAndFormat( $source, $unit ), "'$source' was not parsed and formatted to '$target':" );
		}
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
		foreach ( $GLOBALS['egMapsDistanceUnits'] as $unit => $ratio ) {
			$r = MapsDistanceParser::getUnitRatio( $unit );
			$this->assertEquals( $ratio, $r, "The ratio for '$unit' should be '$ratio' but was '$r'" );
		}
	}
	
	/**
	 * Tests MapsDistanceParser::getValidUnit()
	 */
	public function testGetValidUnit() {
		foreach ( $GLOBALS['egMapsDistanceUnits'] as $unit => $ratio ) {
			$u = MapsDistanceParser::getValidUnit( $unit );
			$this->assertEquals( $unit, $u, "The valid unit for '$unit' should be '$unit' but was '$u'" );			
		}
		
		global $egMapsDistanceUnit;
		
		foreach ( array( '0', 'swfwdffdhy', 'dxwgdrfh' ) as $unit ) {
			$u = MapsDistanceParser::getValidUnit( $unit );
			$this->assertEquals( $egMapsDistanceUnit, $u, "The valid unit for '$unit' should be '$egMapsDistanceUnit' but was '$u'" );
		}
	}
	
	/**
	 * Tests MapsDistanceParser::getUnits()
	 */
	public function testGetUnits() {
		$this->assertEquals( array_keys( $GLOBALS['egMapsDistanceUnits'] ), MapsDistanceParser::getUnits() );
	}

}
