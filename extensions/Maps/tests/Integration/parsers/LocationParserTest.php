<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Jeroen\SimpleGeocoder\Geocoders\StubGeocoder;
use Maps\Elements\Location;
use Maps\LocationParser;

/**
 * @covers \Maps\LocationParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LocationParserTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		if ( !defined( 'MEDIAWIKI' ) ) {
			$this->markTestSkipped( 'MediaWiki is not available' );
		}
	}

	/**
	 * @dataProvider titleProvider
	 */
	public function testGivenTitleThatIsNotLink_titleIsSetAndLinkIsNot( $title ) {
		$parser = LocationParser::newInstance( new StubGeocoder( new LatLongValue( 1, 2 ) ) );
		$location = $parser->parse( '4,2~' . $title );

		$this->assertTitleAndLinkAre( $location, $title, '' );
	}

	protected function assertTitleAndLinkAre( Location $location, $title, $link ) {
		$this->assertHasJsonKeyWithValue( $location, 'title', $title );
		$this->assertHasJsonKeyWithValue( $location, 'link', $link );
	}

	protected function assertHasJsonKeyWithValue( Location $polygon, $key, $value ) {
		$json = $polygon->getJSONObject();

		$this->assertArrayHasKey( $key, $json );
		$this->assertEquals( $value, $json[$key] );
	}

	public function titleProvider() {
		return [
			[ '' ],
			[ 'Title' ],
			[ 'Some title' ],
			[ 'link' ],
			[ 'links:foo' ],
		];
	}

	/**
	 * @dataProvider linkProvider
	 */
	public function testGivenTitleThatIsLink_linkIsSetAndTitleIsNot( $link ) {
		$parser = LocationParser::newInstance( new StubGeocoder( new LatLongValue( 1, 2 ) ) );
		$location = $parser->parse( '4,2~link:' . $link );

		$this->assertTitleAndLinkAre( $location, '', $link );
	}

	public function linkProvider() {
		return [
			[ 'https://www.semantic-mediawiki.org' ],
			[ 'irc://freenode.net' ],
		];
	}

//	/**
//	 * @dataProvider titleLinkProvider
//	 */
//	public function testGivenPageTitleAsLink_pageTitleIsTurnedIntoUrl( $link ) {
//		$parser = new LocationParser();
//		$location = $parser->parse( '4,2~link:' . $link );
//
//		$linkUrl = Title::newFromText( $link )->getFullURL();
//		$this->assertTitleAndLinkAre( $location, '', $linkUrl );
//	}
//
//	public function titleLinkProvider() {
//		return array(
//			array( 'Foo' ),
//			array( 'Some_Page' ),
//		);
//	}

	public function testGivenAddressAndNoTitle_addressIsSetAsTitle() {
		$geocoder = new StubGeocoder( new LatLongValue( 4, 2 ) );

		$parser = LocationParser::newInstance( $geocoder, true );
		$location = $parser->parse( 'Tempelhofer Ufer 42' );

		$this->assertSame( 'Tempelhofer Ufer 42', $location->getTitle() );
	}

	public function testGivenAddressAndTitle_addressIsNotUsedAsTitle() {
		$geocoder = new StubGeocoder( new LatLongValue( 4, 2 ) );

		$parser = LocationParser::newInstance( $geocoder, true );
		$location = $parser->parse( 'Tempelhofer Ufer 42~Great title of doom' );

		$this->assertSame( 'Great title of doom', $location->getTitle() );
	}

	public function testGivenCoordinatesAndNoTitle_noTitleIsSet() {
		$parser = LocationParser::newInstance(
			new StubGeocoder( new LatLongValue( 1, 2 ) ),
			true
		);
		$location = $parser->parse( '4,2' );

		$this->assertFalse( $location->getOptions()->hasOption( 'title' ) );
	}

}
