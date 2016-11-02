<?php

namespace Maps\Tests\Elements;

use Maps\Elements\ImageOverlay;

/**
 * @covers Maps\Elements\ImageOverlay
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ImageOverlayTest extends RectangleTest {

	/**
	 * @see BaseElementTest::getClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public function getClass() {
		return 'Maps\Elements\ImageOverlay';
	}

	public function validConstructorProvider() {
		$argLists = parent::validConstructorProvider();

		foreach ( $argLists as &$argList ) {
			$argList[] = 'Foo.png';
		}

		return $argLists;
	}

	public function invalidConstructorProvider() {
		$argLists = parent::validConstructorProvider();

		foreach ( $argLists as &$argList ) {
			$argList[] = null;
		}

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param ImageOverlay $imageOverlay
	 * @param array $arguments
	 */
	public function testGetImage( ImageOverlay $imageOverlay, array $arguments ) {
		$this->assertEquals( $arguments[2], $imageOverlay->getImage() );
	}

}



