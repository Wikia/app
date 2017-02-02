<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\RectangleParser;

/**
 * @covers Maps\RectangleParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class RectangleParserTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {
		new RectangleParser();
		$this->assertTrue( true );
	}

	public function testGivenBoundingBox_parserReturnsRectangle() {
		$parser = new RectangleParser();

		$rectangle = $parser->parse( '51.8357775,33.83789:46,23.37890625' );

		$this->assertInstanceOf( 'Maps\Elements\Rectangle', $rectangle );

		$expectedNorthEast = new LatLongValue( 51.8357775, 33.83789 );
		$this->assertTrue( $expectedNorthEast->equals( $rectangle->getRectangleNorthEast() ) );

		$expectedSouthWest = new LatLongValue( 46, 23.37890625 );
		$this->assertTrue( $expectedSouthWest->equals( $rectangle->getRectangleSouthWest() ) );
	}

	public function testGivenTitleAndText_rectangleHasProvidedMetaData() {
		$parser = new RectangleParser();

		$rectangle = $parser->parse( "51.8357775,33.83789:46,23.37890625~I'm a square~of doom" );

		$this->assertInstanceOf( 'Maps\Elements\Rectangle', $rectangle );

		$this->assertEquals( "I'm a square", $rectangle->getTitle() );
		$this->assertEquals( 'of doom', $rectangle->getText() );
	}

}
