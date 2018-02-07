<?php

namespace Maps\Test;

use Maps\Elements\WmsOverlay;
use Maps\WmsOverlayParser;

/**
 * @covers Maps\WmsOverlayParser
 * @licence GNU GPL v2+
 * @author Mathias Mølster Lidal <mathiaslidal@gmail.com>
 */
class WmsOverlayParserTest extends \ValueParsers\Test\StringValueParserTest {

	public function setUp() {
		if ( !defined( 'MEDIAWIKI' ) ) {
			$this->markTestSkipped( 'MediaWiki is not available' );
		}
	}

	/**
	 * @see ValueParserTestBase::validInputProvider
	 *
	 * @return array
	 */
	public function validInputProvider() {
		$argLists = [];

		$valid = [
			"http://demo.cubewerx.com/demo/cubeserv/cubeserv.cgi? Foundation.GTOPO30" =>
				[ "http://demo.cubewerx.com/demo/cubeserv/cubeserv.cgi?", "Foundation.GTOPO30" ],
			"http://maps.imr.no:80/geoserver/wms? vulnerable_areas:Identified_coral_area coral_identified_areas" =>
				[
					"http://maps.imr.no:80/geoserver/wms?",
					"vulnerable_areas:Identified_coral_area",
					"coral_identified_areas"
				]
		];

		foreach ( $valid as $value => $expected ) {
			$expectedOverlay = new WmsOverlay( $expected[0], $expected[1] );

			if ( count( $expected ) == 3 ) {
				$expectedOverlay->setWmsStyleName( $expected[2] );
			}

			$argLists[] = [ (string)$value, $expectedOverlay ];
		}

		return $argLists;
	}

	/**
	 * @return string
	 */
	protected function getParserClass() {
		return WmsOverlayParser::class;
	}

	/**
	 * @see ValueParserTestBase::requireDataValue
	 *
	 * @return boolean
	 */
	protected function requireDataValue() {
		return false;
	}

	protected function getInstance() {
		return new WmsOverlayParser();
	}

}
