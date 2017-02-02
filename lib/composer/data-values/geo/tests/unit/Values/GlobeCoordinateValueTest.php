<?php

namespace Tests\DataValues\Geo\Values;

use DataValues\Geo\Values\GlobeCoordinateValue;
use DataValues\Geo\Values\LatLongValue;
use DataValues\Tests\DataValueTest;

/**
 * @covers DataValues\Geo\Values\GlobeCoordinateValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class GlobeCoordinateValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\Geo\Values\GlobeCoordinateValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1 );
		$argLists[] = array( new LatLongValue( 4.2, 42 ), 1 );
		$argLists[] = array( new LatLongValue( 42, 4.2 ), 0.1 );
		$argLists[] = array( new LatLongValue( 42, 42 ), 0.1 );
		$argLists[] = array( new LatLongValue( -4.2, -4.2 ), 0.1 );
		$argLists[] = array( new LatLongValue( 4.2, -42 ), 0.1 );
		$argLists[] = array( new LatLongValue( -42, 4.2 ), 10 );
		$argLists[] = array( new LatLongValue( 0, 0 ), 0.001 );

		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, GlobeCoordinateValue::GLOBE_EARTH );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, 'terminus' );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, "Schar's World" );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, 'coruscant' );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, null );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), null );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 'foo' );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), true );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), array( 1 ) );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), '1' );

		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, array( 1 ) );
		$argLists[] = array( new LatLongValue( 4.2, 4.2 ), 1, 1 );

		// TODO: test precisions that are out of the valid range

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param GlobeCoordinateValue $globeCoordinate
	 * @param array $arguments
	 */
	public function testGetLatitude( GlobeCoordinateValue $globeCoordinate, array $arguments ) {
		$actual = $globeCoordinate->getLatitude();

		$this->assertInternalType( 'float', $actual );
		$this->assertEquals( $arguments[0]->getLatitude(), $actual );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param GlobeCoordinateValue $globeCoordinate
	 * @param array $arguments
	 */
	public function testGetLongitude( GlobeCoordinateValue $globeCoordinate, array $arguments ) {
		$actual = $globeCoordinate->getLongitude();

		$this->assertInternalType( 'float', $actual );
		$this->assertEquals( $arguments[0]->getLongitude(), $actual );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param GlobeCoordinateValue $globeCoordinate
	 * @param array $arguments
	 */
	public function testGetPrecision( GlobeCoordinateValue $globeCoordinate, array $arguments ) {
		$actual = $globeCoordinate->getPrecision();

		$this->assertTrue( is_float( $actual ) || is_int( $actual ) || is_null( $actual ), 'Precision is int or float or null' );
		$this->assertEquals( $arguments[1], $actual );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param GlobeCoordinateValue $globeCoordinate
	 * @param array $arguments
	 */
	public function testGetGlobe( GlobeCoordinateValue $globeCoordinate, array $arguments ) {
		$expected = isset( $arguments[2] )
			? $arguments[2]
			: GlobeCoordinateValue::GLOBE_EARTH;

		$actual = $globeCoordinate->getGlobe();

		$this->assertTrue(
			is_string( $actual ),
			'getGlobe should return a string'
		);

		$this->assertEquals( $expected, $actual );
	}

	public function testArrayValueCompatibility() {
		// These serializations where generated using revision f91f65f989cc3ffacbe924012d8f5b574e0b710c
		// The strings are the result of calling getArrayValue on the objects and then feeding this to serialize.

		$serialization = 'a:5:{s:8:"latitude";d:-4.2000000000000002;s:9:"longitude";d:42;s:8:"altitude";N;s:9:"precision";d:0.01;s:5:"globe";s:4:"mars";}';

		$arrayForm = unserialize( $serialization );
		$globeCoordinate = GlobeCoordinateValue::newFromArray( $arrayForm );

		$this->assertEquals( -4.2, $globeCoordinate->getLatitude() );
		$this->assertEquals( 42, $globeCoordinate->getLongitude() );
		$this->assertEquals( 0.01, $globeCoordinate->getPrecision() );
		$this->assertEquals( 'mars', $globeCoordinate->getGlobe() );

		$serialization = 'a:5:{s:8:"latitude";d:-4.2000000000000002;s:9:"longitude";d:-42;s:8:"altitude";d:9001;s:9:"precision";d:1;s:5:"globe";s:33:"http://www.wikidata.org/entity/Q2";}';

		$arrayForm = unserialize( $serialization );
		$globeCoordinate = GlobeCoordinateValue::newFromArray( $arrayForm );

		$this->assertEquals( -4.2, $globeCoordinate->getLatitude() );
		$this->assertEquals( -42, $globeCoordinate->getLongitude() );
		$this->assertEquals( 1, $globeCoordinate->getPrecision() );
		$this->assertEquals( 'http://www.wikidata.org/entity/Q2', $globeCoordinate->getGlobe() );
	}

	public function testSerializeCompatibility() {
		// These serializations where generated using revision f91f65f989cc3ffacbe924012d8f5b574e0b710c
		// The strings are the result of feeding the objects directly into PHPs serialize method.

		$globeCoordinate = unserialize( 'C:31:"DataValues\GlobeCoordinateValue":27:{[-4.2,-42,null,0.01,"mars"]}' );
		$this->assertInstanceOf( $this->getClass(), $globeCoordinate );

		$this->assertEquals( -4.2, $globeCoordinate->getLatitude() );
		$this->assertEquals( -42, $globeCoordinate->getLongitude() );
		$this->assertEquals( 0.01, $globeCoordinate->getPrecision() );
		$this->assertEquals( 'mars', $globeCoordinate->getGlobe() );

		$globeCoordinate = unserialize( 'C:31:"DataValues\GlobeCoordinateValue":27:{[-4.2,-42,9001,0.01,"mars"]}' );
		$this->assertInstanceOf( $this->getClass(), $globeCoordinate );
	}

}
