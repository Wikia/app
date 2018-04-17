<?php

namespace Maps\Tests\Semantic\DataValues;

use Maps\Semantic\DataValues\CoordinateValue;
use Maps\Semantic\ValueDescriptions\AreaDescription;
use Maps\Semantic\ValueDescriptions\CoordinateDescription;
use SMW\DataValueFactory;
use SMWDataItem;
use SMWDIGeoCoord;

/**
 * @covers \Maps\Semantic\ValueDescriptions\CoordinateValue
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CoordinateValueTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if ( !defined( 'SMW_VERSION' ) ) {
			$this->markTestSkipped( 'SMW is not available' );
		}
	}

	public function testConstruct() {
		$geoDI = new SMWDIGeoCoord( 23, 42 );

		/**
		 * @var CoordinateValue $geoValue
		 */
		$geoValue = DataValueFactory::newDataItemValue( $geoDI );

		$this->assertInstanceOf( CoordinateValue::class, $geoValue );

		$this->assertEquals( $geoDI, $geoValue->getDataItem() );
		$this->assertEquals( '23° 0\' 0", 42° 0\' 0"', $geoValue->getShortWikiText() );
	}

	/**
	 * @dataProvider coordinateProvider
	 */
	public function testGetQueryDescription( $lat, $long, $serialization ) {
		$geoValue = $this->newInstance();

		$description = $geoValue->getQueryDescription( $serialization );

		$this->assertIsCorrectCoordValue( $description, $lat, $long );
	}

	protected function newInstance() {
		return new CoordinateValue( SMWDataItem::TYPE_GEO );
	}

	private function assertIsCorrectCoordValue( $description, $lat, $long ) {
		/**
		 * @var CoordinateDescription $description
		 */
		$this->assertInstanceOf( CoordinateDescription::class, $description );
		$this->assertEquals( $lat, $description->getDataItem()->getLatitude() );
		$this->assertEquals( $long, $description->getDataItem()->getLongitude() );
	}

	public function coordinateProvider() {
		return [
			[
				23,
				42,
				'23° 0\' 0", 42° 0\' 0"',
			],
			[
				0,
				0,
				'0° 0\' 0", 0° 0\' 0"',
			],
			[
				-23.5,
				-42.5,
				'-23° 30\' 0", -42° 30\' 0"',
			],
		];
	}

	/**
	 * @dataProvider coordinateWithDistanceProvider
	 */
	public function testGetQueryDescriptionForArea( $serialization ) {
		$geoValue = $this->newInstance();

		$description = $geoValue->getQueryDescription( $serialization );

		$this->assertInstanceOf( AreaDescription::class, $description );
	}

	public function coordinateWithDistanceProvider() {
		return [
			[
				'23° 0\' 0", 42° 0\' 0"(1km)',
				1000,
			],
			[
				'0° 0\' 0", 0° 0\' 0" ( 1 m )',
				1,
			],
			[
				'-23° 30\' 0", -42° 30\' 0" (9001m)',
				9001,
			],
		];
	}

}
