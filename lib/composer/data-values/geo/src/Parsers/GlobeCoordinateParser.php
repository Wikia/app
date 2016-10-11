<?php

namespace DataValues\Geo\Parsers;

use DataValues\Geo\Values\GlobeCoordinateValue;
use DataValues\Geo\Values\LatLongValue;
use ValueParsers\ParseException;
use ValueParsers\ParserOptions;
use ValueParsers\StringValueParser;

/**
 * Extends the GeoCoordinateParser by adding precision detection support.
 *
 * The object that gets constructed is a GlobeCoordinateValue rather then a LatLongValue.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author H. Snater < mediawiki@snater.com >
 * @author Thiemo Mättig
 */
class GlobeCoordinateParser extends StringValueParser {

	const FORMAT_NAME = 'globe-coordinate';

	const OPT_GLOBE = 'globe';

	/**
	 * @param ParserOptions|null $options
	 */
	public function __construct( ParserOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( self::OPT_GLOBE, 'http://www.wikidata.org/entity/Q2' );
	}

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @param string $value
	 *
	 * @return GlobeCoordinateValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		foreach ( $this->getParsers() as $precisionDetector => $parser ) {
			try {
				$latLong = $parser->parse( $value );

				return new GlobeCoordinateValue(
					new LatLongValue(
						$latLong->getLatitude(),
						$latLong->getLongitude()
					),
					$this->detectPrecision( $latLong, $precisionDetector ),
					$this->getOption( 'globe' )
				);
			} catch ( ParseException $parseException ) {
				continue;
			}
		}

		throw new ParseException(
			'The format of the coordinate could not be determined.',
			$value,
			self::FORMAT_NAME
		);
	}

	private function detectPrecision( LatLongValue $latLong, $precisionDetector ) {
		if ( $this->options->hasOption( 'precision' ) ) {
			return $this->getOption( 'precision' );
		}

		return min(
			call_user_func( array( $this, $precisionDetector ), $latLong->getLatitude() ),
			call_user_func( array( $this, $precisionDetector ), $latLong->getLongitude() )
		);
	}

	/**
	 * @return  StringValueParser[]
	 */
	private function getParsers() {
		$parsers = array();

		$parsers['detectFloatPrecision'] = new FloatCoordinateParser( $this->options );
		$parsers['detectDmsPrecision'] = new DmsCoordinateParser( $this->options );
		$parsers['detectDmPrecision'] = new DmCoordinateParser( $this->options );
		$parsers['detectDdPrecision'] = new DdCoordinateParser( $this->options );

		return $parsers;
	}

	protected function detectDdPrecision( $degree ) {
		return $this->detectFloatPrecision( $degree );
	}

	protected function detectDmPrecision( $degree ) {
		$minutes = $degree * 60;
		$split = explode( '.', round( $minutes, 6 ) );

		if ( isset( $split[1] ) ) {
			return $this->detectDmsPrecision( $degree );
		}

		return 1 / 60;
	}

	protected function detectDmsPrecision( $degree ) {
		$seconds = $degree * 3600;
		$split = explode( '.', round( $seconds, 4 ) );

		if ( isset( $split[1] ) ) {
			return pow( 10, -strlen( $split[1] ) ) / 3600;
		}

		return 1 / 3600;
	}

	protected function detectFloatPrecision( $degree ) {
		$split = explode( '.', round( $degree, 8 ) );

		if ( isset( $split[1] ) ) {
			return pow( 10, -strlen( $split[1] ) );
		}

		return 1;
	}

}
