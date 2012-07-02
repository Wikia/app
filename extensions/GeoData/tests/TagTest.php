<?php

/**
 * @group GeoData
 */
class TagTest extends MediaWikiTestCase {
	public function setUp() {
		$GLOBALS['wgDefaultDim'] = 1000; // reset to default
	}

	private function setWarnings( $level ) {
		global $wgGeoDataWarningLevel;
		foreach ( array_keys( $wgGeoDataWarningLevel ) as $key ) {
			$wgGeoDataWarningLevel[$key] = $level;
		}
	}

	private function assertParse( $input, $expected ) {
		$p = new Parser();
		$opt = new ParserOptions();
		$out = $p->parse( $input, Title::newMainPage(), $opt );
		$this->assertTrue( isset( $out->geoData ) );
		if ( !$expected ) {
			$this->assertEmpty( $out->geoData->getAll(),
				'Expected a failure but a result was found: ' . print_r( $out->geoData->getAll(), true )
			);
			return;
		}
		$all = $out->geoData->getAll();
		$this->assertEquals( 1, count( $all ), 'A result was expected, but there was error: ' . strip_tags( $out->getText() ) );
		$coord = $all[0];
		foreach ( $expected as $field => $value ) {
			$this->assertEquals( $value, $coord->$field, "Checking field $field" );
		}
	}

	/**
	 * @dataProvider getLooseData
	 */
	public function testLooseTagParsing( $input, $expected ) {
		$this->setWarnings( 'none' );
		$this->assertParse( $input, $expected );
	}

	/**
	 * @dataProvider getStrictData
	 */
	public function testStrictTagParsing( $input, $expected ) {
		$this->setWarnings( 'fail' );
		$this->assertParse( $input, $expected );
	}

	public function getLooseData() {
		return array(
			// Basics
			array(
				'{{#coordinates: 10|20|primary}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'primary' => true ),
			),
			array(
				'{{#coordinates: 100|20|primary}}', 
				false,
			),
			array(
				'{{#coordinates: 10|2000|primary}}', 
				false,
			),
			array(
				'{{#coordinates: 10| primary		|	20}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'primary' => true ),
			),
			array( // empty parameter instead of primary
				'{{#coordinates: 10 | |	20 }}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'primary' => false ),
			),
			array(
				'{{#coordinates: primary|10|20}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'primary' => true ),
			),
			// type
			array(
				'{{#coordinates: 10|20|type:city}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'type' => 'city' ),
			),
			array(
				'{{#coordinates: 10|20|type:city(666)}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'type' => 'city' ),
			),
			// Other geohack params
			array(
				'{{#coordinates: 10|20}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 1000 ),
			),
			array( 
				'{{#coordinates:10|20|globe:Moon dim:10_region:RU-mos}}',
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'moon', 'country' => 'RU', 'region' => 'MOS', 'dim' => 10 ),
			),
			array( 
				'{{#coordinates:10|20|globe:Moon dim:10_region:RU}}',
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'moon', 'country' => 'RU', 'dim' => 10 ),
			),
			array(
				'{{#coordinates: 10|20|_dim:3Km_}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 3000 ),
			),
			array(
				'{{#coordinates: 10|20|foo:bar dim:100m}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 100 ),
			),
			array(
				'{{#coordinates: 10|20|dim:-300}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 1000 ),
			),
			array(
				'{{#coordinates: 10|20|dim:-10km}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 1000 ),
			),
			array(
				'{{#coordinates: 10|20|dim:1L}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 1000 ),
			),
			// dim fallbacks
			array(
				'{{#coordinates: 10|20|type:city}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'type' => 'city', 'dim' => 10000 ),
			),
			array(
				'{{#coordinates: 10|20|type:city(2000)}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'type' => 'city', 'dim' => 10000 ),
			),
			array(
				'{{#coordinates: 10|20|type:lulz}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'type' => 'lulz', 'dim' => 1000 ),
			),
			array(
				'{{#coordinates: 10|20|scale:50000}}', 
				array( 'lat' => 10, 'lon' => 20, 'globe' => 'earth', 'dim' => 5000 ),
			),
		);
	}

	public function getStrictData() {
		return array(
			array(
				'{{#coordinates:10|20|globe:Moon dim:10_region:RUS-MOS}}',
				false,
			),
			array(
				'{{#coordinates:10|20|globe:Moon dim:10_region:RU-}}',
				false,
			),
			array(
				'{{#coordinates:10|20|globe:Moon dim:10|region=RU-longvalue}}',
				false,
			),
			array(
				'{{#coordinates:10|20|globe:Moon dim:10_region:РУ-МОС}}',
				false,
			),
		);
	}
}