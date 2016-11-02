<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\CircleParser;

/**
 * @covers Maps\CircleParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CircleParserTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {
		new CircleParser();
		$this->assertTrue( true );
	}

	public function testGivenCoordinateAndRadius_parserReturnsCircle() {
		$parser = new CircleParser();

		$circle = $parser->parse( '57.421,23.90625:32684.605182' );

		$this->assertInstanceOf( 'Maps\Elements\Circle', $circle );

		$expectedLatLong = new LatLongValue( 57.421, 23.90625 );
		$this->assertTrue( $expectedLatLong->equals( $circle->getCircleCentre() ) );

		$this->assertEquals( 32684.605182, $circle->getCircleRadius() );
	}

	public function testGivenTitleAndText_circleHasProvidedMetaData() {
		$parser = new CircleParser();

		$circle = $parser->parse( '57.421,23.90625:32684.605182~title~text' );

		$this->assertInstanceOf( 'Maps\Elements\Circle', $circle );

		$this->assertEquals( 'title', $circle->getTitle() );
		$this->assertEquals( 'text', $circle->getText() );
	}

}
