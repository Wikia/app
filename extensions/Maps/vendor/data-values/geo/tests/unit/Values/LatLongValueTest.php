<?php

namespace Tests\DataValues\Geo\Values;

use DataValues\Geo\Values\LatLongValue;
use DataValues\Tests\DataValueTest;

/**
 * @covers DataValues\Geo\Values\LatLongValue
 *
 * @group DataValue
 * @group DataValueExtensions
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LatLongValueTest extends DataValueTest {

	/**
	 * @see DataValueTest::getClass
	 *
	 * @return string
	 */
	public function getClass() {
		return 'DataValues\Geo\Values\LatLongValue';
	}

	public function validConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( 4.2, 4.2 );
		$argLists[] = array( 4.2, 42 );
		$argLists[] = array( 42, 4.2 );
		$argLists[] = array( 42, 42 );
		$argLists[] = array( -4.2, -4.2 );
		$argLists[] = array( 4.2, -42 );
		$argLists[] = array( -42, 4.2 );
		$argLists[] = array( 360, -360 );
		$argLists[] = array( 48.269, -225.99 );
		$argLists[] = array( 0, 0 );

		return $argLists;
	}

	public function invalidConstructorArgumentsProvider() {
		$argLists = array();

		$argLists[] = array( null, null );

		$argLists[] = array( 42, null );
		$argLists[] = array( array(), null );
		$argLists[] = array( false, null );
		$argLists[] = array( true, null );
		$argLists[] = array( 'foo', null );
		$argLists[] = array( 42, null );

		$argLists[] = array( 'en', 42 );
		$argLists[] = array( 'en', 4.2 );
		$argLists[] = array( 42, false );
		$argLists[] = array( 42, array() );
		$argLists[] = array( 42, 'foo' );
		$argLists[] = array( 4.2, 'foo' );

		$argLists[] = array( '4.2', 4.2 );
		$argLists[] = array( '4.2', '4.2' );
		$argLists[] = array( 4.2, '4.2' );
		$argLists[] = array( '42', 42 );
		$argLists[] = array( 42, '42' );
		$argLists[] = array( '0', 0 );

		$argLists[] = array( -361, 0 );
		$argLists[] = array( -999, 1 );
		$argLists[] = array( 360.001, 2 );
		$argLists[] = array( 3, 361 );
		$argLists[] = array( 4, -1337 );

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param LatLongValue $latLongValue
	 * @param array $arguments
	 */
	public function testGetLatitude( LatLongValue $latLongValue, array $arguments ) {
		$actual = $latLongValue->getLatitude();

		$this->assertInternalType( 'float', $actual );
		$this->assertEquals( (float)$arguments[0], $actual );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param LatLongValue $latLongValue
	 * @param array $arguments
	 */
	public function testGetLongitude( LatLongValue $latLongValue, array $arguments ) {
		$actual = $latLongValue->getLongitude();

		$this->assertInternalType( 'float', $actual );
		$this->assertEquals( (float)$arguments[1], $actual );
	}

}
