<?php

namespace Maps\Test;

use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;
use Maps\LocationParser;
use Title;

/**
 * @covers Maps\LocationParser
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LocationParserTest extends \ValueParsers\Test\StringValueParserTest {

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
			'55.7557860 N, 37.6176330 W' => array( 55.7557860, -37.6176330 ),
			'55.7557860, -37.6176330' => array( 55.7557860, -37.6176330 ),
			'55 S, 37.6176330 W' => array( -55, -37.6176330 ),
			'-55, -37.6176330' => array( -55, -37.6176330 ),
			'5.5S,37W ' => array( -5.5, -37 ),
			'-5.5,-37 ' => array( -5.5, -37 ),
			'4,2' => array( 4, 2 ),
		);

		foreach ( $valid as $value => $expected ) {
			$expected = new Location( new LatLongValue( $expected[0], $expected[1] ) );
			$argLists[] = array( (string)$value, $expected );
		}

		$location = new Location( new LatLongValue( 4, 2 ) );
		$location->setTitle( 'Title' );
		$location->setText( 'some description' );
		$argLists[] = array( '4,2~Title~some description', $location );

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
		return 'Maps\LocationParser';
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

	/**
	 * @dataProvider titleProvider
	 */
	public function testGivenTitleThatIsNotLink_titleIsSetAndLinkIsNot( $title ) {
		$parser = new LocationParser();
		$location = $parser->parse( '4,2~' . $title );

		$this->assertTitleAndLinkAre( $location, $title, '' );
	}

	public function titleProvider() {
		return array(
			array( '' ),
			array( 'Title' ),
			array( 'Some title' ),
			array( 'link' ),
			array( 'links:foo' ),
		);
	}

	protected function assertTitleAndLinkAre( Location $location, $title, $link ) {
		$this->assertHasJsonKeyWithValue( $location, 'title', $title );
		$this->assertHasJsonKeyWithValue( $location, 'link', $link );
	}

	protected function assertHasJsonKeyWithValue( Location $polygon, $key, $value ) {
		$json = $polygon->getJSONObject();

		$this->assertArrayHasKey( $key, $json );
		$this->assertEquals(
			$value,
			$json[$key]
		);
	}

	/**
	 * @dataProvider linkProvider
	 */
	public function testGivenTitleThatIsLink_linkIsSetAndTitleIsNot( $link ) {
		$parser = new LocationParser();
		$location = $parser->parse( '4,2~link:' . $link );

		$this->assertTitleAndLinkAre( $location, '', $link );
	}

	public function linkProvider() {
		return array(
			array( 'https://semantic-mediawiki.org' ),
			array( 'http://www.semantic-mediawiki.org' ),
			array( 'irc://freenode.net' ),
		);
	}

	/**
	 * @dataProvider titleLinkProvider
	 */
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

}
