<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;
use MWException;
use Title;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a location.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LocationParser extends StringValueParser {

	// TODO
	private $supportGeocoding = true;

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return Location
	 * @throws MWException
	 */
	public function stringParse( $value ) {
		$separator = '~';

		$metaData = explode( $separator, $value );

		$coordinates = $this->stringToLatLongValue( array_shift( $metaData ) );

		$location = new Location( $coordinates );

		if ( $metaData !== array() ) {
			$this->setTitleOrLink( $location, array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$location->setText( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$location->setIcon( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$location->setGroup( array_shift( $metaData ) );
		}

		if ( $metaData !== array() ) {
			$location->setInlineLabel( array_shift( $metaData ) );
		}

		return $location;
	}

	private function setTitleOrLink( Location $location, $titleOrLink ) {
		if ( $this->isLink( $titleOrLink ) ) {
			$this->setLink( $location, $titleOrLink );
		}
		else {
			$location->setTitle( $titleOrLink );
		}
	}

	private function isLink( $value ) {
		return strpos( $value , 'link:' ) === 0;
	}

	private function setLink( Location $location, $link ) {
		$link = substr( $link, 5 );
		$location->setLink( $this->getExpandedLink( $link ) );
	}

	private function getExpandedLink( $link ) {
		if ( filter_var( $link , FILTER_VALIDATE_URL , FILTER_FLAG_SCHEME_REQUIRED ) ) {
			return $link;
		}

		$title = Title::newFromText( $link );

		if ( $title === null ) {
			return '';
		}

		return $title->getFullUrl();
	}

	/**
	 * @param string $location
	 *
	 * @return LatLongValue
	 * @throws ParseException
	 */
	private function stringToLatLongValue( $location ) {
		if ( $this->supportGeocoding && Geocoders::canGeocode() ) {
			$location = Geocoders::attemptToGeocode( $location );

			if ( $location === false ) {
				throw new ParseException( 'Failed to parse or geocode' );
			}

			assert( $location instanceof LatLongValue );
			return $location;
		}

		$parser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );
		return $parser->parse( $location );
	}

}
