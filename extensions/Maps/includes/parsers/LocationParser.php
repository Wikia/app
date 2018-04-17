<?php

namespace Maps;

use DataValues\Geo\Parsers\LatLongParser;
use Jeroen\SimpleGeocoder\Geocoder;
use Maps\Elements\Location;
use Title;
use ValueParsers\ParseException;
use ValueParsers\StringValueParser;
use ValueParsers\ValueParser;

/**
 * ValueParser that parses the string representation of a location.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LocationParser implements ValueParser {

	private $geocoder;
	private $useAddressAsTitle;

	/**
	 * @deprecated Use newInstance instead
	 */
	public function __construct( $enableLegacyCrud = true ) {
		if ( $enableLegacyCrud ) {
			$this->geocoder = MapsFactory::newDefault()->newGeocoder();
			$this->useAddressAsTitle = false;
		}
	}

	public static function newInstance( Geocoder $geocoder, bool $useAddressAsTitle = false ): self {
		$instance = new self( false );
		$instance->geocoder = $geocoder;
		$instance->useAddressAsTitle = $useAddressAsTitle;
		return $instance;
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
	public function parse( $value ) {
		$separator = '~';

		$metaData = explode( $separator, $value );

		$coordinatesOrAddress = array_shift( $metaData );
		$coordinates = $this->geocoder->geocode( $coordinatesOrAddress );

		if ( $coordinates === null ) {
			throw new ParseException( 'Location is not a parsable coordinate and not a geocodable address' );
		}

		$location = new Location( $coordinates );

		if ( $metaData !== [] ) {
			$this->setTitleOrLink( $location, array_shift( $metaData ) );
		} else {
			if ( $this->useAddressAsTitle && $this->isAddress( $coordinatesOrAddress ) ) {
				$location->setTitle( $coordinatesOrAddress );
			}
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
		} else {
			$location->setTitle( $titleOrLink );
		}
	}

	private function isLink( $value ) {
		return strpos( $value, 'link:' ) === 0;
	}

	private function setLink( Location $location, $link ) {
		$link = substr( $link, 5 );
		$location->setLink( $this->getExpandedLink( $link ) );
	}

	private function getExpandedLink( $link ) {
		if ( filter_var( $link, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED ) ) {
			return $link;
		}

		$title = Title::newFromText( $link );

		if ( $title === null ) {
			return '';
		}

		return $title->getFullURL();
	}

	/**
	 * @param string $coordsOrAddress
	 *
	 * @return boolean
	 */
	private function isAddress( $coordsOrAddress ) {
		$coordinateParser = new LatLongParser();

		try {
			$coordinateParser->parse( $coordsOrAddress );
		}
		catch ( ParseException $parseException ) {
			return true;
		}

		return false;
	}

}
