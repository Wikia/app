<?php

namespace Maps;

use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use Maps\Elements\Location;
use MWException;
use Title;
use ValueParsers\ParserOptions;
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

	/**
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( 'useaddressastitle', false );
		$this->defaultOption( 'geoService', '' );
	}

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 3.0
	 *
	 * @param string $value
	 *
	 * @return Location
	 * @throws ParseException
	 */
	public function stringParse( $value ) {
		$separator = '~';

		$useaddressastitle = $this->getOption( 'useaddressastitle' );

		$metaData = explode( $separator, $value );

		$coordinatesOrAddress = array_shift( $metaData );
		$coordinates = $this->stringToLatLongValue( $coordinatesOrAddress );

		$location = new Location( $coordinates );

		if ( $metaData !== [] ) {
			$this->setTitleOrLink( $location, array_shift( $metaData ) );
		}
		else if ( $useaddressastitle && $this->isAddress( $coordinatesOrAddress ) ) {
			$location->setTitle( $coordinatesOrAddress );
		}

		if ( $metaData !== [] ) {
			$location->setText( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$location->setIcon( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
			$location->setGroup( array_shift( $metaData ) );
		}

		if ( $metaData !== [] ) {
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

		return $title->getFullURL();
	}

	/**
	 * @param string $location
	 *
	 * @return LatLongValue
	 * @throws ParseException
	 */
	private function stringToLatLongValue( $location ) {
		if ( Geocoders::canGeocode() ) {
			$latLongValue = Geocoders::attemptToGeocode( $location, $this->getOption( 'geoService' ) );

			if ( $latLongValue === false ) {
				throw new ParseException( 'Failed to parse or geocode' );
			}

			assert( $latLongValue instanceof LatLongValue );
			return $latLongValue;
		}

		$parser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );
		return $parser->parse( $location );
	}

	/**
	 * @param string $coordsOrAddress
	 *
	 * @return boolean
	 */
	private function isAddress( $coordsOrAddress ) {
		$coordinateParser = new GeoCoordinateParser( new \ValueParsers\ParserOptions() );

		try {
			$coordinateParser->parse( $coordsOrAddress );
		}
		catch ( ParseException $parseException ) {
			return true;
		}

		return false;
	}

}
