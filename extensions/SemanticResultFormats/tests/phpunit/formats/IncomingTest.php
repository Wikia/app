<?php

namespace SRF\Test;
use SMW\Tests\ResultPrinterTest;

/**
 *  Tests for the SRF\Incoming class.
 *
 * @file
 * @since 1.8
 *
 * @ingroup SemanticResultFormats
 * @ingroup Test
 *
 * @group SRF
 * @group SMWExtension
 * @group ResultPrinters
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class IncomingTest extends ResultPrinterTest {

	/**
	 * @see ResultPrinterTest::getFormats
	 *
	 * @since 1.8
	 *
	 * @return array
	 */
	public function getFormats() {
		return array( 'incoming' );
	}

	/**
	 * @see ResultPrinterTest::getClass
	 *
	 * @since 1.8
	 *
	 * @return string
	 */
	public function getClass() {
		return '\SRFIncoming';
	}

}
