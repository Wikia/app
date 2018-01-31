<?php

use DataValues\Geo\Values\LatLongValue;
use Maps\Element;
use Maps\ElementOptions;
use Maps\Elements\Circle;
use Maps\Elements\ImageOverlay;
use Maps\Elements\Line;
use Maps\Elements\Rectangle;

/**
 * @covers Maps\Elements\BaseElement
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ElementTest extends \PHPUnit_Framework_TestCase {

	public function elementProvider() {
		$elements = [];

		$elements[] = [ new Rectangle( new LatLongValue( 4, 2 ), new LatLongValue( 5, 6 ) ) ];
		$elements[] = [ new ImageOverlay( new LatLongValue( 4, 2 ), new LatLongValue( 5, 6 ), 'foo' ) ];
		$elements[] = [ new Circle( new LatLongValue( 4, 2 ), 42 ) ];
		$elements[] = [ new Line( [ new LatLongValue( 4, 2 ), new LatLongValue( 5, 6 ) ] ) ];

		//$elements[] = new \Maps\Polygon( array( new LatLongValue( 4, 2 ), new LatLongValue( 5, 6 ) ) );
		// TODO: location

		return $elements;
	}

	/**
	 * @dataProvider elementProvider
	 *
	 * @param Element $element
	 */
	public function getArrayValue( Element $element ) {
		$this->assertEquals( $element->getArrayValue(), $element->getArrayValue() );
	}

	/**
	 * @dataProvider elementProvider
	 *
	 * @param Element $element
	 */
	public function testSetOptions( Element $element ) {
		$options = new \Maps\ElementOptions();
		$options->setOption( 'foo', 'bar' );
		$options->setOption( '~=[,,_,,]:3', 42 );

		$element->setOptions( $options );

		$this->assertEquals( $element->getOptions()->getOption( 'foo' ), 'bar' );
		$this->assertEquals( $element->getOptions()->getOption( '~=[,,_,,]:3' ), 42 );

		$options = clone $options;
		$options->setOption( 'foo', 'baz' );

		$element->setOptions( $options );

		$this->assertEquals( $element->getOptions()->getOption( 'foo' ), 'baz' );
	}

	/**
	 * @dataProvider elementProvider
	 *
	 * @param Element $element
	 */
	public function testGetOptions( Element $element ) {
		$this->assertInstanceOf( ElementOptions::class, $element->getOptions() );
	}

}
