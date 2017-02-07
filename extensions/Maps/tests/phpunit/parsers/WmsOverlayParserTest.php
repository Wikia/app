<?php

namespace Maps\Test;

use Maps\Elements\WmsOverlay;

/**
 * @covers Maps\WmsOverlayParser
 * @licence GNU GPL v2+
 * @author Mathias Mølster Lidal <mathiaslidal@gmail.com>
 */
class WmsOverlayParserTest extends \ValueParsers\Test\StringValueParserTest {

	/**
	 * @see ValueParserTestBase::validInputProvider
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	public function validInputProvider() {
		$argLists = array();

		$valid = array(
			"http://demo.cubewerx.com/demo/cubeserv/cubeserv.cgi? Foundation.GTOPO30" =>
				array( "http://demo.cubewerx.com/demo/cubeserv/cubeserv.cgi?", "Foundation.GTOPO30" ),
			"http://maps.imr.no:80/geoserver/wms? vulnerable_areas:Identified_coral_area coral_identified_areas" =>
				array( "http://maps.imr.no:80/geoserver/wms?", "vulnerable_areas:Identified_coral_area", "coral_identified_areas" )
		);

		foreach ( $valid as $value => $expected ) {
			$expectedOverlay = new WmsOverlay( $expected[0], $expected[1] );

			if ( count( $expected ) == 3 ) {
				$expectedOverlay->setWmsStyleName( $expected[2] );
			}

			$argLists[] = array( (string)$value, $expectedOverlay );
		}

		return $argLists;
	}


	/**
	 * @see ValueParserTestBase::getParserClass
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	protected function getParserClass() {
		return 'Maps\WmsOverlayParser';
	}

	/**
	 * @see ValueParserTestBase::requireDataValue
	 *
	 * @since 3.0
	 *
	 * @return boolean
	 */
	protected function requireDataValue() {
		return false;
	}

}
