<?php

namespace SM\Test;
use \SMW\Tests\ResultPrinterTest as ResultPrinterTest;

/**
 *  Tests for the SM\KMLPrinter class.
 *
 * @file
 * @since 1.8
 *
 * @ingroup SemanticMaps
 * @ingroup Test
 *
 * @group SemanticMaps
 * @group SMWExtension
 * @group ResultPrinters
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class KMLPrinterTest extends ResultPrinterTest {

	/**
	 * @see ResultPrinterTest::getFormats
	 *
	 * @since 1.8
	 *
	 * @return array
	 */
	public function getFormats() {
		return array( 'kml' );
	}

	/**
	 * @see ResultPrinterTest::getClass
	 *
	 * @since 1.8
	 *
	 * @return string
	 */
	public function getClass() {
		return '\SMKMLPrinter';

	}
}
