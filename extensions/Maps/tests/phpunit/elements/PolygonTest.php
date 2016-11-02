<?php

namespace Maps\Tests\Elements;

use Maps\Elements\Polygon;

/**
 * @covers Maps\Elements\Polygon
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class PolygonTest extends LineTest {

	/**
	 * @see BaseElementTest::getClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getClass() {
		return 'Maps\Elements\Polygon';
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Polygon $polygon
	 * @param array $arguments
	 */
	public function testSetOnlyVisibleOnHover( Polygon $polygon, array $arguments ) {
		$this->assertFalse( $polygon->isOnlyVisibleOnHover() );

		$polygon->setOnlyVisibleOnHover( true );
		$this->assertTrue( $polygon->isOnlyVisibleOnHover() );

		$polygon->setOnlyVisibleOnHover( false );
		$this->assertFalse( $polygon->isOnlyVisibleOnHover() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Polygon $polygon
	 * @param array $arguments
	 */
	public function testSetFillOpacity( Polygon $polygon, array $arguments ) {
		$polygon->setFillOpacity( '0.42' );
		$this->assertHasJsonKeyWithValue( $polygon, 'fillOpacity', '0.42' );
	}

	protected function assertHasJsonKeyWithValue( Polygon $polygon, $key, $value ) {
		$json = $polygon->getJSONObject();

		$this->assertArrayHasKey( $key, $json );
		$this->assertEquals(
			$value,
			$json[$key]
		);
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Polygon $polygon
	 * @param array $arguments
	 */
	public function testSetFillColor( Polygon $polygon, array $arguments ) {
		$polygon->setFillColor( '#FFCCCC' );
		$this->assertHasJsonKeyWithValue( $polygon, 'fillColor', '#FFCCCC' );
	}

}



